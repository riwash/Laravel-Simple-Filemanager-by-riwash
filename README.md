# Simple File Manager for Laravel

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.0-8892BF.svg)](https://php.net/)
[![Laravel Version](https://img.shields.io/badge/laravel-%5E7.0%20%7C%5E8.0%20%7C%5E9.0%20%7C%5E10.0%20%7C%5E11.0%20%7C%5E12.0-FF2D20.svg)](https://laravel.com/)

A lightweight, easy-to-use file manager package for Laravel applications with built-in CKEditor integration.

## Features

- **File Upload & Management** - Upload, view, edit, and delete files
- **File Picker with Popup** - Built-in file picker that opens in a popup for easy file selection
- **CKEditor Integration** - Built-in support for CKEditor file browser
- **Multiple Storage Drivers** - Supports local storage and AWS S3
- **Blade Component** - Reusable file upload component with integrated file picker
- **Custom File Picker** - Build your own file picker using postMessage API
- **Search Functionality** - Search files by title
- **Responsive UI** - Clean, modern interface
- **Pagination** - Handles large file collections efficiently

## Installation

Install the package via Composer:

```bash
composer require riwash/simple-file-manager
```

## Setup

### 1. Publish Assets

Publish the configuration, views, and public assets:

```bash
php artisan vendor:publish --tag=simple-file-manager
```

This will publish:
- Configuration to `config/riwashfilemanager.php`
- Views to `resources/views/vendor/simple-file-manager`
- Assets to `public/vendor/simple-file-manager`

### 2. Run Migrations

Run the migrations to create the file manager database table:

```bash
php artisan migrate
```

### 3. Configure Storage (Optional)

For local storage, ensure the storage link exists:

```bash
php artisan storage:link
```

For AWS S3, configure your credentials in `config/filesystems.php` and set the `FILE_UPLOAD_TYPE` environment variable.

## Configuration

The configuration file `config/riwashfilemanager.php` contains:

```php
return [
    'default' => env('FILE_UPLOAD_TYPE', 'local'), // local, aws
    'prefix' => 'file-manager',                   // route prefix
    'middleware' => ['web'],                      // route middleware
];
```

Add to your `.env` file:

```env
# Storage type: local or aws
FILE_UPLOAD_TYPE=local
```

## Usage

### Access the File Manager

After installation, visit the file manager at:

```
http://your-app.com/file-manager
```

Available routes:
- `GET /file-manager` - File manager dashboard
- `GET /file-manager/files` - File browser (for CKEditor/popups)
- `GET /file-manager/demo` - Demo page

### Blade Component (FileUploader)

The package includes a `FileUploader` Blade component (`Riwash\SimpleFileManager\Components\FileUploader`) for easy file selection with integrated file picker popup.

**Component Class:** `Riwash\SimpleFileManager\Components\FileUploader`

**Component Properties:**

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `name` | string | `image_url` | Input field name attribute |
| `id` | string | auto-generated | Input field ID (auto-generated as `file-upload-{random}` if not provided) |
| `placeholder` | string | `Select file` | Placeholder text for the input field |
| `previewWidth` | string | `200px` | Width of the image preview (CSS value) |

**Basic Usage:**

```blade
<x-fileupload 
    name="image_url" 
    id="image-input"
    placeholder="Select file"
    previewWidth="200px" 
/>
```

**Advanced Usage with All Parameters:**

```blade
<x-fileupload 
    name="thumbnail" 
    id="product-thumbnail"
    placeholder="Choose product thumbnail..."
    previewWidth="150px" 
/>
```

**The component automatically:**
- Generates a unique ID if not provided
- Creates a text input field with the specified name and placeholder
- Adds a "Select File" button that opens the file manager popup
- Displays an image preview next to the input when a file is selected
- Uses `postMessage` API for communication between popup and parent window

**Programmatic Usage:**

You can also use the component class directly in your PHP code:

```php
use Riwash\SimpleFileManager\Components\FileUploader;

$component = new FileUploader(
    name: 'cover_image',
    id: 'cover-image-input',
    placeholder: 'Select cover image',
    previewWidth: '300px'
);

return $component->render();
```

### CKEditor Integration

To integrate with CKEditor, use the built-in JavaScript:

```html
<textarea id="editor1" name="content"></textarea>

<script src="{{ asset('vendor/simple-file-manager/simple-file-manager.js') }}"></script>
<script>
    CKEDITOR.replace('editor1', {
        filebrowserBrowseUrl: '{{ route('file-manager.files') }}',
        filebrowserUploadUrl: '{{ route('file-manager.upload') }}?_token={{ csrf_token() }}'
    });
</script>
```

### File Picker (Component with Popup)

The Blade component includes a built-in file picker that opens the file manager in a popup:

```blade
<x-fileupload 
    name="image_url" 
    id="image-input"
    placeholder="Select file"
    previewWidth="200px" 
/>
```

**How it works:**
- Clicking the "Select File" button opens the file manager in a popup window
- When a file is selected, the URL is automatically populated in the input field
- An image preview appears next to the input (for image files)
- The component uses `postMessage` for enhanced integration

### Custom File Picker

Create your own file picker implementation:

**1. HTML Structure**

```blade
<div class="custom-file-picker">
    <input type="text" name="file_url" id="my-file-input" readonly>
    <button type="button" onclick="openCustomFileManager('my-file-input')">
        Browse
    </button>
    <img id="preview-my-file-input" style="display:none; max-width:200px;">
</div>
```

**2. JavaScript Function**

```javascript
function openCustomFileManager(inputId) {
    window.open(
        "{{ route('file-manager.files') }}?input=" + inputId,
        "FileManager",
        "width=900,height=600"
    );
}

// Listen for file selection (optional enhancement)
window.addEventListener('message', function(event) {
    if (event.data.type === 'file-selected') {
        console.log('File selected:', event.data.fileUrl);
        // Custom logic here
    }
});
```

**3. File Selection Callbacks**

The file manager supports multiple callback methods:

- **Input Field Population**: Automatically fills the input with the selected file URL
- **Image Preview**: Updates the preview image (if element ID matches `preview-{inputId}`)
- **postMessage**: Sends a message event to the parent window for custom handling
- **CKEditor Integration**: Works with CKEditor's file browser callbacks

**4. Advanced Custom Picker Example**

```blade
<div class="file-picker-advanced">
    <div class="input-group">
        <input type="text" 
               id="thumbnail" 
               name="thumbnail" 
               class="form-control" 
               placeholder="Select thumbnail...">
        <button type="button" 
                class="btn btn-primary" 
                onclick="pickFile('thumbnail')">
            <i class="bi bi-folder"></i> Browse
        </button>
    </div>
    <div id="thumbnail-info" class="file-info mt-2" style="display:none;">
        <img id="preview-thumbnail" src="" alt="Preview" style="max-height:150px;">
        <p class="file-name mt-1"></p>
    </div>
</div>

<script>
function pickFile(inputId) {
    const popup = window.open(
        "{{ route('file-manager.files') }}?input=" + inputId,
        "FilePicker",
        "width=1000,height=700,scrollbars=yes"
    );
    
    // Optional: focus the popup
    if (popup) popup.focus();
}

// Handle file selection via postMessage
window.addEventListener('message', function(e) {
    if (e.data.type === 'file-selected' && e.data.inputId === 'thumbnail') {
        // Show file info
        document.getElementById('thumbnail-info').style.display = 'block';
        document.getElementById('thumbnail-info').querySelector('.file-name').textContent = 
            e.data.fileUrl.split('/').pop();
    }
});
</script>
```

### Customizing Views

After publishing, you can customize the views in:

```
resources/views/vendor/simple-file-manager/
├── index.blade.php      # Main file manager
├── files.blade.php      # File browser for CKEditor
├── demo.blade.php       # Demo page
└── fileupload.blade.php # File upload component
```

## AWS S3 Configuration

To use AWS S3 for file storage:

1. Install the AWS SDK:

```bash
composer require league/flysystem-aws-s3-v3
```

2. Configure S3 in `config/filesystems.php`:

```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
],
```

3. Set the environment variable:

```env
FILE_UPLOAD_TYPE=aws
```

## File Model

Access uploaded files programmatically:

```php
use Riwash\SimpleFileManager\Models\RiwashFilemanager;

// Get all files
$files = RiwashFilemanager::all();

// Search files
$files = RiwashFilemanager::where('title', 'like', '%search%')->get();

// Create new file record
$file = RiwashFilemanager::create([
    'title' => 'My File',
    'filename' => 'original.jpg',
    'path' => 'file-manager/abc123.jpg',
    'url' => 'https://example.com/storage/file-manager/abc123.jpg',
    'mime_type' => 'image/jpeg',
    'size' => 1024000,
]);
```

## Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/file-manager` | `file-manager.index` | Main file manager |
| GET | `/file-manager/files` | `file-manager.files` | File browser view |
| POST | `/file-manager/upload` | `file-manager.upload` | Upload file |
| PUT | `/file-manager/edit` | `file-manager.edit` | Update file title |
| DELETE | `/file-manager/delete/{id}` | `file-manager.destroy` | Delete file |
| GET | `/file-manager/demo` | `file-manager.demo` | Demo page |

## Security

- File uploads are validated (max 10MB by default)
- Routes use configurable middleware (default: `web`)
- Files are stored with unique random filenames (12 characters)
- Original file extensions are preserved

## Requirements

- PHP >= 8.0
- Laravel ^7.0 || ^8.0 || ^9.0 || ^10.0 || ^11.0 || ^12.0

## License

This package is open-source software licensed under the [MIT License](LICENSE).

## Credits

- **Author:** Riwash Chamlagain ([technicalriwash@gmail.com](mailto:technicalriwash@gmail.com))

## Support

For issues and feature requests, please use the [GitHub issue tracker](https://github.com/riwash/simple-file-manager/issues).
