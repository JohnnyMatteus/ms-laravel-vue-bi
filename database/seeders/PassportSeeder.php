<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;

class PassportSeeder extends Seeder
{
    public function run()
    {
        if (!Client::where('id', 1)->exists()) {
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

        if (!Client::where('id', 2)->exists()) {
            Client::create([
                'id' => 2,
                'user_id' => null,
                'name' => 'Password Grant Client',
                'secret' => 'secret-key',
                'redirect' => '',
                'personal_access_client' => false,
                'password_client' => true,
                'revoked' => false,
            ]);
        }
    }
}
