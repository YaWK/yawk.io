<?php
include '../classes/SimpleImage.php';
$img = new \YAWK\SimpleImage();

// prepare vars
$prefix = "../../../../";
$action = $_POST['action'];
$galleryID = $_POST['id'];
$folder = $_POST['folder'];
$filename = $_POST['filename'];
$itemID = $_POST['itemID'];
$createThumbnails = $_POST['createThumbnails'];
$thumbnailWidth = $_POST['thumbnailWidth'];
$watermark = $_POST['watermark'];
$watermarkImage = $_POST['watermarkImage'];
$watermarkOpacity = $_POST['watermarkOpacity'];
$watermarkPosition = $_POST['watermarkPosition'];
$offsetX = $_POST['offsetX'];
$offsetY = $_POST['offsetY'];
$watermarkFont = $_POST['watermarkFont'];
$watermarkTextSize = $_POST['watermarkTextSize'];
$watermarkColor = $_POST['watermarkColor'];
$watermarkBorderColor = $_POST['watermarkBorderColor'];
$watermarkBorder = $_POST['watermarkBorder'];
$ttfPrefix = "../../../";                                        // prefix to system/fonts


// GET THE ACTION AND DO WHATEVER A SCRIPT GOT TO DO.....

// FLIP X (horizontal)
    if ($action === "flip-horizontal")
    {   // flip image horizontal (X axis)
        // if WATERMARK IS SET
        if (!empty($watermark))
        {   // load, flip X, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
            $img->load("$prefix$folder/edit/$filename")
                ->flip("x")
                ->save("$prefix$folder/edit/$filename")
                ->text("$watermark",
                       "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                       "#$watermarkColor",
                       "$watermarkPosition",
                       "$offsetX",
                       "$offsetY",
                       "#$watermarkBorderColor",
                        $watermarkBorder)
                ->save("$prefix$folder/$filename");
            // check if thumbnail directory exist...
            if (is_dir("$prefix$folder/thumbnails/"))
            {   // check if image is in tn folder
                if (is_file("$prefix$folder/thumbnails/$filename"))
                {   // load image from edit folder, watermark it, change size + save TN
                    // to flip is not needed, because the file from edit folder is already flipped. (see above)
                $img->load("$prefix$folder/edit/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
                }
            }
        }
        else
            {   // NO WATERMARK, just flip and save
                $img->load("$prefix$folder/edit/$filename")
                    ->flip("x")
                    ->save("$prefix$folder/edit/$filename")
                    ->save("$prefix$folder/$filename");
                // check if thumbnail directory exist...
                if (is_dir("$prefix$folder/thumbnails/"))
                {   // check if image is in tn folder
                    if (is_file("$prefix$folder/thumbnails/$filename"))
                    {   // flip is already done, just resize and save.
                        $img->load("$prefix$folder/edit/$filename")
                            ->fit_to_width($thumbnailWidth)
                            ->save("$prefix$folder/thumbnails/$filename");
                    }
                }
            }
        // WATERMARK FROM IMAGE
        if (!empty($watermarkImage))
        {   // load image, flip X, overlay image watermark and save to image gallery root folder
            $img->load("$prefix$folder/edit/$filename")
                ->overlay("$prefix$watermarkImage",
                          "$watermarkPosition",
                           $watermarkOpacity)
                ->save("$prefix$folder/$filename");
            // check if thumbnail directory exist...
            if (is_dir("$prefix$folder/thumbnails/"))
            {   // check if image is in tn folder
                if (is_file("$prefix$folder/thumbnails/$filename"))
                {   // ok, it's here so flip it
                    $img->load("$prefix$folder/edit/$filename")
                        ->overlay("$prefix$watermarkImage",
                                  "$watermarkPosition",
                                   $watermarkOpacity)
                        ->fit_to_width($thumbnailWidth)
                        ->save("$prefix$folder/thumbnails/$filename");
                }
            }
        }
        $response['status'] = 'true';
        $response['action'] = 'flip horizontal';
        echo json_encode($response);
    } // ./ flip-horizontal

// FLIP Y (vertical)
    if ($action === "flip-vertical")
    {   // flip image vertical (Y axis)
        // if WATERMARK IS SET
        if (!empty($watermark))
        {   // load, flip Y, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
            $img->load("$prefix$folder/edit/$filename")
                ->flip("y")
                ->save("$prefix$folder/edit/$filename")
                ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                ->save("$prefix$folder/$filename");
            // check if thumbnail directory exist...
            if (is_dir("$prefix$folder/thumbnails/"))
            {   // check if image is in tn folder
                if (is_file("$prefix$folder/thumbnails/$filename"))
                {   // load image from edit folder, watermark it, change size + save TN
                    // to flip is not needed, because the file from edit folder is already flipped. (see above)
                    $img->load("$prefix$folder/edit/$filename")
                        ->text("$watermark",
                            "$ttfPrefix$watermarkFont",
                            $watermarkTextSize,
                            "#$watermarkColor",
                            "$watermarkPosition",
                            "$offsetX",
                            "$offsetY",
                            "#$watermarkBorderColor",
                            $watermarkBorder)
                        ->fit_to_width($thumbnailWidth)
                        ->save("$prefix$folder/thumbnails/$filename");
                }
            }
        }
        else
        {   // if NO WATERMARK is set, just flip and save
            $img->load("$prefix$folder/edit/$filename")
                ->flip("y")
                ->save("$prefix$folder/edit/$filename")
                ->save("$prefix$folder/$filename");
            // check if thumbnail directory exist...
            if (is_dir("$prefix$folder/thumbnails/"))
            {   // check if image is in tn folder
                if (is_file("$prefix$folder/thumbnails/$filename"))
                {   // load image from edit folder, change size + save TN
                    // to flip is not needed, because the file from edit folder is already flipped. (see above)
                    $img->load("$prefix$folder/edit/$filename")
                        ->fit_to_width($thumbnailWidth)
                        ->save("$prefix$folder/thumbnails/$filename");
                }
            }

        }
        // WATERMARK FROM IMAGE
        if (!empty($watermarkImage))
        {   // load image, flip Y, overlay image watermark and save to image gallery root folder
            $img->load("$prefix$folder/edit/$filename")
                ->overlay("$prefix$watermarkImage",
                    "$watermarkPosition",
                    $watermarkOpacity)
                ->save("$prefix$folder/$filename");
            // check if thumbnail directory exist...
            if (is_dir("$prefix$folder/thumbnails/"))
            {   // check if image is in tn folder
                if (is_file("$prefix$folder/thumbnails/$filename"))
                {   // ok, it's here so flip it
                    $img->load("$prefix$folder/edit/$filename")
                        ->overlay("$prefix$watermarkImage",
                            "$watermarkPosition",
                            $watermarkOpacity)
                        ->fit_to_width($thumbnailWidth)
                        ->save("$prefix$folder/thumbnails/$filename");
                }
            }
        }
        $response['status'] = 'true';
        $response['action'] = 'flip vertical';
        echo json_encode($response);
    } // ./ flip-vertical

// ROTATE 90 degrees
if ($action === "rotate-90")
{   // rotate image -90 degrees (to the left)
    // if WATERMARK IS SET
    if (!empty($watermark))
    {   // load, rotate, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->rotate(-90)
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                    "$ttfPrefix$watermarkFont",
                    $watermarkTextSize,
                    "#$watermarkColor",
                    "$watermarkPosition",
                    "$offsetX",
                    "$offsetY",
                    "#$watermarkBorderColor",
                    $watermarkBorder)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                // rotate is not needed, because the file from edit folder is already manipulated. (see above)
                $img->load("$prefix$folder/edit/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    else
    {   // if NO WATERMARK is set, just rotate and save
        $img->load("$prefix$folder/edit/$filename")
            ->rotate(-90)
            ->save("$prefix$folder/edit/$filename")
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder,change size + save TN
                // rotate is not needed, because the file from edit folder is already manipulated.
                $img->load("$prefix$folder/edit/$filename")
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    // WATERMARK FROM IMAGE
    if (!empty($watermarkImage))
    {   // load image, rotate, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // ok, it's here so rotate, resize and save it
                $img->load("$prefix$folder/edit/$filename")
                    ->overlay("$prefix$watermarkImage",
                        "$watermarkPosition",
                        $watermarkOpacity)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    $response['status'] = 'true';
    $response['action'] = 'flip rotate -90';
    echo json_encode($response);
} // ./ rotate-90

// CONTRAST PLUS
if ($action === "contrast-plus")
{   // add contrast +5 to image
    // if WATERMARK IS SET
    if (!empty($watermark))
    {   // load, add contrast, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->contrast(-5)
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetX",
                "$offsetY",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                // to contrast+ is not needed, because the file from edit folder is already manipulated
                $img->load("$prefix$folder/edit/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    else
    {   // if NO WATERMARK is set, just add contrast and save
        $img->load("$prefix$folder/edit/$filename")
            ->contrast(-5)
            ->save("$prefix$folder/edit/$filename")
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    // WATERMARK FROM IMAGE
    if (!empty($watermarkImage))
    {   // load image, contrast+, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // ok, it's here so contrast+, resize and save it
                $img->load("$prefix$folder/edit/$filename")
                    ->overlay("$prefix$watermarkImage",
                        "$watermarkPosition",
                        $watermarkOpacity)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    $response['status'] = 'true';
    $response['action'] = 'more contrast';
    echo json_encode($response);
} // ./ contrast-plus

// CONTRAST MINUS
if ($action === "contrast-minus")
{   // remove contrast from image
    // if WATERMARK IS SET
    if (!empty($watermark))
    {   // load, remove contrast, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->contrast(5)
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetX",
                "$offsetY",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    else
    {   // if NO WATERMARK is set, just remove contrast and save
        $img->load("$prefix$folder/edit/$filename")
            ->contrast(5)
            ->save("$prefix$folder/edit/$filename")
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, remove contrast, resize + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    // WATERMARK FROM IMAGE
    if (!empty($watermarkImage))
    {   // load image, remove contrast, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // ok, it's here so remove contrast, resize and save it
                $img->load("$prefix$folder/edit/$filename")
                    ->overlay("$prefix$watermarkImage",
                        "$watermarkPosition",
                        $watermarkOpacity)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    $response['status'] = 'true';
    $response['action'] = 'remove contrast';
    echo json_encode($response);
} // ./ contrast-minus

// BRIGHTNESS PLUS
if ($action === "brightness-plus")
{   // add brightness +5 to image
    // if WATERMARK IS SET
    if (!empty($watermark))
    {   // load, add brightness, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->brightness(5)
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetX",
                "$offsetY",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    else
    {   // if NO WATERMARK is set, just add brightness and save
        $img->load("$prefix$folder/edit/$filename")
            ->brightness(5)
            ->save("$prefix$folder/edit/$filename")
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    // WATERMARK FROM IMAGE
    if (!empty($watermarkImage))
    {   // load image, add brightness, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // ok, it's here so add brightness, resize and save it
                $img->load("$prefix$folder/edit/$filename")
                    ->overlay("$prefix$watermarkImage",
                        "$watermarkPosition",
                        $watermarkOpacity)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    $response['status'] = 'true';
    $response['action'] = 'more brightness';
    echo json_encode($response);
} // ./ brightness-plus


// BRIGHTNESS MINUS
if ($action === "brightness-minus")
{   // remove brightness -5 from image
    // if WATERMARK IS SET
    if (!empty($watermark))
    {   // load, remove brightness, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->brightness(-5)
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetX",
                "$offsetY",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    else
    {   // if NO WATERMARK is set, just remove brightness and save
        $img->load("$prefix$folder/edit/$filename")
            ->brightness(-5)
            ->save("$prefix$folder/edit/$filename")
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    // WATERMARK FROM IMAGE
    if (!empty($watermarkImage))
    {   // load image, remove brightness, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // ok, it's here so remove brightness, resize and save it
                $img->load("$prefix$folder/edit/$filename")
                    ->overlay("$prefix$watermarkImage",
                        "$watermarkPosition",
                        $watermarkOpacity)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    $response['status'] = 'true';
    $response['action'] = 'less brightness';
    echo json_encode($response);
} // ./ brightness-remove


// SHARPEN
if ($action === "sharpen")
{   // sharpen image
    // if WATERMARK IS SET
    if (!empty($watermark))
    {   // load, sharpen, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->sharpen()
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetX",
                "$offsetY",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    else
    {   // if NO WATERMARK is set, just sharpen and save
        $img->load("$prefix$folder/edit/$filename")
            ->sharpen()
            ->save("$prefix$folder/edit/$filename")
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }

    }
    // WATERMARK FROM IMAGE
    if (!empty($watermarkImage))
    {   // load image, sharpen, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // ok, it's here so sharpen, resize and save it
                $img->load("$prefix$folder/edit/$filename")
                    ->overlay("$prefix$watermarkImage",
                        "$watermarkPosition",
                        $watermarkOpacity)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    $response['status'] = 'true';
    $response['action'] = 'sharpen';
    echo json_encode($response);
} // ./ sharpen


// SELECTIVE BLUR (magic wand)
if ($action === "selective-blur")
{   // set a selective blur on that image. good for flattening skin.
    // if WATERMARK IS SET
    if (!empty($watermark))
    {   // load, set blur, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->blur('selective', 2)
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetX",
                "$offsetY",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    else
    {   // if NO WATERMARK is set, just set blur and save
        $img->load("$prefix$folder/edit/$filename")
            ->blur('selective', 2)
            ->save("$prefix$folder/edit/$filename")
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    // WATERMARK FROM IMAGE
    if (!empty($watermarkImage))
    {   // load image, set blur, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // ok, it's here so blur, resize and save it
                $img->load("$prefix$folder/edit/$filename")
                    ->overlay("$prefix$watermarkImage",
                        "$watermarkPosition",
                        $watermarkOpacity)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    $response['status'] = 'true';
    $response['action'] = 'magic blur (selective blur)';
    echo json_encode($response);
} // ./ selective-blur


// GREYSCALE
if ($action === "greyscale")
{   // greyscale this image
    // if WATERMARK IS SET
    if (!empty($watermark))
    {   // load, remove color, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->desaturate()
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetX",
                "$offsetY",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    else
    {   // if NO WATERMARK is set, just remove color and save
        $img->load("$prefix$folder/edit/$filename")
            ->desaturate()
            ->save("$prefix$folder/edit/$filename")
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    // WATERMARK FROM IMAGE
    if (!empty($watermarkImage))
    {   // load image, greyscale, overlay image with watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // ok, it's here so remove color, resize and save it
                $img->load("$prefix$folder/edit/$filename")
                    ->overlay("$prefix$watermarkImage",
                        "$watermarkPosition",
                        $watermarkOpacity)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    $response['status'] = 'true';
    $response['action'] = 'greyscale';
    echo json_encode($response);
} // ./ greyscale

// SEPIA image
if ($action === "sepia")
{   // sepia that image.
    // if WATERMARK IS SET
    if (!empty($watermark))
    {   // load, sepia, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->sepia()
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetX",
                "$offsetY",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    else
    {   // if no watermark is set, just sepia and save
        $img->load("$prefix$folder/edit/$filename")
            ->sepia()
            ->save("$prefix$folder/edit/$filename")
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    // WATERMARK FROM IMAGE
    if (!empty($watermarkImage))
    {   // load image, sepia, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // ok, it's here so sepia, resize and save it
                $img->load("$prefix$folder/edit/$filename")
                    ->overlay("$prefix$watermarkImage",
                        "$watermarkPosition",
                        $watermarkOpacity)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    $response['status'] = 'true';
    $response['action'] = 'sepia';
    echo json_encode($response);
} // ./ sepia

// PIXELATE image
if ($action === "pixelate")
{   // set pixelate that image. good for flattening skin.
    // if WATERMARK IS SET
    if (!empty($watermark))
    {   // load, pixelate, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->pixelate(12)
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetX",
                "$offsetY",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    else
    {   // if NO WATERMARK is set, just pixelate and save
        $img->load("$prefix$folder/edit/$filename")
            ->pixelate(12)
            ->save("$prefix$folder/edit/$filename")
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }

    // WATERMARK FROM IMAGE
    if (!empty($watermarkImage))
    {   // load image, pixelate, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // ok, it's here so pixelate, resize and save it
                $img->load("$prefix$folder/edit/$filename")
                    ->overlay("$prefix$watermarkImage",
                        "$watermarkPosition",
                        $watermarkOpacity)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    $response['status'] = 'true';
    $response['action'] = 'pixelate';
    echo json_encode($response);
} // ./ pixelate


// RESET FILE
if ($action === "reset-file")
{   // reset file from original folder
    // if WATERMARK IS SET
    if (!empty($watermark))
    {   // load from original folder, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/original/$filename")
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetX",
                "$offsetY",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                $img->load("$prefix$folder/original/$filename")
                    ->text("$watermark",
                        "$ttfPrefix$watermarkFont",
                        $watermarkTextSize,
                        "#$watermarkColor",
                        "$watermarkPosition",
                        "$offsetX",
                        "$offsetY",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    else
    {   // if NO WATERMARK is set, just load file from original folder and save
        $img->load("$prefix$folder/original/$filename")
            ->save("$prefix$folder/edit/$filename")
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // load image from edit folder, watermark it, change size + save TN
                $img->load("$prefix$folder/edit/$filename")
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    // WATERMARK FROM IMAGE
    if (!empty($watermarkImage))
    {  // load from original folder, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/original/$filename")
            ->save("$prefix$folder/edit/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
        // check if thumbnail directory exist...
        if (is_dir("$prefix$folder/thumbnails/"))
        {   // check if image is in tn folder
            if (is_file("$prefix$folder/thumbnails/$filename"))
            {   // ok, it's here so slap the watermark, resize and save it
                $img->load("$prefix$folder/edit/$filename")
                    ->overlay("$prefix$watermarkImage",
                        "$watermarkPosition",
                        $watermarkOpacity)
                    ->fit_to_width($thumbnailWidth)
                    ->save("$prefix$folder/thumbnails/$filename");
            }
        }
    }
    $response['status'] = 'true';
    $response['action'] = 'reset changes and restore original image';
    echo json_encode($response);
} // ./ reset-file

// DELETE file
if ($action === "delete-file")
{   // delete file from all folders, except original
    require_once '../../../classes/db.php';
    require_once '../../../classes/alert.php';
    $db = new \YAWK\db();

    // DELETE FILES
    // check if there is a thumbnail folder
    if (is_dir("$prefix$folder/thumbnails/"))
    {   // check if there is a thumbnail image
        if (is_file("$prefix$folder/thumbnails/$filename"))
        {   // delete thumbnail image
            unlink("$prefix$folder/thumbnails/$filename");
        }
    }
    // check if there is an edit folder
    if (is_dir("$prefix$folder/edit/"))
    {   // check if there is a image in this folder
        if (is_file("$prefix$folder/edit/$filename"))
        {   // delete temporary edit image
            unlink("$prefix$folder/edit/$filename");
        }
    }
    // check if there is an image in root folder
    if (is_file("$prefix$folder/$filename"))
    {   // delete temporary edit image
        unlink("$prefix$folder/$filename");
    }
    // create array for json response
    $response = array();
    // finally: delete item from database
    if ($db->query("DELETE FROM {plugin_gallery_items} WHERE id = $itemID"))
    {   // all good...
        $response['status'] = 'delete';
        $response['action'] = 'delete';
        echo json_encode($response);
    }
    // image deletion completed, return response status as json

} // ./ delete-file