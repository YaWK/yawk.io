// this is the id of the form
$("#bookingForm").submit(function(e) {

    console.log('JS file called!');

    var form = $(this);
    var url = form.attr('action');
    var thankYouMessage = $("#thankYouMessage");

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
            // hide form
            $("#bookingForm").hide();
            // display thank you message
            thankYouMessage.removeClass("hidden").addClass("animated fadeIn speed6");
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