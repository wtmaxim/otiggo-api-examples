<?php
// Optimize a delivery route with the Otiggo API (PHP 8+, curl extension).
//
//   OTIGGO_API_KEY=otg_test_... php optimize.php

$body = [
    'start' => ['latitude' => 48.8686, 'longitude' => 2.3314],
    'stops' => [
        ['id' => 'A', 'latitude' => 48.87, 'longitude' => 2.30, 'deadline' => '10:30'],
        ['id' => 'B', 'latitude' => 48.8738, 'longitude' => 2.295],
        ['id' => 'C', 'latitude' => 48.84, 'longitude' => 2.37],
    ],
];

$ch = curl_init('https://app.otiggo.com/api/v1/optimize');
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . getenv('OTIGGO_API_KEY'),
        'Content-Type: application/json',
    ],
    CURLOPT_POSTFIELDS => json_encode($body),
]);

$raw = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$result = json_decode($raw, true);

if ($status !== 200) {
    fwrite(STDERR, "$status $raw\n");
    exit(1);
}

echo 'Order: ' . implode(' -> ', $result['order']) . "\n";
echo "{$result['totalDistanceKm']} km, {$result['estimatedTimeMin']} min\n";
foreach ($result['schedule'] as $step) {
    echo "  {$step['colisId']} at {$step['arrivee']}\n";
}
