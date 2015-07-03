# ImageObject #



## Introduction ##

A class to convert/manipulate images with the GDlib, usually used to create thumbnails. To allow a more versatile usage of this class independent of the context it is used in it does not offer any kind of caching. Simply use the default caching Morrow offers :)

## Example ##

The constructor has exactly one parameter which can be any kind of image. Feel free to either pass a local path to an image (or URL if allowed) or a GD-Resource or even any kind of string representation of GIF, JPEG or PNG to the constructor. The class also supports "chaining" as every method beside the constructor itself and the show, get and getResource methods will always return a reference to this.

**Controller which outputs an image**
```
<?php
// ... Controller code
 
$image = new ImageObject(FW_PATH . 'cameron.jpg');
$image->resize(250, 250, 1);
$image->crop(250, 250);
$image->sharpen();
$image->addReflection();
$image->show('png');
die();
?>
```

## Methods ##

### _resize()_ ###
```
bool resize( int $width , int $height , int $mode = 0 , bool $enlarge = true)
```
Resizes the image according to the given values for width and height (in px) using the defined mode. mode can be set to one of the following values:

| Value | Description |
|:------|:------------|
| 0     | scale to width & height (ignoring aspect ratio) |
| 1     | scale to width (keeping aspect ratio for height) |
| 2     | scale to height (keeping aspect ratio for height) |

### _crop()_ ###
```
bool crop( int $width , int $height , int $x = false, int $y = false)
```
Crops the image according to the given values for width and height (in px). You may optionally pass additional values for x and y (also in px) which define the top left coordinates of the cropping area. If x and/or y are set to false (default setting) the image is cropped around its center which is automatically determined.

### _flip()_ ###
```
bool flip( int $axes = 1)
```
Flips the image around the defined axes. axes can be set to one of the following values:

| Value | Description |
|:------|:------------|
| 1     | Flips the image around its y-axes |
| 2     | Flips the image around its x-axes |

### _blur()_ ###
```
bool blur( int $amount = 100, bool $alpha = true)
```
Blurs the image according to the given value for amount. Setting alpha to true (default) will preserve the original image alpha information while setting it to false discards any kind of alpha information (and greatly improves performance).

### _sharpen()_ ###
```
bool sharpen( int $amount = 50, int $radius = 1, int $threshold = 0)
```
Sharpens the image according to the given values for amount, radius and treshold. The values of the parameters try to imitate Photoshops values when using its built-in sharpening filter.

### _addBorder()_ ###
```
bool addBorder( string $color = '#000', int $stroke = 1)
```
Adds a simple border (or outline) to an image according to the given values for color (any hex-color) and stroke (in px).

### _addReflection()_ ###
```
bool addReflection( int $aperture = 80, int $height = false, int $alpha = 40)
```
Adds an Apple like reflection with real alpha to an image according to the given values for aperture (in percent), height (in px) and alpha (in percent). If height is set to false it will be automatically calculated using aperture and the actual height of the image.

### _addShadow()_ ###
```
bool addShadow( $color = '#000', $background = '#fff', $alpha = 50, $angle = 135, $distance = 2, $size = 5, $spread = 0)
```
Adds a Photoshop like dropshadow with real alpha to an image according to the given values for color (any hex-color), background (any hex-color), alpha (in percent), angle (in degress), distance (in px), size (in px) and spread (in px).

### _grayscale()_ ###
```
grayscale( )
```
Converts the image to grayscale

### _invert()_ ###
```
invert( )
```
Inverts the image

### _brightness()_ ###
```
brightness( int $percent = 25 )
```
Changes the brightness of the image in percent

### _hsl()_ ###
```
hsl( int $hue = 0 , int $saturation = NULL , int $lightness = nULL )
```
Tries to mimic Photoshops Hue/Saturation/Lightness settings/filters.

Parameter "hue" must be in range -180 to +180
Parameter "saturation" must be in range -100 to + 100
Parameter "lightness" must be in range -100 to + 100

### _get()_ ###
```
binary get( string $type = 'png', bool $interlace = false , int $quality = NULL , int $filter = 248)
```
Returns an image as a binary representation according to given type (png, jpeg or gif).

If type is set to jpeg "quality" (in percent, 0-100) is used as compression ratio.
If type is set to png "quality" (compression-level, 0-9 where 0 is "no compression" and 9 is "max compression") is used as compression ratio.
If type is set to png "filter" is used as an optional parameter for the various types of PNG-Filters that may be set for "imagepng"

### _show()_ ###
```
show( string $type = 'png', bool $interlace = false , int $quality = NULL , int $filter = NULL )
```
Outputs an image as a binary representation according to given type (png, jpeg or gif).

If type is set to jpeg "quality" (in percent, 0-100) is used as compression ratio.
If type is set to png "quality" (compression-level, 0-9 where 0 is "no compression" and 9 is "max compression") is used as compression ratio.
If type is set to png "filter" is used as an optional parameter for the various types of PNG-Filters that may be set for "imagepng"

### _getResource()_ ###
```
resource &getResource( )
```
Returns a pointer to the current image GD-Resource