<script type="text/javascript">
    $(document).ready(function() {
        var savebutton = ('#savebutton');
        var savebuttonIcon = ('#savebuttonIcon');
        // ok, lets go...
        // we need to check if user clicked on save button
        $(savebutton).click(function() {
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning disabled');
            $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
        });
    }); // end document ready
</script>

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
<h3><?php echo "$lang[SETTINGS] <small>$lang[TPL_SETTINGS_SUBTEXT]</small>"; ?></h3>
<div class="row animated fadeIn">
    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Required Assets Include Configuration</h3>
            </div>
            <div class="box-body">
                <label for="include-bootstrap">Bootstrap JS</label>
                <select id="include-bootstrap" name="include-bootstrap" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/bootstrap)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js</option>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js">https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js</option>
                </select>
                <label for="include-bootstrap">Bootstrap CSS</label>
                <select id="include-bootstrap" name="include-bootstrap" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/bootstrap)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css</option>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css</option>
                </select>
                <label for="include-jquery">jQuery</label>
                <select id="include-jquery" name="include-jquery" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/jquery)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                    <option name="cdn-xyz">use jquery CDN (http://.....)</option>
                </select>
                <label for="include-jquery">jQuery UI</label>
                <select id="include-jquery" name="include-jquery" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/jquery)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                    <option name="cdn-xyz">use jquery CDN (http://.....)</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Optional Assets Configuration</h3>
            </div>
            <div class="box-body">
                <label for="include-animate">Animate.css</label>
                <select id="include-animate" name="include-animate" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/animate)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                    <option name="cdn-xyz">use jquery CDN (http://.....)</option>
                </select>
                <label for="include-fontawesome">Font Awesome Icons</label>
                <select id="include-fontawesome" name="include-fontawesome" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/fontawesome)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                </select>
                <label for="include-lightbox2">Lightbox 2</label>
                <select id="include-lightbox2" name="include-lightbox2" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/lightbox)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                    <option name="cdn-xyz">use jquery CDN (http://.....)</option>
                </select>
                <label for="include-pace">Pace Loading Bar</label>
                <select id="include-pace" name="include-pace" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/pace)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                    <option name="cdn-xyz">use jquery CDN (http://.....)</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">4</div>
</div>

<div class="row animated fadeIn">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[SAVE_AS] <small>$lang[NEW_THEME]</small>"; ?></h3>
            </div>
            <div class="box-body">
                <label for="savetheme"><?php echo "$lang[SAVE_NEW_THEME_AS]"; ?></label>
                <input type="text" class="form-control" name="newthemename" value="<?php echo $template->name; ?>-copy" placeholder="<?php echo "$lang[NEW] $lang[TPL] $lang[NAME]"; ?>">
                <input type="text" class="form-control" name="description" placeholder="<?php echo "$lang[TPL] $lang[DESCRIPTION]"; ?>">
                <input type="text" class="form-control" name="positions" placeholder="<?php echo "$lang[POSITIONS] $lang[POS_DESCRIPTION]"; ?>">
                <br><input id="addbutton" type="submit" class="btn btn-danger" name="savenewtheme" value="<?php echo "$lang[SAVE_NEW_THEME_AS]"; ?>">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[TPL_ADD_GFONT] <small>$lang[TPL_ADD_GFONT_SUBTEXT]</small>"; ?></h3>
            </div>
            <div class="box-body">
                <input type="text" class="form-control" id="gfont" name="gfont" placeholder="font eg. Ubuntu">
                <input type="text" class="form-control" name="gfontdescription" placeholder="description eg. Ubuntu, serif">
                <br><input id="savebutton" type="submit" class="btn btn-danger" name="addgfont" value="<?php echo "$lang[TPL_ADD_GFONT_BTN]"; ?>">
            </div>
        </div>
    </div>
</div>