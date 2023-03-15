$(document).ready(function() {  // wait until document is ready

    // get button and nodes
    var updateBtn = $("#checkForUpdatesBtn");
    var readFilebaseNode = $("#readFilebaseNode");
    let installedVersion = $('#installedVersion').text(); // the current installed version of YAWK
    var updateVersion = ''; // latest version of YAWK (filled with api call from update.yawk.io)
    var statusBarNode = $("#statusBarNode");

    /* UPDATE BTN CLICK */
    // if update button is clicked
    $(updateBtn).click(function() {
        // update button with spinner icon
        $(updateBtn).html("<i class=\"fa fa-refresh fa-spin\"></i> &nbsp;Checking for updates...");

        // Call the function to check the version
        checkVersion(function(error, updateVersion) {
            if (error) {
                console.error(error);
            } else {
                if (compareVersions(installedVersion, updateVersion) < 0) {
                    statusBarNode.html('Update to '+updateVersion+' available! (currently installed: '+installedVersion+')').fadeIn(1000);
                    console.log('Update to '+updateVersion+' available! (currently installed: '+installedVersion+')');
                } else {
                    console.log('No update available! The current version ('+installedVersion+') is up to date.');
                }
            }
        });
    });

    /**
     * Read the filebase from local installation0
     */
    function readFileBase(){
        // check via ajax, if there are updates available
        $.ajax({    // create a new AJAX call
            type: 'POST', // GET or POST
            url: 'https://yawk.io/admin/js/update-readFilebase.php', // the file to call
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

    /*
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
