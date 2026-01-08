import requests
import os
import json
from dotenv import load_dotenv

load_dotenv()

MONDAY_API_TOKEN = os.getenv('MONDAY_API_TOKEN')
MONDAY_BOARD_ID = os.getenv('MONDAY_BOARD_ID')
MONDAY_API_URL = "https://api.monday.com/v2"

def inspect_board(board_id):
    headers = {
        "Authorization": MONDAY_API_TOKEN,
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
            items_page(limit: 3) {
                items {
                    id
                    name
                    column_values {
                        id
                        type
                        text
                        value
                    }
                }
            }
        }
    }
    """
    
    variables = {"boardId": [board_id]}
    
    response = requests.post(
        MONDAY_API_URL,
        json={"query": query, "variables": variables},
        headers=headers
    )
    
    data = response.json()
    
    if 'errors' in data:
        print("❌ Errors:")
        for error in data['errors']:
            print(f"  {error}")
        return
    
    board = data['data']['boards'][0]
    
    print(f"\n📋 Board: {board['name']} (ID: {board['id']})")
    print("\n" + "="*60)
    print("COLUMNS:")
    print("="*60)
    
    for col in board['columns']:
        print(f"  ID: {col['id']:<20} Title: {col['title']:<25} Type: {col['type']}")
    
    items = board['items_page']['items']
    print(f"\n" + "="*60)
    print(f"SAMPLE ITEMS ({len(items)} shown):")
    print("="*60)
    
    for idx, item in enumerate(items, 1):
        print(f"\n--- Item {idx}: {item['name']} ---")
        for col_val in item['column_values']:
            if col_val['text']:
                col_title = next((c['title'] for c in board['columns'] if c['id'] == col_val['id']), col_val['id'])
                print(f"  {col_title}: {col_val['text']}")

if __name__ == "__main__":
    inspect_board(MONDAY_BOARD_ID)
