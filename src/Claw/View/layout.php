<?php
  /* @var string $title */
  /* @var string $appName */
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $this->e($title) ?> - <?= $this->e($appName) ?></title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=cyrillic" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= $this->asset('/css/layout.css') ?>" />
  <link rel="stylesheet" href="<?= $this->asset('/css/helpers.css') ?>" />
  <link rel="stylesheet" href="<?= $this->asset('/css/form.css') ?>" />
  <link rel="stylesheet" href="<?= $this->asset('/css/table.css') ?>" />
  <link rel="stylesheet" href="<?= $this->asset('/css/detailed.css') ?>" />
  <link rel="stylesheet" href="<?= $this->asset('/css/refs.css') ?>" />
</head>
<body>

  <div id="page" class="layout__page">

    <header class="layout__header">
      <h1 class="layout__title"><?= $this->e($title) ?></h1>
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
