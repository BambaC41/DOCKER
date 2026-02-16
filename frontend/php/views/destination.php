<?php
// $destination or $errorMsg expected
?><!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= isset($destination['name']) ? htmlspecialchars($destination['name']) : 'Destination' ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>body{font-family:Arial,Helvetica,sans-serif;background:#f5f7fb;margin:0;padding:24px}.wrap{max-width:900px;margin:0 auto;background:#fff;padding:18px;border-radius:12px;box-shadow:0 8px 30px rgba(2,6,23,0.06)}</style>
</head>
<body>
  <div class="wrap">
    <?php if (!empty($errorMsg)): ?>
      <div style="color:#b91c1c"><?= htmlspecialchars($errorMsg) ?></div>
    <?php elseif (empty($destination)): ?>
      <div>Destination introuvable.</div>
    <?php else: ?>
      <h1><?= htmlspecialchars($destination['name']) ?></h1>
      <h3 style="color:#6b7280"><?= htmlspecialchars($destination['country'] ?? '') ?></h3>
      <?php if (!empty($destination['image_url'])): ?>
        <img src="<?= htmlspecialchars($destination['image_url']) ?>" alt="" style="width:100%;border-radius:8px;margin-top:12px">
      <?php endif; ?>
      <p style="margin-top:12px"><?= nl2br(htmlspecialchars($destination['description'] ?? '')) ?></p>
      <form method="get" action="">
        <input type="hidden" name="route" value="add-favorite">
        <input type="hidden" name="id" value="<?= intval($destination['id']) ?>">
        <button type="submit" style="padding:8px 12px;border-radius:8px;background:#2563eb;color:#fff;border:none">Ajouter aux favoris</button>
      </form>
    <?php endif; ?>
    <p><a href="?route=home">Retour</a></p>
  </div>
</body>
</html>