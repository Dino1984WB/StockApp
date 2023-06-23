<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $phone_number = $data["phone_number"];
    $stock_ticker = $data["stock_ticker"];
    $threshold = $data["threshold"];
    $message = $data["message"];

    if ($phone_number && $stock_ticker && $threshold && $message) {
        $response = send_sms($phone_number, $message);
        if ($response === FALSE) {
            error_log("SMS failed to send for $phone_number");
            http_response_code(500);
            echo json_encode(['error' => 'Failed to send SMS']);
        } else {
            http_response_code(200);
            echo json_encode(['message' => 'SMS sent successfully']);
        }
    }
}

function send_sms($phone_number, $message) {
    $url = "https://api.twilio.com/2010-04-01/Accounts/ACXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX/Messages.json";
    $account_sid = 'your_account_sid';
    $auth_token = 'your_auth_token';
    $data = [
        "From" => "YOUR_TWILIO_PHONE_NUMBER",
        "To" => $phone_number,
        "Body" => $message
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n".
                         "Authorization: Basic ".base64_encode("$account_sid:$auth_token")."\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    return $result;
}
?>
