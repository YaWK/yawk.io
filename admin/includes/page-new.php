<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
    echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['PAGE'], $lang['PAGE_ADD_SMALL']);
echo"<ol class=\"breadcrumb\">
        <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
        <li><a href=\"index.php?page=pages\" title=\"Pages\"> Pages</a></li>
        <li class=\"active\"><a href=\"index.php?page=page-new\" title=\"New Page\"> New Page</a></li>
     </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

  /* focus input text field on page load */ 
  \YAWK\backend::setFocus("alias");
  if(!isset($_POST['alias'])) {
  }
  else
  { // if page obj != set
      if (!isset($page))
      {   // create new page object
          $page = new YAWK\page();
      }
      $alias = $db->quote($_POST['alias']);
      $menuID = $db->quote($_POST['menuID']);
      $blogid = $db->quote($_POST['blogid']);
      $locked = $db->quote($_POST['locked']);
      $plugin="";
    /* create page function */
    if($page->create($db, $alias, $menuID, $locked, $blogid, $plugin))
    {
        if (!\YAWK\sys::setNotification($db, 1, "Page $alias.html created.", $user->id, 0, 0, 0))
        {
            echo \YAWK\alert::draw("danger", "Fehler!", "nix gehta!", "",2000);
        }

        \YAWK\alert::draw("success", "Success!", "Page created.","","420");
        \YAWK\backend::setTimeout("index.php?page=pages",1260);
    }
    else 
    {   // create new page failed
        print \YAWK\alert::draw("danger", "Error!", "The page <strong>".$alias."</strong> could not be created!","page=page-new","4800");
    }
  }
?>
<!-- FORM -->
<form role="form" class="form-inline" action="index.php?page=page-new" method="post">
  <label for "alias"><?PHP print $lang['PAGE_ADD_SUBTEXT']; ?><br>
  <!-- TEXT FIELD -->
  <input type="text" id="alias" size="84" name="alias" class="form-control" maxlength="255" 
  placeholder="<?PHP print $lang['PAGE_ADD_PLACEHOLDER']; ?>" /> .html
  </label>
  <br>
  <!-- MENU SELECTOR -->
  &nbsp;&nbsp;<?PHP print $lang['IN_MENU']; ?>&nbsp; <select name="menuID" class="btn btn-default">
    <?PHP
    foreach (YAWK\backend::getMenusArray($db) AS $menue){
//    foreach(YAWK\sys::getMenus() as $menue){
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
    <option value="empty">-- no menu entry --</option>
  </select>

    <!-- SUBMIT BUTTON -->
    <input type="submit" class="btn btn-success" value="<?PHP print $lang['PAGE_ADD_BTN']; ?>" />

    <input type="hidden" name="blogid" value="0">
  <input type="hidden" name="locked" value="0">
</form>
