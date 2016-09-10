/*
 * admin.js
 * legend selector for textarea
 *
 * */
$(document).ready(function () {
    /*
     * function on select set legend (text) in frontend beneath the form
     */

        /*
        BUILD A FUNCTION THAT DYNAMICALLY REACTS TO i GROUPS

        // count all legend textareas
        var count_element = $( "textarea[name^='legend']").length
        var gid = count_element;
        gid--;
        // for every element
        while (count_element > 0) {
            // hide all
            $('#'+gid+'_hidden').hide();
            // except default text
            $('#0_hidden').fadeIn();
            // on group selector change
            $('#gid-legend').change(function() {
                // show gid legend
                if($('#gid-legend').val() == 0) {
                    $('#0_hidden').fadeIn();
                    $('#'+gid+'_hidden').hide();
                    $('#'+$('#gid-legend').val()+'_hidden').hide();
                }
               else if ($('#gid-legend').val() >= gid) {
                    $('#'+$('#gid-legend').val()+'_hidden').fadeIn();
                     $('#'+gid+'_hidden').hide();
               }
                else {
                    $('#'+gid+'_hidden').hide();
                    $('#'+$('#gid-legend').val()+'_hidden').hide();
                }
            });
            gid--;
            count_element--;
        }
    });
         */

        $('#1_hidden').hide();
        $('#2_hidden').hide();
        $('#3_hidden').hide();
        $('#4_hidden').hide();
        $('#5_hidden').hide();
        $('#gid-legend').change(function(){
            // gid 0
            if($('#gid-legend').val() == '0') {
                $('#0_hidden').fadeIn();
                $('#1_hidden').hide();
                $('#2_hidden').hide();
                $('#3_hidden').hide();
                $('#4_hidden').hide();
                $('#5_hidden').hide();
            } else {
                $('#0_hidden').hide();
                $('#1_hidden').hide();
                $('#2_hidden').hide();
                $('#3_hidden').hide();
                $('#4_hidden').hide();
                $('#5_hidden').hide();
            }
            // gid 5
            if($('#gid-legend').val() == '5') {
                $('#5_hidden').fadeIn();
            }
            // gid 4
            if($('#gid-legend').val() == '4') {
                $('#4_hidden').fadeIn();
            }
            // gid 3
            if($('#gid-legend').val() == '3') {
                $('#3_hidden').fadeIn();
            }
            // gid 2
            if($('#gid-legend').val() == '2') {
                $('#2_hidden').fadeIn();
            }
            // gid 1
            if($('#gid-legend').val() == '1') {
                $('#1_hidden').fadeIn();
            }
        });
});