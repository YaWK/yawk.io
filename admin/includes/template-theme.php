<?php

// new template object if not exists
if (!isset($template)) { $template = new \YAWK\template(); }
// new user object if not exists
if (!isset($user)) { $user = new \YAWK\user(); }
// $_GET['id'] or $_POST['id'] holds the template ID to edit.
// If any one of these two is set, we're in "preview mode" - this means:
// The user database holds two extra cols: overrideTemplate(int|0,1) and templateID
// Any user who is allowed to override the Template, can edit a template and view it
// in the frontend. -Without affecting the current active theme for any other user.
// This is pretty cool when working on a new design: because you see changes, while others wont.
// In theory, thereby every user can have a different frontend template activated.
?>

<!-- SETTINGS -->
<h3><?php echo "$lang[THEME] <small>$lang[SET_COLORS]</small>"; ?></h3>
<div class="row animated fadeIn">
    <!-- col 1 -->
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[COLOR] <small>$lang[COLOR]</small>"; ?></h3>
            </div>
            <div class="box-body">
                ...
            </div>
        </div>
    </div>
    <!-- col 2 -->
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[COLOR] <small>$lang[COLOR]</small>"; ?></h3>
            </div>
            <div class="box-body">
                ...
            </div>
        </div>
    </div>
</div>