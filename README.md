# Otiggo route optimization API: code examples

Working examples for the [Otiggo route optimization API](https://www.otiggo.com/en/route-optimization-api):
send 2 to 200 delivery stops, get back the best visiting order, total distance, duration and
arrival times. Pay per stop from €0.012, no subscription.

- Documentation: https://www.otiggo.com/developers/en
- OpenAPI 3.1 spec: https://www.otiggo.com/openapi.json (import it into Postman or Insomnia)
- Base URL: `https://app.otiggo.com/api/v1`

## Quick start

1. Get a **free test key** (`otg_test_...`, no payment): see the [sandbox guide](https://www.otiggo.com/developers/en/sandbox).
2. Export it and run an example:

```bash
export OTIGGO_API_KEY=otg_test_...

python python/optimize.py
node node/optimize.mjs
php php/optimize.php
sh curl/optimize.sh
```

Output:

```
Order: B -> A -> C
11.2 km, 54 min
  B at 2026-10-20T05:41:00Z
  ...
```

## Request

`POST /optimize` with a Bearer key. `start` and each stop are either coordinates
(`latitude`, `longitude`) or an address (`street`, `postalCode`, `city`, geocoded for you).
A stop can carry a `deadline` (`HH:MM`, Europe/Paris) and `serviceSeconds`.

```json
{
  "start": { "latitude": 48.8686, "longitude": 2.3314 },
  "stops": [
    { "id": "A", "latitude": 48.87, "longitude": 2.30, "deadline": "10:30" },
    { "id": "B", "latitude": 48.8738, "longitude": 2.295 }
  ]
}
```

## Test keys vs live keys

| | Test key `otg_test_...` | Live key `otg_live_...` |
|---|---|---|
| Cost | Free | 1 stop per stop sent (refunded on failure) |
| Limits | 10 stops/call, 20 calls/min, 200 stops/day | 200 stops/call |
| Addresses | Coordinates only | Addresses or coordinates |

Live packs are prepaid and never expire: 2,000 stops for €99, 10,000 for €299,
50,000 for €999, 250,000 for €2,999. See [pricing](https://www.otiggo.com/developers/en/pricing).

## Errors

`400` invalid body, `401` bad key, `402` not enough stops, `422` address not found,
`429` sandbox rate limit, `502` optimization failed (nothing charged).
Full list: https://www.otiggo.com/developers/en/errors

## License

MIT
