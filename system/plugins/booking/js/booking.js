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
            }
        },
        messages: {
            name: {
                required: "Please enter your name (or pseudonym). &nbsp;"
            },
            email: {
                required: "Please enter a valid email address. &nbsp;"
            },
            phone: {
                required: "Please enter your phone number. &nbsp;"
            },
            message: {
                required: "Please enter your message. &nbsp;"
            }
        }
    });
});
