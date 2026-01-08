# Changelog

All notable changes to Monday.com App Web Integration will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- GitHub Marketplace listing preparation
- Privacy Policy documentation
- Terms of Service documentation
- Support documentation
- Marketplace webhook handler for GitHub integration
- Marketing materials guide

## [1.0.0] - 2026-01-08

### Added
- Initial release
- Python-based Monday.com board scraper
- Excel export with customizable templates
- Date-based filtering for board items
- Column mapping configuration
- Web interface with scheduling dashboard
- 3D visualization views
- Mobile-optimized interface
- WordPress integration support
- Email notifications via Resend API
- Automated deployment scripts
- Comprehensive documentation
- MIT License

### Features
- **Python Scraper**
  - Fetch items from Monday.com boards
  - Filter by date column
  - Export to Excel templates
  - Flexible column mapping
  - Automation support (cron/Task Scheduler)

- **Web Interface**
  - Modern scheduling dashboard
  - 3D visualizations
  - Mobile views
  - Contact forms
  - Email integration

- **Integration**
  - Monday.com API
  - Resend API for emails
  - WordPress plugin support
  - Vercel deployment

### Documentation
- README with quick start guide
- API token acquisition guide
- Daily board usage guide
- Web interface guide
- Contributing guidelines
- Security best practices

### Security
- Environment variable protection
- API key encryption
- Input sanitization
- CORS protection

## [0.1.0] - 2025-12-01

### Added
- Initial project structure
- Basic Monday.com API integration
- Excel export functionality
- Configuration system

---

## Release Notes

### Version 1.0.0 - Production Ready

This is the first stable release of Monday.com App Web Integration, ready for GitHub Marketplace publication.

**Highlights:**
- Complete automation of Monday.com to Excel workflows
- Modern web interface for scheduling
- Mobile-friendly design
- Open source under MIT License
- Comprehensive documentation
- Production deployment support

**What's Next:**
- GitHub Marketplace listing
- Community feedback integration
- Additional export formats
- Enhanced visualization options
- API endpoint expansion

---

## Upgrade Guide

### From 0.1.0 to 1.0.0

1. **Update Dependencies**
   ```bash
   pip install -r requirements.txt --upgrade
   cd web && npm install
   ```

2. **Update Configuration**
   - Review `.env.example` for new variables
   - Update `python/config.py` with new column mappings

3. **File Structure Changes**
   - Python files moved to `python/` directory
   - Web files moved to `web/` directory
   - Documentation moved to `docs/` directory
   - Update any custom scripts with new paths

4. **New Features**
   - Web interface now available at `web/`
   - WordPress integration in `wordpress/`
   - Enhanced documentation in `docs/`

---

## Support

For questions about releases or upgrade issues:
- Email: info@manageonsite.com
- GitHub Issues: https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration/issues
- Documentation: https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration/blob/main/docs/SUPPORT.md
