<?php
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/userpage/language/");
}
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['USERPAGE'], $lang['USERPAGE_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=userpage\" title=\"$lang[USERPAGE]\"> $lang[USERPAGE]</a></li>
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
            \YAWK\settings::setSetting($db, "userpage_hellotext", $_POST['hellotext'], $lang);
        }
        if (isset($_POST['hellotextsub'])) {
            \YAWK\settings::setSetting($db, "userpage_hellotextsub", $_POST['hellotextsub'], $lang);
        }
        if (isset($_POST['hello'])) {
            \YAWK\settings::setSetting($db, "userpage_hello", $_POST['hello'], $lang);
        }
        if (isset($_POST['hellogroup'])) {
            \YAWK\settings::setSetting($db, "userpage_hellogroup", $_POST['hellogroup'], $lang);
        }
        if (isset($_POST['settings'])) {
            \YAWK\settings::setSetting($db, "userpage_settings", $_POST['settings'], $lang);
        }
        if (isset($_POST['help'])) {
            \YAWK\settings::setSetting($db, "userpage_help", $_POST['help'], $lang);
        }
        if (isset($_POST['profile'])) {
            \YAWK\settings::setSetting($db, "userpage_profile", $_POST['profile'], $lang);
        }
        if (isset($_POST['admin'])) {
            \YAWK\settings::setSetting($db, "userpage_admin", $_POST['admin'], $lang);
        }
        if (isset($_POST['dashboard'])) {
            \YAWK\settings::setSetting($db, "userpage_dashboard", $_POST['dashboard'], $lang);
        }
        if (isset($_POST['messageplugin'])) {
            \YAWK\settings::setSetting($db, "userpage_msgplugin", $_POST['messageplugin'], $lang);
        }
        if (isset($_POST['stats'])) {
            \YAWK\settings::setSetting($db, "userpage_stats", $_POST['stats'], $lang);
        }
        if (isset($_POST['changeUsername'])) {
            \YAWK\settings::setSetting($db, "userpage_changeUsername", $_POST['changeUsername'], $lang);
        }
        if (isset($_POST['changePassword'])) {
            \YAWK\settings::setSetting($db, "userpage_changePassword", $_POST['changePassword'], $lang);
        }
        if (isset($_POST['changeEmail'])) {
            \YAWK\settings::setSetting($db, "userpage_changeEmail", $_POST['changeEmail'], $lang);
        }
        if (isset($_POST['changeFirstname'])) {
            \YAWK\settings::setSetting($db, "userpage_changeFirstname", $_POST['changeFirstname'], $lang);
        }
        if (isset($_POST['changeLastname'])) {
            \YAWK\settings::setSetting($db, "userpage_changeLastname", $_POST['changeLastname'], $lang);
        }
        if (isset($_POST['changeStreet'])) {
            \YAWK\settings::setSetting($db, "userpage_changeStreet", $_POST['changeStreet'], $lang);
        }
        if (isset($_POST['changeZipcode'])) {
            \YAWK\settings::setSetting($db, "userpage_changeZipcode", $_POST['changeZipcode'], $lang);
        }
        if (isset($_POST['changeCity'])) {
            \YAWK\settings::setSetting($db, "userpage_changeCity", $_POST['changeCity'], $lang);
        }
        if (isset($_POST['changeCountry'])) {
            \YAWK\settings::setSetting($db, "userpage_changeCountry", $_POST['changeCountry'], $lang);
        }
        if (isset($_POST['changeState'])) {
            \YAWK\settings::setSetting($db, "userpage_changeState", $_POST['changeState'], $lang);
        }
        if (isset($_POST['changeUrl'])) {
            \YAWK\settings::setSetting($db, "userpage_changeUrl", $_POST['changeUrl'], $lang);
        }
        if (isset($_POST['changeFacebook'])) {
            \YAWK\settings::setSetting($db, "userpage_changeFacebook", $_POST['changeFacebook'], $lang);
        }
        if (isset($_POST['changeTwitter'])) {
            \YAWK\settings::setSetting($db, "userpage_changeTwitter", $_POST['changeTwitter'], $lang);
        }
        if (isset($_POST['logoutmenu'])) {
            \YAWK\settings::setSetting($db, "userpage_logoutmenu", $_POST['logoutmenu'], $lang);
        }
        if (isset($_POST['activeTab'])) {
            \YAWK\settings::setSetting($db, "userpage_activeTab", $_POST['activeTab'], $lang);
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

<div class="box box-default">
    <div class="box-body">
<form action="index.php?plugin=userpage" class="form-inline" role="form" name="settings" method="POST">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
       <li role="presentation" class="active"><a href="#greeting" aria-controls="greeting" role="tab" data-toggle="tab"><i class="fa fa-commenting-o"></i> &nbsp;<?php echo "$lang[USERPAGE_GREETING_TEXT]"; ?></a></li>
       <li role="presentation"><a href="#dash" aria-controls="dash" role="tab" data-toggle="tab"><i class="fa fa-folder-open"></i> &nbsp;<?php echo "$lang[USERPAGE_TABS]"; ?></a></li>
       <li role="presentation"><a href="#menu" aria-controls="menu" role="tab" data-toggle="tab"><i class="fa fa-bars"></i> &nbsp;<?php echo "$lang[LOGOUT_MENU]"; ?></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="greeting">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?php print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
            <fieldset>
                <legend><i class="fa fa-commenting-o"></i> &nbsp;<?php echo "$lang[USERPAGE_GREETING_TEXT]"; ?> <small><?php echo "$lang[USERPAGE_GREETING_SUBTEXT]"; ?></small></legend>
                <label for="hellotext"><?php echo "$lang[USERPAGE_GREETING]"; ?> </label><br>
                <input type="text" id="hellotext" size="16" name="hellotext" class="form-control" placeholder="Welcome" value="<?php echo \YAWK\settings::getSetting($db, "userpage_hellotext");?>" title="Greeting">
                &nbsp;$USERNAME &nbsp;
                <input type="text" id="hellotextsub" size="32" name="hellotextsub" class="form-control" placeholder="good to see you again!" value="<?php echo \YAWK\settings::getSetting($db, "userpage_hellotextsub");?>" title="Greeting Subtext">
                <label for="hellotextsub">&nbsp;</label><br><br>
                <input type="hidden" value='0' name="hello">
                <input type="checkbox" id="hello" name="hello" class="form-control" value="1" title="Enable User Greeting" <?php echo $helloHtml; ?>>
                <label for="hello"><?php echo $lang['USERPAGE_GREETING_ENABLE']; ?></label><br>
                <input type="hidden" value='0' name="hellogroup">
                <input type="checkbox" id="hellogroup" name="hellogroup" class="form-control" value="1" title="Enable User Group Greeting" <?php echo $hellogroupHtml; ?>>
                <label for="hellogroup"><?php echo $lang['USERPAGE_GRP_GREETING_ENABLE']; ?></label><br><br><br>
            </fieldset>
        </div>

        <div role="tabpanel" class="tab-pane fade in" id="dash">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?php print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#homeTab" aria-controls="homeTab" role="tab" data-toggle="tab"><i class="fa fa-home"></i> &nbsp;<?php print $lang['USERPAGE_TAB_HOME']; ?></a></li>
                <li role="presentation"><a href="#profileTab" aria-controls="profileTab" role="tab" data-toggle="tab"><i class="fa fa-user"></i> &nbsp;<?php print $lang['USERPAGE_TAB_PROFILE']; ?></a></li>
                <li role="presentation"><a href="#messagesTab" aria-controls="messagesTab" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i> &nbsp;<?php print $lang['USERPAGE_TAB_MESSAGES']; ?></a></li>
                <li role="presentation"><a href="#settingsTab" aria-controls="settingsTab" role="tab" data-toggle="tab"><i class="fa fa-cog"></i> &nbsp;<?php print $lang['USERPAGE_TAB_SETTINGS']; ?></a></li>
                <li role="presentation"><a href="#statsTab" aria-controls="statsTab" role="tab" data-toggle="tab"><i class="fa fa-line-chart"></i> &nbsp;<?php print $lang['USERPAGE_TAB_STATS']; ?></a></li>
                <li role="presentation"><a href="#helpTab" aria-controls="helpTab" role="tab" data-toggle="tab"><i class="fa fa-question-circle"></i> &nbsp;<?php print $lang['USERPAGE_TAB_HELP']; ?></a></li>
                <li role="presentation"><a href="#adminTab" aria-controls="adminTab" role="tab" data-toggle="tab"><i class="fa fa-question-wrench"></i> &nbsp;<?php print $lang['USERPAGE_TAB_ADMIN']; ?></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <fieldset>
                    <legend><br><i class="fa fa-gears"></i><small><i class="fa fa-user"></i></small> &nbsp;<?php echo "$lang[USERPAGE_SINGLE] <small>$lang[USERPAGE_TABS_SUBTEXT]</small>"; ?></legend>
                </fieldset>

                <!-- home -->
                <div role="tabpanel" class="tab-pane active" id="homeTab">
                    <!-- HOME (dashboard) TAB ENABLE -->
                    <input type="hidden" value='0' name="dashboard">
                    <input type="checkbox" id="dashboard" name="dashboard" class="form-control" value="1" title="Enable Dashboard Tab" <?php echo $dashboardHtml; ?>>
                    <label for="dashboard"> <?php echo "$lang[USERPAGE_TAB_DASH_ENABLE]"; ?></label><br>
                    <!-- DASHBOARD ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Dashboard" title="<?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?>" <?php echo $activeDashboardHtml; ?>>
                        <?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?></label><br>
                </div>
                <!-- profile -->
                <div role="tabpanel" class="tab-pane" id="profileTab">
                    <!-- PROFILE ENABLE -->
                    <input type="hidden" value='0' name="profile">
                    <input type="checkbox" id="profile" name="profile" class="form-control" value="1" title="Enable Profile Tab" <?php echo $profileHtml; ?>>
                    <label for="profile"> <?php echo "$lang[USERPAGE_TAB_PROFILE_ENABLE]"; ?></label><br>
                    <!-- PROFILE ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Profile" title="<?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?>" <?php echo $activeProfileHtml; ?>>
                        <?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?></label><br>

                    <fieldset>
                        <legend><i class="fa fa-user"></i> &nbsp;<?php echo "$lang[USERPAGE_SETUP_PROFILE_PAGE] <small>$lang[USERPAGE_SETUP_PROFILE_PAGE_SUBTEXT]</small>"; ?></legend>
                        <!-- change username -->
                        <input type="hidden" value='0' name="changeUsername">
                        <input type="checkbox" id="changeUsername" name="changeUsername" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_USERNAME]"; ?>" <?php echo $changeUsernameHtml; ?>>
                        <label for="changeUsername"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_USERNAME]"; ?></label><br>
                        <!-- change email -->
                        <input type="hidden" value='0' name="changeEmail">
                        <input type="checkbox" id="changeEmail" name="changeEmail" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_EMAIL]"; ?>" <?php echo $changeEmailHtml; ?>>
                        <label for="changeEmail"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_EMAIL]"; ?></label><br>
                        <!-- change password -->
                        <input type="hidden" value='0' name="changePassword">
                        <input type="checkbox" id="changePassword" name="changePassword" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_PWD]"; ?>" <?php echo $changePasswordHtml; ?>>
                        <label for="changePassword"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_PWD]"; ?></label><br><br>
                        <!-- change firstname -->
                        <input type="hidden" value='0' name="changeFirstname">
                        <input type="checkbox" id="changeFirstname" name="changeFirstname" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_FIRSTNAME]"; ?>" <?php echo $changeFirstnameHtml; ?>>
                        <label for="changeFirstname"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_FIRSTNAME]"; ?></label><br>
                        <!-- change lastname -->
                        <input type="hidden" value='0' name="changeLastname">
                        <input type="checkbox" id="changeLastname" name="changeLastname" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_LASTNAME]"; ?>" <?php echo $changeLastnameHtml; ?>>
                        <label for="changeLastname"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_LASTNAME]"; ?></label><br><br>
                        <!-- change street -->
                        <input type="hidden" value='0' name="changeStreet">
                        <input type="checkbox" id="changeStreet" name="changeStreet" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_STREET]"; ?>" <?php echo $changeStreetHtml; ?>>
                        <label for="changeStreet"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_STREET]"; ?></label><br>
                        <!-- change zipcode -->
                        <input type="hidden" value='0' name="changeZipcode">
                        <input type="checkbox" id="changeZipcode" name="changeZipcode" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_ZIPCODE]"; ?>" <?php echo $changeZipcodeHtml; ?>>
                        <label for="changeZipcode"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_ZIPCODE]"; ?></label><br>
                        <!-- city city -->
                        <input type="hidden" value='0' name="changeCity">
                        <input type="checkbox" id="changeCity" name="changeCity" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_CITY]"; ?>" <?php echo $changeCityHtml; ?>>
                        <label for="changeCity"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_CITY]"; ?></label><br>
                        <!-- change country -->
                        <input type="hidden" value='0' name="changeCountry">
                        <input type="checkbox" id="changeCountry" name="changeCountry" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_COUNTRY]"; ?>" <?php echo $changeCountryHtml; ?>>
                        <label for="changeCountry"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_COUNTRY]"; ?></label><br>
                        <!-- change state -->
                        <input type="hidden" value='0' name="changeState">
                        <input type="checkbox" id="changeState" name="changeState" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_STATE]"; ?>" <?php echo $changeStateHtml; ?>>
                        <label for="changeState"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_STATE]"; ?></label><br><br>
                        <!-- change url -->
                        <input type="hidden" value='0' name="changeUrl">
                        <input type="checkbox" id="changeUrl" name="changeUrl" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_URL]"; ?>" <?php echo $changeUrlHtml; ?>>
                        <label for="changeUrl"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_URL]"; ?></label><br>
                        <!-- change facebook -->
                        <input type="hidden" value='0' name="changeFacebook">
                        <input type="checkbox" id="changeFacebook" name="changeFacebook" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_FACEBOOK]"; ?>" <?php echo $changeFacebookHtml; ?>>
                        <label for="changeFacebook"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_FACEBOOK]"; ?></label><br>
                        <!-- change twitter -->
                        <input type="hidden" value='0' name="changeTwitter">
                        <input type="checkbox" id="changeTwitter" name="changeTwitter" class="form-control" value="1" title="<?php echo "$lang[USERPAGE_ALLOW_CHANGE_TWITTER]"; ?>" <?php echo $changeTwitterHtml; ?>>
                        <label for="changeTwitter"><?php echo "$lang[USERPAGE_ALLOW_CHANGE_TWITTER]"; ?></label><br><br><br>
                    </fieldset>
                </div>
                <!-- messages -->
                <div role="tabpanel" class="tab-pane" id="messagesTab">
                    <!-- MESSAGE PLUGIN ENABLE -->
                    <input type="hidden" value='0' name="messageplugin">
                    <input type="checkbox" id="messageplugin" name="messageplugin" class="form-control" value="1" title="Enable Message Plugin" <?php echo $msgpluginHtml; ?>>
                    <label for="messageplugin"> <?php echo "$lang[USERPAGE_TAB_MESSAGES_ENABLE]"; ?></label><br>
                    <!-- MESSAGE ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                        <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Messages" title="<?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?>" <?php echo $activeMessagesHtml; ?>>
                        <?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?></label><br>
                    <!-- link to plg settings -->
                    <h4><i class="fa fa-wrench"></i><small><i class="fa fa-envelope-o"></i></small> &nbsp;
                    <a href="index.php?plugin=messages"><?php echo $lang['USERPAGE_MESSAGE_PLUGIN_SETTINGS']; ?></a>
                    <small><?php echo $lang['USERPAGE_MESSAGE_PLUGIN_SETTINGS_SUBTEXT']; ?></small></h4><br><br>
                </div>
                <!-- settings -->
                <div role="tabpanel" class="tab-pane" id="settingsTab">
                    <!-- SETTINGS ENABLE -->
                    <input type="hidden" value='0' name="settings">
                    <input type="checkbox" id="settings" name="settings" class="form-control" value="1" title="Enable Settings Tab" <?php echo $settingsHtml; ?>>
                    <label for="settings"> <?php echo "$lang[USERPAGE_TAB_SETTINGS_ENABLE]"; ?></label><br>
                    <!-- SETTINGS ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Settings" title="<?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?>" <?php echo $activeSettingsHtml; ?>>
                        <?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?></label><br>
                </div>
                <!-- stats -->
                <div role="tabpanel" class="tab-pane" id="statsTab">
                    <!-- STATS ENABLE -->
                    <input type="hidden" value='0' name="stats">
                    <input type="checkbox" id="stats" name="stats" class="form-control" value="1" title="Enable Stats Tab" <?php echo $statsHtml; ?>>
                    <label for="stats"> <?php echo "$lang[USERPAGE_TAB_STATS_ENABLE]"; ?></label><br>
                    <!-- STATS ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Stats" title="<?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?>" <?php echo $activeStatsHtml; ?>>
                    <?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?></label><br>
                </div>
                <!-- help -->
                <div role="tabpanel" class="tab-pane" id="helpTab">
                    <!-- HELP ENABLE -->
                    <input type="hidden" value='0' name="help">
                    <input type="checkbox" id="help" name="help" class="form-control" value="1" title="Enable Help Tab" <?php echo $helpHtml; ?>>
                    <label for="help"> <?php echo "$lang[USERPAGE_TAB_HELP_ENABLE]"; ?></label><br>
                    <!-- HELP ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Help" title="<?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?>" <?php echo $activeHelpHtml; ?>>
                    <?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?></label><br>
                    <fieldset>
                        <legend><i class="fa fa-question-circle"></i> &nbsp;<?php echo "$lang[USERPAGE_USER_HELP] <small>$lang[USERPAGE_USER_HELP_SUBTEXT]</small>"; ?></legend>
                        <!-- USER HELP TEXTAREA -->
                        <label for="helptext"> <?php echo "$lang[USERPAGE_USER_HELP] <small>$lang[USERPAGE_USER_HELP_SUBTEXT_LABEL]</small>"; ?></label><br>
                        <textarea name="helptext" id="helptext" class="form-control" cols="70" rows="10" title="User Help Text"><?php echo \YAWK\settings::getLongSetting($db, "userpage_helptext"); ?></textarea>
                        <br><br><br><br>
                    </fieldset>
                </div>
                <!-- admin -->
                <div role="tabpanel" class="tab-pane" id="adminTab">
                    <!-- ADMIN TAB ENABLE -->
                    <input type="hidden" value='0' name="admin">
                    <input type="checkbox" id="admin" name="admin" class="form-control" value="1" title="Enable Admin Tab" <?php echo $adminHtml; ?>>
                    <label for="admin"> <?php echo "$lang[USERPAGE_TAB_ADMIN_ENABLE]"; ?></label><br>
                    <!-- ADMIN ACTIVE TAB -->
                    <label class="radio radio-inline control-label">
                    <input type="radio" id="activeTab" name="activeTab" class="form-control" value="Admin" title="<?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?>" <?php echo $activeAdminHtml; ?>>
                    <?php echo "$lang[SET_THIS_TAB_ACTIVE]"; ?></label><br>
                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane fade in" id="userhelp">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?php print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
        </div>

        <!-- Tab panes -->
            <div role="tabpanel" class="tab-pane fade in" id="menu">
                <fieldset>
                    <!-- SUBMIT BUTTON -->
                    <input type="submit" class="btn btn-success pull-right" value="<?php print $lang['SETTINGS_SAVE']; ?>">
                    <input type="hidden" name="sent" value="1">
                </fieldset>
                <fieldset>
                    <legend><i class="fa fa-bars"></i> &nbsp;<?php echo "$lang[USERPAGE_LOGOUTMENU] <small>$lang[USERPAGE_LOGOUTMENU_SUBTEXT]</small>"; ?></legend>
                    <input type="hidden" value='0' name="logoutmenu">
                    <input type="checkbox" id="logoutmenu" name="logoutmenu" class="form-control" value="1" title="<?php print $lang['LOGOUTMENU_ENABLE']; ?>" <?php echo $logoutmenuHtml; ?>>
                    <label for="logoutmenu"><?php print $lang['USERPAGE_LOGOUTMENU_ENABLE']; ?></label>
                   <br><br><br>
                </fieldset>
            </div>
    </div>
</form>

    </div>
</div>


