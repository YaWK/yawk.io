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
?>
<div class="row animated fadeIn">
    <!-- PREVIEW -->
    <div class="col-md-12">
        <!-- website preview iframe -->
        <div class="embed-responsive embed-responsive-4by3">
            <iframe id="preview" class="embed-responsive-item" src="../index.php"></iframe>
        </div>
    </div>
</div>