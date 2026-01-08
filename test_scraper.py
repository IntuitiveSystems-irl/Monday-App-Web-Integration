from datetime import datetime
from excel_handler import ExcelHandler
import os

def test_scraper_locally():
    print("=" * 50)
    print("Testing Monday.com Scraper Locally")
    print("=" * 50)
    
    mock_data = [
        {
            'name': 'Task 1 - Design Homepage',
            'status': 'In Progress',
            'date': datetime.now().strftime('%Y-%m-%d'),
            'priority': 'High',
            'owner': 'John Doe'
        },
        {
            'name': 'Task 2 - Backend API',
            'status': 'Done',
            'date': datetime.now().strftime('%Y-%m-%d'),
            'priority': 'Medium',
            'owner': 'Jane Smith'
        },
        {
            'name': 'Task 3 - Testing',
            'status': 'Stuck',
            'date': datetime.now().strftime('%Y-%m-%d'),
            'priority': 'Low',
            'owner': 'Bob Johnson'
        }
    ]
    
    print(f"\n✓ Created {len(mock_data)} mock Monday.com items")
    print(f"  Date filter: {datetime.now().strftime('%Y-%m-%d')}")
    
    column_mappings = {
        'name': 'A',
        'status': 'B',
        'date': 'C'
    }
    
    template_path = 'template.xlsx'
    if not os.path.exists(template_path):
        print(f"\n✗ Template file not found: {template_path}")
        return
    
    print(f"\n✓ Found template: {template_path}")
    
    excel_handler = ExcelHandler(template_path)
    
    os.makedirs('output', exist_ok=True)
    timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
    output_path = os.path.join('output', f'test_export_{timestamp}.xlsx')
    
    print(f"\n⚙ Exporting to Excel...")
    result_path = excel_handler.populate_template_multiple_rows(
        mock_data,
        column_mappings,
        start_row=2,
        output_path=output_path
    )
    
    print(f"\n✓ SUCCESS! Excel file created: {result_path}")
    print(f"\nData exported:")
    for idx, item in enumerate(mock_data, start=2):
        print(f"  Row {idx}: {item['name']} | {item['status']} | {item['date']}")
    
    print(f"\n{'=' * 50}")
    print("Test completed successfully!")
    print(f"{'=' * 50}")
    
    return result_path

if __name__ == "__main__":
    test_scraper_locally()
