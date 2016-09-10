
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="content-FX">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- draw title on top-->
        <?php echo \YAWK\backend::getTitle($lang['MENU'], $lang['MENU_CREATE']); ?>
<ol class="breadcrumb">
  <li><a href="./" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li><a href="index.php?page=menus" title="Menus"> Menus</a></li>
  <li class="active"><a href="index.php?page=menu-new" title="<?php echo $lang['MENU_CREATE'];?>"> Add a new Menu</a></li>
</ol>
</section>
<!-- Main content -->
<section class="content">
<!-- START CONTENT HERE -->

  <?php
/* if user clicked create menu */
if(isset($_POST['create'])){
  if (YAWK\menu::createMenu($db, $db->quote($_POST['name']))) {
    print \YAWK\alert::draw("success", "Erfolg!", "Das Men&uuml; <strong>".$_POST['name']."</strong> wurde erstellt!", "page=menus","2000");
    exit;
    }
    else 
    {
    print \YAWK\alert::draw("danger", "Fehler!", "Das Men&uuml; <strong>".$_POST['name']."</strong> konnte nicht erstellt werden!", "page=menu-new","2400");
    exit;
    }
  }
/* ...and the plain HTML form */
?>
<form action="index.php?page=menu-new" role="form" method="POST">
  <input name="menu" class="form-control" value="<?php print $id; ?>" type="hidden" />
  <input name="page" class="form-control" value="menu-create" type="hidden" />
  <label>W&auml;hle einen aussagekr&auml;ftigen Namen f&uuml;r Dein neues Men&uuml;.
   <input type="text" class="form-control" placeholder="Men&uuml; Name" id="name" name="name" />
  </label>
  <input class="btn btn-success" type="submit" name="create" value="Men&uuml;&nbsp;anlegen" />
</form>