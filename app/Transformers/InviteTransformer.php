<?php

namespace App\Transformers;
use App\Model\Invite;
use League\Fractal\TransformerAbstract;

class InviteTransformer extends TransformerAbstract {

    public function transform(Invite $invite) {
        return [
            'user_id' => $invite->user_id,
            'invited_email' => $invite->invited_email,
            'invite_token' => $invite->invite_token,
            'status' => $invite->status
        ];
    }
}
