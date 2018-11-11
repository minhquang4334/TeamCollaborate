<?php

namespace App\Transformers;
use App\Model\React;
use League\Fractal\TransformerAbstract;

class ReactTransformer extends TransformerAbstract {

    public function transform(React $react) {
        return [
            'user_id' => $react->user_id,
            'post_id' => $react->post_id,
            'react_code' => $react->react_code
        ];
    }
}
