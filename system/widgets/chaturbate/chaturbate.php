<?php
$widget = new \YAWK\widget();
$data = $widget->getWidgetSettingsArray($db);
$chaturbateRoom = $data['chaturbateRoom'];
$disableSound = $data['chaturbateDisableSound'];
$embedVideoOnly = 0;
$width = $data['chaturbateWidth'];
$height = $data['chaturbateHeight'];
$width = $data['chaturbateVideoOnly'];
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

// build video url
$chaturbateVideoURL = "https://chaturbate.com/affiliates/in/?tour=Jrvi&campaign=APohb&track=embed&room=$chaturbateRoom&bgcolor=transparent&disable_sound=$disableSound&embed_video_only=$embedVideoOnly&target=_parent";

// HTML output
echo "
<!-- chaturbate room stream iframe -->
$headline
<iframe src=\"$chaturbateVideoURL\" 
        width=\"$width\" 
        height=\"$height\" 
        frameborder=\"0\"
        scrolling=\"no\">
</iframe>";