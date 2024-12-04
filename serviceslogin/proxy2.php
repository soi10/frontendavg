<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $client_id = $_POST['client_id'];
    $client_secret = $_POST['client_secret'];
    $redirect_uri = $_POST['redirect_uri'];
    $grant_type = 'authorization_code';

    $url = "https://sso2.pea.co.th/realms/pea-users/protocol/openid-connect/token";

    $data = http_build_query([
        'code' => $code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => $grant_type
    ]);

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => $data
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        http_response_code(500);
        echo "Error fetching token. Response was: " . $http_response_header[0];
    } else {
        $response_data = json_decode($response, true);
        if (isset($response_data['access_token'])) {
            echo json_encode($response_data);
        } else {
            http_response_code(500);
            echo "Error: Access token not found in the response. Full response: " . json_encode($response_data);
        }
    }
} else {
    http_response_code(400);
    echo "Invalid request method.";
}
?>
