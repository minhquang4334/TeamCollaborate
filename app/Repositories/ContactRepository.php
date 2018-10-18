<?php

namespace App\Repositories;

use App\model\Contact;
use Illuminate\Support\Facades\Auth;

class ContactRepository {
    use BaseRepository;
    //

    protected $model;

    /**
     * Constructor
     *
     * @param Contact $contact
     */

    public function __construct(Contact $contact)
    {
        $this->model = $contact;
    }

}