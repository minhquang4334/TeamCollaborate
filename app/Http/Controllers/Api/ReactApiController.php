<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ReactRepository;
use Illuminate\Support\Facades\Request;

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

    /**
     * add react to thread
     * return true if react success, if not return false and message
     * @param Request $request
     */
    public function react(Request $request) {

    }

    /**
     * un react to thread
     * return true if react success, if not return false and message
     * @param Request $request
     */
    public function unReact(Request $request) {

    }



}
