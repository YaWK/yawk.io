$(document).ready(function() {
console.log('setupHelper.js loaded');
// Get the form element
const form = document.getElementById('installerForm');

// Add an event listener to the form submit event
    form.addEventListener('submit', (event) => {
        event.preventDefault(); // prevent the form from submitting

        // Get the form data
        const formData = new FormData(form);

        // Send an AJAX request to the server
        fetch('system/setup/checkDatabaseCredentials.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
                // Handle the response data
                if (data.success) {
                    // Credentials are valid, continue with installation
                    form.submit();
                }
                else
                {
                    // Credentials are invalid, display error message
                    $.notify({
                        // options
                        title: '<h4><i class=\"fa fa-database\"></i>&nbsp; SERVER RETURNED AN ERROR:</h4>',
                        message: '<b>'+data.message+'</b><br><br>Please check whether your data is correct and try again.',
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

                    var saveBtn = $("#savebutton");
//                    $(saveBtn).setAttribute('class', 'btn btn-danger pull-right');
                    $(saveBtn).html('2/5 Test Connection Again &nbsp;<i id="savebuttonIcon" class="fa fa-refresh"></i>').removeClass().addClass('btn btn-success pull-right');
                }
            })
            .catch(error => {
                // Handle any errors that occurred during the request
                console.error(error);
            });
    });

});