<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ReactRepository;

class ReactApiController extends ApiController
{
    protected $react;

    /**
     * ReactApiController constructor.
     * @param ReactRepository $react
     */
    public function __construct(ReactRepository $react)
    {
        parent::__construct();
        $this->react = $react;
    }




}
