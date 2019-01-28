// this is the id of the form
$("#bookingForm").submit(function(e) {

    console.log('JS file called!');

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
            // $("#bookingForm").hide();
            alert('success: '+data); // show response from the php script.
            console.log('ajax post successful');

            // hide form and display success message
            $("#bookingForm").hide();

        },
        error: function (request, status, error)
        {
            // error output
            alert('error: '+data);
            console.log('ERROR: ajax post failed with error '+data);

            // shake form
            $("#bookingForm").shake();
        }
    });
    // avoid form submit behavior.
    e.preventDefault();
});