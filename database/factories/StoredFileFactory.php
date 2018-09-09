<?php

use Faker\Generator as Faker;

$factory->define(\App\StoredFile::class, function (Faker $faker) {
    $file = $faker->file(storage_path('../tests/data'), storage_path('app/uploads'), false);
    $ext  = explode('.', $file);
    $ext  = end($ext);
    return [
        'filename_orig'    => $faker->word . '.' . $ext,
        'filename'         => $file,
        'type'             => 'image/jpeg',
        'upload_completed' => true,
    ];
});
