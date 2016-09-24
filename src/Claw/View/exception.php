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
