<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $this->e('title') ?></title>
  <link rel="stylesheet" href="<?= $this->asset('/css/layout.css') ?>" />
</head>
<body>
  <main class="layout__content">
    <?= $this->section('content') ?>
  </main>
</body>
</html>
