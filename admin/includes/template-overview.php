<?php
// check if template obj is set and create if not exists
if (!isset($template)) { $template = new \YAWK\template(); }
// new user obj if not exists
if (!isset($user)) { $user = new \YAWK\user(); }
// get ID of current active template
$getID = \YAWK\settings::getSetting($db, "selectedTemplate");
// load properties of current active template
$template->loadProperties($db, $getID);
// previewButton is an empty string - why? this should be checked
$previewButton = "";

// load all template settings into array
// $templateSettings = \YAWK\template::getAllSettingsIntoArray($db, $user);

// check template wrapper
\YAWK\template::checkWrapper($lang, $lang['TPL'], $lang['OVERVIEW']);
?>

<!-- OVERVIEW -->
<h3><?php echo "$lang[OVERVIEW] <small>$lang[TPL] $lang[SUMMARY]</small>"; ?></h3>
<!-- list TEMPLATE HOME PAGE (DETAILS) -->
<div class="row animated fadeIn">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[DETAILS] <small>$lang[OF_CURRENT_ACTIVE_THEME]"; ?></small></h3>
            </div>
            <dl class="dl-horizontal">
                <?php
                // PREPARE TEMPLATE DETAILS VARS
                // author URL
                if (isset($template->authorUrl) && (!empty($template->authorUrl)))
                {   // set author's link
                    $authorUrl = "<small>&nbsp;<a href=\"$template->authorUrl\" target=\"_blank\" title=\"$lang[AUTHORS_WEBLINK_DESC]\"
                                <i class=\"fa fa-external-link\"></i></a></small>";
                }
                else { $authorUrl = ""; }

                // author
                if (isset($template->author) && (!empty($template->author)))
                {   // set author
                    $author = "<dt>$lang[AUTHOR]</dt><dd>$template->author&nbsp;$authorUrl</dd>";
                }
                else { $author = ""; }

                // weblink
                if (isset($template->weblink) && (!empty($template->weblink)))
                {   // set author's link
                    $weblink = "<dt>$lang[WEBLINK]</dt><dd><a href=\"$template->weblink\" target=\"_blank\" title=\"$lang[PROJECT_WEBLINK_DESC]\">$template->weblink</a></dd>";
                }
                else { $weblink= ""; }

                // modifyDate
                if (isset($template->modifyDate) && ($template->modifyDate !== "0000-00-00 00:00:00"))
                {   // set modifyDate
                    $modifyDate = "<dt>$lang[MODIFIED]</dt><dd>$template->modifyDate</dd>";
                }
                else { $modifyDate = ''; }

                // releaseDate
                if (isset($template->releaseDate) && ($template->releaseDate !== "0000-00-00 00:00:00"))
                {   // set release date
                    $releaseDate = "<dt>$lang[RELEASED]</dt><dd>$template->releaseDate</dd>";
                }
                else { $releaseDate = ''; }

                // description
                if (isset($template->description) && (!empty($template->description)))
                {   // set author
                    $description = "<dt>$lang[DESCRIPTION]</dt><dd>$template->description</dd>";
                }
                else { $description = ""; }

                // version
                if (isset($template->version) && (!empty($template->version)))
                {   // set author
                    $version = "<dt>$lang[VERSION]</dt><dd>$template->version</dd>";
                }
                else { $version = ""; }

                if (isset($template->subAuthorUrl) && (!empty($template->subAuthorUrl)))
                {   // set author's link
                    $subauthorurl = "<small>&nbsp;<a href=\"$template->subAuthorUrl\" target=\"_blank\" title=\"$lang[MODIFIED_BY_LINKDESC]\"
                                <i class=\"fa fa-external-link\"></i></a></small>";
                }
                else { $subauthorurl = ""; }

                // subAuthor
                if (isset($template->subAuthor) && (!empty($template->subAuthor)))
                {   // set subAuthor
                    $subauthor = "<dt>$lang[MODIFIED_BY]</dt><dd>$template->subAuthor&nbsp;$subauthorurl</dd>";
                }
                else { $subauthor = ""; }

                // subAuthor
                if (isset($template->license) && (!empty($template->license)))
                {   // set subAuthor
                    $license = "<dt>$lang[LICENSE]</dt><dd>$template->license</dd>";
                }
                else { $license = ""; }

                $settings = "<dt>$lang[SETTINGS]</dt>
                            <dd>".$template->countTemplateSettings($db, $template->id)."</dd>";

                ?>
                <dt><?php echo "$lang[TEMPLATE] $lang[NAME]"; ?></dt>
                <dd><b><?php echo $template->name; ?></b></dd>
                <dt><?php echo $lang['STATUS']; ?></dt>
                <dd><b><?php echo $infoBadge; ?></b></dd>

                <?php echo $description.$author.$weblink.$license.$version.$releaseDate.$settings."<br>".$subauthor.$modifyDate; ?>

                <dt>&nbsp;</dt>
                <dd>&nbsp;</dd>
                <dt><?php echo $lang['TOOLS']; ?></dt>
                <dd>
                    <b><?php echo $lang['YAWK_SLOGAN_TOGETHER']; ?><br>
                        <i class="fa fa-check text-light-blue"></i> YaWK 16.9 <small>
                        <a href="http://www.yawk.io/" target="_blank" title="Official YaWK Website [in new tab]">
                        <i class="fa fa-external-link"></i></a></small><br>

                        <i class="fa fa-check text-light-blue"></i> Boostrap 3.3.7<small>
                        <a href="http://www.getbootstrap.com/" target="_blank" title="Official Bootstrap Website [in new tab]">
                        <i class="fa fa-external-link"></i></a></small><br>

                        <i class="fa fa-check text-light-blue"></i> jQuery 1.11.3<small>
                        <a href="http://www.jquery.com/" target="_blank" title="Official jQuery Website [in new tab]">
                        <i class="fa fa-external-link"></i></a></small><br>

                        <i class="fa fa-check text-light-blue"></i> FontAwesome 4.6.3<small>
                        <a href="http://www.fontawesome.io/" target="_blank" title="Official FontAwesome Website [in new tab]">
                        <i class="fa fa-external-link"></i></a></small><br>

                        <i class="fa fa-check text-light-blue"></i> Animate CSS 3.5.2<small>
                        <a href="http://www.fontawesome.io/" target="_blank" title="Official FontAwesome Website [in new tab]">
                        <i class="fa fa-external-link"></i></a></small><br>
                </dd>
                <dt>&nbsp;</dt>
                <dd>&nbsp;</dd>
            </dl>
        </div>
    </div>
    <div class="col-md-6">

        <!-- website preview iframe
        <div class="embed-responsive embed-responsive-4by3">
            <iframe id="preview" class="embed-responsive-item" src="../index.php"></iframe>
        </div>
        -->

    </div>
</div>