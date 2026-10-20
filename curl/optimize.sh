#!/bin/sh
# OTIGGO_API_KEY=otg_test_... ./optimize.sh
curl -sS https://app.otiggo.com/api/v1/optimize \
  -H "Authorization: Bearer $OTIGGO_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "start": { "latitude": 48.8686, "longitude": 2.3314 },
    "stops": [
      { "id": "A", "latitude": 48.87, "longitude": 2.30, "deadline": "10:30" },
      { "id": "B", "latitude": 48.8738, "longitude": 2.295 },
      { "id": "C", "latitude": 48.84, "longitude": 2.37 }
    ]
  }'
