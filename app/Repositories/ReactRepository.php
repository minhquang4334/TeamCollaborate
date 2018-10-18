<?php

namespace App\Repositories;

use App\model\React;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;

class ReactRepository {
    use BaseRepository;
    //

    protected $model;

    /**
     * Constructor
     *
     * @param React $react
     */

    public function __construct(React $react)
    {
        $this->model = $react;
    }

}