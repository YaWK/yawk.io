<?php
$theme = YAWK\settings::getSetting("backendTheme");
if ($theme === 'dark' || $theme === 'blue') {
    $html = "inverse";
}
else {
    $html = "default";
}
?>
<!-- Fixed navbar -->
<div class="navbar navbar-<?php echo $html; ?> navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- FRONTEND link on the left side -->
            <a class="navbar-brand" href="../index.php" target="_blank">
                <i class="glyphicon glyphicon-home"></i> &nbsp;
                <?php print $lang['MENU_FRONTEND'];?></a>
        </div>
    <div class="navbar-collapse collapse" id="navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li><a href="index.php?page=dashboard"><i class="glyphicon glyphicon-dashboard"></i> &nbsp;<?php print $lang['MENU_DASHBOARD']; ?></a></li>
            <li><a href="index.php?page=pages"><i class="glyphicon glyphicon-text-height"></i> &nbsp;<?php print $lang['MENU_PAGES']; ?></a></li>
            <li><a href="index.php?page=menus"><i class="glyphicon glyphicon-list"></i> &nbsp;<?php print $lang['MENU_MENUS']; ?></a></li>
            <li><a href="index.php?page=plugins"><i class="fa fa-plug"></i> &nbsp;<?php print $lang['PLUGINS']; ?></a></li>
            <!-- <li><a href="index.php?page=tourdates"><i class="fa fa-calendar-check-o"></i> &nbsp;<?php print $lang['TOUR']; ?></a></li>-->
            <!--   <li><a href="index.php?plugin=blog&pluginpage=blog\"s"><i class="glyphicon glyphicon-font"></i> &nbsp;<?php // print $lang['BLOG_PAGES']; ?></a></li> -->
            <li><a href="index.php?page=widgets"><i class="glyphicon glyphicon-tags"></i> &nbsp;<?php print $lang['MENU_WIDGETS']; ?></a></li>
            <li><a href="index.php?page=filemanager"><i class="glyphicon glyphicon-folder-open"></i> &nbsp;<?php print $lang['MENU_FILES']; ?></a></li>
            <li><a href="index.php?page=users"><i class="glyphicon glyphicon-user"></i> &nbsp;<?php print $lang['MENU_USERS']; ?></a></li>
            <!--  <li><a href="index.php?page=settings"><i class="glyphicon glyphicon-wrench"></i> &nbsp;<?php // print $lang['MENU_SETTINGS']; ?></a></li> -->
            <li><a href="index.php?page=settings-template"><i class="fa fa-paint-brush"></i> &nbsp;<?php print $lang['MENU_DESIGN']; ?></a></li>
        <!--    <li><a href="index.php?page=yawk-stats"><i class="glyphicon glyphicon-stats"></i> &nbsp;<?php print $lang['MENU_STATS']; ?></a></li> -->
        </ul>
            <!-- Collect the nav links, forms, and other content for toggling -->
                <ul class="nav navbar-nav navbar-right">
                   <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo YAWK\user::getSessionUserImage(20,20); ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?page=user-edit&user=<?php echo YAWK\sys::getCurrentUserName(); ?>">
                                    <?php echo YAWK\user::getSessionUserImage(50,50); ?>
                                  <!--  <img src="../media/images/users/00_user.png" width="50" height="50" class="img-circle"> --> &nbsp;&nbsp;Edit Profile</a></li>
                            <li><a href="index.php?page=logins">Failed Logins</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo YAWK\sys::getCurrentUserName(); ?> &nbsp;<i class="glyphicon glyphicon-off"></i></a>
                        <ul id="dropdown-menu" class="dropdown-menu">
                            <li><a href="index.php?page=<?php echo $_GET['page']; ?>&lang=de-DE">Switch to DE</a>
                                <a href="index.php?page=<?php echo $_GET['page']; ?>&lang=en-EN">Switch to EN</a></li>
                            <li class="divider"></li>
                            <li><a href="index.php?page=help" title="Help and Documentation"><i class="glyphicon glyphicon-question-sign"></i> &nbsp;Help</a></li>
                            <li><a href="index.php?page=yawk-stats" title="Stats"><i class="glyphicon glyphicon-stats"></i> &nbsp;Stats</a></li>
                            <li><a href="index.php?page=settings-system" title="Settings"><i class="glyphicon glyphicon-cog"></i> &nbsp;System</a></li>
                        <!--<li><a href="index.php?page=settings-database" title="Database"><i class="fa fa-database"></i> &nbsp;Database</a></li> -->
                            <li><a href="index.php?page=settings-backend" title="Backend Settings"><i class="glyphicon glyphicon-wrench"></i> &nbsp;Backend</a></li>
                            <li><a href="index.php?page=backup" title="Backup"><i class="glyphicon glyphicon-hdd"></i> &nbsp;Backup</a></li>
                            <li class="divider"></li>
                            <li><a href="index.php?page=logout"><i class="glyphicon glyphicon-log-out"></i> &nbsp;Logout</a></li>
                            </li>
                        </ul>
    </div><!-- /.container-fluid -->
</div>
</div>