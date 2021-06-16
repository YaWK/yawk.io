<?php

use YAWK\backend;
use YAWK\db;
use YAWK\language;

/** @var $db db */
/** @var $lang language */
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="content-FX">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- draw title on top-->
        <?php echo backend::getTitle($lang['MENU'], $lang['MENU_CREATE']); ?>
<ol class="breadcrumb">
  <li><a href="./" title="Dashboard"><i class="fa fa-dashboard"></i> <?php echo $lang['DASHBOARD']; ?></a></li>
  <li><a href="index.php?page=menus" title="<?php echo $lang['MENUS']; ?>"> <?php echo $lang['MENUS']; ?></a></li>
  <li class="active"><a href="index.php?page=menu-new" title="<?php echo $lang['MENU_CREATE'];?>"> <?php echo $lang['MENU+']; ?></a></li>
</ol>
</section>
<!-- Main content -->
<section class="content">
<!-- START CONTENT HERE -->
<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title"><?php echo $lang['MENU+']; ?></h3>
    </div>
    <div class="box-body">
    <form action="index.php?page=menus&add=1" role="form" method="POST">
        <input name="menu"
               class="form-control"
               value="<?php // print $id; ?>"
               type="hidden">
        <input name="page"
               class="form-control"
               value="menu-create"
               type="hidden">

        <label><?php echo $lang['MENU_ADD_SUBTEXT']; ?>
        <input type="text"
               class="form-control"
               placeholder="<?php echo $lang['MENU_NAME']; ?>"
               id="name"
               name="name">
        </label>
        <input class="btn btn-success"
               type="submit"
               name="create"
               value="<?php echo $lang['MENU+']; ?>">
    </form>
    </div>
</div>