(function ($) {

    var TYPE_TEXT = 'text';

    var init = function () {
        var typeElement = $('.js-type-field');
        var currentType = typeElement.filter(':checked').val();
        handleTypeChange(currentType);

        var button = $('#search-submit-button');
        button.prop('disabled', false);

        typeElement.on('change', onTypeChanged);
        $('#search-form').on('submit', onFormSubmit);
    };

    var onTypeChanged = function (evt) {
        var currentType = $(evt.currentTarget).val();
        handleTypeChange(currentType);
    };

    var handleTypeChange = function(currentType) {
        var textGroup = $('.js-text-group');
        var isTextType = currentType === TYPE_TEXT;
        textGroup.toggleClass('hidden', !isTextType);
        textGroup.find(':input').prop('disabled', !isTextType);
        textGroup.find(':input').prop('required', isTextType);
    };

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

    var onSuccessFormSubmit = function (answer) {
        var newPageElement = $(answer).filter('#page');
        $('#page').replaceWith(newPageElement);
    };

    var onFailedFormSubmit = function (xhr) {
        console.error(xhr);
    };

    $(document).ready(init);

}(jQuery));
