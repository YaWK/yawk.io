<script type="text/javascript" >
/* start own JS bootstrap function 
...on document ready... letsego! */
$(document).ready(function() {
	
 /* needed to get it work in firefox */
 $('div.btn-group .btn').click(function(){
 	/* find + set attribute checked */
  $(this).find('input:radio').attr('checked', true);	
  });
  /* *****************************************************
 /* @ FB Button  */
 	/* by click "on button */
		$("#fbon").click(function(){ 
	/* toggle colors 
	   change 'on button's css' class to green */
		$('#fbon').removeClass("btn").addClass("btn btn-success"); 
	/* change 'off button's' css color to default btn  */
		$('#fboff').removeClass("btn btn-danger").addClass("btn"); 
	/* animate: fade in the url textfield */	
		$("#facebookurl").fadeIn('fast', function() {
			  /* Animation complete
			 set focus on url textfield */
			$('#fburl').focus();
		  	/* ...& do other things */
		  });	
		});	/* end click function fb on button */

 /* by click "off button */
	$("#fboff").click(function(){
		/* toggle colors + fade out textfield */
		$('#fbon').removeClass("btn btn-success").addClass("btn");
		$('#fboff').removeClass("btn").addClass("btn btn-danger");
		$("#facebookurl").fadeOut('fast', function() {
		    /* Animation complete.
         ...& do other things */
		  });
	}); /* end click function fb off button */
	
  /* ***************************************************** 
 /* @ TW Button  */
		$("#twon").click(function(){ 
		$('#twon').removeClass("btn").addClass("btn btn-success"); 
		$('#twoff').removeClass("btn btn-danger").addClass("btn"); 
		$("#twitterurl").fadeIn('fast', function() {
			  /* Animation complete */
			$('#twurl').focus();
		  });	
		});	/* end click function tw on button */

		$("#twoff").click(function(){
		$('#twon').removeClass("btn btn-success").addClass("btn");
		$('#twoff').removeClass("btn").addClass("btn btn-danger");
		$("#twitterurl").fadeOut('fast', function() {
		    /* Animation complete. */
        });
	}); /* end click function tw off button */
	
  /* *****************************************************
 /* @ OFFLINE Button  */
		$("#offlineon").click(function(){ 
		$('#offlineon').removeClass("btn").addClass("btn btn-success"); 
		$('#offlineoff').removeClass("btn btn-danger").addClass("btn"); 
		$("#offline").fadeOut('fast', function() {
			  /* Animation complete */
			$('#offline').focus();
		  });	
		});	/* end click function offline on button */

	$("#offlineoff").click(function(){
		$('#offlineon').removeClass("btn btn-success").addClass("btn");
		$('#offlineoff').removeClass("btn").addClass("btn btn-danger");
		$("#offline").fadeIn('fast', function() {
		    /* Animation complete. */
		  });
	}); /* end click function offline off button */	
	
  /* *****************************************************
 /* @ timediff Button  */
		$("#timediffon").click(function(){ 
		$('#timediffon').removeClass("btn").addClass("btn btn-success"); 
		$('#timediffoff').removeClass("btn btn-danger").addClass("btn"); 
		$("#timediff").fadeIn('fast', function() {
			  /* Animation complete */
			$('#timediff').focus();
		  });	
		});	/* end click function tw on button */

		$("#timediffoff").click(function(){
		$('#timediffon').removeClass("btn btn-success").addClass("btn");
		$('#timediffoff').removeClass("btn").addClass("btn btn-danger");
		$("#timediff").fadeOut('fast', function() {
		    /* Animation complete. */
        });
	}); /* end click function tw off button */
}); /* end JS function */
</script>

<?PHP
/* draw Title on top */
 \YAWK\backend::getTitle($lang['SETTINGS_SYSTEM'],$lang['SETTINGS_SYSTEM_SUBTEXT']);
?>

	
<?php
  if(isset($_POST['save'])){
    foreach($_POST as $property=>$value){
   if($property != "save"){
     \YAWK\settings::setSetting($property,$value);
   }
 }
  }
?>



<!-- FORM -->
<form class="form" action="index.php?page=settings-system" method="POST">

<ul class="nav nav-pills">
  <li class="active"><a href="#site" data-toggle="tab">Site</a></li>
  <li><a href="#social" data-toggle="tab">Social</a></li>
  <li><a href="#server" data-toggle="tab">Server</a></li>
</ul>


<!-- TAB CONTENT -->
<div class="tab-content">
<?php
// get default settings for toggleswitches 
$offline_state=\YAWK\settings::getSetting("offline");
$timediff_state=\YAWK\settings::getSetting("timediff");
  if ($offline_state === '1'){
	$offline_on="btn";
	$offline_off="btn btn-danger";		   	
	}
  else {
	$offline_on="btn btn-success";
	$offline_off="btn";
	$offline_vis = "display:none;";  			   		
	}
  if ($timediff_state === '0'){
	$timediff_on="btn";
	$timediff_off="btn btn-danger";
	$timediff_vis = "display:none;"; 			   	
	}
  else {
	$timediff_on="btn btn-success";
	$timediff_off="btn";	
	}
?>
<!-- SITE -->
<div class="tab-pane active" id="site">
 <div class="span6">

  <!-- TEMPLATE SELECT -->  
  <div class="ownbox"> 
  	<h3>Design <small>set active template</small></h3>
       <select class="form-control" name="selectedTemplate">
	     <option value="<?php echo \YAWK\template::getCurrentTemplateId(); ?>"><?php echo \YAWK\template::getCurrentTemplateName("admin"); ?></option>
   
			<?php /* foreach to fetch template select fields */
			  foreach(\YAWK\template::getTemplates() as $template){
			  
			    echo "<option value=\"".$template['id']."\"";
			
			if (isset($_POST['template'])) {
	  			if($_POST['template'] === $template['id']){
	            echo " selected=\"selected\"";
	          }
			}
			    echo ">".$template['name']."</option>";
			  }
			?>
		</select>
	</div> <!-- end template select --> 
 
 <br>
 <!-- OFFLINE STATUS -->
  <div class="ownbox"> 
  	<h3>Site <small>Online / Offline Status</small></h3>
   	  <!-- OFFLINE ON BUTTON -->
			<div class="btn-group" data-toggle="buttons-radio">
			 <button id="offlineon" type="button" value="0" class="<?php echo $offline_on; ?>" data-toggle="button">
			  <input type="radio" name="offline" value="0"/> Online </input>
			 </button>
		   <!-- OFFLINE OFF BUTTON -->
			 <button id="offlineoff" type="button" value="1" class="<?php echo $offline_off; ?>" data-toggle="button">
			  <input type="radio" name="offline" value="1"/> Offline </input>
			 </button>
			</div><br>
	
<!--		   <div class="btn-group" data-toggle="buttons-radio">
		    <button type="button" class="btn btn-success" checked="checked">Online</button>
		    <button type="button" class="btn">Offline</button>
			</div><br> -->
	 <fieldset style="width:90%; <?php echo $offline_vis; ?>" id="offline">
		 <legend>Offline Message</legend>
		  <textarea class="form-control" name="offlinemsg" rows="4" style="width:90%"><?php echo \YAWK\settings::getSetting("offlinemsg"); ?></textarea></label>
		  <br />
	    <legend>Path to Offline Image</legend>
		  <input class="form-control" name="offlineimage" type="text" value="<?php echo \YAWK\settings::getSetting("offlineimage"); ?>" placeholder="images/"> </input>
	 </fieldset>
  </div> <!-- end site ownbox -->
  <br>
  <!-- SITE PUBLISH SETTINGS -->
      <div class="ownbox">
  			<h3>Publish <small>Teaser Text Settings</small></h3>
  			 <hr>
			     <legend>Show Time until Publish</legend>
			     <!-- publish time difference on button -->
				  <div class="btn-group" data-toggle="buttons-radio">
			      <button id="timediffon" type="button" value="1" class="<?php echo $timediff_on; ?>" data-toggle="button">
					  <input type="radio" name="timediff" value="1"/>On </input>
					</button>
				 <!-- publish time differece off button -->
				   <button id="timediffoff" type="button" value="0" class="<?php echo $timediff_off; ?>" data-toggle="button">
					  <input type="radio" name="timediff" value="0"/>Off </input>
					</button>
			 	  </div>
			 	  <br />
			   <fieldset style="width:90%; <?php echo $timediff_vis; ?>" id="timediff">
					<legend>Default Publish Teaser Text</legend>
					<textarea class="form-control" name="timedifftext" rows="4" style="width:100%"><?php echo \YAWK\settings::getSetting("timedifftext"); ?></textarea>
			  </fieldset>
      </div> <!-- END SITE PUBLISH SETTINGS -->
      
 </div> <!-- end span6 -->
 <!-- SECOND COL -->
 <div class="span6">
  <div class="ownbox">
  	<h3>Meta Tags <small>Global Meta Data</small></h3>
   <hr>
	 <fieldset style="width:90%;">
       <legend>Site Title</legend>
  			<inputclass="form-control" name="sitename" type="text" value="<?php echo \YAWK\settings::getSetting("sitename"); ?>" placeholder="YaWK CMS">
  			<legend>Author</legend>
 			<input class="form-control" name="siteauthor" type="text" value="<?php echo \YAWK\settings::getSetting("siteauthor"); ?>" placeholder="Site Author">
			 <br>
		 <legend>Global Meta Text</legend>
			<textarea class="form-control" name="globalmetatext" rows="4" style="width:100%"><?php echo \YAWK\settings::getSetting("globalmetatext"); ?></textarea></label>
 			 <br />
		 <legend>Global Meta Keywords</legend>
			<textarea class="form-control" name="globalmetakeywords" rows="4" style="width:100%"><?php echo \YAWK\settings::getSetting("globalmetakeywords"); ?></textarea>
  			 <br />
  </div> <!-- end meta ownbox -->
 </div> <!-- end span6 -->
</div> <!-- END TAB pane (1) SITE --> 

  
<?php
// get default settings for toggleswitches 
$fb_state=YAWK\settings::getSetting("facebookstatus");
$tw_state=YAWK\settings::getSetting("twitterstatus");
  if ($fb_state === '0'){
	$fb_on="btn";
	$fb_off="btn btn-danger";
	$checked1 = "";
	$checked2 = "checked=\"checked\"";
	$fb_vis = "display:none;";	  			   	
	}
  else {
	$fb_on="btn btn-success";
	$fb_off="btn";
	$checked1 = "checked=\"checked\"";
	$checked2 = "";	  			   		
	}
  if ($tw_state === '0'){
	$tw_on="btn";
	$tw_off="btn btn-danger";
	$checked1 = "";
	$checked2 = "checked=\"checked\"";
	$tw_vis = "display:none;";	  			   	
  	}
  else {
	$tw_on="btn btn-success";
	$tw_off="btn";
	$checked1 = "checked=\"checked\"";
	$checked2 = "";	  			   		
	}
?>
  
<!-- TAB SOCIAL -->
<div class="tab-pane" id="social">
 <div class="span6">
  <div class="ownbox">
  <h3>Facebook <small>Settings</small></h3>
  <hr>
  <legend>Facebook?</legend>
   <!-- FB ON BUTTON -->
	<div class="btn-group" data-toggle="buttons-radio">
	 <button id="fbon" type="button" value="1" class="<?php echo $fb_on; ?>" data-toggle="button">
	  <input type="radio" name="facebookstatus" value="1"/>On </input>
	 </button>
   <!-- FB OFF BUTTON -->
	 <button id="fboff" type="button" value="0" class="<?php echo $fb_off; ?>" data-toggle="button">
	  <input type="radio" name="facebookstatus" value="0"/>Off </input>
	 </button>
	</div>
	<!-- FB URL FIELD -->
	<fieldset style="width:90%; <?php echo $fb_vis; ?>" id="facebookurl">
    <legend>Your Facebook URL</legend>
    <input class="form-control" id="fburl" type="text" value="<?php echo \YAWK\settings::getSetting("facebookurl"); ?>" name="facebookurl" placeholder="http://www.facebook.com/PageID"> </input>
   </fieldset>

  </div><!-- end facebook ownbox -->
 </div> <!-- end span6 social-left -->
 <!-- SOCIAL - RIGHT -->     
 <div class="span6">
  <div class="ownbox">
  <h3>Twitter <small>Settings</small></h3>
  <hr>
	  <legend>Twitter?</legend>
	   <!-- TW ON BUTTON -->
		<div class="btn-group" data-toggle="buttons-radio">
		 <button id="twon" type="button" value="1" class="<?php echo $tw_on; ?>" data-toggle="button">
		  <input type="radio" name="twitterstatus" value="1"/>On </input>
		 </button>
		<!-- TW OFF BUTTON -->
		 <button id="twoff" type="button" value="0" class="<?php echo $tw_off; ?>" data-toggle="button">
		  <input type="radio" name="twitterstatus" value="0"/>Off </input>
		 </button>
		</div>
		<!-- TW URL TEXTFIELD -->
	   <fieldset style="width:90%; <?php echo $tw_vis; ?>" id="twitterurl">
	     <legend>Twitter URL</legend>
	     <input class="form-control" type="text" value="<?php echo \YAWK\settings::getSetting("twitterurl"); ?>" name="twitterurl" placeholder="http://www.twitter.com/yourID"> </input>
	  </fieldset>
      </div> <!-- end twitter ownbox -->
  </div> <!-- end span6  -->
</div> <!-- end TAB PANE SOCIAL -->
  
<!-- TAB SERVER -->
  <div class="tab-pane" id="server">
      <div class="span6">
      <div class="ownbox">
  			<h3>System <small>YaWK, Server, Settings</small></h3>
  			 <hr>
  			 <!-- FOLDER PREFIX -->
			   <fieldset style="width:90%">
			     <legend>Folder Prefix</legend>
			     <input class="form-control" type="text" value="<?php echo \YAWK\settings::getSetting("dirprefix"); ?>" name="dirprefix" placeholder="/YaWK-cms"> </input>
			  <!-- SITE URL -->
			     <legend>Site URL</legend>
			     <input class="form-control" type="text" value="<?php echo \YAWK\settings::getSetting("host"); ?>" name="host" placeholder="http://localhost"> </input>
			  
			  </fieldset>
      </div>
      <!-- EMAIL SETTINGS -->
      <div class="ownbox">
  			<h3>Email <small>Mail Settings</small></h3>
  			 <hr>
			   <fieldset style="width:90%">
			     <legend>from</legend>
			     <input class="form-control" type="text" value="<?php echo \YAWK\settings::getSetting("emailfrom"); ?>" name="emailfrom" placeholder="yourname@email.com"> </input>
			     
					<legend>Default Registration Message</legend>
					<textarea class="form-control" name="defaultemailtext" rows="4" style="width:100%"><?php echo \YAWK\settings::getSetting("defaultemailtext"); ?></textarea>
			  
			  </fieldset>
      </div> <!-- END EMAIL SETTINGS -->
      </div> <!-- end span6 -->     

  <!-- 2nd col -->
  <!-- MYSQL SETTINGS -->
      <div class="span6">
      <div class="ownbox">
  			<h3>Database <small>MySQL Server Settings</small></h3>
  			 <hr>
			   <fieldset style="width:90%">
			     <legend>MySQL Host</legend>
			     <input class="form-control" type="text" value="<?php echo \YAWK\settings::getSetting("mysqlhost"); ?>" name="mysqlhost" placeholder="http://localhost"> </input>
			  
			     <legend>MySQL Port</legend>
			     <input class="form-control" type="text" value="<?php echo \YAWK\settings::getSetting("mysqlport"); ?>" name="mysqlport" placeholder="3306"> </input>
			     
			     <legend>DB Name</legend>
			     <input class="form-control" type="text" value="<?php echo \YAWK\settings::getSetting("dbname"); ?>" name="dbname" placeholder="yawk_cms"> </input>
			     
			     <legend>Prefix</legend>
			     <input class="form-control" type="text" value="<?php echo \YAWK\settings::getSetting("dbprefix"); ?>" name="dbprefix" placeholder="cms_"> </input>
			     
			     <legend>MySQL Admin</legend>
			     <input class="form-control" type="text" value="<?php echo \YAWK\settings::getSetting("mysqlname"); ?>" name="mysqlname" placeholder="root"> </input>
			     <legend>Password</legend>
			     <input class="form-control" type="text" value="<?php echo \YAWK\settings::getSetting("mysqlpwd"); ?>" name="mysqlpwd" placeholder="********"> </input>
			  </fieldset>
      </div> <!-- end mysql ownbox -->
      
      <div class="ownbox"> 
      <!-- SESSION -->
  			<h3>Session <small>Lifetime & Cookie</small></h3>
  			 <hr>
			   <fieldset style="width:90%">
			     <legend>Session Time</legend>
			     <input class="form-control" type="text" value="<?php echo \YAWK\settings::getSetting("sessiontime"); ?>" name="sessiontime" placeholder="60"> </input>
			  
			  </fieldset>
      </div> <!-- end session ownbox -->
      
      </div> <!-- end span6 -->  
  </div> <!-- end tab pane -->
  
</div> <!-- end tab content -->
<br />
<!-- SUBMIT -->
 <input class="btn btn-danger" id="savebutton" type="submit" name="save" value="Speichern" /> 
 <br /><br />
</form>
</div> <!-- end fluid row -->
</div> <!-- end box-page -->
   