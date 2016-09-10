/*
 * Author: Daniel Retzl
 * Email: danielretzl@gmail.com
 * function set text on select in frontend
 */
$(document).ready(function () {
    $('#form').validate({ // initialize the plugin
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            message: {
                required: true
            },
            email: {
                required: true,
                email: true,
                maxlength: 128
            },
            phone: {
                required: true
            },
            todo: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Pflichtfeld. Bitte gib Deinen Namen (oder ein Pseudonym) an. &nbsp;"
            },
            email: {
                required: "Pflichtfeld. Bitte gib eine g&uuml;tige Emailadresse an. &nbsp;"
            },
            phone: {
                required: "Pflichtfeld. Ohne Telefonnummer kein Date! &nbsp;"
            },
            todo: {
                required: "Bitte w&auml;hle aus der Liste, was Du buchen m&ouml;chtest. &nbsp;"
            },
            message: {
                required: "Ohne Text wird das mit uns nichts. Schreib mir ein paar Zeilen! &nbsp;"
            }
        }
    });
});


    $(function() {
        $('#hidden_div').hide();
        $('#todo').change(function(){
            if($('#todo').val() == '1') {
                $('#1_hidden').fadeIn();
            } else {
                $('#1_hidden').hide();
            }
            if($('#todo').val() == '2') {
                $('#2_hidden').fadeIn();
            } else {
                $('#2_hidden').hide();
            }
            if($('#todo').val() == '3') {
                $('#3_hidden').fadeIn();
            } else {
                $('#3_hidden').hide();
            }
            if($('#todo').val() == '4') {
                $('#4_hidden').fadeIn();
            } else {
                $('#4_hidden').hide();
            }
            if($('#todo').val() == '0') {
                $('#5_hidden').fadeIn();
            } else {
                $('#5_hidden').hide();
            }
        });
    });