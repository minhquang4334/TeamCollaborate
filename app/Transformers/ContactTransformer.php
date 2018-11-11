<?php

namespace App\Transformers;
use App\Model\Contact;
use League\Fractal\TransformerAbstract;

class ContactTransformer extends TransformerAbstract {

    public function transform(Contact $contact) {
        return [
            'user_first_id' => $contact->user_first_id,
            'user_second_id' => $contact->user_second_id,
            'type' => $contact->type
        ];
    }
}
