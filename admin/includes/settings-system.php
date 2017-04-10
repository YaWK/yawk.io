<!-- color picker -->
<script type="text/javascript" src="../system/engines/jquery/jscolor/jscolor.js"></script>
<!-- --><script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
<!-- JS GO -->
<script type="text/javascript">
	function saveHotkey() {
		// simply disables save event for chrome
		$(window).keypress(function (event) {
			if (!(event.which == 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which == 19)) return true;
			event.preventDefault();
			formmodified=0; // do not warn user, just save.
			return false;
		});
		// used to process the cmd+s and ctrl+s events
		$(document).keydown(function (event) {
			if (event.which == 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
				event.preventDefault();
				$('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
				formmodified=0; // do not warn user, just save.
				// save(event);
				return false;
			}
		});
	}
	saveHotkey();
	$(document).ready(function() {
		// textarea that will be transformed into editor
		var savebutton = ('#savebutton');
		var savebuttonIcon = ('#savebuttonIcon');
		// textarea that will be transformed into editor
		var editor = ('textarea#summernote');
		// ok, lets go...
		// we need to check if user clicked on save button
		$(savebutton).click(function() {
			$(savebutton).removeClass('btn btn-success').addClass('btn btn-warning disabled');
			$(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');

			if ($(editor).summernote('codeview.isActivated')) {
				// if so, turn it off.
				$(editor).summernote('codeview.deactivate');
			}
		});

		/* START CHECKBOX backend footer */
		// check backend footer checkbox onload
		if( $('#backendFooter').prop('checked')){
			// box is checked, set input field to NOT disabled
			$("#backendFooterValueLeft").prop('disabled', false);
			$("#backendFooterValueRight").prop('disabled', false);
			$("#backendFooterCopyright").prop('disabled', false);
		}
		else {
			// box is not checked, set field to disabled
			$("#backendFooterValueLeft").prop('disabled', true);
			$("#backendFooterValueRight").prop('disabled', true);
			$("#backendFooterCopyright").prop('disabled', true);
		}
		// check wheter the footer checkbox is clicked
		$('#backendFooter').click(function(){ // if user clicked save
			if( $('#backendFooter').prop('checked')){
				// box is checked, set input field to NOT disabled
				$("#backendFooterValueLeft").prop('disabled', false);
				$("#backendFooterValueRight").prop('disabled', false);
				$("#backendFooterCopyright").prop('disabled', false);
			}
			else {
				// set footer value input field to disabled
				$("#backendFooterValueLeft").prop('disabled', true);
				$("#backendFooterValueRight").prop('disabled', true);
				$("#backendFooterCopyright").prop('disabled', true);
			}
		});
        // check wheter the footer copyright checkbox is clicked
        $('#backendFooterCopyright').click(function(){ // if user clicked save
            if( $('#backendFooterCopyright').prop('checked')){
                // box is checked, set input field to NOT disabled
                $("#backendFooterValueLeft").prop('disabled', true);
                $("#backendFooterValueRight").prop('disabled', true);
            }
            else {
                // set footer value input field to disabled
                $("#backendFooterValueLeft").prop('disabled', false);
                $("#backendFooterValueRight").prop('disabled', false);
            }
        });
		/* END CHECKBOX backend footer */

		/* START CHECKBOX backend logo */
		// check backend footer checkbox onload
		if( $('#backendLogoUrl').prop('checked')){
			// box is checked, set input field to NOT disabled
			$("#backendLogoText").prop('disabled', true);
			$("#backendLogoSubText").prop('disabled', true);
		}
		else {
			// box is not checked, set field to disabled
			$("#backendLogoText").prop('disabled', false);
			$("#backendLogoSubText").prop('disabled', false);
		}
		// check wheter the checkbox is clicked
		$('#backendLogoUrl').click(function(){ // if user clicked save
			if( $('#backendLogoUrl').prop('checked')){
				// box is checked, set input field to NOT disabled
				$("#backendLogoText").prop('disabled', true);
				$("#backendLogoSubText").prop('disabled', true);
			}
			else {
				// set footer value input field to disabled
				$("#backendLogoText").prop('disabled', false);
				$("#backendLogoSubText").prop('disabled', false);
			}
		});
		/* END CHECKBOX backend logo */

		/* START CHECKBOX backend fx */
		// check backend footer checkbox onload
		if( $('#backendFX').prop('checked')){
			// box is checked, set input field to NOT disabled
			$("#backendFXtype").prop('disabled', false);
			$("#backendFXtime").prop('disabled', false);
		}
		else {
			// box is not checked, set field to disabled
			$("#backendFXtype").prop('disabled', true);
			$("#backendFXtime").prop('disabled', true);
		}
		// check wheter the checkbox is clicked
		$('#backendFX').click(function(){ // if user clicked save
			if( $('#backendFX').prop('checked')){
				// box is checked, set input field to NOT disabled
				$("#backendFXtype").prop('disabled', false);
				$("#backendFXtime").prop('disabled', false);
			}
			else {
				// set footer value input field to disabled
				$("#backendFXtype").prop('disabled', true);
				$("#backendFXtime").prop('disabled', true);
			}
		});
		/* END CHECKBOX backend fx */

		/* START CHECKBOX timediff */
		// check backend footer checkbox onload
		if( $('#timediff').prop('checked')){
			// box is checked, set input field to NOT disabled
			$("#timedifftext").prop('disabled', false);
		}
		else {
			// box is not checked, set field to disabled
			$("#timedifftext").prop('disabled', true);
		}
		// check wheter the checkbox is clicked
		$('#timediff').click(function(){ // if user clicked save
			if( $('#timediff').prop('checked')){
				// box is checked, set input field to NOT disabled
				$("#timedifftext").prop('disabled', false);
			}
			else {
				// set footer value input field to disabled
				$("#timedifftext").prop('disabled', true);
			}
		});
		/* END CHECKBOX backend footer */

		/* START CHECKBOX offline mode */
		// check backend footer checkbox onload
		if( $('#offline').prop('checked')){
			// box is checked, set input field to NOT disabled
			$("#offlinemsg").prop('disabled', false);
			$("#offlineimage").prop('disabled', false);
		}
		else {
			// box is not checked, set field to disabled
			$("#offlinemsg").prop('disabled', true);
			$("#offlineimage").prop('disabled', true);
		}
		// check wheter the checkbox is clicked
		$('#offline').click(function(){ // if user clicked save
			if( $('#offline').prop('checked')){
				// box is checked, set input field to NOT disabled
				$("#offlinemsg").prop('disabled', false);
				$("#offlineimage").prop('disabled', false);
			}
			else {
				// set footer value input field to disabled
				$("#offlinemsg").prop('disabled', true);
				$("#offlineimage").prop('disabled', true);
			}
		});
		/* END CHECKBOX backend fx */

		formmodified=0; // status
		$('form *').change(function(){ // if form has changed
			formmodified=1; // set status
			$('#savebutton').click(function(){ // if user clicked save
				formmodified=0; // do not warn user, just save.
			});
		});
		// now the function:
		window.onbeforeunload = confirmExit; // before close
		function confirmExit() {             // dialog
			if (formmodified == 1) {         // if form has changed
				return "Your changes may not be saved. Do you wish to leave the page?";
			}
		}
		// call tabCollapse: make the default bootstrap tabs responsive for handheld devices
		$('#tabs').tabCollapse({
			tabsClass: 'hidden-sm hidden-xs',
			accordionClass: 'visible-sm visible-xs'
		});
	});
</script>
<?php


// SAVE tpl settings
if(isset($_POST['save']))
{   // loop through $_POST items
    foreach ($_POST as $property => $value) {
        if ($property != "save") {
			// check setting and call corresponding function
			if (substr($property, -5, 5) == '-long')
			{   // LONG VALUE SETTINGS
				if (!\YAWK\settings::setLongSetting($db, $property, $value))
				{   // throw error
					\YAWK\alert::draw("warning", "Error", "Long Settings: Could not set long value <b>$value</b> of property <b>$property</b>","plugin=signup","4800");
				}
			}
			else
			{
				if ($property === "selectedTemplate")
				{
					\YAWK\template::setTemplateActive($db, $value);
				}

				// save value of property to database
				\YAWK\settings::setSetting($db, $property, $value, $lang);
			}

			if ($property === "robotsText-long")
			{
				\YAWK\sys::setRobotsText("../", $value);
			}
        }

    }
    // to ensure that language switching works correctly, reload page with given POST language
    \YAWK\sys::setTimeout("index.php?page=settings-system&lang=$_POST[backendLanguage]", 0);
}
?>

<?php
// get settings for editor
$editorSettings = \YAWK\settings::getEditorSettings($db, 14);
?>
<!-- include summernote css/js-->
<!-- include codemirror (codemirror.css, codemirror.js, xml.js) -->
<link rel="stylesheet" type="text/css" href="../system/engines/codemirror/codemirror.min.css">
<link rel="stylesheet" type="text/css" href="../system/engines/codemirror/themes/<?php echo $editorSettings['editorTheme']; ?>.css">
<link rel="stylesheet" type="text/css" href="../system/engines/codemirror/show-hint.min.css">
<script type="text/javascript" src="../system/engines/codemirror/codemirror-compressed.js"></script>
<script type="text/javascript" src="../system/engines/codemirror/auto-refresh.js"></script>

<!-- SUMMERNOTE -->
<link href="../system/engines/summernote/dist/summernote.css" rel="stylesheet">
<script src="../system/engines/summernote/dist/summernote.min.js"></script>
<script src="../system/engines/summernote/dist/summernote-cleaner.js"></script>
<script src="../system/engines/summernote/dist/summernote-image-attributes.js"></script>
<script src="../system/engines/summernote/dist/summernote-floats-bs.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// textarea that will be transformed into editor
		var editor = ('textarea#summernote');
		// summernote.init -
		// LOAD SUMMERNOTE IN CODEVIEW ON STARTUP
		$(editor).on('summernote.init', function() {
			// toggle editor to codeview
			$(editor).summernote('codeview.toggle');
		});

		// INIT SUMMERNOTE EDITOR
		$(editor).summernote({    // set editor itself
			height: <?php echo $editorSettings['editorHeight']; ?>,                 // set editor height
			minHeight: null,             // set minimum height of editor
			maxHeight: null,             // set maximum height of editor
			focus: true,                 // set focus to editable area after initializing summernote

			toolbar:
			{
				// no toolbar
			},
			// language for plugin image-attributes.js
			lang: '<?php echo $lang['CURRENT_LANGUAGE']; ?>',

			// powerup the codeview with codemirror theme
			codemirror: { // codemirror options
				theme: '<?php echo $editorSettings['editorTheme']; ?>',                       // codeview theme
				lineNumbers: true,             // display lineNumbers true|false
				undoDepth: <?php echo $editorSettings['editorUndoDepth']; ?>,                 // how many undo steps should be saved? (default: 200)
				smartIndent: <?php echo $editorSettings['editorSmartIndent']; ?>,             // better indent
				indentUnit: <?php echo $editorSettings['editorIndentUnit']; ?>,               // how many spaces auto indent? (default: 2)
				scrollbarStyle: null,                                                         // styling of the scrollbars
				matchBrackets: <?php echo $editorSettings['editorMatchBrackets']; ?>,         // highlight corresponding brackets
				autoCloseBrackets: <?php echo $editorSettings['editorCloseBrackets'];?>,      // auto insert close brackets
				autoCloseTags: <?php echo $editorSettings['editorCloseTags']; ?>,             // auto insert close tags after opening
				value: "<html>\n  " + document.documentElement.innerHTML + "\n</html>",       // all html
				mode: "css",                                                            // editor mode
				matchTags: {bothTags: <?php echo $editorSettings['editorMatchTags']; ?>},     // hightlight matching tags: both
				extraKeys: {
					"Ctrl-J": "toMatchingTag",                  // CTRL-J to jump to next matching tab
					"Ctrl-Space": "autocomplete"               // CTRL-SPACE to open autocomplete window
				},
				styleActiveLine: <?php echo $editorSettings['editorActiveLine']; ?>,           // highlight the active line (where the cursor is)
				autoRefresh: true
			},

			// plugin: summernote-cleaner.js
			// this allows to copy/paste from word, browsers etc.
			cleaner: { // does the job well: no messy code anymore!
				action: 'button', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
				newline: '<br>' // Summernote's default is to use '<p><br></p>'
			}
		}); // end summernote
	}); // end document ready
</script>

<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['SETTINGS'], $lang['SETTINGS_SYSTEM_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=settings-system\" class=\"active\" title=\"$lang[SETTINGS_EDIT]\"> $lang[SETTINGS_EDIT]</a></li>
        </ol></section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<div class="box box-default">
	<div class="box-body">

<form id="template-edit-form" action="index.php?page=settings-system" method="POST">
	<!-- <div class="nav-tabs-custom"> <!-- admin LTE tab style -->
	<div id="btn-wrapper" class="text-right">
		<button type="submit" id="savebutton" name="save" class="btn btn-success">
			<i id="savebuttonIcon" class="fa fa-check"></i> &nbsp;<?php print $lang['SAVE_SETTINGS']; ?>
		</button>
	</div>
	<!-- FORM -->
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" id="tabs" role="tablist">
		<li role="presentation" class="active"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab"><i class="fa fa-home"></i>&nbsp; <?php echo $lang['OVERVIEW'] ?></a></li>
		<li role="presentation"><a href="#frontend" aria-controls="frontend" role="tab" data-toggle="tab"><i class="fa fa-globe"></i>&nbsp; <?php echo $lang['FRONTEND'] ?></a></li>
		<li role="presentation"><a href="#backend" aria-controls="backend" role="tab" data-toggle="tab"><i class="fa fa-wrench"></i>&nbsp; <?php echo $lang['BACKEND'] ?></a></li>
		<li role="presentation"><a href="#system" aria-controls="system" role="tab" data-toggle="tab"><i class="fa fa-gears"></i>&nbsp; <?php echo $lang['SYSTEM'] ?></a></li>
		<li role="presentation"><a href="#database" aria-controls="database" role="tab" data-toggle="tab"><i class="fa fa-database"></i>&nbsp; <?php echo $lang['DATABASE'] ?></a></li>
		<li role="presentation"><a href="#robots" aria-controls="robots" role="tab" data-toggle="tab"><i class="fa fa-android"></i>&nbsp; <?php echo $lang['ROBOTS_TXT'] ?></a></li>
		<li role="presentation"><a href="#info" aria-controls="info" role="tab" data-toggle="tab"><i class="fa fa-info-circle"></i>&nbsp; <?php echo $lang['INFO'] ?></a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<!-- OVERVIEW -->
		<div role="tabpanel" class="tab-pane active" id="overview">
			<h3><?php echo $lang['OVERVIEW']; ?> <small><?php echo $lang['SETTINGS_SYSTEM_SUBTEXT']; ?></small></h3>
			<div class="row animated fadeIn">
				<div class="col-md-8">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo $lang['SETTINGS']; ?>  <small><?php echo $lang['SETTINGS_SUBTEXT']; ?> </small></h3>
						</div>
						<div class="box-body">
							<?php // print_r($settings);
							$i_settings = 0;
							$settings = \YAWK\settings::getAllSettingsIntoArray($db);
							// echo "<pre>"; echo print_r($lang); echo "</pre>";

							?>
							</div>
					</div>
				</div>
				<div class="col-md-4">
                    <?php \YAWK\settings::getFormElements($db, $settings, 1, $lang); ?>
				</div>
			</div>
		</div>

		<!-- FRONTEND -->
		<div role="tabpanel" class="tab-pane" id="frontend">
			<h3><?php echo $lang['FRONTEND']; ?> <small><?php echo $lang['FRONTEND_SUBTEXT']; ?></small></h3>
			<!-- frontend settings -->
			<div class="row animated fadeIn">
				<div class="col-md-4">
                    <!-- theme selector -->
					<?php \YAWK\settings::getFormElements($db, $settings, 3, $lang); ?>
				</div>
				<div class="col-md-4">
					<!-- publish settings -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 7, $lang); ?>
					<!-- user login settings -->
					<?php \YAWK\settings::getFormElements($db, $settings, 17, $lang); ?>
				</div>
				<div class="col-md-4">
					<!-- maintenance mode -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 8, $lang); ?>
				</div>
			</div>
		</div>

		<!-- BACKEND SETTINGS -->
		<div role="tabpanel" class="tab-pane" id="backend">
            <h3><?php echo $lang['BACKEND']; ?> <small><?php echo $lang['BACKEND_SUBTEXT']; ?></small></h3>
			<!-- backend settings -->
			<div class="row animated fadeIn">
				<div class="col-md-4">
                    <!-- backend settings -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 2, $lang); ?>
				</div>
				<div class="col-md-4">
                    <!-- footer settings -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 11, $lang); ?>
				</div>
				<div class="col-md-4">
					<?php \YAWK\settings::getFormElements($db, $settings, 12, $lang); ?>
				</div>
			</div>
		</div>

		<!-- SYSTEM TAB -->
		<div role="tabpanel" class="tab-pane" id="system">
			<!-- system settings -->
			<div class="row animated fadeIn">
				<div class="col-md-4">
                    <!-- server seettings -->
					<h3><?php echo $lang['SERVER']; ?> <small> <?php echo $lang['SERVER_SUBTEXT']; ?></small></h3>
					<?php \YAWK\settings::getFormElements($db, $settings, 9, $lang); ?>
					<?php \YAWK\settings::getFormElements($db, $settings, 16, $lang); ?>
				</div>
				<div class="col-md-4">
                    <!-- database settings -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 13, $lang); ?>
				</div>
				<div class="col-md-4">
                    <!-- syslog settings -->
                    <h3><i class="fa fa-code"></i> <?php echo $lang['EDITOR']; ?> <small> <?php echo $lang['EDITOR_SUBTEXT']; ?></small></h3>
                    <?php \YAWK\settings::getFormElements($db, $settings, 14, $lang); ?>
				</div>
			</div>
		</div>

		<!-- DATABASE -->
		<div role="tabpanel" class="tab-pane" id="database">
			<h3><?php echo $lang['DATABASE']; ?> <small><?php echo $lang['DATABASE_SUBTEXT']; ?></small></h3>
			<div class="row animated fadeIn">
				<div class="col-md-8">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo $lang['SETTINGS']; ?>  <small><?php echo $lang['SETTINGS_SUBTEXT']; ?> </small></h3>
						</div>
						<div class="box-body">
							<?php
							// echo "<h2>Language Array</h2><pre>"; echo print_r($lang); echo "</pre>";

							$dbTables = $db->get_tables();
							echo "<table class=\"table table-striped table-hover table-condensed table-responsive table-bordered\">
									<tr class=\"text-bold\"><td>ID</td>
										<td>TABLE</td>
									</tr>";
							foreach ($dbTables AS $id=>$table)
							{
								echo "<tr><td>$id</td><td>$table</td></tr>";
							}
							echo "</table>";
							?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<!-- syslog settings -->
					<h3><?php // echo $lang['SYSLOG']; ?> <small> <?php // echo $lang['SETTINGS']; ?></small></h3>
					<?php // \YAWK\settings::getFormElements($db, $settings, 0, $lang); ?>
				</div>
			</div>
		</div>

		<!-- ROBOTS.TXT -->
		<div role="tabpanel" class="tab-pane" id="robots">
			<h3><i class="fa fa-android"></i> <?php echo $lang['ROBOTS_TXT']; ?> <small><?php echo $lang['CONFIGURE']; ?></small></h3>
			<div class="row animated fadeIn">
				<div class="col-md-8">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo $lang['DATA_PRIVACY']."&nbsp;&amp;&nbsp;".$lang['PRIVACY']; ?>  <small><?php echo $lang['ROBOTS_SUBTEXT']; ?> </small></h3>
						</div>
						<div class="box-body">
							<label for="summernote"></label>
							<?php $content = \YAWK\sys::getRobotsText($db, "../"); ?>
							<textarea name="robotsText-long" cols="64" rows="28" id="summernote"><?php echo $content; ?></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-4">

					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo $lang['ROBOTS_TXT']; ?> <small> <?php echo $lang['HELP']; ?></small></h3>
						</div>
						<div class="box-body">
							<?php // \YAWK\settings::getFormElements($db, $settings, 0, $lang); ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- INFO -->
		<div role="tabpanel" class="tab-pane" id="info">
			<h3><?php echo $lang['INFO']; ?> <small><?php echo $lang['INFO_SUBTEXT']; ?></small></h3>
			<div class="row animated fadeIn">
				<div class="col-md-8">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo $lang['SETTINGS']; ?>  <small><?php echo $lang['SETTINGS_SUBTEXT']; ?> </small></h3>
						</div>
						<div class="box-body">
							<?php
							// echo "<h2>Language Array</h2><pre>"; echo print_r($lang); echo "</pre>";

							?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<!-- syslog settings -->
					<h3><?php echo $lang['SYSLOG']; ?> <small> <?php echo $lang['SETTINGS']; ?></small></h3>
					<?php \YAWK\settings::getFormElements($db, $settings, 0, $lang); ?>
				</div>
			</div>
		</div>

	</div>
	<!-- </div> <!-- ./ nav-tabs-custom -->
</form>

	</div>
</div>