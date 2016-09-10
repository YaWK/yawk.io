<?php /* SETTINGS.PHP -- stores all changable template settings. */

// $pageID = YAWK\sys::getPageID();
// better: $pageID = $currentpage->id;
// $status = "";

// get HEADER FONT from db
$headingFont = YAWK\template::getActivegfont($db, "", "heading-gfont");

// get all settings for active template
$tpl_settings = YAWK\template::getTemplateSettingsArray($db);
?>

<style type="text/css">
   body {
       color: #<?PHP echo $tpl_settings['text-fontcolor']; ?>;
       background-color: #<?PHP echo $tpl_settings['body-bgcolor']; ?>;
       text-shadow: <?PHP echo $tpl_settings['body-text-shadow']; echo "#".$tpl_settings['body-text-shadow-color']; ?>;
       font-size: <?PHP echo $tpl_settings['body-text-size']; ?>;
       filter: dropshadow(color=#ccc, offx=1, offy=1);
       margin-top: <?PHP echo $tpl_settings['body-margin-top']; ?>;

/*       background-image: url('media/images/bg-1680-circle.jpg');
       background-repeat:no-repeat;
       background-position:center;
       background-attachment:fixed;
       background-size: cover; */
       }

   a {
       color: #<?PHP echo $tpl_settings['a-link']; ?>;
       font-weight: bold;
       text-decoration: <?PHP echo $tpl_settings['decoration-link']; ?>;   }
   a:visited {
       color: #<?PHP echo $tpl_settings['visited-link']; ?>; }
   a:hover {
       color: #<?PHP echo $tpl_settings['hover-link']; ?>;
       text-decoration: <?PHP echo $tpl_settings['hoverdecoration-link']; ?>; }

   .btn {
       color: #<?PHP echo $tpl_settings['buttontext-link']; ?> !important;
   }

   #main-pos {
       box-shadow: <?PHP echo $tpl_settings['main-box-shadow']; ?> #<?PHP echo $tpl_settings['main-box-shadow-color']; ?>;
   }
   #footer {
       box-shadow: <?PHP echo $tpl_settings['main-box-shadow']; ?> #<?PHP echo $tpl_settings['main-box-shadow-color']; ?>;
   }
   #footer-copyright {
       box-shadow: <?PHP echo $tpl_settings['main-box-shadow']; ?> #<?PHP echo $tpl_settings['main-box-shadow-color']; ?>;
   }


  .well {
    min-height: <?PHP echo $tpl_settings['well-min-height']; ?>;
    padding: <?PHP echo $tpl_settings['well-padding']; ?>;
    margin-top:<?PHP echo $tpl_settings['well-margin-top']; ?>;
    margin-bottom: <?PHP echo $tpl_settings['well-margin-bottom']; ?>;
    background-color: #<?PHP echo $tpl_settings['well-bgcolor']; ?>;
    border: <?PHP echo $tpl_settings['well-border']; ?>; #<?PHP echo $tpl_settings['well-border-color']; ?>;
    border-radius: <?PHP echo $tpl_settings['well-border-radius']; ?>;
    -webkit-box-shadow: <?PHP echo $tpl_settings['well-shadow']; ?> <?PHP echo $tpl_settings['well-shadow-color']; ?>;
    box-shadow: <?PHP echo $tpl_settings['well-shadow']; ?> <?PHP echo $tpl_settings['well-shadow-color']; ?>;

  }

   h1 {
	   <?PHP echo $headingFont; ?>
       color: #<?PHP echo $tpl_settings['h1-fontcolor']; ?>;

   }
   h2 {
	   <?PHP echo $headingFont; ?>
       color: #<?PHP echo $tpl_settings['h2-fontcolor']; ?>;
   }
   h3 {
	   <?PHP echo $headingFont; ?>
       color: #<?PHP echo $tpl_settings['h3-fontcolor']; ?>;
   }
   h4 {
	   <?PHP echo $headingFont; ?>
       color: #<?PHP echo $tpl_settings['h4-fontcolor']; ?>;
   }
   h5 {
	   <?PHP echo $headingFont; ?>
       color: #<?PHP echo $tpl_settings['h5-fontcolor']; ?>;
   }
   h6 {
	   <?PHP echo $headingFont; ?>
       color: #<?PHP echo $tpl_settings['h6-fontcolor']; ?>;
   }
   h1 small,
   h2 small,
   h3 small,
   h4 small,
   h5 small,
   h6 small,
   .h1 small,
   .h2 small,
   .h3 small,
   .h4 small,
   .h5 small,
   .h6 small,
   h1 .small,
   h2 .small,
   h3 .small,
   h4 .small,
   h5 .small,
   h6 .small,
   .h1 .small,
   .h2 .small,
   .h3 .small,
   .h4 .small,
   .h5 .small,
   .h6 .small {
       font-weight: normal;
       line-height: 1;
       color: #<?PHP echo $tpl_settings['smalltag-fontcolor']; ?>;
   }

   .list-group-item {
       color: #<?PHP echo $tpl_settings['fontcolor-listgroup']; ?>;
       background-color: #<?PHP echo $tpl_settings['background-listgroup']; ?>;
   }

   .well {
       background-color: #<?PHP echo $tpl_settings['well-bgcolor']; ?>;
   }

   .navbar {
       -webkit-box-shadow: 2px 2px 24px 2px #0a0a0a;
       box-shadow: 2px 2px 24px 2px #0a0a0a;
   }
   .navbar-default {
       text-shadow: 1px 0px #<?PHP echo $tpl_settings['fontshadow-menucolor']; ?>;
       filter: dropshadow(color=#<?PHP echo $tpl_settings['fontshadow-menucolor']; ?>, offx=1, offy=1);
       background-color: #<?PHP echo $tpl_settings['default-menubgcolor']; ?>;
       border-color: #<?PHP echo $tpl_settings['border-menubgcolor']; ?>;
   }
   .navbar-default .navbar-brand {
       color: #<?PHP echo $tpl_settings['brand-menucolor']; ?>;
   }
   .navbar-default .navbar-brand:hover,
   .navbar-default .navbar-brand:focus {
       color: #<?PHP echo $tpl_settings['brandhover-menucolor']; ?>;
       background-color: transparent;
   }
   .navbar-default .navbar-text {
       color: #<?PHP echo $tpl_settings['font-menucolor']; ?>;
   }
   .navbar-default .navbar-nav > li > a {
       color: #<?PHP echo $tpl_settings['font-menucolor']; ?>;
   }
   .navbar-default .navbar-nav > li > a:hover,
   .navbar-default .navbar-nav > li > a:focus {
       color: #<?PHP echo $tpl_settings['fonthover-menucolor']; ?>;
       background-color: transparent;
   }
   .navbar-default .navbar-nav > .active > a,
   .navbar-default .navbar-nav > .active > a:hover,
   .navbar-default .navbar-nav > .active > a:focus {
       color: #<?PHP echo $tpl_settings['fontactive-menucolor']; ?>;
       background-color: #<?PHP echo $tpl_settings['active-menubgcolor']; ?>;
   }
   .navbar-default .navbar-nav > .disabled > a,
   .navbar-default .navbar-nav > .disabled > a:hover,
   .navbar-default .navbar-nav > .disabled > a:focus {
       color: #<?PHP echo $tpl_settings['fontdisabled-menucolor']; ?>;
       background-color: transparent;
   }
   .navbar-default .navbar-toggle {
       border-color: #<?PHP echo $tpl_settings['toggle-menubgcolor']; ?>;
   }
   .navbar-default .navbar-toggle:hover,
   .navbar-default .navbar-toggle:focus {
       border-color:#<?PHP echo $tpl_settings['toggle-menubgcolor']; ?>;
   }
   .navbar-default .navbar-toggle .icon-bar {
       background-color:#<?PHP echo $tpl_settings['iconbar-menubgcolor']; ?>;
   }
   .navbar-default .navbar-collapse,
   .navbar-default .navbar-form {
       border-color: #<?PHP echo $tpl_settings['border-menubgcolor']; ?>;
   }
   .navbar-default .navbar-nav > .open > a,
   .navbar-default .navbar-nav > .open > a:hover,
   .navbar-default .navbar-nav > .open > a:focus {
       background-color: #<?PHP echo $tpl_settings['active-menubgcolor']; ?>;
       color: #<?PHP echo $tpl_settings['fontactive-menucolor']; ?>;
   }
   @media (max-width: 767px) {
       .navbar-default .navbar-nav .open .dropdown-menu > li > a {
           color: #<?PHP echo $tpl_settings['font-menucolor']; ?>;
       }
       .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
       .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
           color: #<?PHP echo $tpl_settings['fonthover-menucolor']; ?>;
           background-color: transparent;
       }
       .navbar-default .navbar-nav .open .dropdown-menu > .active > a,
       .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
       .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
           color: #<?PHP echo $tpl_settings['fontactive-menucolor']; ?>;
           background-color: #<?PHP echo $tpl_settings['active-menubgcolor']; ?>;
       }
       .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a,
       .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:hover,
       .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:focus {
           color: #<?PHP echo $tpl_settings['fontdisabled-menucolor']; ?>;
           background-color: transparent;
       }
   }
   .navbar-default .navbar-link {
       color: #<?PHP echo $tpl_settings['font-menucolor']; ?>;
   }
   .navbar-default .navbar-link:hover {
       color: #<?PHP echo $tpl_settings['fonthover-menucolor']; ?>;
   }
   .navbar-default .btn-link {
       color: #<?PHP echo $tpl_settings['font-menucolor']; ?>;
   }
   .navbar-default .btn-link:hover,
   .navbar-default .btn-link:focus {
       color: #<?PHP echo $tpl_settings['fonthover-menucolor']; ?>;
   }
   .navbar-default .btn-link[disabled]:hover,
   fieldset[disabled] .navbar-default .btn-link:hover,
   .navbar-default .btn-link[disabled]:focus,
   fieldset[disabled] .navbar-default .btn-link:focus {
       color: #<?PHP echo $tpl_settings['fontdisabled-menucolor']; ?>;
   }

   .dropdown-menu {
       position: absolute;
       top: 100%;
       left: 0;
       z-index: 1000;
       display: none;
       float: left;
       min-width: 160px;
       padding: 5px 0;
       margin: 2px 0 0;
       list-style: none;
       font-size: 14px;
       text-align: left;
       background-color: #<?PHP echo $tpl_settings['background-menudropdowncolor']; ?>;
       border: 1px solid #<?PHP echo $tpl_settings['border-menudropdowncolor']; ?>;
       border-radius: 4px;
       -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
       box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
       -webkit-background-clip: padding-box;
       background-clip: padding-box;
   }
   .dropdown-menu.pull-right {
       right: 0;
       left: auto;
   }
   .dropdown-menu > li > a {
       display: block;
       padding: 3px 20px;
       clear: both;
       font-weight: normal;
       line-height: 1.42857143;
       color: #<?PHP echo $tpl_settings['border-menudropdowncolor']; ?>;
       white-space: nowrap;
   }
   .dropdown-menu > li > a:hover,
   .dropdown-menu > li > a:focus {
       text-decoration: none;
       color: #<?PHP echo $tpl_settings['fonthover-menudropdowncolor']; ?>;
       background-color: #<?PHP echo $tpl_settings['hoverbg-menudropdowncolor']; ?>;
   }
   .dropdown-menu > .active > a,
   .dropdown-menu > .active > a:hover,
   .dropdown-menu > .active > a:focus {
       color: #<?PHP echo $tpl_settings['fontactive-menudropdowncolor']; ?>;
       text-decoration: none;
       outline: 0;
       background-color: #<?PHP echo $tpl_settings['activebg-menudropdowncolor']; ?>;
   }
   .dropdown-menu > .disabled > a,
   .dropdown-menu > .disabled > a:hover,
   .dropdown-menu > .disabled > a:focus {
       color: #<?PHP echo $tpl_settings['disabled-menudropdowncolor']; ?>;
   }

    /*     background-color: <?php // echo YAWK\template::getColor("body-bgcolor"); ?>;
         background-image: url(<?php // echo YAWK\sys::getHost(); echo YAWK\sys::getDirPrefix();echo"/"; echo YAWK\template::getPageBgImage($pageID); ?>);
         background-repeat:no-repeat;
         background-attachment:fixed;
            background-position:center top;
     color: <?php // echo YAWK\template::getColor("fore-fontcolor"); ?>;
	    font-size: <?php // echo YAWK\template::getTemplateSetting("text-fontsize"); ?>;
	    <?php // echo YAWK\template::getActivegfont($status); ?>
     }
     */
   /* jQUERY form validate error mesage text color */
    .error {
        color: #<?PHP echo $tpl_settings['form-error']; ?>;
        font-weight: bold;
    }
    .valid {
        color: #<?PHP echo $tpl_settings['form-valid']; ?>;
        font-weight: bold;
    }
    .jumbotron {
        height: 300px;
        background: #000;
        margin-bottom: 0;
        padding-left: 0px;
        padding-right: 0px;
        background-size: cover;
        text-align: center;
    }
    .btn-default {
        background: #666;
        
    }
   .btn-default:hover
   {
       background-color: #333;
   }
   .jumbotron-dark {
       height: auto;
       background: #222;
       margin-bottom: 0;
   }

   .img-thumbnail {
       -webkit-filter: brightness(100%);
   }
   .img-thumbnail:hover {
       -webkit-filter: brightness(110%);
   }
   #bodyFX {
     display: none;
    }
   label {
       display: block;
       margin-bottom: 0px;
       font-size: 12px;
       color: #888;
   }
    .jumbotron-dark-text {
    <?PHP echo $headingFont; ?>
        color: #ccc;
        font-size: 1.4em;
    }
    .container-inner {
        margin-left:1.2em;
        margin-right:1.2em;
    }
    .jumbotron-line {
        border:dashed #333 1px;
    }
    .chapter1 {
        background-image: url("media/images/header-07.jpg");
        margin-top: -36px;
        margin-left: -45px;
        margin-right: -45px;
        height: 288px;
    }
   .chapter2 {
       background-image: url("media/images/header-08.jpg");
       margin-top: -36px;
       margin-left: -45px;
       margin-right: -45px;
       height: 288px;
   }
   .chapter3 {
       background-image: url("media/images/header-10.jpg");
       margin-top: -36px;
       margin-left: -45px;
       margin-right: -45px;
       height: 288px;
   }
   .img-static {
       background-image: url("media/images/header-07.jpg");
       margin-top: -0px;
       margin-left: -0px;
       margin-right: -30px;
       height: 288px;
   }

   .embed-container {
       position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%;
   }
   .embed-container iframe, .embed-container object, .embed-container embed {
       position: absolute; top: 0; left: 0; width: 100%; height: 100%;
   }

   .img-shadow {
       -webkit-box-shadow: 2px 2px 12px 2px #0a0a0a;
       box-shadow: 2px 2px 12px 2px #0a0a0a;
   }

   .img-righty {
        -ms-transform: rotate(7deg); /* IE 9 */
        -webkit-transform: rotate(7deg); /* Chrome, Safari, Opera */
        transform: rotate(7deg);
       -webkit-filter: brightness(100%);
       -webkit-box-shadow: 2px 2px 12px 2px #0a0a0a;
       box-shadow: 2px 2px 12px 2px #0a0a0a;
    }

   .img-lefty {
       -ms-transform: rotate(-7deg); /* IE 9 */
       -webkit-transform: rotate(-7deg); /* Chrome, Safari, Opera */
       transform: rotate(-7deg);
       -webkit-filter: brightness(100%);
       -webkit-box-shadow: 2px 2px 12px 2px #0a0a0a;
       box-shadow: 2px 2px 12px 2px #0a0a0a;
   }
   .img-lefty-less {
       -ms-transform: rotate(-4deg); /* IE 9 */
       -webkit-transform: rotate(-4deg); /* Chrome, Safari, Opera */
       transform: rotate(-4deg);
       -webkit-filter: brightness(100%);
       -webkit-box-shadow: 2px 2px 12px 2px #0a0a0a;
       box-shadow: 2px 2px 12px 2px #0a0a0a;
   }
   .img-lefty:hover {
       -webkit-filter: brightness(110%);
   }
   .img-righty:hover {
       -webkit-filter: brightness(110%);
   }

   .footer-bg {
       background-image: url(media/images/bottom.png); height: 150px;
   }

   .text-black {
        color: #000000;
    }
   .text-grey {
       color: #666;
   }

</style>