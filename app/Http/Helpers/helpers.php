<?php

use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

function upload_image($image_file, $path_name)
{
    $manager = new ImageManager(new Driver());
    $image = $manager->read($image_file);
    $image->resize(300, 300, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });


    $path_location = file_location($path_name);

    $image_name = Str::uuid() . '.webp';
    $image->toWebp(80)->save(public_path($path_location.'/'. $image_name));

    return $image_name;
}

function delete_image($image_name, $path_name)
{
    $path_location = file_location($path_name);
    unlink(public_path($path_location.'/'.$image_name));
}


function file_location($path_name)
{
    $path_array = [
        'profile' => 'assets/frontend/user',
    ];

    return $path_array[$path_name];
}
