<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Wnx\ScreeenlyClient\Screenshot;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class ImageService
{

    /**
     * Save photo to S3 server
     * @param $file
     * @param $path
     * @return string
     */
    public static function saveImage($file, $path)
    {

        $img_size = getimagesize($file);

        $imageFileName = time() . rand(1, 999999999) . '.' . $file->getClientOriginalExtension();

        if ($img_size[0] > 1920) {

            $image = Image::make($file)->encode('jpg', 75);

            $height = round($img_size[1] * 800 / $img_size[0], 2);

            $image->resize(1920, $height);

            $file = $image->stream();

        } else {

            $file = file_get_contents($file);
        }

        $s3 = Storage::disk('public');
        $filePath = '/' . $path . '/' . $imageFileName;

        $s3->put($filePath, $file, 'public');


        return $path . '/' . $imageFileName;

    }


    /**
     * @param $file
     * @param $path
     * @param $object
     * @param $key
     * @return string
     */
    public static function saveFile($file, $path)
    {
        $fileName = time() . rand(1, 999999999) . '.' . $file->getClientOriginalExtension();
        $s3 = Storage::disk('public');
        $filePath = '/' . $path . '/' . $fileName;
        $s3->put($filePath, file_get_contents($file), 'public');

        return $path . '/' . $fileName;
    }


    /**
     * @param $input
     * @param $name
     * @param $widths
     */
    public static function attachmentThumb($input, $name, $widths)
    {
        foreach ($widths as $width) {
            self::attachment($input, $name, $width);
        }
    }


    /**
     * @param $input
     * @param $name
     * @param $width
     */
    public static function attachment($input, $name, $width)
    {
        $img = Image::make($input)->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        })->response();
        $s3 = Storage::disk('s3');
        $filePath = "thumb/" . $name;
        $s3->put($filePath, $img->getContent(), 'public');

        imagewebp(imagecreatefromstring($img->getContent()), 'php.webp', 90);
        $s3->put($filePath . '.webp', file_get_contents(public_path() . '/php.webp'), 'public');
    }

}
