<script type="text/javascript">
    $(document).ready(function() {
        var savebutton = ('#savebutton');
        var savebuttonIcon = ('#savebuttonIcon');
        // ok, lets go...
        // we need to check if user clicked on save button
        $(savebutton).click(function() {
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning disabled');
            $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
        });
    }); // end document ready
</script>

<?php
// new template object if not exists
if (!isset($template)) { $template = new \YAWK\template(); }
// new user object if not exists
if (!isset($user)) { $user = new \YAWK\user(); }
// $_GET['id'] or $_POST['id'] holds the template ID to edit.
// If any one of these two is set, we're in "preview mode" - this means:
// The user database holds two extra cols: overrideTemplate(int|0,1) and templateID
// Any user who is allowed to override the Template, can edit a template and view it
// in the frontend. -Without affecting the current active theme for any other user.
// This is pretty cool when working on a new design: because you see changes, while others wont.
// In theory, thereby every user can have a different frontend template activated.
?>

<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo \YAWK\backend::getTitle($lang['TPL'], $lang['SETTINGS']);
echo \YAWK\backend::getTemplateBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="template-edit-form" action="index.php?page=template-save&action=template-setup&id=<?php echo $template->id; ?>" method="POST">
    <!-- title header -->
    <!-- REDESIGN -->
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-gears\"></i> &nbsp;$lang[SETTINGS] <small>$lang[TPL_SETTINGS_SUBTEXT]</small></h4>"; ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success pull-right" id="savebutton" name="save" style="margin-top:2px;"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['DESIGN_SAVE']; ?></button>
            </div>
        </div>
    </div>
<!-- SETTINGS -->
<h3><?php echo "$lang[SETTINGS] <small>$lang[TPL_SETTINGS_SUBTEXT]</small>"; ?></h3>
<div class="row animated fadeIn">

    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Required Assets Include Configuration</h3>
            </div>
            <div class="box-body">
                <label for="include-bootstrap">Bootstrap JS</label>
                <select id="include-bootstrap" name="include-bootstrap" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/bootstrap)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js</option>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js">https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js</option>
                </select>
                <label for="include-bootstrap">Bootstrap CSS</label>
                <select id="include-bootstrap" name="include-bootstrap" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/bootstrap)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css</option>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css</option>
                </select>
                <label for="include-jquery">jQuery</label>
                <select id="include-jquery" name="include-jquery" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/jquery)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js</option>
                </select>
                <label for="include-jquery">jQuery UI</label>
                <select id="include-jquery" name="include-jquery" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/jquery)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Optional Assets Configuration</h3>
            </div>
            <div class="box-body">
                <label for="include-animate">Animate.css</label>
                <select id="include-animate" name="include-animate" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/animate)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css</option>
                    <option name="https://fastcdn.org/Animate.css/3.4.0/animate.min.css">https://fastcdn.org/Animate.css/3.4.0/animate.min.css</option>
                </select>
                <label for="include-fontawesome">Font Awesome Icons</label>
                <select id="include-fontawesome" name="include-fontawesome" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/fontawesome)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css</option>
                </select>
                <label for="include-lightbox2">Lightbox 2</label>
                <select id="include-lightbox2" name="include-lightbox2" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/lightbox)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/js/lightbox.min.js">https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/js/lightbox.min.js</option>
                </select>
                <label for="include-ekkolightbox">Ekko Lightbox</label>
                <select id="include-ekkolightbox" name="include-ekkolightbox" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/lightbox)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.js">https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.js</option>
                </select>
                <label for="include-bootstraplightbox">Bootstrap Lightbox</label>
                <select id="include-bootstraplightbox" name="include-bootstraplightbox" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/...)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.js">https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.js</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Inclusion Config</h3>
            </div>
            <div class="box-body">
                ...
            </div>
        </div>
    </div>
</div>

<div class="row animated fadeIn">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[SAVE_AS] <small>$lang[NEW_THEME]</small>"; ?></h3>
            </div>
            <div class="box-body">
                <label for="savetheme"><?php echo "$lang[SAVE_NEW_THEME_AS]"; ?></label>
                <input type="text" class="form-control" name="newthemename" value="<?php echo $template->name; ?>-copy" placeholder="<?php echo "$lang[NEW] $lang[TPL] $lang[NAME]"; ?>">
                <input type="text" class="form-control" name="description" placeholder="<?php echo "$lang[TPL] $lang[DESCRIPTION]"; ?>">
                <input type="text" class="form-control" name="positions" placeholder="<?php echo "$lang[POSITIONS] $lang[POS_DESCRIPTION]"; ?>">
                <br><input id="addbutton" type="submit" class="btn btn-danger" name="savenewtheme" value="<?php echo "$lang[SAVE_NEW_THEME_AS]"; ?>">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[TPL_ADD_GFONT] <small>$lang[TPL_ADD_GFONT_SUBTEXT]</small>"; ?></h3>
            </div>
            <div class="box-body">
                <input type="text" class="form-control" id="gfont" name="gfont" placeholder="font eg. Ubuntu">
                <input type="text" class="form-control" name="gfontdescription" placeholder="description eg. Ubuntu, serif">
                <br><input id="savebutton" type="submit" class="btn btn-danger" name="addgfont" value="<?php echo "$lang[TPL_ADD_GFONT_BTN]"; ?>">
            </div>
        </div>
    </div>
</div>