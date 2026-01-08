import os
from datetime import datetime
from typing import List, Dict, Any
import config
from monday_client import MondayClient
from excel_handler import ExcelHandler

class MondayScraper:
    def __init__(self, board_id=None):
        if not config.MONDAY_API_TOKEN:
            raise ValueError("MONDAY_API_TOKEN not set in environment variables")
        
        self.client = MondayClient(config.MONDAY_API_TOKEN)
        self.board_id = board_id or config.MONDAY_BOARD_ID
        
        if not self.board_id:
            raise ValueError("Board ID must be provided or set in MONDAY_BOARD_ID environment variable")
        
        self.excel_handler = ExcelHandler(config.EXCEL_TEMPLATE_PATH)
    
    def scrape_and_export(self, target_date: datetime = None, 
                         output_path: str = None,
                         multiple_rows: bool = True) -> str:
        print(f"Fetching items from board {self.board_id}...")
        items = self.client.get_board_items(self.board_id)
        print(f"Found {len(items)} total items")
        
        if target_date:
            print(f"Filtering items by date: {config.DATE_COLUMN_NAME}...")
            filtered_items = self.filter_by_date_column(items, target_date)
            print(f"Found {len(filtered_items)} items matching the date filter")
        else:
            print("No date filter applied, exporting all items")
            filtered_items = items
        
        processed_data = []
        for item in filtered_items:
            item_data = {
                'name': item['name']
            }
            
            for column in item['column_values']:
                column_text = column.get('text', '')
                column_id = column.get('id', '')
                item_data[column_id] = column_text
            
            processed_data.append(item_data)
        
        if not processed_data:
            print("No data to export")
            return None
        
        if output_path is None:
            os.makedirs(config.OUTPUT_FOLDER, exist_ok=True)
            timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
            output_path = os.path.join(config.OUTPUT_FOLDER, f"monday_export_{timestamp}.xlsx")
        
        print(f"Exporting to Excel: {output_path}...")
        if multiple_rows:
            result_path = self.excel_handler.populate_template_multiple_rows(
                processed_data,
                config.COLUMN_MAPPINGS,
                output_path=output_path
            )
        else:
            result_path = self.excel_handler.populate_template(
                processed_data,
                config.COLUMN_MAPPINGS,
                output_path=output_path
            )
        
        print(f"Export completed: {result_path}")
        return result_path
    
    def filter_by_date_column(self, items, target_date):
        target_date_str = target_date.strftime('%Y-%m-%d')
        filtered = []
        
        for item in items:
            for column in item['column_values']:
                if column['id'] == config.DATE_COLUMN_ID:
                    if column.get('text') and target_date_str in column['text']:
                        filtered.append(item)
                        break
        
        return filtered

def main():
    import sys
    
    board_id = None
    if len(sys.argv) > 1:
        board_id = sys.argv[1]
        print(f"Using board ID from command line: {board_id}")
    
    scraper = MondayScraper(board_id=board_id)
    output_file = scraper.scrape_and_export(target_date=datetime.now())
    
    if output_file:
        print(f"\nSuccess! Data exported to: {output_file}")
    else:
        print("\nNo data to export")

if __name__ == "__main__":
    main()
