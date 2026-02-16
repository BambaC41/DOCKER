<?php
// $destinations or $errorMsg expected
?><!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>City Guide - Destinations</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f5f7fb;margin:0;padding:24px}
    .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:18px}
    .card{background:#fff;padding:12px;border-radius:10px;box-shadow:0 6px 18px rgba(2,6,23,0.06)}
    .img{height:130px;background-size:cover;background-position:center;border-radius:8px}
    .meta{font-size:13px;color:#6b7280}
    a{color:#0b61ff;text-decoration:none}
  </style>
</head>
<body>
  <h1>Destinations</h1>
  <?php if (!empty($errorMsg)): ?>
    <div style="color:#b91c1c;padding:12px;background:#fee2e2;border-radius:8px"><?= htmlspecialchars($errorMsg) ?></div>
  <?php endif; ?>

  <?php if (empty($destinations)): ?>
    <p>Aucune destination trouvée.</p>
  <?php else: ?>
    <div class="grid">
      <?php foreach ($destinations as $d): ?>
        <div class="card">
          <div class="img" style="background-image:url('<?= htmlspecialchars($d['image_url'] ?? '') ?>')"></div>
          <h3><?= htmlspecialchars($d['name'] ?? '—') ?></h3>
          <div class="meta"><?= htmlspecialchars($d['country'] ?? '') ?></div>
          <p><?= htmlspecialchars(isset($d['description']) ? (mb_strimwidth($d['description'], 0, 120, '…') ) : '') ?></p>
          <div><a href="?route=destination&id=<?= intval($d['id']) ?>">Voir</a></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</body>
</html>