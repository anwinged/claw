<?php
  /* @var \League\Plates\Template\Template $this */
  /* @var \Claw\Entity\SearchRequest $searchRequest */
  /* @var array $errors */
  /* @var array $matches */

  $this->layout('layout', ['title' => 'Поиск']);
?>

<ul class="refs">
  <li class="refs__item"><a href="/">Поиск</a></li>
  <li class="refs__item"><a href="/items">Результаты</a></li>
</ul>

<form id="search-form" class="form" method="POST">

  <?php if ($errors): ?>
    <ul>
      <?php foreach ($errors as $errorText): ?>
        <li><?= $this->e($errorText) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <div class="form__group">
    <label class="form__label" for="url">Адрес:</label>
    <input class="form__input"
           name="url"
           id="url"
           type="url"
           value="<?= $this->e($searchRequest->getUrl()) ?>"
           maxlength="2000"
           placeholder="http://example.com"
           required
    >
  </div>

  <div class="form__group">
    <label class="form__label">Тип:</label>
    <?php foreach (\Claw\Entity\SearchType::getTypeNames() as $type => $name): ?>
      <input id="type_<?= $type ?>"
             class="form__type js-type-field"
             type="radio" name="type"
             value="<?= $type ?>"
             <?= $type === $searchRequest->getType() ? 'checked' : '' ?>
      >
      <label class="form__type-label" for="type_<?= $type ?>"><?= $name ?></label>
    <?php endforeach; ?>
  </div>

  <div class="form__group js-text-group hidden">
    <label class="form__label" for="text">Текст:</label>
    <textarea class="form__textarea" name="text" rows="3" maxlength="255" id="text"><?= $this->e($searchRequest->getText()) ?></textarea>
  </div>

  <button id="search-submit-button" class="form__submit" type="submit">Найти</button>
</form>

<!-- -->

<?php $this->start('js') ?>
  <script src="<?= $this->asset('/js/search.js') ?>"></script>
<?php $this->stop() ?>
