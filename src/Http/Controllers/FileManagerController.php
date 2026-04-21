<?php

namespace Riwash\SimpleFileManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Riwash\SimpleFileManager\Models\RiwashFilemanager;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query from request
        $search = $request->input('search');

        $files = RiwashFilemanager::when($search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->latest()
            ->paginate(50);

        // Keep search query in pagination links
        $files->appends(['search' => $search]);

        return view('simple-file-manager::index', compact('files', 'search'));
    }

    public function files(Request $request)
    {
        // Get the search query from request
        $search = $request->input('search');

        $files = RiwashFilemanager::when($search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->latest()
            ->paginate(50);

        // Keep search query in pagination links
        $files->appends(['search' => $search]);

        return view('simple-file-manager::files', compact('files', 'search'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10 MB
        ]);

        try {
            $file = $request->file('file');

            // Generate unique filename: 12 characters + original extension
            $uniqueName = Str::random(12) . '.' . $file->getClientOriginalExtension();

            // Get upload type from config
            $uploadType = config('riwashfilemanager.default', 'local');

            if ($uploadType === 'aws') {
                $disk = 's3'; // must match disk name in config/filesystems.php
                $path = $file->storeAs('file-manager', $uniqueName, $disk);
                $url = Storage::disk($disk)->url($path); // get public URL from S3
            } else {
                $disk = 'public';
                $path = $file->storeAs('file-manager', $uniqueName, $disk);
                $url = asset(Storage::url($path)); // local URL
            }

            // Save file info in database
            $fileItem = RiwashFilemanager::create([
                'filename' => $file->getClientOriginalName(),
                'title' => $request->title ?? null,
                'path' => $path,
                'url' => $url,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ]);

            return back()->with('success', 'File uploaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $file = RiwashFilemanager::findOrFail($request->id);
        $file->title = $request->title;
        $file->save();

        return back()->with('success', 'File title updated successfully!');
    }

    public function destroy($id)
    {
        try {
            // Find the file in database
            $fileItem = RiwashFilemanager::findOrFail($id);

            // Get disk from config
            $uploadType = config('riwashfilemanager.default', 'local');
            $disk = $uploadType === 'aws' ? 's3' : 'public';

            // Delete the physical file from storage
            if (Storage::disk($disk)->exists($fileItem->path)) {
                Storage::disk($disk)->delete($fileItem->path);
            }

            // Delete record from database
            $fileItem->delete();

            return back()->with('success', 'File deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    public function demo()
    {
        return view('simple-file-manager::demo');
    }
}
