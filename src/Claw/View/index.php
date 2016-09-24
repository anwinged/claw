<?php
  /* @var \League\Plates\Template\Template $this */
  /* @var \Claw\Entity\SearchRequest $searchRequest */
  /* @var array $errors */
  /* @var array $matches */

  $this->layout('layout', ['title' => 'Index']);
?>

<form class="form" method="POST">

  <?php if ($errors): ?>
    <ul>
      <?php foreach ($errors as $errorText): ?>
        <li><?= $this->e($errorText) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <div class="form__group">
    <label for="url">Адрес</label>
    <input name="url" id="url" type="url" value="<?= $this->e($searchRequest->getUrl()) ?>" required>
  </div>

  <div class="form__group">
    <label for="type">Тип</label>
    <select name="type" id="type" required>
      <?php foreach (\Claw\Entity\SearchRequestType::getTypeNames() as $type => $name): ?>
        <option value="<?= $type ?>" <?= $type === $searchRequest->getType() ? 'selected' : '' ?> >
          <?= $this->e($name) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form__group">
    <label for="text">Текст</label>
    <input name="text" type="text" id="text" value="<?= $this->e($searchRequest->getText()) ?>">
  </div>

  <button type="submit">Найти</button>
</form>

<?php if ($matches): ?>
  <h2>Всего: <?= count($matches) ?></h2>
  <ul>
    <?php foreach ($matches as $matchValue): ?>
      <li><?= $this->e($matchValue) ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
