<?php


namespace App\Services\SaveFiles;


use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;

class SaveFilesFromRequestService
{
    public function save(Request $request, HasFiles $object): void
    {
        if($request->file('files')) {
            $object->files()->delete();
            $service = new FileService();
            foreach ($request->file('files') as $file){

                $filename = $service->saveFile($file, 'files');
                File::create([
                    'resource_id' => $object->getKey(),
                    'resource_type' => get_class($object),
                    'name' => $file->getClientOriginalName(),
                    'path' => $filename,
                ]);
            }
        }
    }
}
