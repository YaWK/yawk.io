<?php
// FONT ACTIONS.....
// upload folder
$fontFolder = "../system/fonts/";
if (isset($_GET) && (!empty($_GET)))
{   // user wants upload a custom font (ttf, otf or woff)
    if ($_GET['add'] === "true")
    {   // check if data is here
        if (isset($_POST) && (!empty($_POST)))
        {   // check if new font file was sent
            if (isset($_FILES['fontFile']) && (!empty($_FILES['fontFile'])))
            {   // allowed file extensions
                $exts = array('ttf', 'otf', 'woff');
                // file type seems to be ok
                if(in_array(end(explode('.', $_FILES['fontFile']['name'])), $exts))
                {
                    // folder and file to upload
                    $uploadFile = $fontFolder . basename($_FILES['fontFile']['name']);

                    // check if directory is existent and writeable
                    if (is_dir($fontFolder) && is_writable($fontFolder))
                    {
                        // copy file to font folder
                        if (move_uploaded_file($_FILES['fontFile']['tmp_name'], $uploadFile))
                        {   // upload ok, throw success msg
                            \YAWK\alert::draw("success", $lang['SUCCESS'], "$lang[UPLOAD_SUCCESSFUL]: $uploadFile", "", 1800);
                        }
                        else
                        {   // file upload failed - throw msg with error code
                            \YAWK\alert::draw("danger", $lang['ERROR'], "$lang[UPLOAD_FAILED]: $uploadFile $lang[ERROR]: ".$_FILES['fontFile']['error']."", "", 2600);
                        }
                    }
                    else
                        {   // folder does not exist or is not writeable
                            \YAWK\alert::draw("danger", $lang['ERROR'], "$lang[FILE_UPLOAD_ERROR] $lang[FOLDER]: $uploadFile", "", 4800);
                        }
                }
                else
                    {   // wrong file type
                        \YAWK\alert::draw("danger", $lang['ERROR'], "$lang[FONT_WRONG_TYPE]", "", 4600);
                    }
            }
        }
        // TODO: add google fonts to database
    }

    // DELETE FONT ACTION REQUESTED
    if ($_GET['delete'] === "true")
    {   // check which type of font it is
        if (isset($_GET['type']) && (!empty($_GET['type'])))
        {   // custom font (.ttf, .otf or .woff)
            if ($_GET['type'] === "custom")
            {   // check if font is sent
                if (isset($_GET['font']) && (!empty($_GET['font'])))
                {   // check if file is existent
                    if (is_file($fontFolder.$_GET['font']))
                    {   // try to delete file
                        if (unlink($fontFolder.$_GET['font']))
                        {   // all good, throw success msg
                            \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[FONT_DEL_OK]: $_GET[font]", "", 1200);
                        }
                        else
                            {   // failed to delete file
                                \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[FONT_DEL_FAILED]", "", 2600);
                            }
                    }
                    else
                        {   // file does not exist
                            \YAWK\alert::draw("success", "$lang[ERROR]", "$lang[FILEMAN_FILE_DOES_NOT_EXIST] $fontFolder$_GET[font]", "", 4600);
                        }
                }
                else
                    {   // no font was sent - manipulated get vars?!
                        \YAWK\alert::draw("success", "$lang[ERROR]", "$lang[VARS_MANIPULATED]", "", 4600);
                    }
            }
            else
                {   // it must be a google font...
                    // TODO: delete google font from database
                }
        }
        else
        {   // no type was sent - manipulated get vars?!
            \YAWK\alert::draw("success", "$lang[ERROR]", "$lang[VARS_MANIPULATED]", "", 4600);
        }
    }
}

// load google fonts from database into array
$googleFonts = \YAWK\template::getGoogleFontsArray($db);
// load font files from folder to array
$fontArray = \YAWK\template::getFontsFromFolder($fontFolder);

$cssTTF = '';
$cssOTF = '';
$cssWOFF = '';
$cssGoogleFont = '';

// walk through ttf array
foreach ($fontArray['ttf'] as $font)
{   // css tag
    $cssTTF .= "
    @font-face { font-family: '$font';
    src: url('$fontFolder$font') format('truetype'); }
";
}
// walk through otf array
foreach ($fontArray['otf'] as $font)
{   // css tag
    $cssOTF .= "
    @font-face { font-family: '$font';
    src: url('$fontFolder$font') format('opentype'); }
";
}
// walk through ttf array
foreach ($fontArray['woff'] as $font)
{   // css tag
    $cssWOFF .= "
    @font-face { font-family: '$font';
    src: url('$fontFolder$font') format('woff'); }
";
}
// walk through gFonts array
foreach ($googleFonts as $gFont)
{   // google font
    $cssGoogleFont .= "
<link href=\"https://fonts.googleapis.com/css?family=$gFont\" rel=\"stylesheet\">
";
}
// output Google <link href="...">
echo $cssGoogleFont;
// output custom font css styles
echo "<style>".$cssTTF." ".$cssOTF." ".$cssWOFF." </style>";
?>


<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo \YAWK\backend::getTitle($lang['SETTINGS'], $lang['FONTS']);
echo \YAWK\backend::getSettingsBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-font\"></i> &nbsp;$lang[FONTS]&nbsp;<small>$lang[CONFIGURE]</small></h4>"; ?>
            </div>
            <div class="col-md-2">
                <a href="#" id="addFontBtn" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal" style="margin-top:2px;"><i class="fa fa-plus"></i>&nbsp; <?php echo "$lang[FONT_ADD]"; ?></a>
            </div>
        </div>
    </div>

    <!-- FONT MANAGEMENT -->
    <div class="row">
        <!-- GOOGLE FONTS OVERVIEW -->
        <div class="col-md-3">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $lang['FONTS_GOOGLE']; ?> <small> <?php echo $lang['FONTS_GFONT']; ?></small></h3>
                </div>
                <div class="box-body">
                    <?php
                        // draw google fonts list
                        \YAWK\backend::drawFontList($googleFonts, $fontFolder, 'Google', $lang);
                    ?>
                </div>
            </div>
        </div>
        <!-- TTF FONT OVERVIEW -->
        <div class="col-md-3">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $lang['FONTS_TTF']; ?> <small> <?php echo $lang['FONTS_TRUETYPE']; ?></small></h3>
                </div>
                <div class="box-body">
                    <?php
                        // draw TTF font list
                        \YAWK\backend::drawFontList($fontArray['ttf'], $fontFolder, '.ttf', $lang);
                    ?>
                </div>
            </div>
        </div>
        <!-- OTF FONTS OVERVIEW  -->
        <div class="col-md-3">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $lang['FONTS_OTF']; ?> <small> <?php echo $lang['FONTS_OPENTYPE']; ?></small></h3>
                </div>
                <div class="box-body">
                    <?php
                        // draw OTF font list
                        \YAWK\backend::drawFontList($fontArray['otf'], $fontFolder, '.otf', $lang);
                    ?>
                </div>
            </div>
        </div>
        <!-- WOFF FONT OVERVIEW -->
        <div class="col-md-3">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $lang['FONTS_WOFF']; ?> <small> <?php echo $lang['FONTS_WEBOPEN']; ?></small></h3>
                </div>
                <div class="box-body">
                    <?php
                    // draw OTF font list
                    \YAWK\backend::drawFontList($fontArray['woff'], $fontFolder, '.woff', $lang);
                    ?>
                </div>
            </div>
        </div>
    </div>

<!-- Modal --RENAME FOLDER  -- -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form enctype="multipart/form-data" action="index.php?page=settings-fonts&add=true" method="POST">
                <div class="modal-header">
                    <!-- modal header with close controls -->
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> </button>
                    <br>
                    <div class="col-md-1"><h3 class="modal-title"><i class="fa fa-font"></i></h3></div>
                    <div class="col-md-11"><h3 class="modal-title"><?php echo $lang['FONT_ADD']; ?></h3></div>
                </div>

                <!-- modal body -->
                <div class="modal-body">
                    <!-- ADD CUSTOM FONT -->
                    <h4><b><?php echo $lang['FONT_ADD_CUSTOM']; ?></b></h4>
                    <b><?php echo $lang['FONTS_SUPPORTED']; ?></b>
                    <ul>
                        <li><b>.ttf</b> <small><i>(TrueType)</i></small></li>
                        <li><b>.otf</b> <small><i>(Open Type Font)</i></small></li>
                        <li><b>.woff</b> <small><i>(Web Open Font Format)</i></small></li>
                    </ul>

                        <label for="fontFile"><?php echo $lang['SELECT_FILE']; ?></label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="4194304"> <!-- 4 MB -->
                        <input type="file" class="form-control" id="fontFile" name="fontFile">
                        <small><?php echo $lang['FONTS_PATH']; ?></small>
                        <hr>
                        <h4><b><?php echo $lang['FONT_ADD_GFONT']; ?></b></h4>
                        <label for="gfont"><?php echo $lang['FONT_GOOGLE_NAME']; ?></label>
                        <input type="text" class="form-control" id="gfont" name="gfont" placeholder="<?php echo $lang['FONT_GOOGLE_NAME_PH']; ?>">
                        <label for="gfontDescription"><?php echo $lang['FONT_GOOGLE_DESC']; ?></label>
                        <input type="text" class="form-control" name="gfontDescription" id="gfontDescription" placeholder="<?php echo $lang['FONT_GOOGLE_DESC_PH']; ?>">

                </div>

                <!-- modal footer /w submit btn -->
                <div class="modal-footer">
                    <input class="btn btn-large btn-default" data-dismiss="modal" aria-hidden="true" type="submit" value="<?php echo $lang['CANCEL']; ?>">
                    <input class="btn btn-large btn-success" type="submit" value="<?php echo $lang['FONT_ADD']; ?>">
                    <br><br>
                </div>
            </form>
        </div> <!-- modal content -->
    </div> <!-- modal dialog -->
</div>
