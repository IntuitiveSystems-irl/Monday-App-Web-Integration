from flask import Flask, render_template, request, jsonify, send_file, redirect, url_for
import json
import os
from datetime import datetime
from scraper import MondayScraper
from monday_client import MondayClient
import requests

app = Flask(__name__)
app.config['UPLOAD_FOLDER'] = 'uploads'
app.config['MAX_CONTENT_LENGTH'] = 16 * 1024 * 1024

os.makedirs('uploads', exist_ok=True)
os.makedirs('configs', exist_ok=True)

CONFIGS_FILE = 'configs/saved_configs.json'

def load_configs():
    if os.path.exists(CONFIGS_FILE):
        with open(CONFIGS_FILE, 'r') as f:
            return json.load(f)
    return []

def save_configs(configs):
    with open(CONFIGS_FILE, 'w') as f:
        json.dump(configs, f, indent=2)

@app.route('/')
def index():
    configs = load_configs()
    return render_template('index.html', configs=configs)

@app.route('/test_api', methods=['POST'])
def test_api():
    data = request.json
    api_token = data.get('api_token')
    
    if not api_token:
        return jsonify({'success': False, 'error': 'API token is required'})
    
    try:
        headers = {
            "Authorization": api_token,
            "Content-Type": "application/json"
        }
        
        query = """
        query {
            me {
                id
                name
                email
            }
            boards(limit: 50) {
                id
                name
            }
        }
        """
        
        response = requests.post(
            "https://api.monday.com/v2",
            json={"query": query},
            headers=headers,
            timeout=10
        )
        
        result = response.json()
        
        if 'errors' in result:
            return jsonify({'success': False, 'error': result['errors'][0].get('message', 'API error')})
        
        user = result['data']['me']
        boards = result['data']['boards']
        
        return jsonify({
            'success': True,
            'user': user,
            'boards': boards
        })
        
    except Exception as e:
        return jsonify({'success': False, 'error': str(e)})

@app.route('/get_board_columns', methods=['POST'])
def get_board_columns():
    data = request.json
    api_token = data.get('api_token')
    board_id = data.get('board_id')
    
    if not api_token or not board_id:
        return jsonify({'success': False, 'error': 'API token and board ID are required'})
    
    try:
        headers = {
            "Authorization": api_token,
            "Content-Type": "application/json"
        }
        
        query = """
        query ($boardId: [ID!]) {
            boards(ids: $boardId) {
                id
                name
                columns {
                    id
                    title
                    type
                }
            }
        }
        """
        
        response = requests.post(
            "https://api.monday.com/v2",
            json={"query": query, "variables": {"boardId": [board_id]}},
            headers=headers,
            timeout=10
        )
        
        result = response.json()
        
        if 'errors' in result:
            return jsonify({'success': False, 'error': result['errors'][0].get('message', 'API error')})
        
        board = result['data']['boards'][0]
        
        return jsonify({
            'success': True,
            'board_name': board['name'],
            'columns': board['columns']
        })
        
    except Exception as e:
        return jsonify({'success': False, 'error': str(e)})

@app.route('/save_config', methods=['POST'])
def save_config():
    try:
        data = request.json
        
        config = {
            'id': datetime.now().strftime('%Y%m%d_%H%M%S'),
            'name': data.get('config_name'),
            'api_token': data.get('api_token'),
            'board_id': data.get('board_id'),
            'board_name': data.get('board_name'),
            'date_column_id': data.get('date_column_id'),
            'column_mappings': data.get('column_mappings', {}),
            'template_path': data.get('template_path', 'template.xlsx'),
            'created_at': datetime.now().isoformat()
        }
        
        configs = load_configs()
        configs.append(config)
        save_configs(configs)
        
        return jsonify({'success': True, 'config_id': config['id']})
        
    except Exception as e:
        return jsonify({'success': False, 'error': str(e)})

@app.route('/delete_config/<config_id>', methods=['DELETE'])
def delete_config(config_id):
    try:
        configs = load_configs()
        configs = [c for c in configs if c['id'] != config_id]
        save_configs(configs)
        return jsonify({'success': True})
    except Exception as e:
        return jsonify({'success': False, 'error': str(e)})

@app.route('/upload_template', methods=['POST'])
def upload_template():
    if 'template' not in request.files:
        return jsonify({'success': False, 'error': 'No file uploaded'})
    
    file = request.files['template']
    
    if file.filename == '':
        return jsonify({'success': False, 'error': 'No file selected'})
    
    if not file.filename.endswith('.xlsx'):
        return jsonify({'success': False, 'error': 'Only .xlsx files are allowed'})
    
    try:
        filename = f"template_{datetime.now().strftime('%Y%m%d_%H%M%S')}.xlsx"
        filepath = os.path.join(app.config['UPLOAD_FOLDER'], filename)
        file.save(filepath)
        
        return jsonify({'success': True, 'filename': filename, 'path': filepath})
    except Exception as e:
        return jsonify({'success': False, 'error': str(e)})

@app.route('/run_scraper', methods=['POST'])
def run_scraper():
    try:
        data = request.json
        config_id = data.get('config_id')
        
        configs = load_configs()
        config = next((c for c in configs if c['id'] == config_id), None)
        
        if not config:
            return jsonify({'success': False, 'error': 'Configuration not found'})
        
        os.environ['MONDAY_API_TOKEN'] = config['api_token']
        os.environ['MONDAY_BOARD_ID'] = config['board_id']
        
        import config as app_config
        app_config.MONDAY_API_TOKEN = config['api_token']
        app_config.MONDAY_BOARD_ID = config['board_id']
        app_config.DATE_COLUMN_ID = config['date_column_id']
        app_config.COLUMN_MAPPINGS = config['column_mappings']
        
        if config.get('template_path') and os.path.exists(config['template_path']):
            app_config.EXCEL_TEMPLATE_PATH = config['template_path']
        
        scraper = MondayScraper(board_id=config['board_id'])
        output_file = scraper.scrape_and_export(target_date=datetime.now())
        
        if output_file:
            return jsonify({
                'success': True,
                'output_file': output_file,
                'message': f'Successfully exported data to {output_file}'
            })
        else:
            return jsonify({'success': False, 'error': 'No data to export'})
            
    except Exception as e:
        return jsonify({'success': False, 'error': str(e)})

@app.route('/download/<path:filename>')
def download_file(filename):
    return send_file(filename, as_attachment=True)

if __name__ == '__main__':
    app.run(debug=True, port=5000)
