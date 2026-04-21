<?php

namespace Riwash\SimpleFileManager\Models;

use Illuminate\Database\Eloquent\Model;

class RiwashFilemanager extends Model
{
    protected $table = 'riwash_filemanager';

    protected $fillable = [
        'title',
        'filename',
        'path',
        'url',
        'mime_type',
        'size',
    ];
}
