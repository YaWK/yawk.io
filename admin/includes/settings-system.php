<!-- color picker -->
<script type="text/javascript" src="../system/engines/jquery/jscolor/jscolor.js"></script>
<!-- --><script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
<!-- JS GO -->
<script type="text/javascript">
	/* reminder: check if form has changed and warns the user that he needs to save. */
	$(document).ready(function() {
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
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['SETTINGS'], $lang['SETTINGS_SYSTEM_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=settings-system\" class=\"active\" title=\"Edit Settings\"> Settings</a></li>
        </ol></section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="template-edit-form" action="index.php?page=template-edit" method="POST">
	<!-- <div class="nav-tabs-custom"> <!-- admin LTE tab style -->
	<div id="btn-wrapper" class="text-right">
		<input id="savebutton" type="submit" class="btn btn-success" name="save" value="<?php echo $lang['SAVE_SETTINGS']; ?>">
	</div>
	<!-- FORM -->
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" id="tabs" role="tablist">
		<li role="presentation" class="active"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab"><i class="fa fa-home"></i>&nbsp; <?php echo $lang['OVERVIEW'] ?></a></li>
		<li role="presentation"><a href="#frontend" aria-controls="fonts" role="tab" data-toggle="tab"><i class="fa fa-globe"></i>&nbsp; Front End</a></li>
		<li role="presentation"><a href="#backend" aria-controls="typo" role="tab" data-toggle="tab"><i class="fa fa-wrench"></i>&nbsp; Back End</a></li>
		<li role="presentation"><a href="#system" aria-controls="layout" role="tab" data-toggle="tab"><i class="fa fa-gears"></i>&nbsp; System</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<!-- OVERVIEW -->
		<div role="tabpanel" class="tab-pane active" id="overview">
			<h3>Overview <small>Template Statistics</small></h3>
			<!-- list GOOGLE FONTS -->
			<div class="row animated fadeIn">
				<div class="col-md-8">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">Template Details <small>of the current active theme</small></h3>
						</div>
						<div class="box-body">
							<?php // print_r($settings);
							$i_settings = 0;
							$settings = \YAWK\settings::getAllSettingsIntoArray($db);
							?>
							</div>
					</div>
				</div>
				<div class="col-md-4">
					...

				</div>
			</div>
		</div>

		<!-- FONTS -->
		<div role="tabpanel" class="tab-pane" id="frontend">
			<h3>Frontend <small>all settings that belongs to your website frontend</small></h3>
			<!-- list GOOGLE FONTS -->
			<div class="row animated fadeIn">
				<div class="col-md-4">
                    <h3><i class="fa fa-picture-o"></i> Theme <small> set active design template</small></h3>
					<?php \YAWK\settings::getFormElements($db, $settings, 3, $lang); ?>
				</div>
				<div class="col-md-4">
					<!-- publish settings -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 7, $lang); ?>
				</div>
				<div class="col-md-4">
					<!-- maintenance mode -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 8, $lang); ?>
				</div>
			</div>
		</div>

		<!-- TYPO -->
		<div role="tabpanel" class="tab-pane" id="backend">
			<!-- typography styles -->
			<div class="row animated fadeIn">
				<div class="col-md-4">
					<h3>Text <small>Settings</small></h3>
					...
					...
					...

					<h3>Link <small>Colors </small></h3>
					...
				</div>
				<div class="col-md-4">
					<h3>Heading <small>Font Size</small></h3>
					...
				</div>
				<div class="col-md-4">
					<h3>Heading <small>Colors </small></h3>
					...
				</div>
			</div>
		</div>

		<!-- BODY-->
		<div role="tabpanel" class="tab-pane" id="system">
			<!-- typography styles -->
			<div class="row animated fadeIn">
				<div class="col-md-4">
					<h3>Server <small> Settings</small></h3>
					<?php \YAWK\settings::getFormElements($db, $settings, 1, $lang); ?>
				</div>
				<div class="col-md-4">
					<h3>Main Shadow <small>around all positions</small></h3>
					...
					<h3>List Group <small>Colors</small></h3>
					...
				</div>
				<div class="col-md-4">
					<h3>Background <small>Image</small></h3>
					...
					...
					...
				</div>
			</div>
		</div>

	</div>

	<!-- </div> <!-- ./ nav-tabs-custom -->
</form>