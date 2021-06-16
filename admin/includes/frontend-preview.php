<?php
// TEMPLATE WRAPPER - PAGE PREVIEW
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */

// check if alias is set via get param
if (isset($_GET['alias']) && (!empty($_GET['alias'])))
{   // set alias string
    $alias = "?include=$_GET[alias]";
}
// it's not a static page, get plugin param
else if (isset($_GET['plugin']) && (!empty($_GET['plugin'])))
{   // set plugin string
    $alias = "?include=$_GET[plugin]";
}
else
{   // alias not set, leave empty
    $alias = '';
}
?>
<div class="row animated fadeIn">
    <!-- PREVIEW -->
    <div class="col-md-12">
        <!-- website preview iframe -->
        <div class="embed-responsive embed-responsive-4by3">
            <iframe id="preview" class="embed-responsive-item" src="../index.php<?php echo $alias; ?>"></iframe>
        </div>
    </div>
</div>