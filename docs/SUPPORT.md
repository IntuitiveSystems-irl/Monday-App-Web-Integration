# Support

Welcome to Monday.com App Web Integration support! We're here to help you get the most out of the application.

## 📧 Contact Support

For technical support, questions, or issues:

- **Email**: info@manageonsite.com
- **Response Time**: Within 24-48 hours (business days)
- **Website**: https://manageonsite.com

## 🐛 Report Issues

Found a bug or have a feature request?

1. **GitHub Issues**: https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration/issues
2. Click "New Issue"
3. Choose the appropriate template:
   - Bug Report
   - Feature Request
   - Documentation Improvement

## 📚 Documentation

Before reaching out, check our comprehensive documentation:

### Getting Started
- [README.md](../README.md) - Main documentation and quick start guide
- [GET_API_TOKEN.md](GET_API_TOKEN.md) - How to get your Monday.com API token
- [DAILY_BOARD_USAGE.md](DAILY_BOARD_USAGE.md) - Daily usage guide

### Technical Guides
- [WEB_INTERFACE_GUIDE.md](WEB_INTERFACE_GUIDE.md) - Web interface documentation
- [CONTRIBUTING.md](CONTRIBUTING.md) - How to contribute to the project

### Policies
- [PRIVACY_POLICY.md](PRIVACY_POLICY.md) - Privacy and data handling
- [TERMS_OF_SERVICE.md](TERMS_OF_SERVICE.md) - Terms and conditions

## 🔧 Common Issues

### Installation Issues

**Problem**: `pip install` fails
```bash
# Solution: Upgrade pip first
python -m pip install --upgrade pip
pip install -r requirements.txt
```

**Problem**: Module not found errors
```bash
# Solution: Ensure you're in the correct directory
cd /path/to/Monday-App-Web-Integration
pip install -r requirements.txt
```

### API Connection Issues

**Problem**: "Invalid API token"
- Verify your token in Monday.com → Admin → API
- Check that `.env` file has correct `MONDAY_API_TOKEN`
- Ensure no extra spaces in the token

**Problem**: "Board not found"
- Verify the Board ID from the URL
- Check you have access permissions to the board
- Ensure `MONDAY_BOARD_ID` is set correctly in `.env`

### Excel Export Issues

**Problem**: "Template file not found"
- Create `python/template.xlsx` in the project directory
- Check file permissions
- Verify the path in `config.py`

**Problem**: "No items matching date filter"
- Check `DATE_COLUMN_NAME` matches your Monday.com column exactly
- Verify items exist with the target date
- Review date format in Monday.com

### Web Interface Issues

**Problem**: Email not sending
- Verify `RESEND_API_KEY` in `.env`
- Check Resend dashboard for delivery status
- Ensure sender domain is verified

**Problem**: 3D page not loading
- Check browser WebGL support
- Clear browser cache
- Try a different browser (Chrome, Firefox recommended)

## 💡 Best Practices

1. **Keep API Credentials Secure**
   - Never commit `.env` file to git
   - Use environment variables in production
   - Rotate API tokens periodically

2. **Regular Backups**
   - Back up your Excel templates
   - Keep copies of exported data
   - Document your column mappings

3. **Monitor API Usage**
   - Monday.com has rate limits
   - Avoid excessive API calls
   - Use date filtering to reduce data volume

## 🚀 Feature Requests

Have an idea to improve the app?

1. Check existing [GitHub Issues](https://github.com/IntuitiveSystems-irl/Monday-App-Web-Integration/issues) first
2. Create a new Feature Request issue
3. Describe:
   - The problem you're trying to solve
   - Your proposed solution
   - Any alternative solutions considered
   - Additional context or screenshots

## 🤝 Community Support

- **GitHub Discussions**: Ask questions and share tips
- **Contributing**: See [CONTRIBUTING.md](CONTRIBUTING.md) to help improve the app
- **Star the Repo**: Show your support on GitHub!

## 📞 Emergency Support

For critical production issues:
- Email: info@manageonsite.com with subject "URGENT"
- Include:
  - Description of the issue
  - Error messages or logs
  - Steps to reproduce
  - Your environment (OS, Python version, etc.)

## 🔄 Updates and Announcements

Stay informed about updates:
- Watch the GitHub repository for releases
- Check the [CHANGELOG](../CHANGELOG.md) for version history
- Follow release notes for breaking changes

## 📝 Feedback

We value your feedback! Let us know:
- What features you love
- What could be improved
- Your use cases and success stories

Send feedback to: info@manageonsite.com

---

**Thank you for using Monday.com App Web Integration!** 🎉

We're committed to providing excellent support and continuously improving the application based on your feedback.
