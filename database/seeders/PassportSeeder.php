<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;

class PassportSeeder extends Seeder
{
    public function run()
    {
        Client::create([
            'id' => 1,
            'user_id' => null,
            'name' => 'Personal Access Client',
            'secret' => 'secret-key',
            'redirect' => '',
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false,
        ]);
    }
}
