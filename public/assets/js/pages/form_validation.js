$(function() {
    altair_form_validation.init()
}), altair_form_validation = {
    init: function() {
        var i = $("#form_validation");
        i.parsley({
            excluded: "input[type=button], input[type=submit], input[type=reset], input[type=hidden], .selectize-input > input"
        }).on("form:validated", function() {
            altair_md.update_input(i.find(".md-input-danger"))
        }).on("field:validated", function(i) {
            ($(i.$element).hasClass("md-input") || $(i.$element).is("select")) && altair_md.update_input($(i.$element))
        }), window.Parsley.on("field:validate", function() {
            var i = $(this.$element).closest(".md-input-wrapper").siblings(".error_server_side");
            i && i.hide()
        }), $("#val_birth").on("hide.uk.datepicker", function() {
            $(this).parsley().validate()
        })
    }
};