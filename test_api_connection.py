import requests
import os
from dotenv import load_dotenv

load_dotenv()

MONDAY_API_TOKEN = os.getenv('MONDAY_API_TOKEN')
MONDAY_API_URL = "https://api.monday.com/v2"

def test_connection():
    print("Testing Monday.com API connection...")
    print(f"Token: {MONDAY_API_TOKEN[:20]}..." if MONDAY_API_TOKEN else "No token found")
    
    headers = {
        "Authorization": MONDAY_API_TOKEN,
        "Content-Type": "application/json"
    }
    
    query = """
    query {
        me {
            id
            name
            email
        }
        boards(limit: 10) {
            id
            name
            description
        }
    }
    """
    
    try:
        response = requests.post(
            MONDAY_API_URL,
            json={"query": query},
            headers=headers
        )
        response.raise_for_status()
        data = response.json()
        
        if 'errors' in data:
            print("\n❌ API Error:")
            for error in data['errors']:
                print(f"  {error.get('message', error)}")
            return
        
        print("\n✅ Connection successful!")
        
        if 'data' in data and 'me' in data['data']:
            user = data['data']['me']
            print(f"\nLogged in as: {user['name']} ({user['email']})")
        
        if 'data' in data and 'boards' in data['data']:
            boards = data['data']['boards']
            print(f"\n📋 Your boards ({len(boards)} shown):")
            for board in boards:
                print(f"  ID: {board['id']}")
                print(f"  Name: {board['name']}")
                if board.get('description'):
                    print(f"  Description: {board['description']}")
                print()
        
    except requests.exceptions.RequestException as e:
        print(f"\n❌ Connection failed: {e}")
    except Exception as e:
        print(f"\n❌ Error: {e}")

if __name__ == "__main__":
    test_connection()
