# Monday.com App Web Integration

A comprehensive system that combines Monday.com board scraping with web-based scheduling and operations management. This project includes both a Python-based data scraper and a modern web interface for Monday.com workflow automation.

## 🎯 Overview

This project provides two main components:

1. **Monday.com Board Scraper** - Automated Python scraper to collect data from Monday.com boards filtered by date and export to Excel templates
2. **OFFICEOPS Web Interface** - Scheduling system with web interface, 3D visualizations, and WordPress integration

## ✨ Features

### Board Scraper Features
- **Automated Data Collection**: Fetch items from Monday.com boards with date filtering
- **Excel Export**: Export data to customizable Excel templates
- **Column Mapping**: Flexible mapping between Monday.com columns and Excel cells
- **Automation Ready**: Can be scheduled for daily execution via cron or Task Scheduler

### Web Interface Features
- **Multiple Views**: Main dashboard, 3D visualizations, mobile interface
- **Contact Forms**: Request scheduling assistance or system access
- **Email Notifications**: Automated notifications via Resend API
- **WordPress Integration**: Embed scheduling system in WordPress sites
- **Production Ready**: Deployment scripts for live environments

## 🛠 Tech Stack

- **Backend**: Python 3.x, PHP, Node.js (Serverless Functions)
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Visualization**: WebGL / Three.js
- **API Integration**: Monday.com API
- **Data Management**: Microsoft Excel, openpyxl
- **Email Service**: Resend API
- **Deployment**: Vercel, Custom Server (PM2)

## 📋 Prerequisites

- Python 3.x
- Node.js 18.x or higher (for web interface)
- Monday.com account with API access
- Microsoft Excel (for template creation)
- Resend API account (for email notifications)

## 🚀 Quick Start

### Python Scraper Setup

1. **Install Python Dependencies**
   ```bash
   pip install -r requirements.txt
   ```

2. **Configure Environment Variables**
   ```bash
   cp .env.example .env
   ```
   
   Edit `.env`:
   ```
   MONDAY_API_TOKEN=your_monday_api_token
   MONDAY_BOARD_ID=your_board_id
   ```

3. **Get Your Monday.com Credentials**
   - **API Token**: Monday.com → Avatar → Admin → API → Generate token
   - **Board ID**: From board URL: `https://yourcompany.monday.com/boards/1234567890`

4. **Create Excel Template**
   Create `template.xlsx` with your desired layout

5. **Configure Column Mappings**
   Edit `config.py`:
   ```python
   COLUMN_MAPPINGS = {
       'name': 'A2',
       'status': 'B2',
       'date': 'C2',
   }
   DATE_COLUMN_NAME = "Date"
   ```

6. **Run the Scraper**
   ```bash
   python scraper.py
   ```

### Web Interface Setup

1. **Install Node Dependencies**
   ```bash
   npm install
   ```

2. **Configure Environment**
   Add to `.env`:
   ```
   RESEND_API_KEY=your_resend_api_key_here
   ```

3. **Run Development Server**
   ```bash
   npm run dev
   ```

4. **Access the Interface**
   - Main page: `http://localhost:3000`
   - 3D version: `http://localhost:3000/index-3d-v2.html`
   - Mobile view: `http://localhost:3000/mobile.html`

## 📅 Usage

### Python Scraper Usage

**Basic Usage:**
```bash
python scraper.py
```

**Custom Date Filtering:**
```python
from datetime import datetime
target_date = datetime(2024, 12, 25)
scraper.scrape_and_export(target_date=target_date)
```

**Automation (Mac/Linux):**
```bash
crontab -e
# Add: 0 9 * * * cd /Users/lindsay/DD && /usr/bin/python3 scraper.py
```

### Testing & Inspection

- **Test API Connection**: `python test_api_connection.py`
- **Inspect Board Structure**: `python inspect_board.py`
- **Test Scraper**: `python test_scraper.py`

## 📁 Project Structure

```
Monday-App-Web-Integration/
├── Python Scraper Components
│   ├── scraper.py              # Main scraper script
│   ├── monday_client.py        # Monday.com API client
│   ├── excel_handler.py        # Excel template handler
│   ├── config.py               # Configuration
│   ├── test_api_connection.py  # API testing
│   ├── inspect_board.py        # Board inspection tool
│   ├── test_scraper.py         # Scraper testing
│   ├── template.xlsx           # Excel template
│   └── output/                 # Generated Excel files
│
├── Web Interface Components
│   ├── index.html              # Main landing page
│   ├── index-3d.html           # 3D interactive version
│   ├── index-3d-v2.html        # Enhanced 3D experience
│   ├── mobile.html             # Mobile-optimized view
│   ├── mobile-pitch.html       # Mobile pitch presentation
│   ├── api/contact.js          # Contact form handler
│   ├── templates/index.html    # Web templates
│   └── web_config.py           # Web configuration
│
├── WordPress Integration
│   ├── page-smart-systems.php
│   ├── page-smart-systems-standalone.php
│   └── functions-smart-systems.php
│
├── Configuration & Deployment
│   ├── .env.example            # Environment template
│   ├── requirements.txt        # Python dependencies
│   ├── package.json            # Node.js dependencies
│   ├── DEPLOY-TO-PRODUCTION.sh # Deployment script
│   └── .gitignore
│
└── Documentation
    ├── README.md
    ├── GET_API_TOKEN.md
    ├── DAILY_BOARD_USAGE.md
    └── WEB_INTERFACE_GUIDE.md
```

## 🔒 Security

- Environment variables gitignored (`.env`)
- API keys never committed
- Input sanitization for all forms
- CORS protection enabled

## 🚨 Troubleshooting

### Python Scraper Issues

**"Template file not found"**
- Create `template.xlsx` in project directory

**"No items matching date filter"**
- Verify `DATE_COLUMN_NAME` matches Monday.com column exactly
- Check items exist with target date

**API Errors**
- Verify API token and Board ID
- Check board access permissions

### Web Interface Issues

**Email not sending**
- Verify `RESEND_API_KEY` in `.env`
- Check Resend dashboard

**3D page not loading**
- Check browser WebGL support
- Clear browser cache

## 📝 Environment Variables

```bash
# Monday.com API Configuration
MONDAY_API_TOKEN=your_api_token_here
MONDAY_BOARD_ID=your_board_id_here

# Email Service Configuration
RESEND_API_KEY=your_resend_api_key_here
```

## 🌐 Production Deployment

```bash
./DEPLOY-TO-PRODUCTION.sh
```

## 📞 Support

For technical support:
- **Email**: info@manageonsite.com
- **Website**: https://manageonsite.com

---

**Built for efficient Monday.com workflow automation and scheduling** 📅🚀
