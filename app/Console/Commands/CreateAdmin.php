<?php

namespace App\Console\Commands;

use App\Model\Admin;
use Illuminate\Support\Facades\Validator;
use RuntimeException;
//use App\Scopes\StatusScope;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:admin
                            {admin? : The ID of the admin}
                            {--delete : Whether the user should be deleted}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an super admin or delete a admin for the system.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $adminId = $this->argument('admin');
        $option = $this->option('delete');

        if ($adminId && !$option) {
            $admin = Admin::findOrFail($adminId);

            $this->info('name: ' . $admin->name . ', username: ' . $admin->username);

            return;
        } else if ($adminId && $option) {
            if (Admin::find($adminId)->delete()) {
                $this->info('Deleted the admin success!');
            } else {
                $this->error('Sorry, the system had made a mistake! Please check the system.');
            }
            return;
        }

        $name = $this->ask('What is your name?');
        $username = $this->ask('What is your username?');
        $password = $this->secret('What is the password?(min: 6 character)');

        $data = [
            'name'     => $name,
            'username'    => $username,
            'password' => $password,
        ];

        if ( $this->register($data) ) {
            $this->info('Register a new admin success! You can login in the dashboard by the account.');
        } else {
            $this->error('Something went wrong!');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function register($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:admins',
            'password' => 'required|min:6',
        ]);

        if (!$validator->passes()) {
            throw new RuntimeException($validator->errors()->first());
        }

        return $this->create($data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create($data)
    {
        return Admin::create([
            'name'     => $data['name'],
            'username'    => $data['username'],
            'status'   => 1,
            'level' => 1,
            'password' => bcrypt($data['password']),
        ]);
    }
}
