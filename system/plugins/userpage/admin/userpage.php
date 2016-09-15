<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['USERPAGE'], $lang['USERPAGE_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"Pages\"> Plugins</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=userpage\" title=\"Booking\"> Userpage</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

if (isset($_POST['sent'])){
    // check if form is sent
    if ($_POST['sent'] === '1') {

        if (isset($_POST['helptext'])) {
            \YAWK\settings::setLongSetting($db, "userpage_helptext", $_POST['helptext']);
        }
        if (isset($_POST['hellotext'])) {
            \YAWK\settings::setSetting($db, "userpage_hellotext", $_POST['hellotext']);
        }
        if (isset($_POST['hellotextsub'])) {
            \YAWK\settings::setSetting($db, "userpage_hellotextsub", $_POST['hellotextsub']);
        }
        if (isset($_POST['hello'])) {
            \YAWK\settings::setSetting($db, "userpage_hello", $_POST['hello']);
        }
        if (isset($_POST['hellogroup'])) {
            \YAWK\settings::setSetting($db, "userpage_hellogroup", $_POST['hellogroup']);
        }
        if (isset($_POST['settings'])) {
            \YAWK\settings::setSetting($db, "userpage_settings", $_POST['settings']);
        }
        if (isset($_POST['help'])) {
            \YAWK\settings::setSetting($db, "userpage_help", $_POST['help']);
        }
        if (isset($_POST['profile'])) {
            \YAWK\settings::setSetting($db, "userpage_profile", $_POST['profile']);
        }
        if (isset($_POST['admin'])) {
            \YAWK\settings::setSetting($db, "userpage_admin", $_POST['admin']);
        }
        if (isset($_POST['dashboard'])) {
            \YAWK\settings::setSetting($db, "userpage_dashboard", $_POST['dashboard']);
        }
        if (isset($_POST['messageplugin'])) {
            \YAWK\settings::setSetting($db, "userpage_msgplugin", $_POST['messageplugin']);
        }
        if (isset($_POST['stats'])) {
            \YAWK\settings::setSetting($db, "userpage_stats", $_POST['stats']);
        }
        if (isset($_POST['changeUsername'])) {
            \YAWK\settings::setSetting($db, "userpage_changeUsername", $_POST['changeUsername']);
        }
        if (isset($_POST['changePassword'])) {
            \YAWK\settings::setSetting($db, "userpage_changePassword", $_POST['changePassword']);
        }
        if (isset($_POST['changeEmail'])) {
            \YAWK\settings::setSetting($db, "userpage_changeEmail", $_POST['changeEmail']);
        }
        if (isset($_POST['changeFirstname'])) {
            \YAWK\settings::setSetting($db, "userpage_changeFirstname", $_POST['changeFirstname']);
        }
        if (isset($_POST['changeLastname'])) {
            \YAWK\settings::setSetting($db, "userpage_changeLastname", $_POST['changeLastname']);
        }
        if (isset($_POST['changeStreet'])) {
            \YAWK\settings::setSetting($db, "userpage_changeStreet", $_POST['changeStreet']);
        }
        if (isset($_POST['changeZipcode'])) {
            \YAWK\settings::setSetting($db, "userpage_changeZipcode", $_POST['changeZipcode']);
        }
        if (isset($_POST['changeCity'])) {
            \YAWK\settings::setSetting($db, "userpage_changeCity", $_POST['changeCity']);
        }
        if (isset($_POST['changeCountry'])) {
            \YAWK\settings::setSetting($db, "userpage_changeCountry", $_POST['changeCountry']);
        }
        if (isset($_POST['changeState'])) {
            \YAWK\settings::setSetting($db, "userpage_changeState", $_POST['changeState']);
        }
        if (isset($_POST['changeUrl'])) {
            \YAWK\settings::setSetting($db, "userpage_changeUrl", $_POST['changeUrl']);
        }
        if (isset($_POST['changeFacebook'])) {
            \YAWK\settings::setSetting($db, "userpage_changeFacebook", $_POST['changeFacebook']);
        }
        if (isset($_POST['changeTwitter'])) {
            \YAWK\settings::setSetting($db, "userpage_changeTwitter", $_POST['changeTwitter']);
        }
        if (isset($_POST['logoutmenu'])) {
            \YAWK\settings::setSetting($db, "userpage_logoutmenu", $_POST['logoutmenu']);
        }
        if (isset($_POST['activeTab'])) {
            \YAWK\settings::setSetting($db, "userpage_activeTab", $_POST['activeTab']);
        }
    }
} // end if $_POST['sent']

// USER PAGE TAB SETTINGS (checkboxes status)
if (\YAWK\settings::getSetting($db, "userpage_hellogroup") === '1'){
    $hellogroupHtml = "checked"; }
else {
    $hellogroupHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_hello") === '1'){
    $helloHtml = "checked"; }
else {
    $helloHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_msgplugin") === '1'){
    $msgpluginHtml = "checked"; }
else {
    $msgpluginHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_settings") === '1'){
    $settingsHtml = "checked"; }
else {
    $settingsHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_help") === '1'){
    $helpHtml = "checked"; }
else {
    $helpHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_profile") === '1'){
    $profileHtml = "checked"; }
else {
    $profileHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_admin") === '1'){
    $adminHtml = "checked"; }
else {
    $adminHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_dashboard") === '1'){
    $dashboardHtml = "checked"; }
else {
    $dashboardHtml = "";
}
/* GET ACTIVE TABS */
$activeTab = \YAWK\settings::getSetting($db, "userpage_activeTab");
if ($activeTab == "Dashboard") {
    $activeDashboardHtml = "checked";
}
else {
    $activeDashboardHtml = "";
}
if ($activeTab == "Profile") {
    $activeProfileHtml = "checked";
}
else {
    $activeProfileHtml = "";
}
if ($activeTab == "Messages") {
    $activeMessagesHtml = "checked";
}
else {
    $activeMessagesHtml = "";
}
if ($activeTab == "Settings") {
    $activeSettingsHtml = "checked";
}
else {
    $activeSettingsHtml = "";
}
if ($activeTab == "Stats") {
    $activeStatsHtml = "checked";
}
else {
    $activeStatsHtml = "";
}
if ($activeTab == "Help") {
    $activeHelpHtml = "checked";
}
else {
    $activeHelpHtml = "";
}
if ($activeTab == "Admin") {
    $activeAdminHtml = "checked";
}
else {
    $activeAdminHtml= "";
}
if (\YAWK\settings::getSetting($db, "userpage_stats") === '1'){
    $statsHtml = "checked"; }
else {
    $statsHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeUsername") === '1'){
    $changeUsernameHtml = "checked"; }
else {
    $changeUsernameHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changePassword") === '1'){
    $changePasswordHtml = "checked"; }
else {
    $changePasswordHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeEmail") === '1'){
    $changeEmailHtml = "checked"; }
else {
    $changeEmailHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeFirstname") === '1'){
    $changeFirstnameHtml = "checked"; }
else {
    $changeFirstnameHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeLastname") === '1'){
    $changeLastnameHtml = "checked"; }
else {
    $changeLastnameHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeStreet") === '1'){
    $changeStreetHtml = "checked"; }
else {
    $changeStreetHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeZipcode") === '1'){
    $changeZipcodeHtml = "checked"; }
else {
    $changeZipcodeHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeCity") === '1'){
    $changeCityHtml = "checked"; }
else {
    $changeCityHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeCountry") === '1'){
    $changeCountryHtml = "checked"; }
else {
    $changeCountryHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeState") === '1'){
    $changeStateHtml = "checked"; }
else {
    $changeStateHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeUrl") === '1'){
    $changeUrlHtml = "checked"; }
else {
    $changeUrlHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeFacebook") === '1'){
    $changeFacebookHtml = "checked"; }
else {
    $changeFacebookHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_changeTwitter") === '1'){
    $changeTwitterHtml = "checked"; }
else {
    $changeTwitterHtml = "";
}
if (\YAWK\settings::getSetting($db, "userpage_logoutmenu") === '1'){
    $logoutmenuHtml = "checked"; }
else {
    $logoutmenuHtml = "";
}

?>
<script type="text/javascript" src="../system/plugins/signup/js/admin.js"></script>
<form action="index.php?plugin=userpage" class="form-inline" role="form" name="settings" method="POST">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
       <li role="presentation" class="active"><a href="#greeting" aria-controls="greeting" role="tab" data-toggle="tab"><i class="fa fa-commenting-o"></i> &nbsp;Greeting Text</a></li>
       <li role="presentation"><a href="#dash" aria-controls="dash" role="tab" data-toggle="tab"><i class="fa fa-folder-open"></i> &nbsp;Userpage Tabs</a></li>
       <li role="presentation"><a href="#menu" aria-controls="menu" role="tab" data-toggle="tab"><i class="fa fa-bars"></i> &nbsp;Logout Menu</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="greeting">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?PHP print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
            <fieldset>
                <legend><i class="fa fa-commenting-o"></i> &nbsp;Greeting Text <small>set user welcome</small></legend>
                <label for="hellotext">Greeting </label><br>
                <input type="text" id="hellotext" size="16" name="hellotext" class="form-control" placeholder="Welcome" value="<?PHP echo \YAWK\settings::getSetting($db, "userpage_hellotext");?>" title="Greeting">
                &nbsp;$USERNAME &nbsp;
                <input type="text" id="hellotextsub" size="32" name="hellotextsub" class="form-control" placeholder="good to see you again!" value="<?PHP echo \YAWK\settings::getSetting($db, "userpage_hellotextsub");?>" title="Greeting Subtext">
                <label for="hellotextsub">&nbsp;</label><br><br>
                <input type="hidden" value='0' name="hello">
                <input type="checkbox" id="hello" name="hello" class="form-control" value="1" title="Enable User Greeting" <?PHP echo $helloHtml; ?>>
                <label for="hello">Enable User Greeting</label><br>
                <input type="hidden" value='0' name="hellogroup">
                <input type="checkbox" id="hellogroup" name="hellogroup" class="form-control" value="1" title="Enable User Group Greeting" <?PHP echo $hellogroupHtml; ?>>
                <label for="hellogroup">Enable User Group Greeting</label><br><br><br>
            </fieldset>
        </div>

        <div role="tabpanel" class="tab-pane fade in" id="dash">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?PHP print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#homeTab" aria-controls="homeTab" role="tab" data-toggle="tab"><i class="fa fa-home"></i> &nbsp;Home</a></li>
                <li role="presentation"><a href="#profileTab" aria-controls="profileTab" role="tab" data-toggle="tab"><i class="fa fa-user"></i> &nbsp;Profile</a></li>
                <li role="presentation"><a href="#messagesTab" aria-controls="messagesTab" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i> &nbsp;Messages</a></li>
                <li role="presentation"><a href="#settingsTab" aria-controls="settingsTab" role="tab" data-toggle="tab"><i class="fa fa-cog"></i> &nbsp;Settings</a></li>
                <li role="presentation"><a href="#statsTab" aria-controls="statsTab" role="tab" data-toggle="tab"><i class="fa fa-line-chart"></i> &nbsp;Stats</a></li>
                <li role="presentation"><a href="#helpTab" aria-controls="helpTab" role="tab" data-toggle="tab"><i class="fa fa-question-circle"></i> &nbsp;Help</a></li>
                <li role="presentation"><a href="#adminTab" aria-controls="adminTab" role="tab" data-toggle="tab"><i class="fa fa-question-wrench"></i> &nbsp;Admin</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <fieldset>
                    <legend><br><i class="fa fa-gears"></i><small><i class="fa fa-user"></i></small> &nbsp;Userpage Tabs <small>set visible tabs</small></legend>
                </fieldset>

                <!-- home -->
                <div role="tabpanel" class="tab-pane active" id="homeTab">
                    <!-- HOME (dashboard) TAB ENABLE -->
                    <input type="hidden" value='0' name="dashboard">
                    <input type="checkbox" id="dashboard" name="dashboard" class="form-control" value="1" title="Enable Dashboard Tab" <?PHP echo $dashboardHtml; ?>>
                    <label for="dashboard"> Enable Dashboard Tab</label><br>
                    <!-- DASHBOARD ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Dashboard" title="Set This Tab Active" <?PHP echo $activeDashboardHtml; ?>>
                    Set This Tab Active</label><br>
                </div>
                <!-- profile -->
                <div role="tabpanel" class="tab-pane" id="profileTab">
                    <!-- PROFILE ENABLE -->
                    <input type="hidden" value='0' name="profile">
                    <input type="checkbox" id="profile" name="profile" class="form-control" value="1" title="Enable Profile Tab" <?PHP echo $profileHtml; ?>>
                    <label for="profile"> Enable Profile Tab</label><br>
                    <!-- PROFILE ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Profile" title="Set This Tab Active" <?PHP echo $activeProfileHtml; ?>>
                    Set This Tab Active</label><br>

                    <fieldset>
                        <legend><i class="fa fa-user"></i> &nbsp;Set up <small>Profile Page</small></legend>
                        <!-- change username -->
                        <input type="hidden" value='0' name="changeUsername">
                        <input type="checkbox" id="changeUsername" name="changeUsername" class="form-control" value="1" title="Change Username allowed?" <?PHP echo $changeUsernameHtml; ?>>
                        <label for="changeUsername">Allow user to change the username.</label><br>
                        <!-- change email -->
                        <input type="hidden" value='0' name="changeEmail">
                        <input type="checkbox" id="changeEmail" name="changeEmail" class="form-control" value="1" title="Change Email allowed?" <?PHP echo $changeEmailHtml; ?>>
                        <label for="changeEmail">Allow user to change email adress.</label><br>
                        <!-- change password -->
                        <input type="hidden" value='0' name="changePassword">
                        <input type="checkbox" id="changePassword" name="changePassword" class="form-control" value="1" title="Change Password allowed?" <?PHP echo $changePasswordHtml; ?>>
                        <label for="changePassword">Allow user to change password.</label><br><br>
                        <!-- change firstname -->
                        <input type="hidden" value='0' name="changeFirstname">
                        <input type="checkbox" id="changeFirstname" name="changeFirstname" class="form-control" value="1" title="Change Firstname allowed?" <?PHP echo $changeFirstnameHtml; ?>>
                        <label for="changeFirstname">Allow user to change firstname.</label><br>
                        <!-- change lastname -->
                        <input type="hidden" value='0' name="changeLastname">
                        <input type="checkbox" id="changeLastname" name="changeLastname" class="form-control" value="1" title="Change Lastname allowed?" <?PHP echo $changeLastnameHtml; ?>>
                        <label for="changeLastname">Allow user to change lastname.</label><br><br>
                        <!-- change street -->
                        <input type="hidden" value='0' name="changeStreet">
                        <input type="checkbox" id="changeStreet" name="changeStreet" class="form-control" value="1" title="Change Street allowed?" <?PHP echo $changeStreetHtml; ?>>
                        <label for="changeStreet">Allow user to change street.</label><br>
                        <!-- change zipcode -->
                        <input type="hidden" value='0' name="changeZipcode">
                        <input type="checkbox" id="changeZipcode" name="changeZipcode" class="form-control" value="1" title="Change Zipcode allowed?" <?PHP echo $changeZipcodeHtml; ?>>
                        <label for="changeZipcode">Allow user to change zipcode.</label><br>
                        <!-- city city -->
                        <input type="hidden" value='0' name="changeCity">
                        <input type="checkbox" id="changeCity" name="changeCity" class="form-control" value="1" title="Change City allowed?" <?PHP echo $changeCityHtml; ?>>
                        <label for="changeCity">Allow user to change city.</label><br>
                        <!-- change country -->
                        <input type="hidden" value='0' name="changeCountry">
                        <input type="checkbox" id="changeCountry" name="changeCountry" class="form-control" value="1" title="Change Country allowed?" <?PHP echo $changeCountryHtml; ?>>
                        <label for="changeCountry">Allow user to change country.</label><br>
                        <!-- change state -->
                        <input type="hidden" value='0' name="changeState">
                        <input type="checkbox" id="changeState" name="changeState" class="form-control" value="1" title="Change State allowed?" <?PHP echo $changeStateHtml; ?>>
                        <label for="changeState">Allow user to change state.</label><br><br>
                        <!-- change url -->
                        <input type="hidden" value='0' name="changeUrl">
                        <input type="checkbox" id="changeUrl" name="changeUrl" class="form-control" value="1" title="Change Website Url allowed?" <?PHP echo $changeUrlHtml; ?>>
                        <label for="changeUrl">Allow user to change url.</label><br>
                        <!-- change facebook -->
                        <input type="hidden" value='0' name="changeFacebook">
                        <input type="checkbox" id="changeFacebook" name="changeFacebook" class="form-control" value="1" title="Change Facebook URL allowed?" <?PHP echo $changeFacebookHtml; ?>>
                        <label for="changeFacebook">Allow user to change facebook url.</label><br>
                        <!-- change twitter -->
                        <input type="hidden" value='0' name="changeTwitter">
                        <input type="checkbox" id="changeTwitter" name="changeTwitter" class="form-control" value="1" title="Change Twitter allowed?" <?PHP echo $changeTwitterHtml; ?>>
                        <label for="changeTwitter">Allow user to change twitter url.</label><br><br><br>
                    </fieldset>
                </div>
                <!-- messages -->
                <div role="tabpanel" class="tab-pane" id="messagesTab">
                    <!-- MESSAGE PLUGIN ENABLE -->
                    <input type="hidden" value='0' name="messageplugin">
                    <input type="checkbox" id="messageplugin" name="messageplugin" class="form-control" value="1" title="Enable Message Plugin" <?PHP echo $msgpluginHtml; ?>>
                    <label for="messageplugin"> Enable Message Tab</label><br>
                    <!-- MESSAGE ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                        <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Messages" title="Set This Tab Active" <?PHP echo $activeMessagesHtml; ?>>
                        Set This Tab Active</label><br>
                    <!-- link to plg settings -->
                    <h4><i class="fa fa-wrench"></i><small><i class="fa fa-envelope-o"></i></small> &nbsp;
                    <a href="index.php?plugin=messages" title="change names, login access, frontend access and colors">Message Plugin Settings</a>
                    <small>(edit all messaging options here)</small></h4><br><br>
                </div>
                <!-- settings -->
                <div role="tabpanel" class="tab-pane" id="settingsTab">
                    <!-- SETTINGS ENABLE -->
                    <input type="hidden" value='0' name="settings">
                    <input type="checkbox" id="settings" name="settings" class="form-control" value="1" title="Enable Settings Tab" <?PHP echo $settingsHtml; ?>>
                    <label for="settings"> Enable Settings Tab</label><br>
                    <!-- SETTINGS ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Settings" title="Set This Tab Active" <?PHP echo $activeSettingsHtml; ?>>
                    Set This Tab Active</label><br>
                </div>
                <!-- stats -->
                <div role="tabpanel" class="tab-pane" id="statsTab">
                    <!-- STATS ENABLE -->
                    <input type="hidden" value='0' name="stats">
                    <input type="checkbox" id="stats" name="stats" class="form-control" value="1" title="Enable Stats Tab" <?PHP echo $statsHtml; ?>>
                    <label for="stats"> Enable Stats Tab</label><br>
                    <!-- STATS ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Stats" title="Set This Tab Active" <?PHP echo $activeStatsHtml; ?>>
                    Set This Tab Active</label><br>
                </div>
                <!-- help -->
                <div role="tabpanel" class="tab-pane" id="helpTab">
                    <!-- HELP ENABLE -->
                    <input type="hidden" value='0' name="help">
                    <input type="checkbox" id="help" name="help" class="form-control" value="1" title="Enable Help Tab" <?PHP echo $helpHtml; ?>>
                    <label for="help"> HELP Tab enabled</label><br>
                    <!-- HELP ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Help" title="Set This Tab Active" <?PHP echo $activeHelpHtml; ?>>
                    Set This Tab Active</label><br>
                    <fieldset>
                        <legend><i class="fa fa-question-circle"></i> &nbsp;User Help <small>write your own user help</small></legend>
                        <!-- USER HELP TEXTAREA -->
                        <label for="helptext"> User Help Text <small>(html allowed)</small></label><br>
                        <textarea name="helptext" id="helptext" class="form-control" cols="70" rows="10" title="User Help Text"><?php echo \YAWK\settings::getLongSetting($db, "userpage_helptext"); ?></textarea>
                        <br><br><br><br>
                    </fieldset>
                </div>
                <!-- admin -->
                <div role="tabpanel" class="tab-pane" id="adminTab">
                    <!-- ADMIN TAB ENABLE -->
                    <input type="hidden" value='0' name="admin">
                    <input type="checkbox" id="admin" name="admin" class="form-control" value="1" title="Enable Admin Tab" <?PHP echo $adminHtml; ?>>
                    <label for="admin"> Enable Admin Tab</label><br>
                    <!-- ADMIN ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Admin" title="Set This Tab Active" <?PHP echo $activeAdminHtml; ?>>
                    Set This Tab Active</label><br>
                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane fade in" id="userhelp">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?PHP print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
        </div>

        <!-- Tab panes -->
            <div role="tabpanel" class="tab-pane fade in" id="menu">
                <fieldset>
                    <!-- SUBMIT BUTTON -->
                    <input type="submit" class="btn btn-success pull-right" value="<?PHP print $lang['SETTINGS_SAVE']; ?>">
                    <input type="hidden" name="sent" value="1">
                </fieldset>
                <fieldset>
                    <legend><i class="fa fa-bars"></i> &nbsp;Logout Menu <small>when user is logged in</small></legend>
                    <input type="hidden" value='0' name="logoutmenu">
                    <input type="checkbox" id="logoutmenu" name="logoutmenu" class="form-control" value="1" title="Enable Logout Menu" <?PHP echo $logoutmenuHtml; ?>>
                    <label for="logoutmenu">Enable Logout Menu</label>
                   <br><br><br>
                </fieldset>
            </div>
    </div>
</form>




