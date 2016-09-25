(function ($) {

    var TYPE_TEXT = 'text';

    /**
     * Инициализарует события страницы
     */
    var init = function () {
        var typeElement = $('.js-type-field');
        var currentType = typeElement.filter(':checked').val();
        handleTypeChange(currentType);

        var button = $('#search-submit-button');
        button.prop('disabled', false);

        typeElement.on('change', onTypeChanged);
        $('#search-form').on('submit', onFormSubmit);
    };

    /**
     * Событие изменение типа поиска
     *
     * @param evt
     */
    var onTypeChanged = function (evt) {
        var currentType = $(evt.currentTarget).val();
        handleTypeChange(currentType);
    };

    /**
     * Обрабатывает изменение типа поиска
     *
     * @param currentType Новый выбранный тип
     */
    var handleTypeChange = function(currentType) {
        var textGroup = $('.js-text-group');
        var isTextType = currentType === TYPE_TEXT;
        textGroup.toggleClass('hidden', !isTextType);
        textGroup.find(':input').prop('disabled', !isTextType);
        textGroup.find(':input').prop('required', isTextType);
    };

    /**
     * Событие отправки формы
     *
     * @param evt
     */
    var onFormSubmit = function (evt) {
        evt.preventDefault();

        var url = location;
        var data = $(evt.currentTarget).serializeArray();

        data.push({
            name: 'ajax',
            value: 1
        });

        var button = $('#search-submit-button');
        button.prop('disabled', true);
        button.html('<i class="fa fa-spin fa-spinner"></i> Поиск...');

        var request = $.post(url, data);

        request.done(onSuccessFormSubmit);
        request.fail(onFailedFormSubmit);
    };

    /**
     * Обработчик успешной отправки
     *
     * @param answer
     */
    var onSuccessFormSubmit = function (answer) {
        replacePageContent(answer);
    };

    /**
     * Обработчик ошибки при отправке
     *
     * @param xhr
     */
    var onFailedFormSubmit = function (xhr) {
        replacePageContent(xhr.responseText);
    };

    /**
     * Заменяет содержимое страницы
     *
     * @param content
     */
    var replacePageContent = function (content) {
        var newPageElement = $(content).filter('#page');
        $('#page').replaceWith(newPageElement);
    };

    $(document).ready(init);

}(jQuery));
