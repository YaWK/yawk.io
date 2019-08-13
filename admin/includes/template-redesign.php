<!-- color picker -->
<script type="text/javascript" src="../system/engines/jquery/jscolor/jscolor.js"></script>
<!-- TAB collapse -->
<script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
<!-- Javascript for positions tab -->
<script type="text/javascript">
    /* reminder: check if form has changed and warns the user that he needs to save. */
    $(document).ready(function () {

        // re-init js color to fix dynamic loading
        jscolor.init();

        // TRY TO DISABLE CTRL-S browser hotkey
        function saveHotkey() {
            // simply disables save event for chrome
            $(window).keypress(function (event) {
                if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which == 19)) return true;
                event.preventDefault();
                formmodified=0; // do not warn user, just save.
                return false;
            });
            // used to process the cmd+s and ctrl+s events
            $(document).keydown(function (event) {
                if (event.which === 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                    event.preventDefault();
                    $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                    formmodified=0; // do not warn user, just save.
                    // save(event);
                    return false;
                }
            });
        }
        saveHotkey();

        formmodified=0; // status
        $('form *').change(function(){ // if form has changed
            formmodified=1; // set status
            $('#savebutton').click(function(){ // if user clicked save
                formmodified=0; // do not warn user, just save.
            });
            $('#addbutton').click(function(){ // if user clicked add new theme
                formmodified=0; // do not warn user, just save the new theme.
            });
        });

        // now the function:
        window.onbeforeunload = confirmExit; // before close
        function confirmExit() {             // dialog
            if (formmodified === 1) {         // if form has changed
                return "<?php echo $lang['LEAVE_REQUEST']; ?>";
            }
        }
        $(function() {
            // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                // save the latest tab; use cookies if you like 'em better:
                localStorage.setItem('lastTab', $(this).attr('href'));
            });
            // go to the latest tab, if it exists:
            var lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
                // to work correctly, we need to lowercase
                var activeTab = lastTab.toLowerCase();
                // and remove the first char (#)
                var activeFolder = activeTab.slice(1);
                // all done: set select default selected option
                $('select option[value="'+activeFolder+'"]').prop('selected', true);
            }
        });

        // call tabCollapse: make the default bootstrap tabs responsive for handheld devices
        $('#tabs').tabCollapse({
            tabsClass: 'hidden-sm hidden-xs',
            accordionClass: 'visible-sm visible-xs'
        });

        $('[data-toggle="tooltip"]').tooltip();

    });
</script>

<?php
// new template object if not exists
if (!isset($template)) { $template = new \YAWK\template(); }
// new user object if not exists
if (!isset($user)) { $user = new \YAWK\user($db); }

// check, if a session is already running
if (!isset($_SESSION) || (empty($_SESSION)))
{   // if not...
    session_start();
    $_SESSION['template'] = $template;
}

// get ID of current active template
$selectedTemplateID = \YAWK\settings::getSetting($db, "selectedTemplate");
// load properties of current active template
$template->loadProperties($db, $selectedTemplateID);
// previewButton is an empty string - why? this should be checked
$previewButton = "";
// load all template settings into array
$templateSettings = \YAWK\template::getAllSettingsIntoArray($db, $user);
// get current bootstrap version
if (!$template->bootstrapVersion = $template->checkBootstrapVersion($db, $template->id, $lang))
{
    \YAWK\alert::draw("danger", $lang['ERROR'], $lang['FRAMEWORK_FALSE'], "", 0);
}
else if($template->bootstrapVersion == "X")
{
    \YAWK\alert::draw("danger", $lang['ERROR'], $lang['FRAMEWORK_MULTIPLE_FALSE'], "", 0);
}
?>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo \YAWK\backend::getTitle($lang['TPL'], $lang['DESIGN']);
echo \YAWK\backend::getTemplateBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="template-edit-form" action="index.php?page=template-save&action=template-redesign&id=<?php echo $template->id; ?>" method="POST">
<!-- title header -->
    <!-- REDESIGN -->
<div class="box">
    <div class="box-body">
        <div class="col-md-10">
            <?php echo "<h4><i class=\"fa fa-paint-brush\"></i> &nbsp;$lang[DESIGN]  <small>$lang[DESIGN_DETAILS]</small></h4>"; ?>
        </div>
        <div class="col-md-2">
            <button class="btn btn-success pull-right" id="savebutton" name="save" style="margin-top:2px;"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['DESIGN_SAVE']; ?></button>
        </div>
    </div>
</div>

<div class="box">
    <div class="box-body">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="undertabs">

            <?php
            if ($template->bootstrapVersion == "3")
            {
                echo "
            <li>
                <a href=\"#menu\" aria-controls=\"menu\" data-toggle=\"tab\"><i class=\"fa fa-bars\"></i>
                    &nbsp; $lang[MENU]</a>
            </li>
            <li>
                <a href=\"#bootstrap\" aria-controls=\"bootstrap\" data-toggle=\"tab\"><i class=\"fa fa-sticky-note-o\"></i>
                    &nbsp; $lang[BOOTSTRAP3]</a>
            </li>
            <li>
                <a href=\"#buttons\" aria-controls=\"buttons\" role=\"tab\" data-toggle=\"tab\"><i class=\"fa fa-toggle-on\"></i>
                    &nbsp; $lang[FORMS]</a>
            </li>
            <li>
                <a href=\"#images\" aria-controls=\"images\" role=\"tab\" data-toggle=\"tab\"><i class=\"fa fa-picture-o\"></i>
                    &nbsp; $lang[IMAGES]</a>
            </li>";
            }
            elseif ($template->bootstrapVersion == "4")
            {
                echo
                "<li>
                    <a href=\"#bs4-cards\" aria-controls=\"bs4-cards\" data-toggle=\"tab\"><i class=\"fa fa-bars\"></i>
                        &nbsp; $lang[CARDS]</a>
                </li>
                <li>
                    <a href=\"#images\" aria-controls=\"images\" role=\"tab\" data-toggle=\"tab\"><i class=\"fa fa-picture-o\"></i>
                        &nbsp; $lang[IMAGES]</a>
                </li>
                <li>
                    <a href=\"#buttons\" aria-controls=\"buttons\" role=\"tab\" data-toggle=\"tab\"><i class=\"fa fa-toggle-on\"></i>
                        &nbsp; $lang[FORMS]</a>
                </li>";
            }
            ?>
            
        </ul>


<!-- bootstrap -->
<div class="tab-content">

    <?php
    if ($template->bootstrapVersion == "3")
    {
        echo "
    <div class=\"tab-pane active fade in\" id=\"menu\">
    <h3>$lang[GLOBAL_MENU] <small>$lang[NAVBAR]</small></h3>
    <div class=\"row animated fadeIn\">
        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[MENU] $lang[FONT] <small>$lang[COLORS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- menu font colors -menucolor -->";
                    $template->getFormElements($db, $templateSettings, 10, $lang, $user);
                echo "</div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[MENU] $lang[BG] <small>$lang[COLORS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- menu background color -menubgcolor -->";
                    $template->getFormElements($db, $templateSettings, 11, $lang, $user);
                echo "</div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[MENU] $lang[DROPDOWN] <small>$lang[COLORS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- menu background color -menudropdowncolor -->";
                    $template->getFormElements($db, $templateSettings, 12, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[MENU] $lang[NAVBAR] <small>$lang[POSITIONING]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- menu navbar margin top -navbar-marginTop -->";
                    $template->getFormElements($db, $templateSettings, 13, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
    </div>
</div>

<!-- WELL,LISTGROUP, JUMBOTRON -->
<div class=\"tab-pane fade in\" id=\"bootstrap\">
    <h3>$lang[BOOTSTRAP3] <small>$lang[SETTINGS]</small></h3>
    <div class=\"row animated fadeIn\">
        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[WELL] $lang[BOX] <small>$lang[DESIGN]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- well box design  well- -->";
                    $template->getFormElements($db, $templateSettings, 14, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[LIST_GROUP] <small>$lang[DESIGN]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- listgroup design  listgroup-  -->";
                    $template->getFormElements($db, $templateSettings, 15, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[JUMBOTRON] <small>$lang[BOX] $lang[DESIGN]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- jumbotron design  jumbotron-  -->";
                    $template->getFormElements($db, $templateSettings, 16, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">... <small>...</small></h3>
                </div>
                <div class=\"box-body\">
                     
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BUTTONS -->
<div class=\"tab-pane fade in\" id=\"buttons\">
    <h3>$lang[FORMS] <small>$lang[AND] $lang[BUTTONS] </small></h3>
    <div class=\"row animated fadeIn\">

        <div class=\"col-md-4\">
            <!-- btn basic settings -->
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[BUTTON] <small>$lang[FONT] $lang[AND] $lang[BORDER] $lang[SETTINGS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn settings    btn-   -->";
                    $template->getFormElements($db, $templateSettings, 17, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-4\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[FORM] <small>$lang[SETTINGS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- form settings    form-   -->";
                    $template->getFormElements($db, $templateSettings, 25, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-4\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[FORM] <small>$lang[SETTINGS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- form settings    form-   -->";
                    $template->getFormElements($db, $templateSettings, 51, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
    </div>

    <div class=\"row animated fadeIn\">
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Default <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn default    btn-default   -->";
                    $template->getFormElements($db, $templateSettings, 18, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Primary <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn primary    btn-primary   -->";
                    $template->getFormElements($db, $templateSettings, 19, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Success <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn success   btn-success   -->";
                    $template->getFormElements($db, $templateSettings, 20, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Warning <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn warning   btn-warning   -->";
                    $template->getFormElements($db, $templateSettings, 21, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Danger <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn danger   btn-danger   -->";
                    $template->getFormElements($db, $templateSettings, 22, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Info <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn info   btn-info   -->";
                    $template->getFormElements($db, $templateSettings, 23, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
    </div>
</div>

<!-- IMAGES -->
<div class=\"tab-pane fade in\" id=\"images\">
    <h3>$lang[IMAGE] <small>$lang[SETTINGS]</small></h3>
    <div class=\"row animated fadeIn\">
        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[IMAGE] <small>$lang[EFFECTS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- image settings   img-   -->";
                    $template->getFormElements($db, $templateSettings, 24, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Any other thing <small>here...</small></h3>
                </div>
                <div class=\"box-body\">
                    
                </div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Any other thing <small>here...</small></h3>
                </div>
                <div class=\"box-body\">
                    
                </div>
            </div>
        </div>
    </div>
</div>";
    }
    else if ($template->bootstrapVersion == "4")
    {

        echo"<!-- IMAGES -->
<div class=\"tab-pane fade in\" id=\"images\">
    <h3>$lang[IMAGE] <small>$lang[SETTINGS]</small></h3>
    <div class=\"row animated fadeIn\">
        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[IMAGE] <small>$lang[EFFECTS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- image settings   img-   -->";
                    $template->getFormElements($db, $templateSettings, 24, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[JUMBOTRON] <small>$lang[SETTINGS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- jumbotron settings bs4 -->";
                    $template->getFormElements($db, $templateSettings, 16, $lang, $user);
                echo"</div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[LIST_GROUP] <small>$lang[SETTINGS]</small></h3>
                </div>
                <div class=\"box-body\">";
                    $template->getFormElements($db, $templateSettings, 15, $lang, $user);
                echo"</div>
            </div>
        </div>
    </div>
</div>";
        
       echo "<!-- CARDS TAB -->
<div class=\"tab-pane fade in\" id=\"bs4-cards\">
    <h3>$lang[BOOTSTRAP4] <small>$lang[CARDS]</small></h3>
    <div class=\"row animated fadeIn\">
        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[CARDS] <small>$lang[BODY]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- card body -->";
                    $template->getFormElements($db, $templateSettings, 60, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[CARDS] <small>$lang[HEADER]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- card header -->";
                    $template->getFormElements($db, $templateSettings, 59, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[CARDS] <small>$lang[FOOTER]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- card footer -->";
                    $template->getFormElements($db, $templateSettings, 61, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-3\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[CARDS] <small>$lang[SETTINGS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- card link settings -->";
                    $template->getFormElements($db, $templateSettings, 58, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
    </div>
</div>";


echo"<!-- BUTTONS -->
<div class=\"tab-pane fade in\" id=\"buttons\">
    <h3>$lang[FORMS] <small>$lang[AND] $lang[BUTTONS] </small></h3>
    <div class=\"row animated fadeIn\">

        <div class=\"col-md-4\">
            <!-- btn basic settings -->
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[BUTTON] <small>$lang[FONT] $lang[AND] $lang[BORDER] $lang[SETTINGS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn settings    btn-   -->";
                    $template->getFormElements($db, $templateSettings, 17, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-4\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[FORM] <small>$lang[SETTINGS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- form settings    form-   -->";
                    $template->getFormElements($db, $templateSettings, 25, $lang, $user);
                    echo "
                </div>
            </div>
        </div>

        <div class=\"col-md-4\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">$lang[FORM] <small>$lang[SETTINGS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- form settings    form-   -->";
                    $template->getFormElements($db, $templateSettings, 51, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
    </div>

    <div class=\"row animated fadeIn\">
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Default <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn default    btn-default   -->";
                    $template->getFormElements($db, $templateSettings, 18, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Primary <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn primary    btn-primary   -->";
                    $template->getFormElements($db, $templateSettings, 19, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Success <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn success   btn-success   -->";
                    $template->getFormElements($db, $templateSettings, 20, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Warning <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn warning   btn-warning   -->";
                    $template->getFormElements($db, $templateSettings, 21, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Danger <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn danger   btn-danger   -->";
                    $template->getFormElements($db, $templateSettings, 22, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
        <div class=\"col-md-2\">
            <div class=\"box box-default\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">Info <small>Button</small></h3>
                </div>
                <div class=\"box-body\">
                    <!-- btn info   btn-info   -->";
                    $template->getFormElements($db, $templateSettings, 23, $lang, $user);
                    echo "
                </div>
            </div>
        </div>
    </div>
</div>";
    }
    ?>

</div>


    </div>
</div>
</form>