# Web Interface Guide

## Starting the Web Interface

Run this command to start the configuration web interface:

```bash
cd /Users/lindsay/DD
python3 web_config.py
```

Then open your browser to: **http://localhost:5000**

## Features

### 1. **New Configuration Tab**
Create and save configurations for different Monday.com accounts and boards:

- **Enter API Token**: Paste your Monday.com API token
- **Test Connection**: Verify the token works and see your available boards
- **Select Board**: Choose which board to scrape
- **Auto-load Columns**: Columns are automatically detected from your board
- **Map Columns**: Map Monday columns to Excel columns (A, B, C, etc.)
- **Upload Template**: Upload your custom Excel template (optional)
- **Save Configuration**: Save everything for later use

### 2. **Saved Configurations Tab**
View and manage all your saved configurations:

- **Run**: Execute the scraper with that configuration
- **Delete**: Remove a configuration

## How to Use

### Step 1: Create a Configuration

1. Click "New Configuration" tab
2. Enter a name (e.g., "Sales Board - Daily")
3. Paste your Monday.com API token
4. Click "Test API Connection"
5. Select your board from the dropdown
6. Choose which date column to filter by
7. Map columns to Excel columns (e.g., Status → B, Owner → C)
8. (Optional) Upload your Excel template
9. Click "Save Configuration"

### Step 2: Run the Scraper

1. Go to "Saved Configurations" tab
2. Click "Run" on any saved configuration
3. The scraper will:
   - Connect to that Monday.com account
   - Fetch data from that board
   - Filter by today's date
   - Export to Excel using your mappings
   - Save to the `output/` folder

### Step 3: Switch Between Different Monday Accounts

You can save multiple configurations for different:
- Monday.com accounts (different API tokens)
- Boards within the same account
- Column mappings
- Excel templates

Just create a new configuration for each one!

## Column Mapping

When mapping columns, use Excel column letters:
- **A** = First column
- **B** = Second column
- **C** = Third column
- etc.

The "name" column is automatically mapped to column A.

## Excel Templates

### Using Default Template
If you don't upload a template, the system uses `template.xlsx` with headers:
- A1: Item Name
- B1: Owner
- C1: Status
- D1: Due Date

### Using Custom Template
1. Create your Excel file with headers in row 1
2. Upload it in the configuration form
3. Map Monday columns to match your template's column letters

**When you provide your template later**, just:
1. Open the web interface
2. Edit an existing configuration or create a new one
3. Upload your template file
4. Adjust column mappings to match your template

## Configuration Storage

All configurations are saved in: `/Users/lindsay/DD/configs/saved_configs.json`

Uploaded templates are saved in: `/Users/lindsay/DD/uploads/`

## Troubleshooting

### "Cannot connect to Monday.com"
- Check your API token is correct
- Verify you have internet connection
- Make sure the token has proper permissions

### "No data exported"
- Check that items exist on your board with today's date
- Verify the date column is selected correctly
- Try running without date filter (modify scraper.py temporarily)

### "Template not found"
- Make sure you uploaded a template, or
- Ensure `template.xlsx` exists in the DD folder

## Security Note

API tokens are stored in the configuration file. Keep this secure and don't share it.
