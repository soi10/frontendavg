<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $url = "https://sso2.pea.co.th/realms/pea-users/protocol/openid-connect/userinfo";

    $options = [
        'http' => [
            'header' => "Authorization: Bearer $token\r\n"
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        http_response_code(500);
        echo "Error fetching user info. Response was: " . $http_response_header[0];
    } else {
        echo $response;
    }
} else {
    http_response_code(400);
    echo "Missing token parameter.";
}
?>
