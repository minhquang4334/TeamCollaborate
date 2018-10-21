<?php

namespace App\Transformers;
use App\model\Notification;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract {

    public function transform(Notification $notification) {
        return [

        ];
    }
}