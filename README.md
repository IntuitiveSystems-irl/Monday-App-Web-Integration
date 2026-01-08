# Monday.com Board Scraper

Automated scraper to collect data from Monday.com boards filtered by date and export to Excel templates.

## Setup

### 1. Install Dependencies
```bash
pip install -r requirements.txt
```

### 2. Configure Environment Variables
Copy `.env.example` to `.env` and fill in your credentials:
```bash
cp .env.example .env
```

Edit `.env`:
```
MONDAY_API_TOKEN=your_monday_api_token
MONDAY_BOARD_ID=your_board_id
```

#### Getting Your Monday.com API Token:
1. Go to Monday.com
2. Click your avatar (bottom left)
3. Go to Admin → API
4. Generate a new API token
5. Copy and paste it into `.env`

#### Getting Your Board ID:
1. Open the board in Monday.com
2. Look at the URL: `https://yourcompany.monday.com/boards/1234567890`
3. The number `1234567890` is your Board ID

### 3. Create Excel Template
Create a file named `template.xlsx` in this directory with your desired layout.

### 4. Configure Column Mappings
Edit `config.py` to map Monday.com columns to Excel cells:

```python
COLUMN_MAPPINGS = {
    'name': 'A2',           # Item name goes to cell A2
    'status': 'B2',         # Status column goes to B2
    'date': 'C2',           # Date column goes to C2
}
```

For multiple rows, the script will automatically increment row numbers (A2, A3, A4, etc.)

You can also map by column ID from Monday.com. To find column IDs, run the scraper once and check the output.

### 5. Configure Date Filtering
Edit `config.py` to set which column to filter by:
```python
DATE_COLUMN_NAME = "Date"  # Change to your date column name
```

## Usage

### Run the Scraper
```bash
python scraper.py
```

This will:
1. Fetch all items from your Monday.com board
2. Filter items where the date column matches today's date
3. Export matching items to Excel using your template
4. Save the file in the `output/` folder

### Custom Date
To filter by a specific date, modify `scraper.py`:
```python
from datetime import datetime

target_date = datetime(2024, 12, 25)  # Christmas 2024
scraper.scrape_and_export(target_date=target_date)
```

### Single Row vs Multiple Rows
By default, the scraper exports multiple items to multiple rows.

To export only to specific cells (single item):
```python
scraper.scrape_and_export(multiple_rows=False)
```

## Automation

### Daily Execution (Mac/Linux)
Add to crontab:
```bash
crontab -e
```

Add this line to run daily at 9 AM:
```
0 9 * * * cd /Users/lindsay/DD && /usr/bin/python3 scraper.py
```

### Daily Execution (Windows)
Use Task Scheduler:
1. Open Task Scheduler
2. Create Basic Task
3. Set trigger to Daily
4. Action: Start a Program
5. Program: `python`
6. Arguments: `scraper.py`
7. Start in: `C:\path\to\DD`

## File Structure
```
DD/
├── scraper.py              # Main script
├── monday_client.py        # Monday.com API client
├── excel_handler.py        # Excel template handler
├── config.py               # Configuration
├── requirements.txt        # Python dependencies
├── .env                    # Your credentials (create this)
├── .env.example           # Example credentials file
├── template.xlsx          # Your Excel template (create this)
├── output/                # Generated Excel files
└── README.md              # This file
```

## Troubleshooting

### "Template file not found"
Create a `template.xlsx` file in the DD directory.

### "No items matching date filter"
- Check that `DATE_COLUMN_NAME` in `config.py` matches your Monday.com column name exactly
- Verify items exist on your board with today's date
- Check date format in Monday.com

### API Errors
- Verify your API token is correct
- Verify your Board ID is correct
- Check you have access to the board

## Customization

You can customize the scraper by editing:
- `config.py` - Column mappings, date column name, output folder
- `scraper.py` - Main logic, filtering, data processing
- `monday_client.py` - API queries and data extraction
- `excel_handler.py` - Excel formatting and cell placement
