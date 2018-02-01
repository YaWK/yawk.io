<?php
// set default values
$embedPageName="";

// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
if (isset($_GET['widgetID']))
{
    // widget ID
    $widgetID = $_GET['widgetID'];

    // get widget settings from db
    $res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$widgetID."'
	                        AND activated = '1'");
    while($row = mysqli_fetch_assoc($res))
    {   // set widget properties and values into vars
        $w_property = $row['property'];
        $w_value = $row['value'];
        $w_widgetType = $row['widgetType'];
        $w_activated = $row['activated'];
        /* end of get widget properties */

        /* filter and load those widget properties */
        if (isset($w_property)){
            switch($w_property)
            {
                /* name of the page to embed */
                case 'embedPageName';
                    $embedPageName = $w_value;
                    break;
            }
        } /* END LOAD PROPERTIES */
    } // end while fetch row (fetch widget settings)
}
if (isset($embedPageName) && (!empty($embedPageName)))
{
    // filename
    $file = "content/pages/$embedPageName";

    if (is_file($file))
    {
        include ($file);
    }
    else
        {
            echo "embed: $file not found!";
        }
}
else
    {
        echo "embed page name $embedPageName not set";
    }

