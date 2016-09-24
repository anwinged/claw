<?php
  /* @var string $title */
  /* @var string $appName */
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $this->e($title) ?> - <?= $this->e($appName) ?></title>
  <link rel="stylesheet" href="<?= $this->asset('/css/layout.css') ?>" />
  <link rel="stylesheet" href="<?= $this->asset('/css/helpers.css') ?>" />
</head>
<body>

  <div class="layout__page">

    <header>
      <h1><?= $this->e($title) ?></h1>
    </header>

    <main class="layout__content">
      <?= $this->section('content') ?>
    </main>

  </div>

  <script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
  <?= $this->section('js') ?>
</body>
</html>
