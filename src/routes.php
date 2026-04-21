<?php

use Illuminate\Support\Facades\Route;
use Riwash\SimpleFileManager\Http\Controllers\FileManagerController;

Route::group([
    'prefix' => config('riwashfilemanager.prefix', 'file-manager'),
    'middleware' => config('riwashfilemanager.middleware', ['web']),
], function () {
    Route::get('/', [FileManagerController::class, 'index'])->name('file-manager.index');
    Route::post('/upload', [FileManagerController::class, 'upload'])->name('file-manager.upload');
    Route::delete('/delete/{id}', [FileManagerController::class, 'destroy'])->name('file-manager.destroy');
    Route::get('/files', [FileManagerController::class, 'files'])->name('file-manager.files');
    Route::put('/edit', [FileManagerController::class, 'update'])->name('file-manager.edit');
    Route::get('/demo', [FileManagerController::class, 'demo'])->name('file-manager.demo');
});
