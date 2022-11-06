<?php
// IMPORT REQUIRED CLASSES
use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;

/** @var $db db  */
/** @var $lang language  */

// CHECK REQUIRED OBJECTS
if (!isset($page)) // if no page object is set
{   // create new page object
    $page = new YAWK\page();
}

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['PAGE'], $lang['PAGE_ADD_SMALL']);
echo"<ol class=\"breadcrumb\">
        <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
        <li><a href=\"index.php?page=pages\" title=\"$lang[PAGES]\"> $lang[PAGES]</a></li>
        <li class=\"active\"><a href=\"index.php?page=page-new\" title=\"".$lang['PAGE+']."\"> ".$lang['PAGE_ADD']."</a></li>
     </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

/* focus input text field on page load */
backend::setFocus("alias");
if(isset($_POST['alias']) && (!empty($_POST['alias'])))
{
    $page->alias = $db->quote($_POST['alias']);
    $page->menu = $db->quote($_POST['menuID']);
    $page->blogid = $db->quote($_POST['blogid']);
    $page->locked = $db->quote($_POST['locked']);
    $page->plugin="";
    $page->language = $db->quote($_POST['language']);
    /* create page function */
    if($page->create($db, $page->alias, $page->menu, $page->locked, $page->blogid, $page->plugin))
    {
        // YAWK\sys::setNotification($db, 1, "$lang[PAGE] $alias.html $lang[CREATED].", $user->id, 0, 0, 0);
        alert::draw("success", "$lang[SUCCESS]", "$lang[PAGE] $lang[CREATED]","","420");
        backend::setTimeout("index.php?page=pages",1260);
    }
    else
    {   // create new page failed
        print alert::draw("danger", "$lang[ERROR]", "$lang[SAVE] $lang[OF] $lang[PAGE] <strong>".$this->alias."</strong> $lang[FAILED]","page=page-new","4800");
    }

}
?>
<!-- FORM -->
<div class="box box-default">
    <div class="box-body">
        <br>
        <form role="form" class="form-inline" action="index.php?page=page-new" method="post">
            <label for="alias"><?php print $lang['PAGE_ADD_SUBTEXT']; ?>
                <?php echo backend::printTooltip($lang['TT_PAGE_TITLE']); ?></label><br>
            <!-- TEXT FIELD -->
            <input type="text" id="alias" size="84" name="alias" class="form-control" maxlength="255"
                   placeholder="<?php print $lang['PAGE_ADD_PLACEHOLDER']; ?>" /> .html

            <br><br>
            <label for="language"><?php echo $lang['ASSIGN_LANGUAGE']; ?>
                <?php echo backend::printTooltip($lang['TT_PAGE_LANGUAGE']); ?>
            </label><br>
            <select id="language" name="language" class="form-control">
                <?php
                echo language::drawLanguageSelectOptions();
                ?>
            </select>

            <br><br>
            <!-- MENU SELECTOR -->
            &nbsp;&nbsp;<label for="menuID"><?php print $lang['IN_MENU']; ?>
                <?php echo backend::printTooltip($lang['TT_PAGE_MENU']); ?></label> <select id="menuID" name="menuID" class="btn btn-default">
                <?php
                foreach (YAWK\backend::getMenusArray($db) AS $menue){
                    echo "<option value=\"".$menue['id']."\"";
                    if (isset($_POST['menu'])) {
                        if($_POST['menu'] === $menue['id']){
                            echo " selected=\"selected\"";
                        }
                        else if($page->menu === $menue['id'] && !$_POST['menu']){
                            echo " selected=\"selected\"";
                        }
                    }
                    echo ">".$menue['name']."</option>";
                }
                ?>
                <option value="empty"><?php echo $lang['NO_ENTRY']; ?></option>
            </select>

            <!-- SUBMIT BUTTON -->
            <input type="submit" class="btn btn-success" value="<?php print $lang['PAGE_ADD_BTN']; ?>" />

            <input type="hidden" name="blogid" value="0">
            <input type="hidden" name="locked" value="0">
        </form>
        <br>
    </div>
</div>