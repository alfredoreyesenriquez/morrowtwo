# Image #



## Introduction ##

A class to manipulate images with the GDlib, usually used to create thumbnails. For performance reasons there is a caching mechanism integrated.

## Example ##
**Controller which outputs an image**
```
<?php

// ... Controller code
 
$params = array(
    'height' => 100,
    'width' => 100,
    'sharpen' => true,
    'type' => 'jpg',
);
$filename = 'very_big_image.jpg';
 
// get thumbed image
$img_obj = $this->image->get($filename, $params, true);
 
ob_start();
imagejpeg($img_obj);
$img_data = ob_get_clean();
 
$this->view->setHandler('plain');
$this->view->setProperty('mimetype', 'image/jpg');
$this->view->setContent($img_data);
 
// ... Controller code
```

## Methods ##

### _load()_ ###
```
object load( string $file_path )
```
Loads a GIF, PNG or JPEG file and returns a GD image object. Other file formats will throw errors.

### _get()_ ###
```
mixed get( string $file_path , array $params , bool $return_ressource = false)
```
Creates an image with the given $params and returns the file path to the cached file. $filepath is the path to the source image.

$params is an array of the following possible parameters:

| Type | Keyname | Default | Description |
|:-----|:--------|:--------|:------------|
| string | type    | jpg     | The output file format. Possible values are gif, jpg and png. |
| integer | width   | 100     | The width of your thumbnail. The height (if not set) will be automatically calculated. |
| integer | height  | null    | The height of your thumbnail. The width (if not set) will be automatically calculated. |
| integer | shortside | null    | Set the shortest side of the image if width, height and longside is not set. |
| integer | longside | null    | Set the longest side of the image if width, height and shortside is not set. |
| boolean | sharpen | true    | Set to false if you do not want to use the Unsharp Mask. Thumbnail creation will be faster, but quality reduced. |
| boolean | crop    | true    | If set to true, image will be cropped in the center to destination width and height params, while keeping aspect ratio. Otherwise the image will get resized. |
| integer | crop\_position | 2       |             |
| boolean | extrapolate | true    | Set to false if for example your source image is smaller than the calculated thumb and you do not want the image to get extraploated. |
| boolean | dev     | false   | Set to true to add the used rendering time to the image. |
| boolean | hint    | false   | If set to true the image will have a lens icon. |
| string | overlay | null    | A PNG image which is used to create an overlay image. The position will be determined by "overlay\_position". For performance reasons the overlay image will not be checked for modification. |
| integer | overlay\_position | 9       | The position of the overlay image. Possible is an integer from 1 to 9. Here the positions:<br />1 2 3<br />4 5 6<br />7 8 9 |
| string | frame   | null    | A PNG image which is used to create a frame around the thumbnail. This image will be sliced into 3x3 blocks therefore the image dimensions have to be a multiplier of 3. For performance reasons the frame image will not be checked for modification. |

Set $return\_ressource to true to receive an GD image object.
If you set $return\_ressource to true the image will NOT be cached. It is useful if you want to continue work on that image.

### _prepareGet()_ ###
```
mixed _prepareGet( string $file_path , array $params)
```
... missing ...

### _getFromHash()_ ###
```
mixed _getFromHash( string $cache_filename)
```
... missing ...

### _preFilter()_ ###
```
void preFilter( object $img_obj , array $params )
```
This method does nothing at the moment. Define your own method when you extend the image class to do some modifications. Take a look at the example below.

### _postFilter()_ ###
```
void postFilter( object $img_obj , array $params )
```
This method does nothing at the moment. Define your own method when you extend the image class to do some modifications. Take a look at the example below.

## Extending the Image class ##

This class adds a polaroid style frame around the image. Use $this->load('image\_polaroid') in your controller to see your new beautiful image.

**image\_polaroid.class.php**
```
<?php
 
class Image_Polaroid extends Image {
    protected function postFilter ($img_obj, $params) {
        $width  = imagesx($img_obj);
        $height = imagesy($img_obj);
               
        $frame = 12;
        $frame_bottom = 30;
               
        $pol_img = imagecreatetruecolor($width+$frame, $height+$frame_bottom);
        $white = imagecolorallocate($pol_img, 255, 255, 255);
        imagefill($pol_img, 0, 0, $white);
        imagecopy($pol_img, $img_obj, ceil($frame/2), ceil($frame/2), 0, 0, $width, $height);
 
        return $pol_img;
    }
}
```

## Creating Thumbnails ##

If you just want to show thumbnails of your images, you can use the thumb shortcut in the serpent view handler.

```
~
$params = array(
    'height' => 100,
    'width' => 100,
    'sharpen' => true,
    'type' => 'jpg',
);
:thumb('your_file.jpg', $params);
~
```