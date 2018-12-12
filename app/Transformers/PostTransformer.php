<?php

namespace App\Transformers;
use App\Model\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract {

    public function transform(Post $post) {
        return [
            'content' => $post->content,
            'is_parent' => $post->is_parent,
            'channel_id' => $post->channel_id,
            'parent_id' => $post->parent_id,
            'creator' => $post->creator,
            'user_following_post' => $post->user_following_post,
            'status' => $post->status,
            'type' => $post->type,
        ];
    }
}
