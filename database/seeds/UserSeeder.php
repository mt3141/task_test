<?php

use App\Constants\PermissionsConstant;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public $customUsers;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function __construct()
    {
        $this->customUsers = [
            [
                'name' => 'adminOne',
                'username' => 'adminOne',
                'role' => PermissionsConstant::ADMIN,
                'password' => bcrypt('Aa123456'),
            ],
            [
                'name' => 'adminTwo',
                'username' => 'adminTwo',
                'role' => PermissionsConstant::ADMIN,
                'password' => bcrypt('Aa123456'),
            ],
            [
                'name' => 'memberOne',
                'username' => 'memberOne',
                'role' => PermissionsConstant::MEMBER,
                'password' => bcrypt('Aa123456'),
            ],
            [
                'name' => 'memberTwo',
                'username' => 'memberOne',
                'role' => PermissionsConstant::MEMBER,
                'password' => bcrypt('Aa123456'),
            ],
        ];
    }
    public function run()
    {
        foreach ($this->customUsers as $customUser) {
            User::create($customUser);
        }
    }
}
