<?php

namespace Database\Seeders;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Administrator',
            ]
        );

        $ROLES = [
            [
                'name'  => 'Administrator',
            ],
            [
                'name'  => 'Direksi',
            ],
            [
                'name'  => 'Kepala Seksi Sarana dan Prasarana Logistik', // sub departemen
            ],
            [
                'name'  => 'Staf Seksi Sarana dan Prasarana Logistik', // sub departemen
            ],
            [
                'name'  => 'Kepala Sub Bagian Program Perencanaan dan Pelaporan', // sub departemen
            ],
            [
                'name'  => 'Staf Sub Bagian Program Perencanaan dan Pelaporan',
            ],
            [
                'name'  => 'Kepala Bagian Unit',
            ],
            [
                'name'  => 'Staf Bagian Unit',
            ],
        ];
        foreach ($ROLES as $value) {
            $record = Role::firstOrNew(['name'  => $value['name']]);
            $record->save();
        }

        $password = bcrypt('password');
        $user = User::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@email.com',
                'password' => $password,
                'nik' => 'admin',
            ]
        );
        $user->assignRole($role);

        $USERS = [
        ];

        foreach ($USERS as $key => $value) {
            $record = User::firstOrNew(['username' => $value['username']]);
            if (!$record->id) {
                $record->position_id    = $value['position_id'];
                $record->email          = $value['email'];
                $record->password       = $value['password'];
            }
            $record->username       = $value['username'];
            $record->name           = $value['name'];
            $record->status         = $value['status'];
            $record->save();
            $record->roles()->sync($value['role_ids']);
        }
    }
}
