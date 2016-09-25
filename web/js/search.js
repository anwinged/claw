(function ($) {

    var TYPE_TEXT = 'text';

    var init = function () {
        var typeElement = $('.js-type-field');
        var currentType = typeElement.filter(':checked').val();
        handleTypeChange(currentType);

        typeElement.on('change', onTypeChanged);
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

    $(document).ready(init);

}(jQuery));
