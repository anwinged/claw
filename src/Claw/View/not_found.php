<?php
  /* @var \League\Plates\Template\Template $this */
  /* @var string $subject */

  $subject = $subject ?? 'Страница';

  $this->layout('layout', ['title' => $subject.' не найдена']);
?>

<p>
  А что тут у нас? А ничего тут у нас :-)
</p>

<p>
  Вернуться к <a href="/items">списку</a> или к <a href="/">поиску</a>.
</p>
