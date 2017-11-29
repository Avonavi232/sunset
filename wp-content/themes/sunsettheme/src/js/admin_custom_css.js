var editor = ace.edit('customCss');
editor.setTheme('ace/theme/monokai');
editor.getSession().setMode('ace/mode/css');

jQuery(document).ready(function ($) {
    function updateCSS() {
        $('#sunset_option_name_custom_css').val( editor.getSession().getValue() );
    }
    $('#save-custom-css-form').on('submit', updateCSS);
});
