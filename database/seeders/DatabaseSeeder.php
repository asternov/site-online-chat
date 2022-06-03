<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = [
          [
              'name' => 'admin',
              'email' => 'admin@tassfx.com',
              'password' => 'E29Q4bAB4L6TGa5j'
          ],
          [
              'name' => 'test',
              'email' => 'test@tassfx.com',
              'password' => 'yGq9W6ztT7ZjrAUL'
          ],
          [
              'name' => 'chatadmin',
              'email' => 'chatadmin@tassfx.com',
              'password' => 'cbPXAQMfAs42Xgvv'
          ],
          [
              'name' => 'admin2',
              'email' => 'admin2@tassfx.com',
              'password' => 'dLe5WhGStukiRNlp'
          ],
          [
              'name' => 'admin3',
              'email' => 'admin3@tassfx.com',
              'password' => 'Zu0cqqrPgbaH1MFp'
          ],
        ];

        foreach ($data as $datum) {
            if (!User::query()->where('email', $datum['email'])->count()) {
                $datum['password'] = Hash::make($datum['password']);
                User::factory()->create($datum);
            }
        }
    }
}
