$(document).ready(function() {  // wait until document is ready

    // get button and nodes
    var updateBtn = $("#checkForUpdatesBtn");
    var readFilebaseNode = $("#readFilebaseNode");
    let installedVersion = $('#installedVersion').text(); // the current installed version of YAWK
    var updateVersion = ''; // latest version of YAWK (filled with api call from update.yawk.io)
    var statusBarNode = $("#statusBarNode"); // status bar node
    var statusBarMessage = '';  // message to display in status bar
    var successMsg = ''; // holds success message, if update is available
    var errorMsg = ''; // holds error message, if no update is available
    let lang = $('#checkForUpdatesBtn');
    let updateCheck = lang.attr('data-UPDATE_CHECK');

    /* UPDATE BTN CLICK */
// if update button is clicked
    $(updateBtn).click(function() {
        // update button with spinner icon
        $(updateBtn).html("<i class=\"fa fa-refresh fa-spin\"></i> &nbsp;" + updateCheck);

        // Call compareVersions() to check if there is an update available
        checkVersion(function(error, updateVersion) {

            let lang = $('#checkForUpdatesBtn');
            let updateAvailable = lang.attr('data-UPDATE_AVAILABLE');
            let updateAvailableSubtext = lang.attr('data-UPDATE_AVAILABLE_SUBTEXT');
            let updateNotAvailable = lang.attr('data-UPDATE_NOT_AVAILABLE');
            let updateNotAvailableSubtext = lang.attr('data-UPDATE_NOT_AVAILABLE_SUBTEXT');
            let updateInstall = lang.attr('data-UPDATE_INSTALL');
            let updateUpToDate = lang.attr('data-UPDATE_UP_TO_DATE');
            let updateCurrentInstalledVersion = lang.attr('data-UPDATE_CURRENT_INSTALLED_VERSION');
            let updateNoUpdate = lang.attr('data-UPDATE_NO_UPDATE');
            let verifyingFiles = lang.attr('data-UPDATE_VERIFYING_FILES');

            if (error) {
                console.error(error);
            } else {


                if (compareVersions(installedVersion, updateVersion) < 0) {
                    // update available msg
                    statusBarMessage = '<span class="animated lightSpeedIn">'+updateAvailable + ': ' + updateVersion+'</span>';
                    successMsg = '<span class="text-primary animated zoomInDown"><b><i class="fa fa-globe animated bounce slow"></i> &nbsp;' + statusBarMessage + '</b></span>';
                    statusBarNode.html(successMsg).fadeIn(1000);
                    console.log(statusBarMessage);

                    // change update button to install update
                    $("#checkForUpdatesBtn").remove();

                    // Create a new startUpdateBtn element with the given attributes
                    var newBtn = $('<a>', {
                        'href': '#startUpdateBtn',
                        'id': 'startUpdateBtn',
                        'class': 'btn btn-primary pull-right animated fadeIn slow',
                        'html': '<i class="fa fa-download"></i> &nbsp;' + updateInstall
                    });
                    // Append the new startUpdateBtn to a container element on the page
                    $('#updateBtnNode').append(newBtn);

                    var startUpdateBtn = $("#startUpdateBtn");
                    $(startUpdateBtn).click(function() {
                        console.log('install update button clicked, read local filebase and store to ini file');
                        startUpdateBtn.html("<i class=\"fa fa-refresh fa-spin\"></i> &nbsp;&nbsp;" + verifyingFiles);
                        // if install update button is clicked
                        readFileBase();
                    });

                } else {
                    statusBarMessage = updateNotAvailable + ' (' + installedVersion + ') ' + updateNotAvailableSubtext;
                    errorMsg = '<span class="text-success animated fadeIn slow"><i class="fa fa-check-circle-o"></i> &nbsp;' + statusBarMessage + '</span>';
                    statusBarNode.html(errorMsg).fadeIn(1000);
                    $(updateBtn).removeClass().addClass('btn btn-default pull-right disabled animated fadeIn slow').html("<i class=\"fa fa-check-circle-o\"></i> &nbsp;" + updateNoUpdate);
                    console.log(statusBarMessage);
                }
            }
        });
    });


    /**
     * Read the filebase from local installation
     */
    function readFileBase(){
        // check via ajax, if there are updates available
        $.ajax({    // create a new AJAX call
            type: 'POST', // GET or POST
            url: 'js/update-readFilebase.php', // the file to call
            success: function (response) { // fileBase checked successfully
                // update view with response
                $(readFilebaseNode).html(response).fadeIn(1000);
            },
            error: function (response) { // on error..
                console.log('readFileBase() ERROR: ' +response);
            }
        });
    }

    /**
    * Check the version of the current YAWK installation
    * @return {string} version
     */
    function checkVersion(callback) {
        fetch('https://update.yawk.io/?action=version')
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('API error: ' + response.status);
                }
            })
            .then(data => {
                if (data && data.yawkversion) {
                    callback(null, data.yawkversion);
                } else {
                    callback('Error fetching version: ' + JSON.stringify(data));
                }
            })
            .catch(error => {
                callback('Error: ' + error);
            });
    }

    /**
    * Compare two version numbers
    * @param {string} v1
    * @param {string} v2
    * @return {number} 1 if v1 > v2, -1 if v1 < v2, 0 if v1 === v2
    * @example
    * compareVersions('1.0.0', '1.0.1'); // -1
    * compareVersions('1.0.1', '1.0.0'); // 1
    * compareVersions('1.0.0', '1.0.0'); // 0
     */
    function compareVersions(v1, v2) {
        const v1Parts = v1.split('.').map(Number);
        const v2Parts = v2.split('.').map(Number);
        const maxLength = Math.max(v1Parts.length, v2Parts.length);

        for (let i = 0; i < maxLength; i++) {
            const v1Part = v1Parts[i] || 0;
            const v2Part = v2Parts[i] || 0;

            if (v1Part > v2Part) {
                return 1;
            }
            if (v1Part < v2Part) {
                return -1;
            }
        }

        return 0;
    }

}); // END document ready
