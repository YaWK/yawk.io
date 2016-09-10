<?php
\YAWK\backend::drawContentWrapper();

if (isset($_GET['delete']) && ($_GET['delete'] == 'true'))
{
    if(\YAWK\menu::delete($db, $db->quote($_GET['menu'])))
    {
        print \YAWK\alert::draw("success", "Erfolg", "Das Men&uuml; wurde gel&ouml;scht!","page=menus","1800");
        exit;
    }
    else
    {
        print \YAWK\alert::draw("danger", "Fehler!", "Das Men&uuml; konnte nicht gel&ouml;scht werden!","page=menus","4200");
        exit;
    }
}
else {
    echo "
        <div class=\"text-center\">
          <p>Soll das Men&uuml; <strong> $_GET[menu]</strong> unwideruflich gel&ouml;scht werden?</p>
          <a class=\"btn btn-default\" href=\"index.php?page=menus\">Abbrechen</a>
          <a class=\"btn btn-warning\" href=\"index.php?page=menu-delete&menu=$_GET[menu]&delete=true\">
            <i class=\"fa fa-trash-o\"></i>&nbsp; Seite l&ouml;schen
          </a>
        </div>";
}