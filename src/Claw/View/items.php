<?php
  /* @var \League\Plates\Template\Template $this */
  /* @var \Claw\Entity\SearchResult[] $searchResults */

  $this->layout('layout', ['title' => 'Список запросов']);
?>

<h2>Всего: <?= count($searchResults) ?></h2>

<table class="table">
  <thead>
    <tr>
      <th></th>
      <th>Адрес</th>
      <th>Тип</th>
      <th>Результаты</th>
      <th>Результаты</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($searchResults as $index => $searchResult): ?>
      <tr>
        <td>
          <?= $this->e($index) ?>
        </td>
        <td>
          <span title="<?= $this->e($searchResult->getUrl()) ?>">
            <?= $this->e($searchResult->getUrl()) ?>
          </span>
        </td>
        <td>
          <?= $this->e($searchResult->getTypeName()) ?>
        </td>
        <td>
          <?= $this->e($searchResult->getMatchCount()) ?>
        </td>
        <td>
          <a href="/view?id=<?= $searchResult->getId() ?>">Посмотреть</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
