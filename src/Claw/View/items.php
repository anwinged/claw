<?php
  /* @var \League\Plates\Template\Template $this */
  /* @var \Claw\Entity\SearchResult[] $searchResults */

  $this->layout('layout', ['title' => 'Список запросов']);
?>

<ul class="refs">
  <li class="refs__item"><a href="/">Поиск</a></li>
  <li class="refs__item"><a href="/items">Результаты</a></li>
</ul>

<h2>Всего: <?= count($searchResults) ?></h2>

<table class="table">
  <thead>
    <tr>
      <th></th>
      <th>Адрес</th>
      <th>Тип</th>
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
          <a href="/view?id=<?= $searchResult->getId() ?>" title="<?= $this->e($searchResult->getUrl()) ?>">
            <?= $this->e($searchResult->getUrl()) ?>
          </a>
        </td>
        <td>
          <?= $this->e($searchResult->getTypeName()) ?>
        </td>
        <td>
          <?= $this->e($searchResult->getMatchCount()) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
