(function ($) {

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
        textGroup.toggleClass('hidden', currentType !== 'text');
        textGroup.find(':input').prop('disabled', currentType !== 'text');
        textGroup.find(':input').prop('required', currentType === 'text');
    };

    $(document).ready(init);

}(jQuery));
