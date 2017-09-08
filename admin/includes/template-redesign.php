<!-- color picker -->
<script type="text/javascript" src="../system/engines/jquery/jscolor/jscolor.js"></script>
<!-- TAB collapse -->
<script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
<!-- CSS for positions tab -->
<style>
    .posbox
    {
        /* background-color: #fff; */
        font-weight:normal;
        border-style: dotted; border-color: #ccc;
        cursor:pointer;
    }

    .posbox:hover
    {
        border: dotted #888888;
        font-weight: bold;
        cursor:pointer;
    }
    .posboxActive
    {
        background-color: #E3E3E3;
        border: 2px solid #888888;
        font-weight: bold;
        cursor:pointer;
    }
    .bodyBox
    {
        /* background-color: #fff; */
        font-weight:normal;
        border: 1px solid #444;
        cursor:pointer;
    }
    .bodyBoxHover:hover
    {
        font-weight:bold;
    }

    .bodyBox:hover
    {
        cursor:pointer;
    }
    .bodyBoxActive
    {
        /* background-color: #E3E3E3; */
        border: 2px solid #888888;
        /* font-weight: bold; */
        cursor:pointer;
    }
</style>
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
                if (!(event.which == 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which == 19)) return true;
                event.preventDefault();
                formmodified=0; // do not warn user, just save.
                return false;
            });
            // used to process the cmd+s and ctrl+s events
            $(document).keydown(function (event) {
                if (event.which == 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
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
            if (formmodified == 1) {         // if form has changed
                return "<?php echo $lang['LEAVE_REQUEST']; ?>";
            }
        }
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
if (!isset($user)) { $user = new \YAWK\user(); }

// check, if a session is already running
if (!isset($_SESSION) || (empty($_SESSION)))
{   // if not...
    session_start();
    $_SESSION['template'] = $template;
}

// get ID of current active template
$getID = \YAWK\settings::getSetting($db, "selectedTemplate");
// load properties of current active template
$template->loadProperties($db, $getID);
// previewButton is an empty string - why? this should be checked
$previewButton = "";

// load all template settings into array
$templateSettings = \YAWK\template::getAllSettingsIntoArray($db, $user);

// check template wrapper
\YAWK\template::checkWrapper($lang, $lang['POSITIONS'], $lang['POSITIONS']);
?>

<form id="template-edit-form" action="index.php?page=template&action=template-redesign&id=<?php echo $template->id; ?>" method="POST">
    <!-- REDESIGN -->
    <div class="row animated fadeIn">
        <div class="col-md-6">
            <h3><?php echo "$lang[DESIGN]"; ?> <small><?php echo "$lang[DESIGN_DETAILS]"; ?></small></h3>
        </div>
        <div class="col-md-6 text-right">
            <button type="submit" id="savebutton" name="save" class="btn btn-success" style="margin-top:10px;">
                <i id="savebuttonIcon" class="fa fa-check"></i> &nbsp;<?php print $lang['DESIGN_SAVE']; ?>
            </button>
        </div>
    </div>

<!-- list POSITION SETTINGS -->
<!-- MENU -->
<!-- Nav tabs -->
<ul class="nav nav-tabs" id="undertabs">
    <li class="active">
        <a href="#fonts" aria-controls="fonts" data-toggle="tab"><i class="fa fa-font"></i>
        &nbsp; <?php echo $lang['TYPOGRAPHY']; ?></a>
    </li>

    <li>
        <a href="#menu" aria-controls="menu" data-toggle="tab"><i class="fa fa-bars"></i>
        &nbsp; <?php echo $lang['MENU']; ?></a>
    </li>
    <li>
        <a href="#bootstrap" aria-controls="bootstrap" data-toggle="tab"><i class="fa fa-sticky-note-o"></i>
        &nbsp; <?php echo $lang['BOOTSTRAP3']; ?></a>
    </li>
    <li>
        <a href="#buttons" aria-controls="buttons" role="tab" data-toggle="tab"><i class="fa fa-toggle-on"></i>
        &nbsp; <?php echo $lang['FORMS']; ?></a>
    </li>
    <li>
        <a href="#images" aria-controls="images" role="tab" data-toggle="tab"><i class="fa fa-picture-o"></i>
        &nbsp; <?php echo $lang['IMAGES']; ?></a>
    </li>
    <!-- effects - disabled for now
        <li role="presentation">
            <a href="#effects" aria-controls="effects" role="tab" data-toggle="tab"><i class="fa fa-paper-plane-o"></i>
                &nbsp; <?php // echo $lang['EFFECTS']; ?></a>
        </li>
        -->
</ul>
<!-- FONTS -->
<div class="tab-content">
<div class="tab-pane fade in active" id="fonts">
    <h3><?php echo "$lang[FONTS_TYPES] <small>$lang[TPL_FONTS_SUBTEXT]"; ?></small></h3>
    <div class="row">
        <div class="col-md-6">

            <label for="testText"><?php echo $lang['TPL_FORM_TESTFIELD']; ?></label>
            <div class="input-group">
                <!-- <div class="input-group-addon" id="switchPreview" style="cursor: pointer;"><i class="fa fa-link" title="switch preview"></i></div> -->
                <input id="testText" name="testText" placeholder="<?php echo $lang['TPL_FORM_TESTFIELD_PLACEHOLDER']; ?>" maxlength="84" class="form-control">
                <span class="input-group-btn">
                        <button type="button" disabled id="resetTestText" class="btn btn-default" title="<?php echo $lang['RESET']; ?>"><i class="fa fa-refresh"></i></button>
                        </span>
            </div>
            <!-- common text settings (size, shadow, color...) -->
            <?php // $template->getFormElements($db, $templateSettings, 2, $lang, $user); ?>
            <?php // $template->getFormElements($db, $templateSettings, 3, $lang, $user); ?>
        </div>
        <div class="col-md-6">
            <!-- DEMO - can be deleted...
            <label for="pAlign">< p > Text Align Settings</label>
            <select class="form-control" name="pAlign" id="pAlign">
                <option value="left">left</option>
                <option value="center">center</option>
                <option value="right">right</option>
                <option value="justify">justify</option>
            </select>
            <label for="hAlign">< h1-h6 > Text Align Settings</label>
            <select class="form-control" name="hAlign" id="hAlign">
                <option value="left">left</option>
                <option value="center">center</option>
                <option value="right">right</option>
                <option value="justify">justify</option>
            </select>
            -->
        </div>
    </div>
    <hr>
    <div class="row animated fadeIn">
        <?php
        $template->getFontRow($db, $lang, "h1", "h1", $templateSettings);
        $template->getFontRow($db, $lang, "h2", "h2", $templateSettings);
        $template->getFontRow($db, $lang, "h3", "h3", $templateSettings);
        $template->getFontRow($db, $lang, "h4", "h4", $templateSettings);
        $template->getFontRow($db, $lang, "h5", "h5", $templateSettings);
        $template->getFontRow($db, $lang, "h6", "h6", $templateSettings);
        ?>
    </div>
    <hr>
    <div class="row">
        <?php
        $template->getFontRow($db, $lang, "globaltext", "globaltext", $templateSettings);
        // $template->getFontRow($db, $lang, "menufont", "menufont", $templateSettings);
        ?>
    </div>

    <script>
        $(document).ready(function () {

            // TODO: THIS IS WAAAAYYYY NOT READY...!!
            // switch preview from text to link
            /*
             $("#switchPreview").click(function() {
             // alert('you flipped the switch!');
             $("#h1-preview").replaceWith( "<div class=\"h1\" id=\"h1-preview\"><a href=\"#\">H1 Heading (link)</div>");
             // $("#h1-preview").css("text-decoration", "underline");
             });
             */
            // call set default values and preview font function
            previewFont($("#h1-fontfamily"), 'H1 Heading', 'h1-preview', $("#h1-preview"), $("#h1-size"), $("#h1-fontcolor"), $("#h1-fontshadowsize"), $("#h1-fontshadowcolor"), $("#h1-fontweight"), $("#h1-fontstyle"), $("#h1-textdecoration"));
            previewFont($("#h2-fontfamily"), 'H2 Heading', 'h2-preview', $("#h2-preview"), $("#h2-size"), $("#h2-fontcolor"), $("#h2-fontshadowsize"), $("#h2-fontshadowcolor"), $("#h2-fontweight"), $("#h2-fontstyle"), $("#h2-textdecoration"));
            previewFont($("#h3-fontfamily"), 'H3 Heading', 'h3-preview', $("#h3-preview"), $("#h3-size"), $("#h3-fontcolor"), $("#h3-fontshadowsize"), $("#h3-fontshadowcolor"), $("#h3-fontweight"), $("#h3-fontstyle"), $("#h3-textdecoration"));
            previewFont($("#h4-fontfamily"), 'H4 Heading', 'h4-preview', $("#h4-preview"), $("#h4-size"), $("#h4-fontcolor"), $("#h4-fontshadowsize"), $("#h4-fontshadowcolor"), $("#h4-fontweight"), $("#h4-fontstyle"), $("#h4-textdecoration"));
            previewFont($("#h5-fontfamily"), 'H5 Heading', 'h5-preview', $("#h5-preview"), $("#h5-size"), $("#h5-fontcolor"), $("#h5-fontshadowsize"), $("#h5-fontshadowcolor"), $("#h5-fontweight"), $("#h5-fontstyle"), $("#h5-textdecoration"));
            previewFont($("#h6-fontfamily"), 'H6 Heading', 'h6-preview', $("#h6-preview"), $("#h6-size"), $("#h6-fontcolor"), $("#h6-fontshadowsize"), $("#h6-fontshadowcolor"), $("#h6-fontweight"), $("#h6-fontstyle"), $("#h6-textdecoration"));
            previewFont($("#globaltext-fontfamily"), 'Default Text', 'globaltext-preview', $("#globaltext-preview"), $("#globaltext-size"), $("#globaltext-fontcolor"), $("#globaltext-fontshadowsize"), $("#globaltext-fontshadowcolor"), $("#globaltext-fontweight"), $("#globaltext-fontstyle"), $("#globaltext-textdecoration"));

            /*
             * obj font-family select field
             * string heading
             * string preview field as string
             * obj h1-preview
             * obj h1-size
             * obj h1-color
             * obj h1-fontshadowsize
             * obj h1-fontshadowcolor
             */
            function previewFont(font, heading, previewString, previewField, fontsize, fontcolor, fontshadowsize, fontshadowcolor, fontweight, fontstyle, textdecoration)
            {
                // what to do if click on reset text button
                $("#resetTestText").click(function()
                {   // reset preview: set default value
                    $(previewField).html(heading);
                    // empty the input field also
                    $("#testText").val('');
                    // and disable button
                    $('#resetTestText').prop('disabled', true); // enable reset btn if key up on testText field
                });

                // if test text changes due input via keyup
                $('#testText').keyup(function(){
                    // enable reset text button
                    $('#resetTestText').prop('disabled', false);
                    // update text preview with values from testText field
                    $(previewField).html($(this).val());
                });

                // LOAD DEFAULT (CURRENT) PREVIEW
                // SET DEFAULT VALUES
                var selectedFont = $(font).val();
                var pathAndFont = '../system/fonts/'+selectedFont;

                // check if font is a custom font (from system/fonts)
                // check if fontfamily contains the string ttf
                if ($(font).val().toLowerCase().indexOf("-ttf") >= 0)
                {
                    // workaround: remove the last 4 chars (-ttf)
                    var fn = pathAndFont.slice(0,-4);
                    // workaround: add file extension
                    fn += '.ttf';

                    // append external font to head
                    $("head").append("<style type=\"text/css\">" +
                        "@font-face {\n" +
                        "\tfont-family: '"+selectedFont+"';\n" +
                        "\tsrc: url("+fn+");\n" +
                        "}\n" +
                        "\t."+previewString+" {\n" +
                        "\tfont-family: '"+selectedFont+"' !important;\n" +
                        "}\n" +
                        "</style>");
                    // set preview to selected true type font
                    $(previewField).css("font-family", selectedFont);
                }
                // check if fontfamily contains the string otf
                else if ($(font).val().toLowerCase().indexOf("-otf") >= 0)
                {
                    // workaround: remove the last 4 chars (-otf)
                    fn = pathAndFont.slice(0,-4);
                    // workaround: add file extension
                    fn += '.otf';

                    // append external font to head
                    $("head").append("<style type=\"text/css\">" +
                        "@font-face {\n" +
                        "\tfont-family: '"+selectedFont+"';\n" +
                        "\tsrc: url("+fn+");\n" +
                        "}\n" +
                        "\t."+previewString+" {\n" +
                        "\tfont-family: '"+selectedFont+"' !important;\n" +
                        "}\n" +
                        "</style>");
                    // set preview to selected true type font
                    $(previewField).css("font-family", selectedFont);
                }
                // check if fontfamily contains the string otf
                else if ($(font).val().toLowerCase().indexOf("-woff") >= 0)
                {
                    // workaround: remove the last 5 chars (-woff)
                    fn = pathAndFont.slice(0,-5);
                    // workaround: add file extension
                    fn += '.woff';

                    // append external font to head
                    $("head").append("<style type=\"text/css\">" +
                        "@font-face {\n" +
                        "\tfont-family: '"+selectedFont+"';\n" +
                        "\tsrc: url("+fn+");\n" +
                        "}\n" +
                        "\t."+previewString+" {\n" +
                        "\tfont-family: '"+selectedFont+"' !important;\n" +
                        "}\n" +
                        "</style>");
                    // set preview to selected true type font
                    $(previewField).css("font-family", selectedFont);
                }
                // check if fontfamily contains the string -gfon
                else if ($(font).val().toLowerCase().indexOf("-gfont") >= 0)
                {
                    // workaround: remove the last 6 chars (-gfont)
                    fn = selectedFont.slice(0,-6);

                    var HtmlDocumentHead = $("head");
                    // append google font include to head
                    HtmlDocumentHead.append("<link href=\"https://fonts.googleapis.com/css?family="+fn+"\" rel=\"stylesheet\">");
                    // append external font to head
                    HtmlDocumentHead.append("<style type=\"text/css\">" +
                        "\t."+previewString+" {\n" +
                        "\tfont-family: '"+fn+"';\n" +
                        "}\n" +
                        "</style>");
                    // set preview to selected true type font
                    $(previewField).css("font-family", fn);
                }
                else
                {    //alert('no ttf');
                    $(previewField).css("font-family", $(font).val());
                }
                $(previewField).css("font-size", $(fontsize).val());
                $(previewField).css("color", '#'+$(fontcolor).val());
                $(previewField).css("text-shadow", $(fontshadowsize).val()+' #'+$(fontshadowcolor).val());
                $(previewField).css("font-weight", $(fontweight).val());
                $(previewField).css("font-style", $(fontstyle).val());
                $(previewField).css("text-decoration", $(textdecoration).val());

                // SET SELECTED FONT STYLES ON CHANGE...
                // check if a font is selected, on change of select field...
                $(font).change(function()
                {
                    var selectedFont = $(font).val();
                    var pathAndFont = '../system/fonts/'+selectedFont;
                    var fn = '';

                    // check if font is a custom font (from system/fonts)
                    // check if fontfamily contains the string ttf
                    if ($(font).val().toLowerCase().indexOf("-ttf") >= 0)
                    {
                        // workaround: remove the last 4 chars (-ttf)
                        fn = pathAndFont.slice(0,-4);
                        // workaround: add file extension
                        fn += '.ttf';

                        // append external font to head
                        $("head").append("<style type=\"text/css\">" +
                            "@font-face {\n" +
                            "\tfont-family: '"+selectedFont+"';\n" +
                            "\tsrc: url("+fn+");\n" +
                            "}\n" +
                            "\t."+previewString+" {\n" +
                            "\tfont-family: '"+selectedFont+"' !important;\n" +
                            "}\n" +
                            "</style>");
                        // set preview to selected true type font
                        $(previewField).css("font-family", selectedFont);
                    }
                    // check if fontfamily contains the string otf
                    else if ($(font).val().toLowerCase().indexOf("-otf") >= 0)
                    {
                        // workaround: remove the last 4 chars (-otf)
                        fn = pathAndFont.slice(0,-4);
                        // workaround: add file extension
                        fn += '.otf';

                        // append external font to head
                        $("head").append("<style type=\"text/css\">" +
                            "@font-face {\n" +
                            "\tfont-family: '"+selectedFont+"';\n" +
                            "\tsrc: url("+fn+");\n" +
                            "}\n" +
                            "\t."+previewString+" {\n" +
                            "\tfont-family: '"+selectedFont+"' !important;\n" +
                            "}\n" +
                            "</style>");
                        // set preview to selected true type font
                        $(previewField).css("font-family", selectedFont);
                    }
                    // check if fontfamily contains the string otf
                    else if ($(font).val().toLowerCase().indexOf("-woff") >= 0)
                    {
                        // workaround: remove the last 5 chars (-otf)
                        fn = pathAndFont.slice(0,-5);
                        // workaround: add file extension
                        fn += '.woff';

                        // append external font to head
                        $("head").append("<style type=\"text/css\">" +
                            "@font-face {\n" +
                            "\tfont-family: '"+selectedFont+"';\n" +
                            "\tsrc: url("+fn+");\n" +
                            "}\n" +
                            "\t."+previewString+" {\n" +
                            "\tfont-family: '"+selectedFont+"' !important;\n" +
                            "}\n" +
                            "</style>");
                        // set preview to selected true type font
                        $(previewField).css("font-family", selectedFont);
                    }
                    // check if fontfamily contains the string -gfon
                    else if ($(font).val().toLowerCase().indexOf("-gfont") >= 0)
                    {
                        // workaround: remove the last 5 chars (-gfon)
                        fn = selectedFont.slice(0,-6);
                        googlePath = "https://fonts.googleapis.com/css?family="+fn;

                        var HtmlDocumentHead = $("head");
                        // append google font include to head
                        HtmlDocumentHead.append("<link href=\"https://fonts.googleapis.com/css?family="+fn+"\" rel=\"stylesheet\">");
                        // append external font to head
                        HtmlDocumentHead.append("<style type=\"text/css\">" +
                            "\t."+previewString+" {\n" +
                            "\tfont-family: '"+fn+"';\n" +
                            "}\n" +
                            "</style>");
                        // set preview to selected true type font
                        $(previewField).css("font-family", fn);
                    }
                    else
                    {    //alert('no ttf');
                        $(previewField).css("font-family", $(font).val());
                    }
                });

                // do the rest of the font preview stuff: size, colors, shadow...
                // switch font size
                $(fontsize).keyup(function() {
                    $(previewField).css("font-size", $(fontsize).val());
                });
                // switch font color
                $(fontcolor).change(function() {
                    $(previewField).css("color", '#'+$(fontcolor).val());
                });
                // switch shadow size
                $(fontshadowsize).keyup(function() {
                    $(previewField).css("text-shadow", $(fontshadowsize).val()+' #'+$(fontshadowcolor).val());
                });
                // switch shadow color
                $(fontshadowcolor).change(function() {
                    $(previewField).css("text-shadow", $(fontshadowsize).val()+' #'+$(fontshadowcolor).val());
                });
                // switch font weight
                $(fontweight).change(function() {
                    $(previewField).css("font-weight", $(fontweight).val());
                });
                // switch font style
                $(fontstyle).change(function() {
                    $(previewField).css("font-style", $(fontstyle).val());

                });
                // switch text decoration
                $(textdecoration).change(function() {
                    $(previewField).css("text-decoration", $(textdecoration).val());

                });
            }

        });
    </script>
    </div>
<div class="tab-pane fade in" id="menu">
    <h3><?php echo "$lang[GLOBAL_MENU] <small>$lang[NAVBAR]"; ?></small></h3>
    <div class="row animated fadeIn">
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[MENU] $lang[FONT] <small>$lang[COLORS]"; ?></small></h3>
                </div>
                <div class="box-body">
                    <!-- menu font colors -menucolor -->
                    <?php $template->getFormElements($db, $templateSettings, 10, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[MENU] $lang[BG] <small>$lang[COLORS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- menu background color -menubgcolor -->
                    <?php $template->getFormElements($db, $templateSettings, 11, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[MENU] $lang[DROPDOWN] <small>$lang[COLORS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- menu background color -menudropdowncolor -->
                    <?php $template->getFormElements($db, $templateSettings, 12, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[MENU] $lang[NAVBAR] <small>$lang[POSITIONING]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- menu navbar margin top -navbar-marginTop -->
                    <?php $template->getFormElements($db, $templateSettings, 13, $lang, $user); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- WELL,LISTGROUP, JUMBOTRON -->
<div class="tab-pane fade in" id="bootstrap">
    <h3><?php echo "$lang[BOOTSTRAP3] <small>$lang[SETTINGS]</small>"; ?></h3>
    <div class="row animated fadeIn">
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[WELL] $lang[BOX] <small>$lang[DESIGN]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- well box design  well- -->
                    <?php $template->getFormElements($db, $templateSettings, 14, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[LIST_GROUP] <small>$lang[DESIGN]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- listgroup design  listgroup-  -->
                    <?php $template->getFormElements($db, $templateSettings, 15, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[JUMBOTRON] <small>$lang[BOX] $lang[DESIGN]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- jumbotron design  jumbotron-  -->
                    <?php $template->getFormElements($db, $templateSettings, 16, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">... <small>...</small></h3>
                </div>
                <div class="box-body">
                    <?php // $template->getSetting($db, "%-menudropdowncolor", "", ""); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BUTTONS -->
<div class="tab-pane fade in" id="buttons">
    <h3><?php echo "$lang[FORMS] <small>$lang[AND] $lang[BUTTONS] </small>"; ?></h3>
    <div class="row animated fadeIn">

        <div class="col-md-4">
            <!-- btn basic settings -->
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[BUTTON] <small>$lang[FONT] $lang[AND] $lang[BORDER] $lang[SETTINGS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- btn settings    btn-   -->
                    <?php $template->getFormElements($db, $templateSettings, 17, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[FORM] <small>$lang[SETTINGS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- form settings    form-   -->
                    <?php $template->getFormElements($db, $templateSettings, 25, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[FORM] <small>$lang[SETTINGS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- form settings    form-   -->
                    <?php $template->getFormElements($db, $templateSettings, 51, $lang, $user); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row animated fadeIn">
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Default <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn default    btn-default   -->
                    <?php $template->getFormElements($db, $templateSettings, 18, $lang, $user); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Primary <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn primary    btn-primary   -->
                    <?php $template->getFormElements($db, $templateSettings, 19, $lang, $user); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Success <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn success   btn-success   -->
                    <?php $template->getFormElements($db, $templateSettings, 20, $lang, $user); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Warning <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn warning   btn-warning   -->
                    <?php $template->getFormElements($db, $templateSettings, 21, $lang, $user); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Danger <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn danger   btn-danger   -->
                    <?php $template->getFormElements($db, $templateSettings, 22, $lang, $user); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Info <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn info   btn-info   -->
                    <?php $template->getFormElements($db, $templateSettings, 23, $lang, $user); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- IMAGES -->
<div class="tab-pane fade in" id="images">
    <h3><?php echo "$lang[IMAGE] <small>$lang[SETTINGS]</small>"; ?></h3>
    <div class="row animated fadeIn">
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[IMAGE] <small>$lang[EFFECTS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- image settings   img-   -->
                    <?php $template->getFormElements($db, $templateSettings, 24, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Any other thing <small>here...</small></h3>
                </div>
                <div class="box-body">
                    <?php // $template->getSetting($db, "%-menubgcolor", "", ""); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Any other thing <small>here...</small></h3>
                </div>
                <div class="box-body">
                    <?php // $template->getSetting($db, "%-menudropdowncolor", "", ""); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</form>