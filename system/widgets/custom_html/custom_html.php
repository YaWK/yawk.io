<?php
// create new widget object
$widget = new \YAWK\widget();
// get widget data into array
$data = $widget->getWidgetSettingsArray($db);
// check if array is set, customHtmlCode is set
if (is_array($data) && ((is_string($data['customHtmlCode']))
// check if customHtmlCode is a string
&& (!empty($data['customHtmlCode']))))
{   // output custom html code
    echo $data['customHtmlCode'];
}
else
    {   // custom html code is not valid, leave empty
        $customHtmlCode = '';
    }
