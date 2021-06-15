<?php
// IMPORT REQUIRED CLASSES
use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;

// CHECK REQUIRED OBJECTS
if (!isset($page)) // if no page object is set
{   // create new page object
    $page = new YAWK\page();
}
if (!isset($db))
{   // create database object
    $db = new db();
}
if (!isset($lang))
{   // create language object
    $lang = new language();
}
// TOGGLE MENU ITEM
if (isset($_GET['toggleItem']))
{
    if (isset($_GET['published']) && (isset($_GET['menu']) && ($_GET['id'])))
    {
        if (is_numeric($_GET['published'])
            && (is_numeric($_GET['menu'])
                && (is_numeric($_GET['id']))))
        {
            // data is set, types seem to be correct, go ahead...
            if (!isset($menu))
            {   // create new menu object
                $menu = new YAWK\menu();
            }
            $menu->parent = $db->quote($_GET['menu']);
            $menu->id = $db->quote($_GET['id']);
            $menu->published = $db->quote($_GET['published']);

            // check status and toggle it
            if ($menu->published === '1') {
                $menu->published = 0;
                $status = $lang['OFFLINE'];
                $color = "warning";
            }
            else {
                $menu->published = 1;
                $status = $lang['ONLINE'];
                $color = "success";
            }
            // all ok, now toggle that menu entry
            if($menu->toggleItemOffline($db, $menu->id, $menu->published, $menu->parent))
            {   // throw notification
                \YAWK\alert::draw("$color", "$lang[MENU_ITEM] $lang[IS_NOW] $status", "$lang[MENU_ITEM] $lang[TOGGLED_TO] $status.", "", 800);
            }
            else
            {   // throw error
                \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[FAILED] $lang[TOGGLE] $lang[MENU_ITEM] $status.", "",5800);
            }

        }
    }
}

// DELETE MENU ENTRY
if (isset($_GET['del']) && ($_GET['del'] === "1")) {
    switch ($_GET['deleteitem'])
    {
        case 1:
            $menuID = $_GET['menu'];
            $entry = $_GET['entry'];
            if (YAWK\menu::deleteEntry($db, $menuID, $entry) === true)
            {   // delete successful
                \YAWK\alert::draw("success", "$lang[ITEM] $lang[DELETED].", "$lang[MENU_ITEM] $lang[DELETED]", "", 800);
            }
            else
                {   // could not delete - throw error
                    \YAWK\alert::draw("danger", "$lang[MENU_ITEM] $lang[DELETE] $lang[FAILED].", "$lang[DATABASE] $lang[ERROR].", "", 5800);
                }
         break;
    }
}
/* CHANGE MENU TITLE */
if(isset($_POST['changetitle'])) {
    if (!$res = \YAWK\menu::changeTitle($db, $db->quote($_GET['menu']),$db->quote($_POST['menutitle'])))
    {   // throw error
        \YAWK\alert::draw("warning", "$lang[WARNING]!", "$lang[MENU_CHANGE_FAILED]", "page=menu-edit&menu=$_GET[menu]","4200");
        exit;
    }
}
/* CHANGE MENU LANGUAGE */
if(isset($_POST['changeLanguage'])) {
    if (!$res = \YAWK\menu::changeLanguage($db, $db->quote($_GET['menu']),$db->quote($_POST['menuLanguage'])))
    {   // throw error
        \YAWK\alert::draw("warning", "$lang[WARNING]!", "$lang[MENU_CHANGE_FAILED]", "page=menu-edit&menu=$_GET[menu]","4200");
        exit;
    }
}
/* ADD MENU ENTRY */
if(isset($_POST['add'])) {
  trim($_POST['newtitle']);
  trim($_POST['newurl']);
  if (!$res = YAWK\menu::addEntry($db, $db->quote($_GET['menu']),$db->quote($_POST['newtitle']),$db->quote($_POST['newurl'])))
  {
      \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[MENU_ADD_FAILED].","page=menu-edit&menu=$_GET[menu]","2200");
      exit;
  }
}
  else if(isset($_POST['save'])) {
    $entries = array();
    foreach($_POST as $param=>$value){

    if(substr($param,-4,4) === "_gid"){
            $entries[substr($param,0,-4)]['gid'] = $value;
        }
      if(strlen($param) >= 6){
        if(substr($param,-5,5) === "_href"){
          $entries[substr($param,0,-5)]['href'] = $value;
        }
        else if(substr($param,-7,7) === "_target"){
            $entries[substr($param,0,-7)]['target'] = $value;
        }
        else if(strlen($param) >= 5 && substr($param,-5,5) === "_text"){
            $entries[substr($param,0,-5)]['text'] = $value;
        }
        else if(strlen($param) >= 7 && substr($param,-6,6) === "_title"){
         $entries[substr($param,0,-6)]['title'] = $value;
        }
        else if(substr($param,-5,5) === "_sort"){
          $entries[substr($param,0,-5)]['sort'] = $value;
        }
        else if(substr($param,-10,10) === "_published"){
          $entries[substr($param,0,-10)]['published'] = $value;
        }
        else if(substr($param,-9,9) === "_parentID"){
          $entries[substr($param,0,-9)]['parentID'] = $value;
        }
        else if(substr($param,-8,8) === "_divider"){
          $entries[substr($param,0,-8)]['divider'] = $value;
        }
      }
    }

    foreach($entries as $id=>$params){
    // echo "<br>".$params['gid']; exit;
      $_GET['menu'] = $db->quote($_GET['menu']);
      $id = $db->quote($id);
      $params['text'] = $db->quote($params['text']);
      $params['title'] = $db->quote($params['title']);
      $params['href'] = $db->quote($params['href']);
      $params['sort'] = $db->quote($params['sort']);
      $params['gid'] = $db->quote($params['gid']);
      $params['published'] = $db->quote($params['published']);
      if (isset($params['parentID']) && (!empty($params['parentID'])))
      { $params['parentID'] = $db->quote($params['parentID']); }
      $params['target'] = $db->quote($params['target']);
      YAWK\menu::editEntry($db,
          $_GET['menu'],
          $id,
          $params['text'],
          $params['title'],
          $params['href'],
          $params['sort'],
          $params['gid'],
          $params['published'],
          $params['parentID'],
          $params['target']);
    }
  }
  else {
    foreach($_POST as $param=>$value){
      if(strlen($param) >= 8){
        if(substr($param,-7,7) === "_delete"){
          YAWK\menu::deleteEntry($db, $_GET['menu'], substr($param,0,-7));
        }
      }
    }
  }
?>

<!-- data tables JS -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });

        // TRY TO DISABLE CTRL-S browser hotkey
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
    });
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="content-FX">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- draw title on top-->
        <?php
            /* MENU Title */
            $menuName = YAWK\sys::getMenuName($db, $_GET['menu']);
            echo \YAWK\backend::getTitle($menuName, $lang['EDIT']);
        ?>
        <ol class="breadcrumb">
            <li><a href="./" title="<?php echo $lang['DASHBOARD']; ?>"><i class="fa fa-dashboard"></i> <?php echo $lang['DASHBOARD']; ?></a></li>
            <li><a href="index.php?page=menus" title="<?php echo $lang['MENUS']; ?>"> <?php echo $lang['MENUS']; ?></a></li>
            <li class="active"><a href="index.php?page=menu-edit&menu=<?php echo $_GET['menu']; ?>" title="<?php echo $lang['EDIT_MENU']; ?>"> <?php echo $lang['EDIT_MENU']; ?></a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <!-- START CONTENT HERE -->
<form role="form" action="index.php?page=menu-edit&menu=<?php echo $_GET['menu']; ?>" method="POST">
<div class="box box-default">
    <div class="box-body">
        <!-- save btn -->
        <button name="save"
                id="savebutton"
                class="btn btn-success pull-right"
                type="submit"><i class="fa fa-save"></i>&nbsp; <?php echo $lang['MENU_SAVE']; ?>
        </button>
        <!-- back btn -->
        <a class="btn btn-default pull-right" href="index.php?page=menus">
        <i class="glyphicon glyphicon-backward"></i> &nbsp;<?php print $lang['BACK']; ?></a>
      <?php
      // DISPLAY EDITABLE MENU ENTRIES
      \YAWK\menu::displayEditable($db, $db->quote($_GET['menu']), $lang);
      ?>

    <br><br>

    </div>
</div>

    <div class="row">
        <div class="col-md-6">
            <div class="box default">
                <div class="box-header with border">
                    <h3 class="box-title"><?php echo $lang['ENTRY_ADD']; ?></h3>
                </div>
                <div class="box-body">
                    <input type="text"
                           id="newtitle"
                           class="form-control"
                           name="newtitle"
                           maxlength="128"
                           placeholder="<?php echo $lang['TITLE']; ?>">
                    <input type="text"
                           id="newurl"
                           class="form-control"
                           name="newurl"
                           maxlength="128"
                           placeholder="<?php echo $lang['LINK_OR_FILENAME']; ?>">
                    <input name="add"
                           id="savebutton3"
                           style="margin-top:5px;"
                           class="btn btn-default pull-right"
                           type="submit"
                           value="<?php echo $lang['ADD']; ?>">
                </div>
            </div>
         </div>
        <!-- 2nd col -->
        <div class="col-md-6">
            <div class="box default">
                <div class="box-header with border">
                    <h3 class="box-title"><?php echo $lang['MENU_TITLE_CHANGE']; ?></h3>
                </div>
                <div class="box-body">
                    <input type="text"
                           class="form-control"
                           name="menutitle"
                           maxlength="128"
                           value="<?php print \YAWK\sys::getMenuName($db, $_GET['menu']); ?>">
                    <input name="changetitle"
                           style="margin-top:5px;"
                           id="savebutton2"
                           class="btn btn-default pull-right"
                           type="submit"
                           value="<?php echo $lang['SAVE']; ?>">
                    </div>
            </div>
            <div class="box default">
                <div class="box-header with border">
                    <h3 class="box-title"><?php echo $lang['MENU_LANGUAGE_CHANGE']; ?></h3>
                </div>
                <div class="box-body">
                    <select id="menuLanguage" name="menuLanguage" class="form-control">
                        <?php $menuLanguage = \YAWK\sys::getMenuLanguage($db, $_GET['menu']); ?>

                        <?php
                        if (isset($menuLanguage) && (!empty($menuLanguage)))
                        {
                            echo "<option value=".$menuLanguage." selected>$menuLanguage</option>";
                        }
                        ?>
                        <option value="af">Afrikaans</option>
                        <option value="sq">Albanian - shqip</option>
                        <option value="am">Amharic - አማርኛ</option>
                        <option value="ar">Arabic - العربية</option>
                        <option value="an">Aragonese - aragonés</option>
                        <option value="hy">Armenian - հայերեն</option>
                        <option value="ast">Asturian - asturianu</option>
                        <option value="az">Azerbaijani - azərbaycan dili</option>
                        <option value="eu">Basque - euskara</option>
                        <option value="be">Belarusian - беларуская</option>
                        <option value="bn">Bengali - বাংলা</option>
                        <option value="bs">Bosnian - bosanski</option>
                        <option value="br">Breton - brezhoneg</option>
                        <option value="bg">Bulgarian - български</option>
                        <option value="ca">Catalan - català</option>
                        <option value="ckb">Central Kurdish - کوردی (دەستنوسی عەرەبی)</option>
                        <option value="zh">Chinese - 中文</option>
                        <option value="zh-HK">Chinese (Hong Kong) - 中文（香港）</option>
                        <option value="zh-CN">Chinese (Simplified) - 中文（简体）</option>
                        <option value="zh-TW">Chinese (Traditional) - 中文（繁體）</option>
                        <option value="co">Corsican</option>
                        <option value="hr">Croatian - hrvatski</option>
                        <option value="cs">Czech - čeština</option>
                        <option value="da">Danish - dansk</option>
                        <option value="nl">Dutch - Nederlands</option>
                        <option value="en">English</option>
                        <option value="en-AU">English (Australia)</option>
                        <option value="en-CA">English (Canada)</option>
                        <option value="en-IN">English (India)</option>
                        <option value="en-NZ">English (New Zealand)</option>
                        <option value="en-ZA">English (South Africa)</option>
                        <option value="en-GB">English (United Kingdom)</option>
                        <option value="en-US">English (United States)</option>
                        <option value="eo">Esperanto - esperanto</option>
                        <option value="et">Estonian - eesti</option>
                        <option value="fo">Faroese - føroyskt</option>
                        <option value="fil">Filipino</option>
                        <option value="fi">Finnish - suomi</option>
                        <option value="fr">French - français</option>
                        <option value="fr-CA">French (Canada) - français (Canada)</option>
                        <option value="fr-FR">French (France) - français (France)</option>
                        <option value="fr-CH">French (Switzerland) - français (Suisse)</option>
                        <option value="gl">Galician - galego</option>
                        <option value="ka">Georgian - ქართული</option>
                        <option value="de">German - Deutsch</option>
                        <option value="de-AT">German (Austria) - Deutsch (Österreich)</option>
                        <option value="de-DE">German (Germany) - Deutsch (Deutschland)</option>
                        <option value="de-LI">German (Liechtenstein) - Deutsch (Liechtenstein)</option>
                        <option value="de-CH">German (Switzerland) - Deutsch (Schweiz)</option>
                        <option value="el">Greek - Ελληνικά</option>
                        <option value="gn">Guarani</option>
                        <option value="gu">Gujarati - ગુજરાતી</option>
                        <option value="ha">Hausa</option>
                        <option value="haw">Hawaiian - ʻŌlelo Hawaiʻi</option>
                        <option value="he">Hebrew - עברית</option>
                        <option value="hi">Hindi - हिन्दी</option>
                        <option value="hu">Hungarian - magyar</option>
                        <option value="is">Icelandic - íslenska</option>
                        <option value="id">Indonesian - Indonesia</option>
                        <option value="ia">Interlingua</option>
                        <option value="ga">Irish - Gaeilge</option>
                        <option value="it">Italian - italiano</option>
                        <option value="it-IT">Italian (Italy) - italiano (Italia)</option>
                        <option value="it-CH">Italian (Switzerland) - italiano (Svizzera)</option>
                        <option value="ja">Japanese - 日本語</option>
                        <option value="kn">Kannada - ಕನ್ನಡ</option>
                        <option value="kk">Kazakh - қазақ тілі</option>
                        <option value="km">Khmer - ខ្មែរ</option>
                        <option value="ko">Korean - 한국어</option>
                        <option value="ku">Kurdish - Kurdî</option>
                        <option value="ky">Kyrgyz - кыргызча</option>
                        <option value="lo">Lao - ລາວ</option>
                        <option value="la">Latin</option>
                        <option value="lv">Latvian - latviešu</option>
                        <option value="ln">Lingala - lingála</option>
                        <option value="lt">Lithuanian - lietuvių</option>
                        <option value="mk">Macedonian - македонски</option>
                        <option value="ms">Malay - Bahasa Melayu</option>
                        <option value="ml">Malayalam - മലയാളം</option>
                        <option value="mt">Maltese - Malti</option>
                        <option value="mr">Marathi - मराठी</option>
                        <option value="mn">Mongolian - монгол</option>
                        <option value="ne">Nepali - नेपाली</option>
                        <option value="no">Norwegian - norsk</option>
                        <option value="nb">Norwegian Bokmål - norsk bokmål</option>
                        <option value="nn">Norwegian Nynorsk - nynorsk</option>
                        <option value="oc">Occitan</option>
                        <option value="or">Oriya - ଓଡ଼ିଆ</option>
                        <option value="om">Oromo - Oromoo</option>
                        <option value="ps">Pashto - پښتو</option>
                        <option value="fa">Persian - فارسی</option>
                        <option value="pl">Polish - polski</option>
                        <option value="pt">Portuguese - português</option>
                        <option value="pt-BR">Portuguese (Brazil) - português (Brasil)</option>
                        <option value="pt-PT">Portuguese (Portugal) - português (Portugal)</option>
                        <option value="pa">Punjabi - ਪੰਜਾਬੀ</option>
                        <option value="qu">Quechua</option>
                        <option value="ro">Romanian - română</option>
                        <option value="mo">Romanian (Moldova) - română (Moldova)</option>
                        <option value="rm">Romansh - rumantsch</option>
                        <option value="ru">Russian - русский</option>
                        <option value="gd">Scottish Gaelic</option>
                        <option value="sr">Serbian - српски</option>
                        <option value="sh">Serbo-Croatian - Srpskohrvatski</option>
                        <option value="sn">Shona - chiShona</option>
                        <option value="sd">Sindhi</option>
                        <option value="si">Sinhala - සිංහල</option>
                        <option value="sk">Slovak - slovenčina</option>
                        <option value="sl">Slovenian - slovenščina</option>
                        <option value="so">Somali - Soomaali</option>
                        <option value="st">Southern Sotho</option>
                        <option value="es">Spanish - español</option>
                        <option value="es-AR">Spanish (Argentina) - español (Argentina)</option>
                        <option value="es-419">Spanish (Latin America) - español (Latinoamérica)</option>
                        <option value="es-MX">Spanish (Mexico) - español (México)</option>
                        <option value="es-ES">Spanish (Spain) - español (España)</option>
                        <option value="es-US">Spanish (United States) - español (Estados Unidos)</option>
                        <option value="su">Sundanese</option>
                        <option value="sw">Swahili - Kiswahili</option>
                        <option value="sv">Swedish - svenska</option>
                        <option value="tg">Tajik - тоҷикӣ</option>
                        <option value="ta">Tamil - தமிழ்</option>
                        <option value="tt">Tatar</option>
                        <option value="te">Telugu - తెలుగు</option>
                        <option value="th">Thai - ไทย</option>
                        <option value="ti">Tigrinya - ትግርኛ</option>
                        <option value="to">Tongan - lea fakatonga</option>
                        <option value="tr">Turkish - Türkçe</option>
                        <option value="tk">Turkmen</option>
                        <option value="tw">Twi</option>
                        <option value="uk">Ukrainian - українська</option>
                        <option value="ur">Urdu - اردو</option>
                        <option value="ug">Uyghur</option>
                        <option value="uz">Uzbek - o‘zbek</option>
                        <option value="vi">Vietnamese - Tiếng Việt</option>
                        <option value="wa">Walloon - wa</option>
                        <option value="cy">Welsh - Cymraeg</option>
                        <option value="fy">Western Frisian</option>
                        <option value="xh">Xhosa</option>
                        <option value="yi">Yiddish</option>
                        <option value="yo">Yoruba - Èdè Yorùbá</option>
                        <option value="zu">Zulu - isiZulu</option>
                    </select>
                    <input name="changeLanguage"
                           style="margin-top:5px;"
                           id="savebutton2"
                           class="btn btn-default pull-right"
                           type="submit"
                           value="<?php echo $lang['SAVE']; ?>">
                </div>
            </div>
        </div>
    </div>
</form>