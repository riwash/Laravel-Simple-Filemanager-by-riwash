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
