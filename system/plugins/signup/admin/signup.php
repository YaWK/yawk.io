<?php
// check if language is set
use YAWK\db;
use YAWK\language;
use YAWK\template;
use YAWK\user;

if (!isset($db)){
    $db = new db();
}
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = language::inject(@$lang, "../system/plugins/signup/language/");
}
if (!isset($user)){
    $user = new user($db);
}
if (!isset($template)){
    $template = new template($db);
}
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
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=pages\" title=\"$lang[PAGES]\"> $lang[PAGES]</a></li>
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
                    \YAWK\alert::draw("warning", "$lang[ERROR]", "Long Settings: Could not set long value <b>$value</b> of property <b>$property</b>","plugin=signup","4800");
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
                if (!\YAWK\settings::setSetting($db, $property, $value, $lang))
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
                \YAWK\settings::setSetting($db, $property, $value, $lang);
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

<div class="box box-default">
    <div class="box-body">
<form action="index.php?plugin=signup" class="form-inline" role="form" name="settings" method="POST">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#layout" aria-controls="layout" role="tab" data-toggle="tab"><i class="fa fa-object-group"></i> &nbsp;<?php echo "$lang[LAYOUT]"; ?></a>
        </li>
        <li role="presentation"><a href="#groups" aria-controls="groups" role="tab" data-toggle="tab"><i class="fa fa-users"></i> &nbsp;<?php echo "$lang[USER_GROUPS]"; ?></a></li>
        <li role="presentation"><a href="#fields" aria-controls="fields" role="tab" data-toggle="tab"><i class="fa fa-exclamation-triangle"></i> &nbsp;<?php echo "$lang[MANDATORY_FIELDS]"; ?></a></li>
        <li role="presentation"><a href="#text" aria-controls="text" role="tab" data-toggle="tab"><i class="fa fa-check-square-o"></i> &nbsp;<?php echo "$lang[TEXT_BTN_STYLE]"; ?></a></li>
        <li role="presentation"><a href="#termstab" aria-controls="termstab" role="tab" data-toggle="tab"><i class="fa fa-legal"></i> &nbsp;<?php echo "$lang[TERMS_OF_SERVICE]"; ?></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="layout">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?php print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
            <!-- layout -->
            <fieldset>
                <legend><i class="fa fa-object-group"></i> &nbsp;<?php print "$lang[LAYOUT] <small>$lang[LAYOUT_SUBTEXT]</small>"; ?></legend>
                <input type="radio" id="layout_p" name="signup_layout" class="form-control" value="plain" <?php echo $plainHtml;?>>
                <label for="layout_p"><?php print "$lang[COL_LAYOUT_1]"; ?></label><br>
                <input type="radio" id="layout_r" name="signup_layout" class="form-control" value="right" <?php echo $rightHtml;?>>
                <label for="layout_r"><?php print "$lang[COL_LAYOUT_2]"; ?></label><br>
                <input type="radio" id="layout_l" name="signup_layout" class="form-control" value="left" <?php echo $leftHtml;?>>
                <label for="layout_l"><?php print "$lang[COL_LAYOUT_3]"; ?></label><br>
                <input type="radio" id="layout_c" name="signup_layout" class="form-control" value="center" <?php echo $centerHtml;?>>
                <label for="layout_c"><?php print "$lang[COL_LAYOUT_4]"; ?></label><br><br><br>
            </fieldset>
            <!-- title text  -->
            <fieldset>
                <legend><i class="fa fa-header"></i> &nbsp;<?php echo "$lang[SIGNUP_TITLE_TEXT] <small>$lang[SIGNUP_TITLE_SUBTEXT]</small>"; ?></legend>
                <label for="title"><?php echo "$lang[SIGNUP_TITLE_TEXT] <small>($lang[SIGNUP_TITLE_LABEL_SUBTEXT])</small>"; ?></label><br>
                <input type="text" id="title" name="signup_title" class="form-control" size="64" value="<?php echo \YAWK\settings::getSetting($db, "signup_title");?>" title="<?php echo "$lang[SIGNUP_TITLE_TEXT]"; ?>"><br><br><br>
            </fieldset>
            <!-- adultcheck -->
            <fieldset>
                <legend><i class="fa fa-question-circle"></i> &nbsp;<?php echo "$lang[SIGNUP_ADULT_CHECK] <small>$lang[SIGNUP_ADULT_CHECK_SUBTEXT]</small>"; ?></legend>
                <input type="hidden" value='0' name="signup_adultcheck">
                <input type="checkbox" id="adultCheck" name="signup_adultcheck" class="form-control" value="1" title="<?php echo "$lang[SIGNUP_ADULT_CHECK]"; ?>" <?php echo $adultCheckHtml; ?>>
                <label for="adultCheck"><?php echo "$lang[ENABLE]?"; ?> <small><?php echo "$lang[SIGNUP_ADULT_CHECK]"; ?></small></label>
            </fieldset>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="groups">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?php print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
            <!-- group selector -->
            <fieldset>
                <legend><i class="fa fa-users"></i> &nbsp;<?php echo "$lang[SIGNUP_GROUP_TITLE] <small>$lang[SIGNUP_GROUP_TITLE_SUBTEXT]</small>";?></legend>
                <input type="radio" id="gidselect1" name="signup_gid" class="form-control" value="1" <?php echo $gidHtmlOn; ?>>
                <label for="gidselect1"><?php print $lang['ENABLED']; ?> </label>&nbsp;&nbsp;<small><?php print $lang['OR']; ?></small>&nbsp;
                <input type="radio" id="gidselect2" name="signup_gid" class="form-control" value="0" <?php echo $gidHtmlOff; ?>>
                <label for="gidselect2"><?php print $lang['DISABLED']; ?> </label><br>
                <!-- ACCESS CONTROL / PRIVACY -->
                <select name="gid[]" class="form-control" aria-multiselectable="true" multiple>
                    <?php \YAWK\PLUGINS\SIGNUP\backend::getUserGroupSelector($db); ?>
                </select><br><br>
                <h4><a href="index.php?page=user-groups" title="<?php echo "$lang[SIGNUP_GROUPSETTINGS_SUBTEXT]"; ?>">
                        <i class="fa fa-wrench"></i> &nbsp;<?php echo "$lang[SIGNUP_GROUPSETTINGS_EDIT]"; ?></a>
                    <small>(<?php echo "$lang[SIGNUP_GROUPSETTINGS_SUBTEXT]"; ?>)</small></h4><br><br>
            </fieldset>
            <fieldset>
                <legend><i class="fa fa-info"></i> &nbsp;<?php echo "$lang[SIGNUP_GROUP_LEGEND_TEXT] <small>$lang[SIGNUP_GROUP_LEGEND_SUBTEXT]</small>";?></legend>
                <select name="gid-legend" id="gid-legend" class="form-control">
                    <?php
                    \YAWK\PLUGINS\SIGNUP\backend::getGroupSelector($db);
                    ?>
                </select>
                <label for="gid-legend"><?php echo "$lang[SELECT_GROUP]"; ?></label>
                <br><br>

                <?php
                $groupIDArray = user::getAllGroupIDs($db);
                foreach ($groupIDArray as $gid){
                    echo "<!-- LEGEND INPUT FIELDS -->
                <div id=\"$gid[0]_hidden\">
                    <label for=\"$gid[0]_hidden\">$gid[1] $lang[SIGNUP_LEGEND] <small class=\"text-muted\">$lang[SIGNUP_LEGEND_SUBTEXT]</small>  </label><br>
                    <textarea name=\"signup_legend$gid[0]-long\" id=\"$gid[0]_hidden\" class=\"form-control\" cols=\"64\" rows=\"10\">";
                    echo \YAWK\settings::getLongSetting($db, "signup_legend$gid[0]-long"); echo"</textarea>
                </div>";
                }
                echo "<!-- LEGEND INPUT FIELDS -->
                <div id=\"0_hidden\">
                    <label for=\"0_hidden\">$lang[LEGEND] <small class=\"text-muted\">$lang[SIGNUP_LEGEND_SUBTEXT]</small>  </label><br>
                    <textarea name=\"signup_legend0-long\" id=\"0_hidden\" class=\"form-control\" cols=\"64\" rows=\"10\">";
                    echo \YAWK\settings::getLongSetting($db, "signup_legend0-long"); echo"</textarea>
                </div>";

                ?>
            </fieldset>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="fields">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?php print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
            <!-- mandatory & additional fields -->
            <fieldset>
                <legend><i class="fa fa-exclamation-triangle"></i> &nbsp;<?php echo $lang['MANDATORY_FIELDS']; ?> <small><?php echo $lang['THESE_ARE_REQUIRED']; ?></small></legend>
                <input type="checkbox" id="username" name="username" checked="checked" class="form-control" title="<?php echo $lang['USERNAME']; ?>" disabled>
                <label for="username"><?php echo $lang['USERNAME']; ?> <small class="text-danger"><?php echo $lang['REQUIRED']; ?></small></label><br>
                <input type="checkbox" id="password" name="password" checked="checked" class="form-control" disabled>
                <label for="password"><?php echo $lang['PASSWORD']; ?> <small class="text-danger"><?php echo $lang['REQUIRED']; ?></small>  </label><br>
                <input type="checkbox" id="terms" name="terms" checked="checked" class="form-control" disabled>
                <label for="terms"><?php echo $lang['TERMS_OF_SERVICE']; ?> <small class="text-danger"><?php echo $lang['REQUIRED']; ?></small></label><br><br>
            </fieldset>
            <fieldset>
                <legend><i class="fa fa-toggle-down"></i> &nbsp;<?php echo $lang['OPTIONAL']; ?> <small><?php echo $lang['OPTIONAL_SUBTEXT']; ?></small></legend>
                <input type="hidden" value='0' name="signup_firstname">
                <input type="checkbox" id="firstname" name="signup_firstname" class="form-control" value="1" title="<?php echo $lang['FIRSTNAME']; ?>" <?php echo $firstnameHtml; ?>>
                <label for="firstname"><?php echo $lang['FIRSTNAME']; ?></label><br>

                <input type="hidden" value='0' name="signup_lastname">
                <input type="checkbox" id="lastname" name="signup_lastname" class="form-control" value="1" title="<?php echo $lang['LASTNAME']; ?>" <?php echo $lastnameHtml; ?>>
                <label for="lastname"><?php echo $lang['LASTNAME']; ?></label><br>

                <input type="hidden" value='0' name="signup_street">
                <input type="checkbox" id="street" name="signup_street" class="form-control" value="1" title="<?php echo $lang['STREET']; ?>" <?php echo $streetHtml; ?>>
                <label for="street"><?php echo $lang['STREET']; ?></label><br>

                <input type="hidden" value='0' name="signup_zipcode">
                <input type="checkbox" id="zipcode" name="signup_zipcode" class="form-control" value="1" title="<?php echo $lang['ZIPCODE']; ?>" <?php echo $zipcodeHtml; ?>>
                <label for="zipcode"><?php echo $lang['ZIPCODE']; ?></label><br>

                <input type="hidden" value='0' name="signup_city">
                <input type="checkbox" id="city" name="signup_city" class="form-control" title="<?php echo $lang['CITY']; ?>" value="1" <?php echo $cityHtml; ?>>
                <label for="city"><?php echo $lang['CITY']; ?></label><br>

                <input type="hidden" value='0' name="signup_country">
                <input type="checkbox" id="country" name="signup_country" class="form-control" value="1" title="<?php echo $lang['COUNTRY']; ?>" <?php echo $countryHtml; ?>>
                <label for="country"><?php echo $lang['COUNTRY']; ?></label><br><br>
            </fieldset>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="text">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?php print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
                <!-- submit button text & style -->
                <fieldset>
                    <legend><i class="fa fa-check-square-o"></i> &nbsp;<?php echo $lang['SIGNUP_SUBMIT_BTN']; ?> <small><?php echo $lang['SIGNUP_SUBMIT_BTN_SUBTEXT']; ?></small></legend>
                    <label for="submittext"><?php echo $lang['SIGNUP_SUBMIT_BTN']." ".$lang['TEXT']; ?></label><br>
                    <input type="text" id="submittext" name="signup_submittext" class="form-control" value="<?php echo \YAWK\settings::getSetting($db, "signup_submittext");?>" title="<?php echo $lang['SIGNUP_SUBMIT_BTN']." ".$lang['TEXT']; ?>"><br>
                    <label for="submitstyle"><?php echo $lang['SIGNUP_SUBMIT_BTN']." ".$lang['SIGNUP_SUBMIT_BTN_SUBTEXT']; ?> <small><?php echo $lang['SIGNUP_SUBMIT_BTN_STYLES']; ?></small></label><br>
                    <input type="text" id="submitstyle" name="signup_submitstyle" class="form-control" value="<?php echo \YAWK\settings::getSetting($db, "signup_submitstyle");?>" title="<?php echo $lang['SIGNUP_SUBMIT_BTN']." ".$lang['SIGNUP_SUBMIT_BTN_SUBTEXT']; ?>">
                    <br><br><br>
                </fieldset>
            <!-- error / valid text color -->
            <fieldset>
                <legend><i class="glyphicon glyphicon-text-color"></i> &nbsp;<?php echo "$lang[COLORS] <small>$lang[SIGNUP_COLORS_SUBTEXT]</small>"; ?></legend>
                <label for="formerror"><?php echo $lang['ERROR_TEXT_COLOR']; ?> <small>default: #<?php echo template::getTemplateSetting($db, "valueDefault", "form-error", $user, $template) ;?></small></label><br>
                <input type="text" id="formerror" name="formerror-tpl" class="form-control color" value="<?php echo template::getTemplateSetting($db, "value", "form-error", $user, $template);?>" title="Error Text Color"><br>
                <label for="formvalid"><?php echo $lang['VALID_TEXT_COLOR']; ?> <small>default: #<?php echo template::getTemplateSetting($db, "valueDefault", "form-valid", $user, $template) ;?></small></label><br>
                <input type="text" id="formvalid" name="formvalid-tpl" class="form-control color" value="<?php echo template::getTemplateSetting($db, "value", "form-valid", $user, $template);?>" title="Valid Text Color"><br>
            </fieldset>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="termstab">
            <fieldset>
                <!-- SUBMIT BUTTON -->
                <input type="submit" class="btn btn-success pull-right" value="<?php print $lang['SETTINGS_SAVE']; ?>">
                <input type="hidden" name="sent" value="1">
            </fieldset>
            <!-- terms of service settings -->
            <fieldset>
                <legend><i class="fa fa-legal"></i> &nbsp;<?php print $lang['TERMS_OF_SERVICE']; ?> <small><?php print $lang['SETTINGS']; ?></small></legend>
                <label for="tos-long"><?php echo $lang['TOS_TITLE']; ?></label><br>
                <textarea id="tos-long" name="signup_terms-long" class="form-control" cols="60" rows="10"><?php echo \YAWK\settings::getLongSetting($db, "signup_terms-long");?></textarea><br><br>
                <label for="tospage"><?php echo $lang['TOS_FILENAME']; ?> <small>default: tos.html</small></label><br>
                <input type="text" id="tospage" name="signup_tospage" size="40" class="form-control" value="<?php echo \YAWK\settings::getSetting($db, "signup_tospage");?>" title="Terms of Service Page Name"> .html<br><br>
                <label for="tostext"><?php echo $lang['TOS_LINK_DESC']; ?> <small><?php echo $lang['TOS_LINK_DESC_SUBTEXT']; ?></small></label><br>
                <input type="text" id="tostext" name="signup_tostext" size="40" class="form-control" value="<?php echo \YAWK\settings::getSetting($db, "signup_tostext");?>" title="Terms of Service Link Description"><br><br>
                <label for="toscolor"><?php echo "$lang[LINK] $lang[COLOR]"; ?></label><br>
                <input type="text" id="toscolor" name="signup_toscolor" class="form-control color" value="<?php echo \YAWK\settings::getSetting($db, "signup_toscolor");?>" title="Terms of Service Link Color"><br>
                <br><br><br>
            </fieldset>
        </div>
</form>

    </div>
</div>