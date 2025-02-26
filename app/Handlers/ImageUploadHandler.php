<?php

namespace App\Handlers;
use Illuminate\Support\Str;

class ImageUploadHandler
{
    protected array $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    public function save($file, $folder, $file_prefix): array|bool
    {
        $folder_name = "uploads/images/$folder/" . date("Ym/d", time());
        $upload_path = public_path() .'/'. $folder_name;
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $filename);
        return [
            'path' => "/$folder_name/$filename"
        ];
    }
}
