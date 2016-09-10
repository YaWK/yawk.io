<?php
// include '../system/plugins/signup/classes/signup.php';
include '../system/plugins/signup/classes/backend.php';

 // TEMPLATE WRAPPER - HEADER & breadcrumbs
    echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
    /* draw Title on top */
    echo \YAWK\backend::getTitle($lang['SIGNUP'], $lang['SIGNUP_SUBTEXT']);
    echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li class=\"active\"><a href=\"index.php?page=pages\" title=\"Pages\"> Pages</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
    /* page content start here */


if (isset($_POST['sent']))
{   // user clicked on save signup settings
    if ($_POST['sent'] === '1')
    {
    foreach ($_POST as $property => $value)
    {   // loop trough properties
        if ($property != "sent")
        {   // check setting and call corresponding function
            if (substr($property, -5, 5) == '-long')
            {   // LONG VALUE SETTINGS
                if (!\YAWK\settings::setLongSetting($db, $property, $value))
                {   // throw error
                    \YAWK\alert::draw("warning", "Error", "Long Settings: Could not set long value <b>$value</b> of property <b>$property</b>","plugin=signup","4800");
                }
            }
            else if (substr($property, -4, 4) == '-tpl')
            {   // TEMPLATE SETTINGS
                if (!\YAWK\settings::setTemplateSetting($db, $property, $value))
                {   // throw error
                    \YAWK\alert::draw("warning", "Error", "Template Settings: Could not set template setting <b>$value</b> of property <b>$property</b>","plugin=signup","4800");
                }
            }
            // TERMS OF SERVICE PAGE
            else if ($property == "signup_tospage")
            {   // check terms of service filename
                if (empty($_POST['signup_tospage']))
                {   // set default filename
                    $value="terms-of-service"; // set default value
                }
                // set terms of service setting
                if (!\YAWK\settings::setSetting($db, $property, $value))
                {   // throw error
                    \YAWK\alert::draw("warning", "Error!", "Settings: Could not set value <b>$value</b> of property <b>$property</b>","plugin=signup","4800");
                }
                // array to help create terms of service page
                $plugin = array("tos", $_POST['signup_tospage'], $_POST['signup_terms-long']);
                if (!\YAWK\plugin::createPluginPage($db, $_POST['signup_tospage'], $plugin))
                {   // throw error
                    \YAWK\alert::draw("danger","Error!", "Could not create terms of service page.", "","");
                }
            }
            // SET ALLOWED GROUP ID SELECTOR
            else if ($property == "gid")
            {   //
                \YAWK\PLUGINS\SIGNUP\backend::setAllowedGroup($db, $value);
            }
            else
            {   // any other setting
                \YAWK\settings::setSetting($db, $property, $value);
            }
        }
    }   // ./ end foreach
    }
}

// get layout settings
$layout = \YAWK\settings::getSetting($db, "signup_layout");
if ($layout === 'left') {
    $leftHtml = "checked";
} else {
    $leftHtml = "";
}
if ($layout === 'right') {
    $rightHtml = "checked";
} else {
    $rightHtml = "";
}
if ($layout === 'plain') {
    $plainHtml = "checked";
} else {
    $plainHtml = "";
}
if ($layout === 'center') {
    $centerHtml = "checked";
} else {
    $centerHtml = "";
}

// get aditional field settings
// set checkbox status
    // firstname
    if (\YAWK\settings::getSetting($db, "signup_firstname") === '1') {
        $firstnameHtml = "checked";
    }else {
        $firstnameHtml = "";
    }
    // lastname
    if (\YAWK\settings::getSetting($db, "signup_lastname") === '1') {
        $lastnameHtml = "checked";
    } else {
        $lastnameHtml = "";
    }
    // street
    if (\YAWK\settings::getSetting($db, "signup_street") === '1') {
        $streetHtml = "checked";
    } else {
        $streetHtml = "";
    }
    // zipcode
    if (\YAWK\settings::getSetting($db, "signup_zipcode") === '1') {
        $zipcodeHtml = "checked";
    } else {
        $zipcodeHtml = "";
    }
    // city
    if (\YAWK\settings::getSetting($db, "signup_city") === '1') {
        $cityHtml = "checked";
    } else {
        $cityHtml = "";
    }
    // country
    if (\YAWK\settings::getSetting($db, "signup_country") === '1') {
        $countryHtml = "checked";
    } else {
        $countryHtml = "";
    }

if (\YAWK\settings::getSetting($db, "signup_gid") === '0'){
    $gidHtmlOn = "";
    $gidHtmlOff = "checked";
} else {
    $gidHtmlOn = "checked";
    $gidHtmlOff = "";
}

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
if (\YAWK\settings::getSetting($db, "userpage_stats") === '1'){
    $statsHtml = "checked"; }
else {
    $statsHtml = "";
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
if (\YAWK\settings::getSetting($db, "signup_adultcheck") === '1'){
    $adultCheckHtml = "checked"; }
else {
    $adultCheckHtml = "";
}

?>
<script type="text/javascript" src="../system/plugins/signup/js/admin.js"></script>
<form action="index.php?plugin=signup" class="form-inline" role="form" name="settings" method="POST">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#layout" aria-controls="layout" role="tab" data-toggle="tab"><i class="fa fa-object-group"></i> &nbsp;Layout</a>
        </li>
        <li role="presentation"><a href="#groups" aria-controls="groups" role="tab" data-toggle="tab"><i class="fa fa-users"></i> &nbsp;Group Selector</a></li>
        <li role="presentation"><a href="#fields" aria-controls="fields" role="tab" data-toggle="tab"><i class="fa fa-exclamation-triangle"></i> &nbsp;Mandatory Fields</a></li>
        <li role="presentation"><a href="#text" aria-controls="text" role="tab" data-toggle="tab"><i class="fa fa-check-square-o"></i> &nbsp;Text & Button Style</a></li>
        <li role="presentation"><a href="#termstab" aria-controls="termstab" role="tab" data-toggle="tab"><i class="fa fa-legal"></i> &nbsp;Terms of Service</a></li>
        <li role="presentation"><a href="#userpage" aria-controls="userpage" role="tab" data-toggle="tab"><i class="fa fa-gears"></i><small><i class="fa fa-user"></i></small> &nbsp;Userpage Options</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="layout">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?PHP print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
            <!-- layout -->
            <fieldset>
                <legend><i class="fa fa-object-group"></i> &nbsp;Layout <small>choose between different form layouts</small></legend>
                <input type="radio" id="layout_p" name="signup_layout" class="form-control" value="plain" <?PHP echo $plainHtml;?>>
                <label for="layout_p">1 column, plain form, no legend</label><br>
                <input type="radio" id="layout_r" name="signup_layout" class="form-control" value="right" <?PHP echo $rightHtml;?>>
                <label for="layout_r">2 columns, legend right</label><br>
                <input type="radio" id="layout_l" name="signup_layout" class="form-control" value="left" <?PHP echo $leftHtml;?>>
                <label for="layout_l">2 columns, legend left</label><br>
                <input type="radio" id="layout_c" name="signup_layout" class="form-control" value="center" <?PHP echo $centerHtml;?>>
                <label for="layout_c">3 columns, form in the middle, no legend</label><br><br><br>
            </fieldset>
            <!-- title text  -->
            <fieldset>
                <legend><i class="fa fa-header"></i> &nbsp;Title Text <small>that appears above the form</small></legend>
                <label for="title">Title above form <small>(html allowed)</small></label><br>
                <input type="text" id="title" name="signup_title" class="form-control" size="64" value="<?PHP echo \YAWK\settings::getSetting($db, "signup_title");?>" title="Form Title (above)"><br><br><br>
            </fieldset>
            <!-- adultcheck -->
            <fieldset>
                <legend><i class="fa fa-question-circle"></i> &nbsp;Adult Check <small>ask question before the registration form</small></legend>
                <input type="hidden" value='0' name="signup_adultcheck">
                <input type="checkbox" id="adultCheck" name="signup_adultcheck" class="form-control" value="1" title="Adult Check" <?PHP echo $adultCheckHtml; ?>>
                <label for="adultCheck">Enable <small>adult check</small></label>
            </fieldset>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="groups">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?PHP print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
            <!-- group selector -->
            <fieldset>
                <legend><i class="fa fa-users"></i> &nbsp;Group Selector <small>let users choose to wich group they belong</small></legend>
                <input type="radio" id="gidselect1" name="signup_gid" class="form-control" value="1" <?PHP echo $gidHtmlOn; ?>>
                <label for="gidselect1">Enabled </label>&nbsp;&nbsp;<small>or</small>&nbsp;
                <input type="radio" id="gidselect2" name="signup_gid" class="form-control" value="0" <?PHP echo $gidHtmlOff; ?>>
                <label for="gidselect2">Disabled </label><br>
                <!-- ACCESS CONTROL / PRIVACY -->
                <select name="gid[]" class="form-control" aria-multiselectable="true" multiple>
                    <?php
                    \YAWK\PLUGINS\SIGNUP\backend::getUserGroupSelector($db);
                    ?>
                </select><br><br>
                <h4><a href="index.php?page=user-groups" title="change names, login access, frontend access and colors">
                        <i class="fa fa-wrench"></i> &nbsp;Edit Group Settings</a>
                    <small>(change group names and set backend access)</small></h4><br><br>
            </fieldset>
            <fieldset>
                <legend><i class="fa fa-info"></i> &nbsp;Legend Text <small>that appears beside the form</small></legend>
                <select name="gid-legend" id="gid-legend" class="form-control">
                    <?php
                    \YAWK\PLUGINS\SIGNUP\backend::getGroupSelector($db);
                    ?>
                </select>
                <label for="gid-legend">Select Group</label>
                <br><br>

                <?php
                $groupIDArray = \YAWK\user::getAllGroupIDs($db);
                foreach ($groupIDArray as $gid){
                    echo "<!-- LEGEND INPUT FIELDS -->
                <div id=\"$gid[0]_hidden\">
                    <label for=\"$gid[0]_hidden\">$gid[1] Legend Text <small class=\"text-muted\">left or right, depending on your layout choice.</small>  </label><br>
                    <textarea name=\"signup_legend$gid[0]-long\" id=\"$gid[0]_hidden\" class=\"form-control\" cols=\"64\" rows=\"10\">";
                    echo \YAWK\settings::getLongSetting($db, "signup_legend$gid[0]-long"); echo"</textarea>
                </div>";
                }
                echo "<!-- LEGEND INPUT FIELDS -->
                <div id=\"0_hidden\">
                    <label for=\"0_hidden\">Default Legend Text <small class=\"text-muted\">left or right, depending on your layout choice.</small>  </label><br>
                    <textarea name=\"signup_legend0-long\" id=\"0_hidden\" class=\"form-control\" cols=\"64\" rows=\"10\">";
                    echo \YAWK\settings::getLongSetting($db, "signup_legend0-long"); echo"</textarea>
                </div>";

                ?>
            </fieldset>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="fields">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?PHP print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
            <!-- mandatory & additional fields -->
            <fieldset>
                <legend><i class="fa fa-exclamation-triangle"></i> &nbsp;Mandatory Fields <small>these are required</small></legend>
                <input type="checkbox" id="username" name="username" checked="checked" class="form-control" title="Benutzername" disabled>
                <label for="username">Benutzername <small class="text-danger">required</small></label><br>
                <input type="checkbox" id="password" name="password" checked="checked" class="form-control" disabled>
                <label for="password">Passwort <small class="text-danger">required</small>  </label><br>
                <input type="checkbox" id="terms" name="terms" checked="checked" class="form-control" disabled>
                <label for="terms">Terms of Service <small class="text-danger">required</small></label><br><br>
            </fieldset>
            <fieldset>
                <legend><i class="fa fa-toggle-down"></i> &nbsp;Optional: <small>choose more fields</small></legend>
                <input type="hidden" value='0' name="signup_firstname">
                <input type="checkbox" id="firstname" name="signup_firstname" class="form-control" value="1" title="First Name" <?PHP echo $firstnameHtml; ?>>
                <label for="firstname">First Name</label><br>

                <input type="hidden" value='0' name="signup_lastname">
                <input type="checkbox" id="lastname" name="signup_lastname" class="form-control" value="1" title="Last Name" <?PHP echo $lastnameHtml; ?>>
                <label for="lastname">Last Name</label><br>

                <input type="hidden" value='0' name="signup_street">
                <input type="checkbox" id="street" name="signup_street" class="form-control" value="1" title="Street" <?PHP echo $streetHtml; ?>>
                <label for="street">Street</label><br>

                <input type="hidden" value='0' name="signup_zipcode">
                <input type="checkbox" id="zipcode" name="signup_zipcode" class="form-control" value="1" title="ZIP Code" <?PHP echo $zipcodeHtml; ?>>
                <label for="zipcode">ZIP Code</label><br>

                <input type="hidden" value='0' name="signup_city">
                <input type="checkbox" id="city" name="signup_city" class="form-control" title="City" value="1" <?PHP echo $cityHtml; ?>>
                <label for="city">City</label><br>

                <input type="hidden" value='0' name="signup_country">
                <input type="checkbox" id="country" name="signup_country" class="form-control" value="1" title="Country" <?PHP echo $countryHtml; ?>>
                <label for="country">Country</label><br><br>
            </fieldset>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="text">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?PHP print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
                <!-- submit button text & style -->
                <fieldset>
                    <legend><i class="fa fa-check-square-o"></i> &nbsp;Submit Button <small>Text & Style</small></legend>
                    <label for="submittext">Submit Button Text</label><br>
                    <input type="text" id="submittext" name="signup_submittext" class="form-control" value="<?PHP echo \YAWK\settings::getSetting($db, "signup_submittext");?>" title="Submit Button Text"><br>
                    <label for="submitstyle">Submit Button Style <small>(success, error, warning, default, info)</small></label><br>
                    <input type="text" id="submitstyle" name="signup_submitstyle" class="form-control" value="<?PHP echo \YAWK\settings::getSetting($db, "signup_submitstyle");?>" title="Submit Button Style">
                    <br><br><br>
                </fieldset>
            <!-- error / valid text color -->
            <fieldset>
                <legend><i class="glyphicon glyphicon-text-color"></i> &nbsp;Colors <small>error / valid</small></legend>
                <label for="formerror">Error Text Color <small>default: #<?php echo \YAWK\template::getTemplateSetting($db, "valueDefault", "form-error") ;?></small></label><br>
                <input type="text" id="formerror" name="formerror-tpl" class="form-control color" value="<?PHP echo \YAWK\template::getTemplateSetting($db, "value", "form-error");?>" title="Error Text Color"><br>
                <label for="formvalid">Valid Text Color <small>default: #<?php echo \YAWK\template::getTemplateSetting($db, "valueDefault", "form-valid") ;?></small></label><br>
                <input type="text" id="formvalid" name="formvalid-tpl" class="form-control color" value="<?PHP echo \YAWK\template::getTemplateSetting($db, "value", "form-valid");?>" title="Valid Text Color"><br>
            </fieldset>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="termstab">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?PHP print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
            <!-- terms of service settings -->
            <fieldset>
                <legend><i class="fa fa-legal"></i> &nbsp;Terms of Service <small>privacy & data protection</small></legend>
                <label for="tos-long">Enter the Terms of Service for your project</label><br>
                <textarea id="tos-long" name="signup_terms-long" class="form-control" cols="60" rows="10"><?PHP echo \YAWK\settings::getLongSetting($db, "signup_terms-long");?></textarea><br><br>
                <label for="tospage">Terms of Service Page Name <small>default: tos.html</small></label><br>
                <input type="text" id="tospage" name="signup_tospage" size="40" class="form-control" value="<?PHP echo \YAWK\settings::getSetting($db, "signup_tospage");?>" title="Terms of Service Page Name"> .html<br><br>
                <label for="tostext">Link Description <small>(link underneath form)</small></label><br>
                <input type="text" id="tostext" name="signup_tostext" size="40" class="form-control" value="<?PHP echo \YAWK\settings::getSetting($db, "signup_tostext");?>" title="Terms of Service Link Description"><br><br>
                <label for="toscolor">Link Color</label><br>
                <input type="text" id="toscolor" name="signup_toscolor" class="form-control color" value="<?PHP echo \YAWK\settings::getSetting($db, "signup_toscolor");?>" title="Terms of Service Link Color"><br>
                <br><br><br>
            </fieldset>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="userpage">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?PHP print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
            <fieldset>
                <legend><i class="fa fa-gears"></i><small><i class="fa fa-user"></i></small> &nbsp;Userpage Options <small>set welcome page</small></legend>
                <label for="hellotext">Greeting </label><br>
                <input type="text" id="hellotext" name="hellotext" class="form-control" placeholder="Welcome" value="<?PHP echo \YAWK\settings::getSetting($db, "userpage_hellotext");?>" title="Greeting">
                &nbsp;$USERNAME &nbsp;
                <input type="text" id="hellotextsub" name="hellotextsub" class="form-control" placeholder="good to see you again!" value="<?PHP echo \YAWK\settings::getSetting($db, "userpage_hellotextsub");?>" title="Greeting Subtext">
                <label for="hellotextsub">&nbsp;</label><br><br>
                <input type="hidden" value='0' name="hello">
                <input type="checkbox" id="hello" name="hello" class="form-control" value="1" title="Enable User Greeting" <?PHP echo $helloHtml; ?>>
                <label for="hello">Enable User Greeting</label><br>
                <input type="hidden" value='0' name="hellogroup">
                <input type="checkbox" id="hellogroup" name="hellogroup" class="form-control" value="1" title="Enable User Group Greeting" <?PHP echo $hellogroupHtml; ?>>
                <label for="hellogroup">Enable User Group Greeting</label><br><br><br>
            </fieldset>
            <fieldset>
                <legend><i class="fa fa-dashboard"></i> &nbsp;User Dashboard <small> visibility of tabs for logged in users</small></legend>

                <!-- ADMIN TAB ENABLE -->
                <input type="hidden" value='0' name="dashboard">
                <input type="checkbox" id="dashboard" name="dashboard" class="form-control" value="1" title="Enable Dashboard Tab" <?PHP echo $dashboardHtml; ?>>
                <label for="dashboard"> Enable Dashboard Tab</label><br>

                <!-- ADMIN TAB ENABLE -->
                <input type="hidden" value='0' name="admin">
                <input type="checkbox" id="admin" name="admin" class="form-control" value="1" title="Enable Admin Tab" <?PHP echo $adminHtml; ?>>
                <label for="admin"> Enable Admin Tab</label><br>

                <!-- PROFILE ENABLE -->
                <input type="hidden" value='0' name="profile">
                <input type="checkbox" id="profile" name="profile" class="form-control" value="1" title="Enable Profile Tab" <?PHP echo $profileHtml; ?>>
                <label for="profile"> Enable Profile Tab</label><br>

                <!-- SETTINGS ENABLE -->
                <input type="hidden" value='0' name="settings">
                <input type="checkbox" id="settings" name="settings" class="form-control" value="1" title="Enable Settings Tab" <?PHP echo $settingsHtml; ?>>
                <label for="settings"> Enable Settings Tab</label><br>

                <!-- STATS ENABLE -->
                <input type="hidden" value='0' name="stats">
                <input type="checkbox" id="stats" name="stats" class="form-control" value="1" title="Enable Stats Tab" <?PHP echo $statsHtml; ?>>
                <label for="stats"> Enable Stats Tab</label><br>

                <!-- HELP ENABLE -->
                <input type="hidden" value='0' name="help">
                <input type="checkbox" id="help" name="help" class="form-control" value="1" title="Enable Help Tab" <?PHP echo $helpHtml; ?>>
                <label for="help"> Enable Help Tab</label><br>

                <!-- MESSAGE PLUGIN ENABLE -->
                <input type="hidden" value='0' name="messageplugin">
                <input type="checkbox" id="messageplugin" name="messageplugin" class="form-control" value="1" title="Enable Message Plugin" <?PHP echo $msgpluginHtml; ?>>
                <label for="messageplugin"> Enable Message Plugin</label><br>
                <h4><a href="index.php?plugin=messages" title="change names, login access, frontend access and colors">
                        <i class="fa fa-envelope-o"></i> &nbsp;Message Plugin Settings</a>
                    <small>(edit all messaging options here)</small></h4><br><br>
            </fieldset>
            <fieldset>
                <legend><i class="fa fa-question-circle"></i> &nbsp;User Help <small>configure user help</small></legend>
                <!-- USER HELP TEXTAREA -->
                <label for="helptext-long"> User Help Text <small>(html allowed)</small></label><br>
                <textarea name="helptext-long" id="helptext-long" class="form-control" cols="70" rows="10" title="User Help Text"><?php echo \YAWK\settings::getLongSetting($db, "userpage_helptext"); ?></textarea>
                <br><br><br><br>
            </fieldset>
        </div>
</form>
