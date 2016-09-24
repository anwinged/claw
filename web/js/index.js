(function ($) {

    var init = function () {
        console.log('Yeeah!');
        $('.js-type-field').on('change', onTypeChanged).trigger('change');
    };

    var onTypeChanged = function (evt) {
        var currentType = $(evt.currentTarget).val();
        var textGroup = $('.js-text-group');
        textGroup.toggleClass('hidden', currentType !== 'text');
        textGroup.find(':input').prop('disabled', currentType !== 'text');
        textGroup.find(':input').prop('required', currentType === 'text');
    };

    $(document).ready(init);

}(jQuery));
