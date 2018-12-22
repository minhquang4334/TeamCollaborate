<?php

namespace App\Transformers;
use App\Model\File;
use App\Model\User;
use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract {

    public function transform(File $file) {
    	$user = User::find($file->creator);
        return [
            'file_path' => $file->file_path,
            'file_name' => $file->file_name,
            'is_image' => $file->is_image,
            'creator' => $file->creator,
            'channel_id' => $file->channel_id,
            'post_id' => $file->post_id,
	        'created_at' => $file->created_at,
	        'creator_name' => $user['name']
        ];
    }
}
