<!DOCTYPE html>
<html lang="demo">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script> </script>
</head>

<body class="antialiased">
   
<div class="container py-5">
    <h2 class="mb-4">Demo File Upload Page</h2>

    <div class="card p-4 shadow-sm">
        <!-- Custom File Upload Component -->
        <div class="file-upload-wrapper">
            <x-fileupload name="profile_image" placeholder="Choose Profile Image" previewWidth="200px" />
        </div>


        <!-- Text editors -->
        <div class="mb-3">
            <label for="editor1" class="form-label">Content Editor 1</label>
            <textarea name="content" id="editor1" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label for="editor2" class="form-label">Content Editor 2</label>
            <textarea id="editor2" name="content2" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</div>
</body>

    <script>
    let activeInputId = null;

    function openFileManager(inputId) {
        activeInputId = inputId;

        window.open(
            "{{ route('file-manager.files') }}?input=" + inputId,
            "FileManager",
            "width=900,height=600",
        );
    }

    CKEDITOR.replace("editor1", {
        filebrowserBrowseUrl: "{{ route('file-manager.files') }}",
        filebrowserUploadUrl:
            "{{ route('file-manager.upload') }}?_token={{ csrf_token() }}",
    });

    CKEDITOR.replace("editor2", {
        filebrowserBrowseUrl: "{{ route('file-manager.files') }}",
        filebrowserUploadUrl:
            "{{ route('file-manager.upload') }}?_token={{ csrf_token() }}",
    });

       


    </script>
</body>

</html>