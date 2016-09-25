<?php
  /* @var \League\Plates\Template\Template $this */
  /* @var \Claw\Entity\SearchResult $searchResult */

  $this->layout('layout', ['title' => 'Результаты поиска #'.$searchResult->getId()]);
?>

<ul class="refs">
  <li class="refs__item"><a href="/">Поиск</a></li>
  <li class="refs__item"><a href="/items">Результаты</a></li>
</ul>

<table class="detailed">
  <tr>
    <th>Адрес</th>
    <td><?= $this->e($searchResult->getUrl()) ?></td>
  </tr>
  <tr>
    <th>Тип поиска</th>
    <td><?= $this->e($searchResult->getTypeName()) ?></td>
  </tr>
  <?php if ($searchResult->getType() === \Claw\Entity\SearchType::TEXT): ?>
    <tr>
      <th>Текст</th>
      <td><?= $this->e($searchResult->getText()) ?></td>
    </tr>
  <?php endif ?>
  <tr>
    <th>Совпадений</th>
    <td><?= $this->e($searchResult->getMatchCount()) ?></td>
  </tr>
</table>

<table class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>Совпадение</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($searchResult->getMatches() as $index => $matchValue): ?>
      <tr>
        <td><?= $this->e($index + 1) ?></td>
        <td><?= $this->e($matchValue) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
