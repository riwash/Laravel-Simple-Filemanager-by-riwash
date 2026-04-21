<?php

namespace Riwash\SimpleFileManager\Components;

use Illuminate\View\Component;

class FileUploader extends Component
{
    public $name;

    public $id;

    public $placeholder;

    public $previewWidth;

    /**
     * Create a new component instance.
     */
    public function __construct($name = 'image_url', $id = null, $placeholder = 'Select file', $previewWidth = '200px')
    {
        $this->name = $name;
        $this->id = $id ?? 'file-upload-' . rand(1000, 9999);
        $this->placeholder = $placeholder;
        $this->previewWidth = $previewWidth;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('simple-file-manager::fileupload');
    }
}
