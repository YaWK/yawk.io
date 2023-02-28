$(document).ready(function() {  // wait until document is ready
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

// This file is a helper to check the database credentials via xhr
// Get the form element
const form = document.getElementById('installerForm');
// Add an event listener to the form submit event
    form.addEventListener('submit', (event) => {
        event.preventDefault(); // prevent the form from submitting

        // store save button in variable
        var saveBtn = $("#savebutton");

        // Get the form data
        const formData = new FormData(form);

        // Send an AJAX request to the server
        fetch('system/setup/checkDatabaseCredentials.php', {
            method: 'POST',
            body: formData
        })
            // Get the response as JSON
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
                // Handle the response data
                if (data.success)
                {   // Credentials are valid, continue with installation

                    // indicate loading state, change button text and icon
                    $(saveBtn).removeClass('btn btn-success').html('<small>2/5</small> '+data.DB_IMPORT_BTN+' &nbsp;<i class=\"fa fa-spinner fa-spin fa-fw\"></i>').addClass('btn btn-danger disabled');

                    // submit form
                    form.submit();

                    // disable save button to prevent double submission if user clicks multiple times
                    $(saveBtn).prop('disabled', true);

                    // credentials are valid, display success message
                    $.notify({
                        // options
                        title: '<h4><i class=\"fa fa-database\"></i>&nbsp; '+data.message+'</h4>',
                        message: '<b>'+data.importmsg+'</b>',
                    }, {
                        // settings
                        type: 'success',
                        element: 'body',
                        position: null,
                        allow_dismiss: 'false',
                        newest_on_top: 'true',
                        placement: {
                            from: 'top',
                            align: 'center'
                        },
                        offset: {
                            x: 10,
                            y: 62
                        },
                        spacing: 10,
                        z_index: 9999,
                        delay: 6200,
                        timer: 420,
                        mouse_over: 'pause',
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        }
                    });
                }
                else
                {   // Credentials are invalid, display error message
                    $.notify({
                        // options
                        title: '<h4><i class=\"fa fa-database\"></i>&nbsp; '+data.message+'</h4>',
                        message: '<b>'+data.subline+'</b>',
                    }, {
                        // settings
                        type: 'danger',
                        element: 'body',
                        position: null,
                        allow_dismiss: 'false',
                        newest_on_top: 'true',
                        placement: {
                            from: 'top',
                            align: 'center'
                        },
                        offset: {
                            x: 10,
                            y: 62
                        },
                        spacing: 10,
                        z_index: 9999,
                        delay: 4200,
                        timer: 420,
                        mouse_over: 'pause',
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        }
                    });

                    // change button text and icon
                    $(saveBtn).html('2/5 '+data.checkagain+' &nbsp;<i id="savebuttonIcon" class="fa fa-refresh"></i>').removeClass().addClass('btn btn-success pull-right');
                }
            })
            .catch(error => {
                // Handle any errors that occurred during the request
                console.error(error);
            });
    });
});