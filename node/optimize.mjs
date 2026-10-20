// Optimize a delivery route with the Otiggo API (Node 18+, no dependency).
//
//   OTIGGO_API_KEY=otg_test_... node optimize.mjs

const API = "https://app.otiggo.com/api/v1";

const response = await fetch(`${API}/optimize`, {
  method: "POST",
  headers: {
    Authorization: `Bearer ${process.env.OTIGGO_API_KEY}`,
    "Content-Type": "application/json",
  },
  body: JSON.stringify({
    start: { latitude: 48.8686, longitude: 2.3314 },
    stops: [
      { id: "A", latitude: 48.87, longitude: 2.3, deadline: "10:30" },
      { id: "B", latitude: 48.8738, longitude: 2.295 },
      { id: "C", latitude: 48.84, longitude: 2.37 },
    ],
  }),
});

const result = await response.json();
if (!response.ok) {
  console.error(response.status, result);
  process.exit(1);
}

console.log("Order:", result.order.join(" -> "));
console.log(`${result.totalDistanceKm} km, ${result.estimatedTimeMin} min`);
for (const step of result.schedule) console.log(`  ${step.colisId} at ${step.arrivee}`);
