<?php
include '../classes/SimpleImage.php';
$img = new \YAWK\SimpleImage();

// prepare vars
$prefix = "../../../../";
$action = $_POST['action'];
$folder = $_POST['folder'];
$filename = $_POST['filename'];
$itemID = $_POST['itemID'];
$createThumbnails = $_POST['createThumbnails'];
$thumbnailWidth = $_POST['thumbnailWidth'];
$watermark = $_POST['watermark'];
$watermarkImage = $_POST['watermarkImage'];
$watermarkOpacity = $_POST['watermarkOpacity'];
$watermarkPosition = $_POST['watermarkPosition'];
$offsetRight = $_POST['offsetRight'];
$offsetBottom = $_POST['offsetBottom'];
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
        // if watermark is set
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
                       "$offsetRight",
                       "$offsetBottom",
                       "#$watermarkBorderColor",
                        $watermarkBorder)
                ->save("$prefix$folder/$filename");
        }
        else
            {   // if no watermark is set, just flip and save
                $img->load("$prefix$folder/$filename")
                    ->flip("x")
                    ->save("$prefix$folder/$filename");
            }

        // if watermark FROM IMAGE is set
        if (!empty($watermarkImage))
        {   // load image, flip X, overlay image watermark and save to image gallery root folder
            $img->load("$prefix$folder/edit/$filename")
                ->flip("x")
                ->overlay("$prefix$watermarkImage",
                          "$watermarkPosition",
                           $watermarkOpacity)
                ->save("$prefix$folder/$filename");
        }
    } // ./ flip-horizontal


// FLIP X (horizontal)
    if ($action === "flip-vertical")
    {   // flip image vertical (Y axis)
        // if watermark is set
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
                        "$offsetRight",
                        "$offsetBottom",
                        "#$watermarkBorderColor",
                        $watermarkBorder)
                ->save("$prefix$folder/$filename");
        }
        else
        {   // if no watermark is set, just flip and save
            $img->load("$prefix$folder/$filename")
                ->flip("y")
                ->save("$prefix$folder/$filename");
        }

        // if watermark FROM IMAGE is set
        if (!empty($watermarkImage))
        {   // load image, flip X, overlay image watermark and save to image gallery root folder
            $img->load("$prefix$folder/edit/$filename")
                ->flip("y")
                ->overlay("$prefix$watermarkImage",
                          "$watermarkPosition",
                           $watermarkOpacity)
                ->save("$prefix$folder/$filename");
        }
    } // ./ flip-vertical


// ROTATE 90 degrees
if ($action === "rotate-90")
{   // rotate image -90 degrees (to the left)
    // if watermark is set
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
                    "$offsetRight",
                    "$offsetBottom",
                    "#$watermarkBorderColor",
                    $watermarkBorder)
            ->save("$prefix$folder/$filename");
    }
    else
    {   // if no watermark is set, just rotate and save
        $img->load("$prefix$folder/$filename")
            ->rotate(-90)
            ->save("$prefix$folder/$filename");
    }

    // if watermark FROM IMAGE is set
    if (!empty($watermarkImage))
    {   // load image, rotate, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->rotate(-90)
            ->overlay("$prefix$watermarkImage",
                      "$watermarkPosition",
                       $watermarkOpacity)
            ->save("$prefix$folder/$filename");
    }
} // ./ rotate-90


// CONTRAST PLUS
if ($action === "contrast-plus")
{   // add contrast +10 to image
    // if watermark is set
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
                "$offsetRight",
                "$offsetBottom",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
    }
    else
    {   // if no watermark is set, just add contrast and save
        $img->load("$prefix$folder/$filename")
            ->contrast(-5)
            ->save("$prefix$folder/$filename");
    }

    // if watermark FROM IMAGE is set
    if (!empty($watermarkImage))
    {   // load image, add contrast, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->contrast(-5)
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
    }
} // ./ contrast-plus


// CONTRAST MINUS
if ($action === "contrast-minus")
{   // remove contrast -10 from image
    // if watermark is set
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
                "$offsetRight",
                "$offsetBottom",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
    }
    else
    {   // if no watermark is set, just remove contrast and save
        $img->load("$prefix$folder/$filename")
            ->contrast(5)
            ->save("$prefix$folder/$filename");
    }

    // if watermark FROM IMAGE is set
    if (!empty($watermarkImage))
    {   // load image, remove contrast, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->contrast(5)
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
    }
} // ./ contrast-plus


// BRIGHTNESS PLUS
if ($action === "brightness-plus")
{   // add brightness +5 to image
    // if watermark is set
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
                "$offsetRight",
                "$offsetBottom",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
    }
    else
    {   // if no watermark is set, just add brightness and save
        $img->load("$prefix$folder/$filename")
            ->brightness(5)
            ->save("$prefix$folder/$filename");
    }

    // if watermark FROM IMAGE is set
    if (!empty($watermarkImage))
    {   // load image, add brightness, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->brightness(5)
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
    }
} // ./ brightness-plus


// BRIGHTNESS MINUS
if ($action === "brightness-minus")
{   // remove brightness -5 from image
    // if watermark is set
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
                "$offsetRight",
                "$offsetBottom",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
    }
    else
    {   // if no watermark is set, just remove brightness and save
        $img->load("$prefix$folder/$filename")
            ->brightness(-5)
            ->save("$prefix$folder/$filename");
    }

    // if watermark FROM IMAGE is set
    if (!empty($watermarkImage))
    {   // load image, remove brightness, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->brightness(-5)
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
    }
} // ./ brightness-remove


// SHARPEN
if ($action === "sharpen")
{   // sharpen image
    // if watermark is set
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
                "$offsetRight",
                "$offsetBottom",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
    }
    else
    {   // if no watermark is set, just sharpen and save
        $img->load("$prefix$folder/$filename")
            ->sharpen()
            ->save("$prefix$folder/$filename");
    }

    // if watermark FROM IMAGE is set
    if (!empty($watermarkImage))
    {   // load image, sharpen, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->sharpen()
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
    }
} // ./ sharpen


// SELECTIVE BLUR (magic wand)
if ($action === "selective-blur")
{   // set a selective blur on that image. good for flattening skin.
    // if watermark is set
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
                "$offsetRight",
                "$offsetBottom",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
    }
    else
    {   // if no watermark is set, just set blur and save
        $img->load("$prefix$folder/$filename")
            ->blur('selective', 2)
            ->save("$prefix$folder/$filename");
    }

    // if watermark FROM IMAGE is set
    if (!empty($watermarkImage))
    {   // load image, set blur, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->blur('selective', 2)
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
    }
} // ./ selective-blur


// GREYSCALE
if ($action === "greyscale")
{   // greyscale this image
    // if watermark is set
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
                "$offsetRight",
                "$offsetBottom",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
    }
    else
    {   // if no watermark is set, just remove color and save
        $img->load("$prefix$folder/$filename")
            ->desaturate()
            ->save("$prefix$folder/$filename");
    }

    // if watermark FROM IMAGE is set
    if (!empty($watermarkImage))
    {   // load image, remove color, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->desaturate()
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
    }
} // ./ greyscale


// SEPIA image
if ($action === "sepia")
{   // sepia that image. good for flattening skin.
    // if watermark is set
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
                "$offsetRight",
                "$offsetBottom",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
    }
    else
    {   // if no watermark is set, just sepia and save
        $img->load("$prefix$folder/$filename")
            ->sepia()
            ->save("$prefix$folder/$filename");
    }

    // if watermark FROM IMAGE is set
    if (!empty($watermarkImage))
    {   // load image, sepia, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->sepia()
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
    }
} // ./ sepia


// PIXELATE image
if ($action === "pixelate")
{   // set pixelate that image. good for flattening skin.
    // if watermark is set
    if (!empty($watermark))
    {   // load, pixelate, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->pixelate(12)
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetRight",
                "$offsetBottom",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
    }
    else
    {   // if no watermark is set, just pixelate and save
        $img->load("$prefix$folder/$filename")
            ->pixelate(12)
            ->save("$prefix$folder/$filename");
    }

    // if watermark FROM IMAGE is set
    if (!empty($watermarkImage))
    {   // load image, pixelate, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/edit/$filename")
            ->pixelate(12)
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
    }
} // ./ pixelate


// RESET FILE
if ($action === "reset-file")
{   // reset file from original folder
    // if watermark is set
    if (!empty($watermark))
    {   // load from original folder, save to edit (tmp), slap the watermark on and finally save image to img gallery root folder
        $img->load("$prefix$folder/original/$filename")
            ->save("$prefix$folder/edit/$filename")
            ->text("$watermark",
                "$ttfPrefix$watermarkFont",
                $watermarkTextSize,
                "#$watermarkColor",
                "$watermarkPosition",
                "$offsetRight",
                "$offsetBottom",
                "#$watermarkBorderColor",
                $watermarkBorder)
            ->save("$prefix$folder/$filename");
    }
    else
    {   // if no watermark is set, just load file from original folder and save
        $img->load("$prefix$folder/original/$filename")
            ->save("$prefix$folder/$filename");
    }

    // if watermark FROM IMAGE is set
    if (!empty($watermarkImage))
    {   // load image from original folder, overlay image watermark and save to image gallery root folder
        $img->load("$prefix$folder/original/$filename")
            ->overlay("$prefix$watermarkImage",
                "$watermarkPosition",
                $watermarkOpacity)
            ->save("$prefix$folder/$filename");
    }
} // ./ reset-file

