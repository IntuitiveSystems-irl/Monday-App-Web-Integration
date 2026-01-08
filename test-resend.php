<?php
// Test Resend API directly
$resendApiKey = 're_XZGzn28r_GZtRPUPVtZcy9kEmt9wuTp7j';

$payload = [
    'from' => 'Smart Systems <onboarding@resend.dev>',
    'to' => ['info@manageonsite.com'],
    'subject' => 'Test Email from Smart Systems',
    'text' => 'This is a test email to verify Resend API integration.'
];

$ch = curl_init('https://api.resend.com/emails');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $resendApiKey,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

echo "HTTP Code: " . $httpCode . "\n";
echo "CURL Error: " . ($curlError ?: 'None') . "\n";
echo "Response: " . $response . "\n";
?>
