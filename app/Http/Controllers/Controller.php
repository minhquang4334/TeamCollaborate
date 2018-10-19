<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const CODE_GET_SUCCESS = 200;
    const CODE_CREATE_SUCCESS = 201;
    const CODE_UPDATE_SUCCESS = 200;
    const CODE_DELETE_SUCCESS = 200;
    const CODE_BAD_REQUEST = 400;
    const CODE_UNAUTHORIZED = 401;
    const CODE_FORBIDDEN = 403;
    const CODE_INTERNAL_ERROR = 404;
    const CODE_METHOD_NOT_ALLOWED = 405;
    const CODE_NOT_IMPLEMENTED = 500;
    const CODE_BAD_GATEWAY = 501;
    const CODE_SERVICE_UNAVAILABLE = 503;
    const CODE_GATEWAY_TIMEOUT = 504;
}
