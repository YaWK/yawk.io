$(document).ready(function() {  // wait until document is ready

    // get button and nodes
    var updateBtn = $("#checkForUpdatesBtn");
    var readFilebaseNode = $("#readFilebaseNode");
    let installedVersion = $('#installedVersion').text(); // the current installed version of YAWK
    var updateVersion = ''; // latest version of YAWK (filled with api call from update.yawk.io)
    var statusBarNode = $("#statusBarNode"); // status bar node
    var extendedInfoNode = $("#extendedInfoNode"); // displays more info about update
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
            let verifyFiles = lang.attr('data-UPDATE_VERIFY_FILES');
            let verifyingFiles = lang.attr('data-UPDATE_VERIFYING_FILES');
            let latestAvailableVersion = lang.attr('data-UPDATE_LATEST_AVAILABLE_VERSION');
            let updateChanges = lang.attr('data-UPDATE_CHANGES');
            let released = lang.attr('data-RELEASED');
            let githubReference = lang.attr('data-GITHUB_REFERENCE');
            let githubMilestoneText = lang.attr('data-GITHUB_MILESTONE');

            if (error) {
                console.error(error);
            } else {


                // check, if version is higher than installed version (if so, update is available)
                // UPDATE AVAILABLE: call api and get update config, update markup and display update message
                if (compareVersions(installedVersion, updateVersion) < 0)
                {
                    // This method will call the api and return the update config object
                    getUpdateConfig(function(error, data) {
                        if (error) {
                            console.error(error);
                        }
                        else // retrieved update config successfully
                        {   console.log('Update config:', data);

                            // check, if all required properties are set
                            if (data.updateConfig && data.updateConfig.UPDATE
                                && data.updateConfig.UPDATE.buildMessage
                                && data.updateConfig.UPDATE.buildTime
                                && data.updateConfig.UPDATE.updateVersion
                                && data.updateConfig.UPDATE.updateFilebase)
                            {
                                // ok, set vars from update config
                                let buildMessage = data.updateConfig.UPDATE.buildMessage;
                                let buildTime = data.updateConfig.UPDATE.buildTime;
                                let updateVersion = data.updateConfig.UPDATE.updateVersion;
                                // let updateFilebase = data.updateConfig.UPDATE.updateFilebase;

                                if (data.updateConfig.UPDATE.githubIssues){
                                    var githubIssues = data.updateConfig.UPDATE.githubIssues;
                                }
                                else { githubIssues = false; }

                                if (data.updateConfig.UPDATE.githubMilestone){
                                    var githubMilestone = data.updateConfig.UPDATE.githubMilestone;
                                }
                                else { githubMilestone = false; }

                                // log vars
                                // console.log('Build message:', buildMessage);
                                // console.log('Build time:', buildTime);
                                // console.log('Build version:', updateVersion);
                                // console.log('Build filebase:', updateFilebase);

                                if (githubIssues){
                                    // Use a regular expression to match issue numbers (# followed by digits)
                                    const regex = /#(\d+)/g;
                                    // Extract the issue numbers
                                    const issueNumbers = [];
                                    let match;

                                    while ((match = regex.exec(githubIssues)) !== null) {
                                        issueNumbers.push(match[1]);
                                    }
                                    // Replace issue numbers with GitHub links
                                    const repoUrl = 'https://github.com/YaWK/yawk.io/issues/';
                                    var issuesWithLinks = githubIssues.replace(regex, (match, issueNumber) => {
                                        return `<a href="${repoUrl}${issueNumber}" target="_blank">${match}</a>`;
                                    });
                                    // console.log('Issue numbers:', issueNumbers);
                                    // console.log('String with links:', stringWithLinks);

                                    // create GitHub info string
                                    var githubRelatedIssues = '<li>'+githubReference+': <b>'+issuesWithLinks+'</b></li>';
                                }
                                else // no GitHub issues found
                                {   // leave GitHub info empty
                                    githubRelatedIssues = '';
                                }

                                // check, if GitHub milestone is set
                                if (githubMilestone){
                                    // Use a regular expression to match issue numbers (# followed by digits)
                                    const regex = /#(\d+)/g;
                                    // Extract the milestone numbers
                                    const milestoneNumbers = [];
                                    let match;

                                    while ((match = regex.exec(githubMilestone)) !== null) {
                                        milestoneNumbers.push(match[1]);
                                    }

                                    // Replace milestone numbers with GitHub links
                                    const repoUrl = 'https://github.com/YaWK/yawk.io/milestone/';
                                    var milestoneWithLinks = githubMilestone.replace(regex, (match, milestoneNumber) => {
                                        return `<a href="${repoUrl}${milestoneNumber}" target="_blank">${match}</a>`;
                                    });

                                    // create GitHub info string
                                    var githubRelatedMilestone = '<li>'+githubMilestoneText+': <b>'+milestoneWithLinks+'</b></li>';
                                }
                                else // no GitHub issues found
                                {   // leave GitHub info empty
                                    githubRelatedMilestone = '';
                                }

                                // update available msg
                                statusBarMessage = updateAvailable;
                                successMsg = '<h3 class="text-primary animated fadeIn"><b><i class="fa fa-globe animated bounce slow"></i></b> &nbsp;' + updateAvailable + '<br><small>'+updateAvailableSubtext+'</small></h3>';
                                statusBarNode.html(successMsg).fadeIn(1000);

                                let extendedInfo = '<ul class="animated fadeIn slow delay-2s"><li><span class="text-primary"><b>' + latestAvailableVersion + '</b> build <b>' + updateVersion + '</b></span></li><li>' + updateCurrentInstalledVersion + ' build <b class="text-muted">' + installedVersion + '</b></li>' +  '<li>'+updateChanges+': <b>'+ buildMessage + '</b></li>'+githubRelatedIssues+githubRelatedMilestone+'<li>'+released+': ' + buildTime + '</li></ul>';
                                extendedInfoNode.html(extendedInfo).fadeIn(1000);
                                console.log(statusBarMessage);

                                // START BTN CREATION
                                // switch styling of update button to "install update" process
                                // to achieve this, we have to remove the old button and create a new one
                                $("#checkForUpdatesBtn").remove();

                                // Create the new startUpdateBtn element with the given attributes
                                var newBtn = $('<a>', {
                                    'href': '#startUpdateBtn',
                                    'id': 'getFilebaseBtn',
                                    'class': 'btn btn-primary pull-right animated fadeIn slow',
                                    'html': '<i class="fa fa-search"></i> &nbsp;&nbsp;' + verifyFiles
                                });
                                // Append the new startUpdateBtn to a container element on the page
                                $('#updateBtnNode').append(newBtn);
                                // END BTN CREATION

                                // get new startUpdateBtn, check if it is clicked and call generateLocalFileBase()
                                var getFilebaseBtn = $("#getFilebaseBtn");
                                $(getFilebaseBtn).click(function() {
                                    console.log('install update button clicked, read local filebase and store to ini file');
                                    getFilebaseBtn.html("<i class=\"fa fa-refresh fa-spin\"></i> &nbsp;&nbsp;" + verifyingFiles);
                                    // this function will read the local filebase from your installation and store it to a filebase.ini file
                                    // Call both functions and wait for them to complete
                                    Promise.all([generateLocalFileBase(updateInstall)])
                                        .then(([localFilebase]) => {
                                            // local filebase generated successfully, now read update filebase
                                            readUpdateFileBase();
                                        })
                                        .catch((error) => {
                                            console.log(error);
                                        });
                                });
                            } // end if all required properties are set
                            else // update config not found or properties not set
                            {   // throw error to console
                                console.error('updateConfig, UPDATE, or properties not found in xhr data');
                            }
                        }
                    });
                }
                else    // no update available
                {   // update status bar message and updateBtn text
                    statusBarMessage = updateNotAvailable + ' (' + installedVersion + ') ' + updateNotAvailableSubtext;
                    errorMsg = '<span class="text-success animated fadeIn slow"><i class="fa fa-check-circle-o"></i> &nbsp;' + statusBarMessage + '</span>';
                    statusBarNode.html(errorMsg).fadeIn(1000);
                    $(updateBtn).removeClass().addClass('btn btn-default pull-right disabled animated fadeIn slow').html("<i class=\"fa fa-check-circle-o\"></i> &nbsp;" + updateNoUpdate);
                    console.log(statusBarMessage);
                }
            }
        });
    }); // end update button click processing

    /**
     * Read the filebase from local installation and generate a filebase.ini file to compare with the latest update filebase
     */
    // Wrap the AJAX request in a Promise
    function generateLocalFileBase(upateInstall) {
        var updateBtnText = upateInstall;
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'POST',
                url: 'js/update-generateLocalFilebase.php',
                success: function (response) {
                    resolve(response);
                    $(readFilebaseNode).html(response).fadeIn(1000);
                    // this function will read the filebase.ini from remote update server https://update.yawk.io
                    // add start update button
                    // Create the new startUpdateBtn element with the given attributes
                    var newBtn = $('<a>', {
                        'href': '#startUpdateBtn',
                        'id': 'startUpdateBtn',
                        'class': 'btn btn-success pull-right animated flipInX',
                        'html': '<i class="fa fa-download"></i> &nbsp;' + updateBtnText
                    });
                    // Append the new startUpdateBtn to a container element on the page
                    delay(function(){
                        $("#getFilebaseBtn").remove();
                        $('#updateBtnNode').append(newBtn);
                    }, 5000 ); // end delay

                },
                error: function (response) {
                    reject('generateLocalFileBase() ERROR: ' + response);
                },
            });
        });
    }
    var delay = ( function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    /**
     * Read the filebase from local installation and generate a filebase.ini file to compare with the latest update filebase
     */
    function readUpdateFileBase(){
        console.log('readUpdateFileBase() called');
        // check via ajax, if there are updates available
        $.ajax({    // create a new AJAX call
            type: 'POST', // GET or POST
            url: 'js/update-readUpdateFilebase.php', // the file to call
            success: function (response) { // fileBase checked successfully
                // update view with response
                // console.log("readUpdateFileBase() response: " + response);
                $(readUpdateFilebaseNode).html(response).fadeIn(1000);
            },
            error: function (response) { // on error..
                console.log('readUpdateFileBase() ERROR: ' +response);
            }
        });
    }

    /**
    * Return the latest update version from update.yawk.io
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
     * Return the update config from update.yawk.io
     * @return {string} update config as json
     */
    function getUpdateConfig(callback)
    {   // get update config from update.yawk.io
        fetch('https://update.yawk.io/?action=getUpdateConfig')
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('API error: ' + response.status);
                }
            })
            .then(data => {
                if (data) {
                    callback(null, data);
                } else {
                    callback('Error fetching data: ' + JSON.stringify(data));
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
