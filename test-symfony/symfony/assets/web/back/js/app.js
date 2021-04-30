/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you require will output into a single css file (app.css in this case)
require('../css/root.css')
require('./jquery.min')

require('./plugin/bootstrap/bootstrap.min')
require('./plugin/plugins')
require('select2')
require('select2/dist/css/select2.css')
require('./select2-fr')
require('./bootstrap-filestyle.min')
require('./collections')
require('moment')
require('./plugin/date-range-picker/daterangepicker.js')
const swal = require('./plugin/sweet-alert/sweet-alert.min')
// require jQuery normally
 const $ = require('jquery');
// create global $ and jQuery variables
 global.$ = global.jQuery = $;
$('.daterangepicker-wrapper input[type="text"]').daterangepicker({
    "format": "DD/MM/YYYY",
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Valider",
        "cancelLabel": "Annuler",
        "fromLabel": "Du",
        "toLabel": "Au",
        "daysOfWeek": [
            "Dim",
            "Lun",
            "Mar",
            "Mer",
            "Jeu",
            "Ven",
            "Sam"
        ],
        "monthNames": [
            "Janvier",
            "Fevrier",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Août",
            "Septembre",
            "Octobre",
            "Novembre",
            "Decembre"
        ],
        "firstDay": 1
    },
});
$('[data-toggle=swal]').on('click', function (e) {
    e.preventDefault();
    var form = $(this).closest('form');
    var confirmUrl = $(this).data('swal-confirm-url');
    var targetType = $(this).attr('type');
    swal({
            title: $(this).data('swal-title'),
            text: $(this).data('swal-text'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: $(this).data('swal-confirm-button-color'),
            confirmButtonText: $(this).data('swal-confirm-button-text'),
            cancelButtonText: $(this).data('swal-cancel-button-text'),
            closeOnConfirm: false,
            closeOnCancel: true,
            allowOutsideClick: true
        },
        function (isConfirm) {
            if (isConfirm) {
                if('submit' === targetType) {
                    form.submit();
                } else {
                    window.location.href = confirmUrl;
                }
            }
        });
});
