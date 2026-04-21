<style>
    .file-upload-component {
        display: flex;
        align-items: center;
        max-width: 500px;
    }

    .file-upload-component .input-group {
        display: flex;
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #ced4da;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .file-upload-component .input-group input {
        flex: 1;
        padding: 10px 14px;
        border: none;
        font-size: 14px;
    }

    .file-upload-component .input-group input:focus {
        outline: none;
        box-shadow: inset 0 0 0 2px rgba(79, 70, 229, 0.2);
    }

    .file-upload-component .input-group button {
        padding: 0 16px;
        background-color: #4f46e5;
        /* Indigo */
        color: #fff;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .file-upload-component .input-group button:hover {
        background-color: #4338ca;
    }

    /* Inline image preview */
    .file-upload-component img {
        margin-left: 8px;
        max-width: 60px;
        height: 40px;
        border-radius: 4px;
        border: 1px solid #ddd;
        object-fit: cover;
        transition: transform 0.2s;
    }

    .file-upload-component img:hover {
        transform: scale(1.05);
    }
</style>

<div class="file-upload-component mb-3">
    <div class="input-group">
        <input type="text" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}">
        <button type="button" onclick="openFileManager('{{ $id }}')">Select File</button>
    </div>
    <img id="preview-{{ $id }}" style="display:none;">
</div>