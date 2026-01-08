# Using Different Boards Daily

The scraper now supports running on different boards each day.

## Method 1: Command Line (Recommended for Daily Switching)

Run the scraper with a specific board ID:

```bash
python3 scraper.py 18392833674
```

Replace `18392833674` with your target board ID for that day.

## Method 2: Update .env File

Edit `.env` and change the `MONDAY_BOARD_ID`:

```
MONDAY_BOARD_ID=18392833674
```

Then run:
```bash
python3 scraper.py
```

## Method 3: Create Daily Scripts

Create separate scripts for each board:

**monday_board_1.sh:**
```bash
#!/bin/bash
cd /Users/lindsay/DD
python3 scraper.py 18392833674
```

**monday_board_2.sh:**
```bash
#!/bin/bash
cd /Users/lindsay/DD
python3 scraper.py 98765432109
```

Make executable:
```bash
chmod +x monday_board_1.sh monday_board_2.sh
```

## Method 4: Automated Daily Rotation

Create a script that picks the board based on day of week:

**daily_scraper.sh:**
```bash
#!/bin/bash
cd /Users/lindsay/DD

# Get day of week (1=Monday, 7=Sunday)
DAY=$(date +%u)

case $DAY in
    1) BOARD_ID="board_id_for_monday" ;;
    2) BOARD_ID="board_id_for_tuesday" ;;
    3) BOARD_ID="board_id_for_wednesday" ;;
    4) BOARD_ID="board_id_for_thursday" ;;
    5) BOARD_ID="board_id_for_friday" ;;
    6) BOARD_ID="board_id_for_saturday" ;;
    7) BOARD_ID="board_id_for_sunday" ;;
esac

python3 scraper.py $BOARD_ID
```

## Finding Board IDs

To get your board IDs, run:
```bash
python3 test_api_connection.py
```

This will list all your boards with their IDs.

## Current Configuration

Your board columns are mapped to Excel as:
- **Column A**: Item Name
- **Column B**: Owner
- **Column C**: Status  
- **Column D**: Due Date

The scraper filters items where **Due Date = Today's Date**.

## Customizing for Different Boards

If different boards have different column structures, you can:

1. **Inspect a board:**
   ```bash
   # Update MONDAY_BOARD_ID in .env first
   python3 inspect_board.py
   ```

2. **Update column mappings in `config.py`:**
   ```python
   COLUMN_MAPPINGS = {
       'name': 'A',
       'project_owner': 'B',
       'project_status': 'C',
       'date': 'D',
   }
   ```

3. **Update Excel template headers** to match your needs

## Examples

**Export today's items from board 18392833674:**
```bash
python3 scraper.py 18392833674
```

**Export all items (no date filter):**
Edit `scraper.py` and change:
```python
output_file = scraper.scrape_and_export(target_date=None)
```

**Export specific date:**
Edit `scraper.py`:
```python
from datetime import datetime
target = datetime(2025, 12, 25)
output_file = scraper.scrape_and_export(target_date=target)
```
