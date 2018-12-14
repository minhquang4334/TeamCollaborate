<?php

namespace App\Http\Controllers\Api;

use App\Model\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;

class InviteToAppController extends ApiController
{
    protected $user;

    /**
     * InviteToAppController constructor.
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->user = $user;
    }


    /**
     * Method POST
     * @usage http://localhost:8000/api/invite-to-app?emails[]=anhlahau.hl@gmail.com&emails[]=leconghau.hit@gmail.com&names[]=LeeKangHo&names[]=KangMinKyung
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        try{
        	$invited_users = $request->get('invited_users');
        	if($invited_users) {
		        $data = [];
		        foreach ($invited_users as $key => $invite){
			        if (!$this->user->isRegistered($invite['email'])){
				        // When email is not in app
				        $user = new User();
				        $link = route('home') .
					        '/#/register?' . base64_encode($invite['email']) .
					        '---' . base64_encode($invite['name']);
				        $user->setEmail($invite['email'])
					        ->sendInviteToAppNotification($link);
				        $data[] = ['email'=> $invite['email'], 'name' => $invite['name'], 'link' => $link];
			        }
		        }
		        return response()->json(['status' => true, 'data' => $data], self::CODE_CREATE_SUCCESS);
	        }
            return $this->response->withNoContent();
            /** @var array $data */
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
        }
    }
}
