<?php

return [
    'default' => env('FILE_UPLOAD_TYPE', 'local'), // local store,aws,alibaba bucket
    'prefix' => 'file-manager', // route prefix
    'middleware' => ['web'],    // default middleware
];
