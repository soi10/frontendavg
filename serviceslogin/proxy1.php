<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if (isset($_GET['redirect_uri']) && isset($_GET['response_type']) && isset($_GET['scope']) && isset($_GET['client_id'])) {
    $redirect_uri = urlencode($_GET['redirect_uri']);
    $response_type = urlencode($_GET['response_type']);
    $scope = urlencode($_GET['scope']);
    $client_id = urlencode($_GET['client_id']);
    
    $url = "https://sso2.pea.co.th/realms/pea-users/protocol/openid-connect/auth?redirect_uri=$redirect_uri&response_type=$response_type&scope=$scope&client_id=$client_id";

    header("Location: $url");
    exit();
} else {
    http_response_code(400);
    echo "Missing required query parameters.";
}
?>