"""Optimize a delivery route with the Otiggo API (standard library only).

    export OTIGGO_API_KEY=otg_test_...
    python optimize.py
"""
import json
import os
import urllib.error
import urllib.request

API = "https://app.otiggo.com/api/v1"
KEY = os.environ["OTIGGO_API_KEY"]

body = {
    "start": {"latitude": 48.8686, "longitude": 2.3314},
    "stops": [
        {"id": "A", "latitude": 48.87, "longitude": 2.30, "deadline": "10:30"},
        {"id": "B", "latitude": 48.8738, "longitude": 2.295},
        {"id": "C", "latitude": 48.84, "longitude": 2.37},
    ],
}

request = urllib.request.Request(
    f"{API}/optimize",
    data=json.dumps(body).encode(),
    headers={"Authorization": f"Bearer {KEY}", "Content-Type": "application/json"},
)

try:
    with urllib.request.urlopen(request) as response:
        result = json.load(response)
except urllib.error.HTTPError as error:
    print(error.code, error.read().decode())
    raise SystemExit(1)

print("Order:", " -> ".join(result["order"]))
print(f"{result['totalDistanceKm']} km, {result['estimatedTimeMin']} min")
for step in result["schedule"]:
    print(f"  {step['colisId']} at {step['arrivee']}")
