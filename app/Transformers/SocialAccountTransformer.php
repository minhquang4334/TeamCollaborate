<?php

namespace App\Transformers;
use App\Model\SocialAccount;
use League\Fractal\TransformerAbstract;

class SocialAccountTransformer extends TransformerAbstract {

    public function transform(SocialAccount $account) {
        return [
            'google_id' => $account->google_id,
            'access_token' => $account->access_token,
            'refresh_token' => $account->refresh_token
        ];
    }
}
