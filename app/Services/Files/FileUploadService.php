<?php

namespace App\Services\Files;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Date;

class FileUploadService
{
    private $file;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    public function store(): ?string
    {
        $fileName = str_replace([':', '-'], '_', Date::now().'_'.rand());
        return $this->file->storeAs('csv', $fileName.'.csv');
    }
}
