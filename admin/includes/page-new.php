<?php
// IMPORT REQUIRED CLASSES
use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;

/** @var $db db  */
/** @var $lang language  */

// CHECK REQUIRED OBJECTS
if (!isset($page)) // if no page object is set
{   // create new page object
    $page = new YAWK\page();
}

// TEMPLATE WRAPPER - HEADER & breadcrumbs
    echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['PAGE'], $lang['PAGE_ADD_SMALL']);
echo"<ol class=\"breadcrumb\">
        <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
        <li><a href=\"index.php?page=pages\" title=\"$lang[PAGES]\"> $lang[PAGES]</a></li>
        <li class=\"active\"><a href=\"index.php?page=page-new\" title=\"".$lang['PAGE+']."\"> ".$lang['PAGE_ADD']."</a></li>
     </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

/* focus input text field on page load */
backend::setFocus("alias");
if(isset($_POST['alias']) && (!empty($_POST['alias'])))
  {
      $page->alias = $db->quote($_POST['alias']);
      $page->menu = $db->quote($_POST['menuID']);
      $page->blogid = $db->quote($_POST['blogid']);
      $page->locked = $db->quote($_POST['locked']);
      $page->plugin="";
      $page->language = $db->quote($_POST['language']);
      /* create page function */
      if($page->create($db, $page->alias, $page->menu, $page->locked, $page->blogid, $page->plugin))
      {
          // YAWK\sys::setNotification($db, 1, "$lang[PAGE] $alias.html $lang[CREATED].", $user->id, 0, 0, 0);
          alert::draw("success", "$lang[SUCCESS]", "$lang[PAGE] $lang[CREATED]","","420");
          backend::setTimeout("index.php?page=pages",1260);
      }
      else
      {   // create new page failed
          print alert::draw("danger", "$lang[ERROR]", "$lang[SAVE] $lang[OF] $lang[PAGE] <strong>".$this->alias."</strong> $lang[FAILED]","page=page-new","4800");
      }

  }
?>
<!-- FORM -->
<div class="box box-default">
    <div class="box-body">
<br>
<form role="form" class="form-inline" action="index.php?page=page-new" method="post">
  <label for="alias"><?php print $lang['PAGE_ADD_SUBTEXT']; ?>  </label><br>
  <!-- TEXT FIELD -->
  <input type="text" id="alias" size="84" name="alias" class="form-control" maxlength="255" 
  placeholder="<?php print $lang['PAGE_ADD_PLACEHOLDER']; ?>" /> .html

<br><br>
    <label for="language"><?php echo $lang['ASSIGN_LANGUAGE']; ?></label><br>
    <select id="language" name="language" class="form-control">
        <option value="" selected></option>
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

    <br><br>
    <!-- MENU SELECTOR -->
    &nbsp;&nbsp;<label for="menuID"><?php print $lang['IN_MENU']; ?></label> <select id="menuID" name="menuID" class="btn btn-default">
        <?php
        foreach (YAWK\backend::getMenusArray($db) AS $menue){
            echo "<option value=\"".$menue['id']."\"";
            if (isset($_POST['menu'])) {
                if($_POST['menu'] === $menue['id']){
                    echo " selected=\"selected\"";
                }
                else if($page->menu === $menue['id'] && !$_POST['menu']){
                    echo " selected=\"selected\"";
                }
            }
            echo ">".$menue['name']."</option>";
        }
        ?>
        <option value="empty"><?php echo $lang['NO_ENTRY']; ?></option>
    </select>

    <!-- SUBMIT BUTTON -->
    <input type="submit" class="btn btn-success" value="<?php print $lang['PAGE_ADD_BTN']; ?>" />

    <input type="hidden" name="blogid" value="0">
  <input type="hidden" name="locked" value="0">
</form>
<br>
    </div>
</div>