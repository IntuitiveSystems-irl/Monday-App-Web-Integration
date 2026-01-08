import os
from dotenv import load_dotenv

load_dotenv()

MONDAY_API_TOKEN = os.getenv('MONDAY_API_TOKEN')
MONDAY_BOARD_ID = os.getenv('MONDAY_BOARD_ID')
MONDAY_API_URL = "https://api.monday.com/v2"

DATE_COLUMN_ID = "date"
DATE_COLUMN_NAME = "Due date"
EXCEL_TEMPLATE_PATH = os.path.join(os.path.dirname(__file__), "template.xlsx")
OUTPUT_FOLDER = os.path.join(os.path.dirname(__file__), "output")

COLUMN_MAPPINGS = {
    'name': 'A',
    'project_owner': 'B',
    'project_status': 'C',
    'date': 'D',
}
