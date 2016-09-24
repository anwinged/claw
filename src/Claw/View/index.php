<?php
  $this->layout('layout', ['title' => 'Index'])

  /* @var string $name */
?>

<h1>User Profile</h1>
<p>Hello, <?= $this->e($name) ?> </p>
