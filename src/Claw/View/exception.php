<?php
  /* @var \League\Plates\Template\Template $this */
  /* @var \Exception $exception */

  $this->layout('layout', ['title' => 'Ошибка']);
?>

<p>
  <?= $this->e($exception->getMessage()) ?>
</p>

<pre>
<?= $this->e($exception->getTraceAsString()) ?>
</pre>

<ul class="refs">
  <li class="refs__item"><a href="/">Поиск</a></li>
  <li class="refs__item"><a href="/items">Результаты</a></li>
</ul>
