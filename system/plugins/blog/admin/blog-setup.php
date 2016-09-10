<!-- iconpicker css + JS -->
<link href="../system/engines/iconpicker/css/fontawesome-iconpicker.min.css" rel="stylesheet">
<script src="../system/engines/iconpicker/js/fontawesome-iconpicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#icon').iconpicker();
    });
</script>
<?php
global $lang;
include '../system/plugins/blog/classes/blog.php';
YAWK\backend::getTitle($lang['BLOG'], $lang['BLOG_SETUP']);
// create new blog object
$blog = new \YAWK\PLUGINS\BLOG\blog();
if (isset($_GET['blogid'])) { // if blog is set,
    $blog->id = $_GET['blogid']; // load id to object
} else {
    $blog->id = 1; // else set default blogid
}

// and get blog settings
$blog->name = $blog->getBlogProperty($db, $blog->id, "name");
$blog->description = $blog->getBlogProperty($db, $blog->id, "description");
$blog->icon = $blog->getBlogProperty($db, $blog->id, "icon");
// if form is sent, prepare data
if (isset($_POST['setup'])) {
    $blog->blogid = $_POST['blogid'];
    $blog->name = $db->quote($_POST['name']);
    $blog->description = $db->quote($_POST['description']);
    $blog->icon = $db->quote($_POST['icon']);
    $blog->gid = $db->quote($_POST['gid']);

    // set frontend settings
    if (!isset($_POST['showTitle'])) {
        $blog->showTitle = 0;
    } else {
        $blog->showTitle = $_POST['showTitle'];
    }
    if (!isset($_POST['showDesc'])) {
        $blog->showDesc = 0;
    } else {
        $blog->showDesc = $_POST['showDesc'];
    }
    if (!isset($_POST['showDate'])) {
        $blog->showDate = 0;
    } else {
        $blog->showDate = $_POST['showDate'];
    }
    if (!isset($_POST['showAuthor'])) {
        $blog->showAuthor = 0;
    } else {
        $blog->showAuthor = $_POST['showAuthor'];
    }
    if (!isset($_POST['permaLink'])) {
        $blog->permaLink = 0;
    } else {
        $blog->permaLink = $_POST['permaLink'];
    }
    if (!isset($_POST['preview'])) {
        $blog->preview = 0;
    } else {
        $blog->preview = $_POST['preview'];
    }
    if (!isset($_POST['voting'])) {
        $blog->voting = 0;
    } else {
        $blog->voting = $_POST['voting'];
    }

    // set layout setting
    if (!isset($_POST['layout'])) {
        $blog->layout = 0;
    } else {
        $blog->layout = $_POST['layout'];
    }

    // sequence tells how it needs2be sorted. (by name or by date)
    if (!isset($_POST['sequence'])) {
        $blog->sequence = "0";
    } else {
        $blog->sequence = $_POST['sequence'];
    }
    if (!isset($_POST['sortation'])) {
        $blog->sortation = "0";
    } else {
        $blog->sortation = $_POST['sortation'];
    }

    // comments in frontend?
    if (!isset($_POST['comments'])) {
        $blog->comments = "0";
    } else {
        $blog->comments = $_POST['comments'];
    }

    // finally: save blog settings
    if ($blog->setup($db, $blog->blogid))
    {   // success
        echo YAWK\alert::draw("success", "Hooray!", "Entry saved successfully.","plugin=blog","1200");
        exit;
    }
    else
    {   // setup failed, throw error
        echo YAWK\alert::draw("danger", "Error: ", "Settings for Blog ID " . $_POST['blogid'] . " " . $blog->name . " - " . $blog->description . " could not be saved.","plugin=blog","3800");
        exit;
    }
}
/*
 * HERE IS THE BACKEND LOGIC
 */
// get frontend settings
$blog->showTitle = $blog->getBlogProperty($db, $blog->id, "showtitle");
$blog->showDesc = $blog->getBlogProperty($db, $blog->id, "showdesc");
$blog->showDate = $blog->getBlogProperty($db, $blog->id, "showdate");
$blog->showAuthor = $blog->getBlogProperty($db, $blog->id, "showauthor");
$blog->sequence = $blog->getBlogProperty($db, $blog->id, "sequence");
$blog->sortation = $blog->getBlogProperty($db, $blog->id, "sortation");
$blog->comments = $blog->getBlogProperty($db, $blog->id, "comments");
$blog->permaLink = $blog->getBlogProperty($db, $blog->id, "permaLink");
$blog->layout = $blog->getBlogProperty($db, $blog->id, "layout");
$blog->gid = $blog->getBlogProperty($db, $blog->id, "gid");
$blog->preview = $blog->getBlogProperty($db, $blog->id, "preview");
$blog->voting = $blog->getBlogProperty($db, $blog->id, "voting");

// prepare HTML HELPER VARS, check if checkboxes needs to be checked (:
// frontend settings checkboxes
if ($blog->showTitle === '1') {
    $titleChecked = "checked";
} else {
    $titleChecked = "";
}
if ($blog->showDesc === '1') {
    $descCheckbox = "checked";
} else {
    $descCheckbox = "";
}
if ($blog->showDate === '1') {
    $dateChecked = "checked";
} else {
    $dateChecked = "";
}
if ($blog->showAuthor === '1') {
    $authorChecked = "checked";
} else {
    $authorChecked = "";
}
if ($blog->permaLink === '1') {
    $permaLinkChecked = "checked";
} else {
    $permaLinkChecked = "";
}
if ($blog->preview === '1') {
    $previewChecked = "checked";
} else {
    $previewChecked = "";
}

// layout radio buttons
if ($blog->layout === '0') {
    $layout0Checked = "checked";
} else {
    $layout0Checked = "";
}
if ($blog->layout === '1') {
    $layout1Checked = "checked";
} else {
    $layout1Checked = "";
}
if ($blog->layout === '2') {
    $layout2Checked = "checked";
} else {
    $layout2Checked = "";
}
if ($blog->layout === '3') {
    $layout3Checked = "checked";
} else {
    $layout3Checked = "";
}
if ($blog->layout === '4') {
    $layout4Checked = "checked";
} else {
    $layout4Checked = "";
}

// sortation radio buttons
if ($blog->sequence === '0') {
    $sequenceDateChecked = "checked";
} else {
    $sequenceDateChecked = "";
}
if ($blog->sequence === '1') {
    $sequenceTitleChecked = "checked";
} else {
    $sequenceTitleChecked = "";
}
if ($blog->sortation === '0') {
    $ascChecked = "checked";
} else {
    $ascChecked = "";
}
if ($blog->sortation === '1') {
    $descChecked = "checked";
} else {
    $descChecked = "";
}

// comments radio buttons
if ($blog->comments === '0') {
    $commentsOffChecked = "checked";
} else {
    $commentsOffChecked = "";
}
if ($blog->comments === '1') {
    $commentsOnChecked = "checked";
} else {
    $commentsOnChecked = "";
}

// voting radio buttons
if ($blog->voting === '0') {
    $votingOffChecked = "checked";
} else {
    $votingOffChecked = "";
}
if ($blog->voting === '1') {
    $votingOnChecked = "checked";
} else {
    $votingOnChecked = "";
}

// GO ON WITH THE PLAIN HTML FORM...
?>

<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
<!-- Content Wrapper. Contains page content -->
<div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
        /* draw Title on top */
        echo \YAWK\backend::getTitle($lang['BLOG'], $lang['BLOG_SETUP']);
        echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"Plugins\"> Plugins</a></li>
            <li><a href=\"index.php?plugin=blog\" title=\"Blog\"> Blog</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=blog&pluginpage=blog-setup\" title=\"Blog\"> Setup</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
        /* page content start here */
?>

<form action="index.php?plugin=blog&pluginpage=blog-setup" class="form-inline" role="form" method="POST"
      xmlns="http://www.w3.org/1999/html">

    <!-- SAVE BUTTON -->
    <input id="savebutton"
           class="btn btn-success pull-right"
           type="submit"
           name="create"
           value="<?PHP echo $lang['SAVE_SETTINGS']; ?>"/>&nbsp;

    <!-- BACK BUTTON -->
    <a class="btn btn-default pull-right" href="index.php?plugin=blog"><?PHP echo $lang['BACK']; ?></a><br>


    <input name="setup"
           value="blog-create"
           type="hidden"/>
    <input name="blogid"
           value="<?PHP echo $_GET['blogid']; ?>"
           type="hidden"/>

    <input type="text"
           class="form-control"
           size="64"
           placeholder="<?PHP echo $lang['BLOG_NAME']; ?>"
           id="name"
           name="name"
           value="<?PHP echo $blog->name; ?>"/><br>


    <textarea class="form-control"
              cols="64"
              rows="3"
              style="margin-top: 6px;"
              placeholder="<?PHP echo $lang['BLOG_DESCRIPTION']; ?>"
              id="description"
              name="description"><?PHP echo $blog->description; ?></textarea><br>

    <input type="text"
           class="form-control icp icp-auto iconpicker-element iconpicker-input"
           size="50"
           style="margin-top: 6px;"
           placeholder="<?PHP echo $lang['BLOG_ICON']; ?>"
           id="icon"
           name="icon"
           value="<?PHP echo $blog->icon; ?>"/><br><br>

    <!-- FRONTEND SETTINGS -->
    <hr>
    <h3><i class="fa fa-television"></i> Frontend Einstellungen</h3>

    <div class="checkbox">
        <label for="showTitle">
            <input type="checkbox"
                   class="form-control"
                   id="showTitle"
                   name="showTitle"
                   value="1"
                <?PHP echo $titleChecked; ?> /> Titel im Frontend anzeigen?
        </label><br>

        <label for="showDesc">
            <input type="checkbox"
                   class="form-control"
                   id="showDesc"
                   name="showDesc"
                   value="1"
                <?PHP echo $descCheckbox; ?> /> Beschreibung im Frontend anzeigen?
        </label><br>

        <label for="showDate">
            <input type="checkbox"
                   class="form-control"
                   id="showDate"
                   name="showDate"
                   value="1"
                <?PHP echo $dateChecked; ?> /> Datum im Frontend anzeigen?<br>

            <label for="showAuthor">
                <input type="checkbox"
                       class="form-control"
                       id="showAuthor"
                       name="showAuthor"
                       value="1"
                    <?PHP echo $authorChecked; ?> /> Autor im Frontend anzeigen?<br>

                <label for="permaLink">
                    <input type="checkbox"
                           class="form-control"
                           id="permaLink"
                           name="permaLink"
                           value="1"
                        <?PHP echo $permaLinkChecked; ?> /> Permalink im Frontend anzeigen?<br>

                <label for="preview">
                    <input type="checkbox"
                           class="form-control"
                           id="preview"
                           name="preview"
                           value="1"
                       <?PHP echo $previewChecked; ?> /> Nur Preview anzeigen? <small>(&laquo;alles anzeigen&raquo; button verstecken)</small><br>
    </div>

    <!-- BLOG LAYOUT -->
    <hr>
    <h3><i class="fa fa-object-group"></i> Layout</h3>

    <div class="radio">
        <label for="layout0">
            <input type="radio" name="layout" id="layout0" value="0" <?PHP echo $layout0Checked; ?>>
            <img src="http://placehold.it/120x80">&nbsp;&nbsp; 1 spaltig, Text Blog
        </label><br><br>
        <label for="layout1">
            <input type="radio" name="layout" id="layout1" value="1" <?PHP echo $layout1Checked; ?>>
            <img src="http://placehold.it/120x80">&nbsp;&nbsp; 2 spaltig, Vorschaubild links
        </label><br><br>
        <label for="layout2">
            <input type="radio" name="layout" id="layout2" value="2" <?PHP echo $layout2Checked; ?>>
            <img src="http://placehold.it/120x80">&nbsp;&nbsp; 2 spaltig, Vorschaubild rechts
        </label><br><br>
        <label for="layout3">
            <input type="radio" name="layout" id="layout3" value="3" <?PHP echo $layout3Checked; ?>>
            <img src="http://placehold.it/120x80">&nbsp;&nbsp; 3 spaltig, Newspaper Style
        </label><br><br>
        <label for="layout4">
            <input type="radio" name="layout" id="layout4" value="4" <?PHP echo $layout4Checked; ?>>
            <img src="http://placehold.it/120x80">&nbsp;&nbsp; 1 spaltig, Responsive YouTube Blog
        </label><br><br>
    </div>

    <!-- BLOG ENTRY SORTATION -->
    <hr>
    <h3><i class="fa fa-sort-alpha-asc"></i> Sortierung</h3>

    <div class="radio">
        <label for="sequenceDate">
            <input type="radio" name="sequence" id="sequenceDate" value="0" <?PHP echo $sequenceDateChecked; ?>>
            Beitr&auml;ge chronologisch (nach Datum) sortieren
        </label><br><br>
        <label for="sequenceTitle">
            <input type="radio" name="sequence" id="sequenceTitle" value="1" <?PHP echo $sequenceTitleChecked; ?>>
            Beitr&auml;ge alphabetisch (nach Titel) sortieren
        </label>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="radio">
        <label for="asc">
            <input type="radio" name="sortation" id="asc" value="0" <?PHP echo $ascChecked; ?>>
            aufsteigend
        </label><br><br>
        <label for="desc">
            <input type="radio" name="sortation" id="desc" value="1" <?PHP echo $descChecked; ?>>
            absteigend
        </label>
    </div>

    <!-- COMMENTS -->
    <hr>
    <h3><i class="fa fa-comment-o"></i> Kommentare</h3>

    <div class="radio">
        <label for="comment_off">
            <input type="radio" name="comments" id="comment_off" value="0" <?PHP echo $commentsOffChecked; ?>>
            Comments verboten
        </label><br><br>
        <label for="comment_on">
            <input type="radio" name="comments" id="comment_on" value="1" <?PHP echo $commentsOnChecked; ?>>
            Comments erlaubt
        </label>
    </div>

    <!-- VOTING -->
    <hr>
    <h3><i class="fa fa-thumbs-o-up"></i> Kommentare</h3>

    <div class="radio">
        <label for="voting_off">
            <input type="radio" name="voting" id="voting_off" value="0" <?PHP echo $votingOffChecked; ?>>
            Voting verboten
        </label><br><br>
        <label for="voting_on">
            <input type="radio" name="voting" id="voting_on" value="1" <?PHP echo $votingOnChecked; ?>>
            Voting erlaubt
        </label>
    </div>

    <!-- ACCESS CONTROL / PRIVACY -->
    <hr>
    <h3><i class="fa fa-eye"></i> Privatsph&auml;re</h3>
    <select name="gid" class="form-control">
        <option value="<?php print \YAWK\sys::getRoleId($db, $blog->gid, "blog"); ?>"><?php print \YAWK\sys::getRole($db, $blog->gid, "blog"); ?></option>

        <?php
        foreach(YAWK\sys::getRoles("blog") as $gid) {
            print "<option value=\"".$gid['id']."\"";
            if (isset($blog->gid)) {
                if($blog->gid === $gid['id']) {
                    print " selected=\"selected\"";
                }
                else if($blog->gid === $gid['id'] && !$_POST['gid']) {
                    print " selected=\"selected\"";
                }
            }
            print ">".$gid['value']."</option>";
        }
        ?>

    </select>
</form>

<br><br><br><br>

