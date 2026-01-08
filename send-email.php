<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validate required fields
        if (empty($data['company']) || empty($data['email']) || empty($data['message'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }
        
        // Sanitize inputs
        $company = htmlspecialchars($data['company']);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $message = htmlspecialchars($data['message']);
        
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid email address']);
            exit;
        }
        
        // Prepare email content
        $emailBody = "New inquiry from Smart Systems landing page\n\n";
        $emailBody .= "Company: " . $company . "\n";
        $emailBody .= "Email: " . $email . "\n\n";
        $emailBody .= "Message:\n" . $message . "\n";
        
        // Send via Resend API
        $resendApiKey = 're_XZGzn28r_GZtRPUPVtZcy9kEmt9wuTp7j';
        
        $payload = [
            'from' => 'lindsay@manageonsite.com',
            'to' => ['info@manageonsite.com'],
            'reply_to' => $email,
            'subject' => 'New Inquiry from ' . $company,
            'text' => $emailBody
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
        
        if ($curlError) {
            throw new Exception('CURL Error: ' . $curlError);
        }
        
        if ($httpCode === 200) {
            echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
        } else {
            $errorDetails = json_decode($response, true);
            throw new Exception('Resend API Error (HTTP ' . $httpCode . '): ' . json_encode($errorDetails));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Server error', 'message' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
