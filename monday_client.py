import requests
from datetime import datetime
from typing import List, Dict, Any
import config

class MondayClient:
    def __init__(self, api_token: str):
        self.api_token = api_token
        self.headers = {
            "Authorization": api_token,
            "Content-Type": "application/json"
        }
    
    def execute_query(self, query: str, variables: Dict = None) -> Dict[str, Any]:
        data = {"query": query}
        if variables:
            data["variables"] = variables
        
        response = requests.post(
            config.MONDAY_API_URL,
            json=data,
            headers=self.headers
        )
        response.raise_for_status()
        return response.json()
    
    def get_board_items(self, board_id: str, limit: int = 100) -> List[Dict[str, Any]]:
        query = """
        query ($boardId: [ID!], $limit: Int) {
            boards(ids: $boardId) {
                items_page(limit: $limit) {
                    items {
                        id
                        name
                        column_values {
                            id
                            text
                            type
                            value
                        }
                    }
                }
            }
        }
        """
        variables = {
            "boardId": [board_id],
            "limit": limit
        }
        
        result = self.execute_query(query, variables)
        
        if result.get('data') and result['data'].get('boards'):
            boards = result['data']['boards']
            if boards and len(boards) > 0:
                return boards[0]['items_page']['items']
        return []
    
    def filter_items_by_date(self, items: List[Dict[str, Any]], 
                            date_column_name: str, 
                            target_date: datetime = None) -> List[Dict[str, Any]]:
        if target_date is None:
            target_date = datetime.now()
        
        target_date_str = target_date.strftime('%Y-%m-%d')
        filtered_items = []
        
        for item in items:
            for column in item['column_values']:
                if column['text'] and column['text'].lower() == date_column_name.lower():
                    if column['value']:
                        try:
                            import json
                            date_value = json.loads(column['value'])
                            item_date = date_value.get('date', '')
                            if item_date.startswith(target_date_str):
                                filtered_items.append(item)
                                break
                        except:
                            if target_date_str in str(column['text']):
                                filtered_items.append(item)
                                break
                elif date_column_name.lower() in column.get('text', '').lower():
                    if target_date_str in str(column.get('text', '')):
                        filtered_items.append(item)
                        break
        
        return filtered_items
    
    def extract_column_value(self, item: Dict[str, Any], column_id: str) -> str:
        for column in item['column_values']:
            if column['id'] == column_id or column['text'] == column_id:
                return column.get('text', '')
        return ''
