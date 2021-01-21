<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->truncate();

        DB::table('oauth_clients')->insert([
            [
                'id' => "90ef3f03-b692-496e-9240-c6486e4c8c51",
                'name' => "App",
                'secret' => 'gRkm3DmM8DNwhDS5l7UYkUMkJiFa4tgRYgviMRVf',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2019-06-05 14:22:20',
                'updated_at' => '2019-06-05 14:22:20'
            ],
        ]);
    }
}
