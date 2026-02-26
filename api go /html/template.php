<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>CityGuide</title>
  <link rel="stylesheet" href="/style.css?v=1">
</head>
<body>

<header>  
  <h1>🌍 CityGuide</h1>
  <p class="muted">API: <?= htmlspecialchars($API_BASE ?? "") ?></p>
</header>

<div class="container">

<?php if (!empty($error)): ?>
  <div class="card">
    <div class="content">
      <p class="error">⚠ <?= htmlspecialchars($error) ?></p>
    </div>
  </div>
<?php endif; ?>

<?php foreach ($destinations as $d): 
  $id = intval($d["id"] ?? 0);
  $isFav = isset($favMap[$id]);
  $img = $d["image_url"] ?? ($d["image"] ?? "");
?>
  <div class="card">
    <div class="image" style="background-image:url('<?= htmlspecialchars($img) ?>')"></div>

    <div class="content">
      <h2><?= htmlspecialchars($d["name"] ?? "") ?></h2>
      <p class="country"><?= htmlspecialchars($d["country"] ?? "") ?></p>
      <p><?= htmlspecialchars(substr($d["description"] ?? "", 0, 90)) ?>...</p>

      <?php if ($isFav): ?>
        <form method="post">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="favorite_id" value="<?= intval($favMap[$id]) ?>">
          <button class="btn fav">★ Supprimer</button>
        </form>
      <?php else: ?>
        <form method="post">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="destination_id" value="<?= $id ?>">
          <button class="btn">☆ Ajouter</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
<?php endforeach; ?>

</div>
</body>
</html>