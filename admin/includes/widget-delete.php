<?php
    if (!isset($widget))
    {   // create new widget obj
        $widget = new YAWK\widget();
    }

    if(isset($_GET['widget']))
    {   // layout wrapper
        \YAWK\backend::drawContentWrapper();
        echo "<div class=\"text-center\">
                <p>Soll das Widget <strong> $_GET[widget].html</strong> wirklich gel&ouml;scht werden?</p>
                <a class=\"btn btn-default\" href=\"index.php?page=widgets\">Abbrechen</a>
                <a class=\"btn btn-warning\" href=\"index.php?page=widget-delete&widget=$_GET[widget]&delete=true\">
                <i class=\"fa fa-trash-o\"></i>&nbsp; Widget l&ouml;schen
                </a>
              </div>";
    }
    if (isset($_GET['widget']) && (isset($_GET['delete']) && ($_GET['delete'] == "true")))
    {   // delete widget
        if($widget->delete($db, $_GET['widget']))
        {   // delete successful
            YAWK\alert::draw("success", "Erfolg", "Das Widget ".$_GET['widget']." wurde gel&ouml;scht!","page=widgets","1800");
            exit;
        }
        else
        {   // q failed, throw error
            \YAWK\alert::draw("danger", "Error!", "Could not delete widget ".$_GET['widget']."!","page=widgets","4800");
        }
    }
