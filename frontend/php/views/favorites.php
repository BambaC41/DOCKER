<?php
// $favorite_items or $favorites or $errorMsg expected
?><!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Favoris</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>body{font-family:Arial,Helvetica,sans-serif;background:#f5f7fb;margin:0;padding:24px}.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:18px}.card{background:#fff;padding:12px;border-radius:10px;box-shadow:0 6px 18px rgba(2,6,23,0.06)}</style>
</head>
<body>
  <h1>Favoris</h1>
  <?php if (!empty($errorMsg)): ?>
    <div style="color:#b91c1c"><?= htmlspecialchars($errorMsg) ?></div>
  <?php endif; ?>

  <?php if (empty($favorite_items)): ?>
    <div style="padding:18px;background:#fff;border-radius:8px">Aucun favori pour le moment.</div>
  <?php else: ?>
    <div class="grid">
      <?php foreach ($favorite_items as $d): ?>
        <div class="card">
          <h3><?= htmlspecialchars($d['name'] ?? '') ?></h3>
          <div style="color:#6b7280"><?= htmlspecialchars($d['country'] ?? '') ?></div>
          <p><?= htmlspecialchars(mb_strimwidth($d['description'] ?? '', 0, 120, '…')) ?></p>
          <div style="display:flex;gap:8px;margin-top:8px">
            <a href="?route=destination&id=<?= intval($d['id']) ?>">Voir</a>
            <!-- If your favorites objects have an id in $favorites, allow delete -->
            <?php if (!empty($favorites)): foreach ($favorites as $f): if ((isset($f['destination_id']) && intval($f['destination_id'])===intval($d['id'])) || (isset($f['destinationId']) && intval($f['destinationId'])===intval($d['id']))): ?>
              <?php $fid = intval($f['id'] ?? 0); if($fid>0): ?>
                <a href="?route=delete-favorite&id=<?= $fid ?>" style="color:#b91c1c">Supprimer</a>
              <?php endif; ?>
            <?php endif; endforeach; endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <p><a href="?route=home">Retour</a></p>
</body>
</html>