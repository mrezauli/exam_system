<?php

namespace App\Helpers;

/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 12/7/15
 * Time: 5:19 PM
 */
class ImageResize
{
    /*
     * $newWidth :: image size in width
     * $targetFile :: taget file and location
     * $originalFile  :: original file
     */

    public static function shift($sft){
        $shift_array = array('s1'=>'Shift 1','s2'=>'Shift 2','s3'=>'Shift 3','s4'=>'Shift 4','s5'=>'Shift 5','s6'=>'Shift 6','s7'=>'Shift 7','s8'=>'Shift 8');
        foreach($shift_array as $str => $val){
            if($str == $sft)return $val;
        }
    }

    public static function resize($newWidth, $targetFile, $originalFile) {

        $info = getimagesize($originalFile);
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                break;

            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                break;

            default:
                return false;
        }

        $img = $image_create_func($originalFile);
        list($width, $height) = getimagesize($originalFile);

        $newHeight = ($height / $width) * $newWidth;
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        #$image_save_func($tmp, "$targetFile.$new_image_ext"); // using extension as well as case

        $image_save_func($tmp, "$targetFile");

        return true;
    }
}