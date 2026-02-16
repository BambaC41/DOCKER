<?php
// Mini-routeur front qui proxy les appels vers l'API distante
require_once __DIR__ . '/api.php';

header('X-Frame-Options: DENY');

$route = $_GET['route'] ?? null;

// Support simple routes via PATH (ex: /destination?id=2)
if (!$route) {
    $u = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $parts = explode('/', trim($u, '/'));
    $route = $parts[0] ?? 'home';
}

function clean_id($name = 'id') {
    return isset($_GET[$name]) ? intval($_GET[$name]) : 0;
}

switch ($route) {
    case 'health':
        // Just forward raw text if present
        $res = api_call('GET', '/health');
        if ($res['ok'] && is_string($res['raw'])) {
            header('Content-Type: text/plain; charset=utf-8');
            echo $res['raw'];
        } else {
            http_response_code(502);
            echo 'Error: API health check failed';
        }
        break;

    case 'ping':
        $res = api_call('GET', '/ping');
        header('Content-Type: application/json; charset=utf-8');
        if ($res['ok']) echo json_encode($res['body']);
        else { http_response_code(502); echo json_encode(['error' => 'ping failed']); }
        break;

    case 'destinations':
    case 'home':
        $res = api_call('GET', '/api/destinations');
        if (!$res['ok']) {
            $errorMsg = "Unable to fetch destinations (HTTP {$res['status']})";
            include __DIR__ . '/views/home.php';
            break;
        }
        $destinations = $res['body'] ?? [];
        include __DIR__ . '/views/home.php';
        break;

    case 'destination':
        $id = clean_id('id');
        if ($id <= 0) { http_response_code(400); echo "Invalid id"; exit; }
        $res = api_call('GET', "/api/destinations/{$id}");
        if (!$res['ok']) {
            $errorMsg = "Destination not found (HTTP {$res['status']})";
            include __DIR__ . '/views/destination.php';
            break;
        }
        $destination = $res['body'] ?? null;
        include __DIR__ . '/views/destination.php';
        break;

    case 'favorites':
        $res = api_call('GET', '/api/favorites');
        if (!$res['ok']) {
            $errorMsg = "Unable to fetch favorites (HTTP {$res['status']})";
            $favorites = [];
            include __DIR__ . '/views/favorites.php';
            break;
        }
        $favorites = $res['body'] ?? [];
        // Optionally fetch destination details for each favorite if API returns destination_id
        $items = [];
        foreach ($favorites as $f) {
            $did = isset($f['destination_id']) ? intval($f['destination_id']) : (isset($f['destinationId']) ? intval($f['destinationId']) : 0);
            if ($did > 0) {
                $dres = api_call('GET', "/api/destinations/{$did}");
                if ($dres['ok']) $items[] = $dres['body'];
            }
        }
        $favorite_items = $items;
        include __DIR__ . '/views/favorites.php';
        break;

    case 'add-favorite':
        $destinationId = clean_id('id');
        if ($destinationId <= 0) { http_response_code(400); echo "Invalid destination id"; exit; }
        $post = ['destinationId' => $destinationId];
        $res = api_call('POST', '/api/favorites', $post);
        if (!$res['ok']) {
            http_response_code(502);
            echo "Failed to add favorite (HTTP {$res['status']})";
            exit;
        }
        header('Location: ?route=favorites');
        break;

    case 'delete-favorite':
        $favId = clean_id('id');
        if ($favId <= 0) { http_response_code(400); echo "Invalid favorite id"; exit; }
        $res = api_call('DELETE', "/api/favorites/{$favId}");
        if (!$res['ok']) {
            http_response_code(502);
            echo "Failed to delete favorite (HTTP {$res['status']})";
            exit;
        }
        header('Location: ?route=favorites');
        break;

    default:
        // 404 simple
        http_response_code(404);
        echo "Route not found";
        break;
}