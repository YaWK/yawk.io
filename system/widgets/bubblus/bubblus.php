<?php
$widget = new \YAWK\widget();
$data = $widget->getWidgetSettingsArray($db);
$bubblusUrl = $data['bubblusUrl'];
$bubblusWidth = $data['bubblusWidth'];
$bubblusHeight = $data['bubblusHeight'];
$heading = $data['bubblusHeading'];
$subtext = $data['bubblusSubtext'];


// if a heading is set and not empty
if (isset($heading) && (!empty($heading)))
{   // add a h1 tag to heading string
    $heading = "$heading";

    // if subtext is set, add <small> subtext to string
    if (isset($subtext) && (!empty($subtext)))
    {   // build a headline with heading and subtext
        $subtext = "<small>$subtext</small>";
        $headline = "<h1>$heading&nbsp;"."$subtext</h1>";
    }
    else
    {   // build just a headline - without subtext
        $headline = "<h1>$heading</h1>";    // draw just the heading
    }
}
else
{   // leave empty if it's not set
    $headline = '';
}
$bubbleusUrl = rtrim("/", $bubblusUrl);
echo $headline;
?>
<iframe width="<?php echo $bubblusWidth;?>" height="<?php echo $bubblusHeight;?>" allowfullscreen frameborder="0" src="<?php echo $bubblusUrl;?>"></iframe>