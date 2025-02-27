<?php

namespace App\Handlers;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageUploadHandler
{
    protected array $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    public function save($file, string $folder, string $file_prefix, int|bool $max_width = false): array|bool
    {
        $folder_name = "uploads/images/$folder/" . date("Ym/d", time());
        $upload_path = public_path() .'/'. $folder_name;
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $filename);

        if ($max_width && $extension != 'gif') {
            $this->reducesSize($upload_path . '/' .$filename, $max_width);
        }

        return [
            'path' => "/$folder_name/$filename"
        ];
    }

    public function reducesSize(string $file_path, int $max_width)
    {
        Image::read($file_path)
            ->scale(width: $max_width)
            ->save();
    }
}
