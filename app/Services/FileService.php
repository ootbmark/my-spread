<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 25.07.2019
 * Time: 14:59
 */

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileService
{
    /**
     * Save image
     * @param $image
     * @param $object
     * @param $path
     * @param $field
     */
    public function saveCropImage($image, $object, $path, $field = 'image')
    {
        $data = explode(',', $image);
        $img_string = $data[1];
        $imageFileName = '/'. $path .'/' .  time() . rand(1000000, 9999999) . '.jpg';
        $storage = Storage::disk('public');
        $storage->put($imageFileName, base64_decode($img_string), 'public');
        $object->$field = $imageFileName;
        $object->save();
    }


    /**
     * Save image
     * @param $file
     * @param $object
     * @param $path
     * @param $field
     */
    public function saveImage($file, $object, $path, $field = 'image')
    {
        $imageFileName = time() . rand(1000000, 9999999) . '.' . $file->getClientOriginalExtension();
        $imageFileName = '/'. $path .'/' . $imageFileName;
        $storage = Storage::disk('public');
        $storage->put($imageFileName, file_get_contents($file), 'public');
        $object->$field = $imageFileName;
        $object->save();
    }

    /**
     * Save image
     * @param $content
     * @param $name
     * @param $path
     * @param $object
     * @param $field
     */
    public function saveFileFromContent($content, $name, $path, $object, $field = 'image')
    {
        $imageFileName  = '/'. $path .'/' .  time() . '_' .  $name;
        $storage = Storage::disk('public');
        $storage->put( $imageFileName, $content, 'public');
        $object->$field = $imageFileName;
        $object->save();
    }


    /**
     * @param $file
     * @param $path
     * @return string
     */
    public function saveFile($file, $path)
    {
        $fileName = time() . rand(1000000, 9999999) . '.' . $file->getClientOriginalExtension();
        $fileName = '/'. $path .'/' . $fileName;
        $storage = Storage::disk('public');
        $storage->put($fileName, file_get_contents($file), 'public');
        return $fileName;
    }



}
