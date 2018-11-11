<?php

namespace App\Transformers;
use App\Model\File;
use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract {

    public function transform(File $file) {
        return [
            'file_path' => $file->file_path,
            'file_name' => $file->file_name,
            'is_image' => $file->is_image,
            'creator' => $file->creator,
            'channel_id' => $file->channel_id,
            'post_id' => $file->post_id
        ];
    }
}
