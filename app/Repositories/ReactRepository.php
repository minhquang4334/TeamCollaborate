<?php

namespace App\Repositories;

use App\Model\React;
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

    public function isHaveSameUserReact($user_id, $post_id, $react_code) {
    	$react = $this->model->where('user_id', $user_id)->where('post_id', $post_id)->where('react_code', $react_code)->first();
    	if($react) return $react->id;
	    return 0;
    }

}
