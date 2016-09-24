<?php
/* @var \League\Plates\Template\Template $this */
/* @var \Claw\Entity\SearchResult[] $searchResults */

$this->layout('layout', ['title' => 'Список запросов']);
?>

<h2>Всего: <?= count($searchResults) ?></h2>
<ol>
  <?php foreach ($searchResults as $searchResult): ?>
    <li>
      <a href="/view?id=<?= $searchResult->getId() ?>">
        <?= $this->e($searchResult->getUrl()) ?></a>
      <?= $this->e($searchResult->getTypeName()) ?>
      <?= $this->e($searchResult->getMatchCount()) ?>
    </li>
  <?php endforeach; ?>
</ol>
