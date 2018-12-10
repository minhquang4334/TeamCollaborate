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
            $data = [];
            $emails = $request->get('emails');
            $names = $request->get('names');
            foreach ($emails as $key=>$email){
                if (!$this->user->isRegistered($email)){
                    // When email is not in app
                    $user = new User();
                    $link = route('home') .
                        '/#/register?' . base64_encode($email) .
                        '---' . base64_encode($names[$key]);
                    $user->setEmail($email)
                        ->sendInviteToAppNotification($link);
                    $data[] = ['email'=> $email, 'name' => $names[$key], 'link' => $link];
                }
            }
            /** @var array $data */
            return response()->json(['status' => true, 'data' => $data], self::CODE_CREATE_SUCCESS);
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
        }
    }
}
