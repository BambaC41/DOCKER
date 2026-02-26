<?php
$API_BASE = rtrim(getenv("API_BASE") ?: "http://localhost:8080");
function api_get_json($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 6,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_HTTPHEADER => ["Accept: application/json"],
    ]);
    $raw = curl_exec($ch);
    $err = curl_error($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($raw === false) throw new Exception("cURL error: $err");
    if ($code < 200 || $code >= 300) throw new Exception("HTTP $code: " . substr($raw, 0, 200));

    $data = json_decode($raw, true);
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("JSON invalide: " . substr($raw, 0, 200));
    }
    return $data;
}

function api_post_json($url, $payloadArr) {
    $payload = json_encode($payloadArr);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 6,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => ["Content-Type: application/json", "Accept: application/json"],
    ]);
    $raw = curl_exec($ch);
    $err = curl_error($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($raw === false) throw new Exception("cURL error: $err");
    if ($code < 200 || $code >= 300) throw new Exception("HTTP $code: " . substr($raw, 0, 200));
    return true;
}

function api_delete($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 6,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_HTTPHEADER => ["Accept: application/json"],
    ]);
    $raw = curl_exec($ch);
    $err = curl_error($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($raw === false) throw new Exception("cURL error: $err");
    if ($code === 204) return true;
    if ($code < 200 || $code >= 300) throw new Exception("HTTP $code: " . substr($raw, 0, 200));
    return true;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $action = $_POST["action"] ?? "";

        if ($action === "add") {
            $destId = intval($_POST["destination_id"] ?? 0);
            if ($destId > 0) {
                api_post_json("$API_BASE/favorites", [
                    "destination_id" => $destId
                ]);
            }
        }

        if ($action === "delete") {
            $favId = intval($_POST["favorite_id"] ?? 0);
            if ($favId > 0) api_delete("$API_BASE/favorites/$favId");
        }

        header("Location: index.php");
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$destinations = [];
$favorites = [];
$favMap = [];

try {
    $destinations = api_get_json("$API_BASE/destinations");
} catch (Exception $e) {
    $error = $e->getMessage();
}

try {
    $favorites = api_get_json("$API_BASE/favorites");

    if (is_array($favorites)) {
        foreach ($favorites as $f) {
            if (isset($f["destination_id"], $f["id"])) {
                $favMap[intval($f["destination_id"])] = intval($f["id"]);
            }
        }
    }
} catch (Exception $e) {
    
    if (!$error) {
        $error = "Favoris indisponibles: " . $e->getMessage();
    }
}

include __DIR__ . "/../html/template.php";
