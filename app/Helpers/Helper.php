<?php

use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

function uploadImage($file, $height, $width, $folder)
{
    $image_name = Str::random(10).'.'.$file->getClientOriginalExtension();
    $path = public_path("uploads/{$folder}/{$image_name}");
    $ImageManager = new ImageManager(new Driver);
    $thumbImage = $ImageManager->read($path);
    $thumbImage->cover($height, $width);
    $thumbImage->save($path);
    // Image::make($file)->resize($height, $width)->save($path);

    // return $image_name;
}

function uploadFile($file, $folder)
{
    $file_name = $file->getClientOriginalName();
    $file->move(public_path("uploads/{$folder}"), $file_name);

    return $file_name;
}

function deleteFile($file, $folder)
{
    $file_path = public_path('uploads/'.$folder.'/'.$file);
    if (File::isFile($file_path)) {
        File::delete($file_path);
    }

    return true;
}

function getCurrentDateTime()
{
    $timeZone = config('app.timezone');
    $carbon = Carbon::now()->setTimezone($timeZone);

    return $carbon;
}

function isSuperAdmin()
{
    return Gate::allows('isSuperAdmin');
}

function setting()
{
    return Setting::first();
}

function jsonResponse(array $data)
{
    return new JsonResponse($data);
}
