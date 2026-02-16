<?php

$apiBaseUrl = "http://172.168.0.32:8080";

// Fonction générique pour appeler l'API
function callApi($method, $endpoint, $data = null) {
    global $apiBaseUrl;

    $url = $apiBaseUrl . $endpoint;

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
    }

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}