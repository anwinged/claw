<?php
/* @var \League\Plates\Template\Template $this */
/* @var \Claw\Entity\SearchResult $searchResult */

$this->layout('layout', ['title' => 'Index']);
?>

<?php if ($searchResult->getMatches()): ?>
  <h2>Всего: <?= count($searchResult->getMatches()) ?></h2>
  <ol>
    <?php foreach ($searchResult->getMatches() as $matchValue): ?>
      <li><?= $this->e($matchValue) ?></li>
    <?php endforeach; ?>
  </ol>
<?php endif; ?>
