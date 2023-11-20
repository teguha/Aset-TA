<?php

namespace Database\Seeders\Dummy;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Globals\Menu;
use App\Models\Master\Org\OrgStruct;
use App\Models\Master\Org\Position;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = bcrypt('password');

        // Direktur Utama
        if ($struct = OrgStruct::presdir()->first()) {
            $position = $struct->positions()->firstOrCreate(['name' => $struct->name], ['code' => (new Position)->getNewCode()]);
            $email = 'dirut@email.com';
            $user = User::firstOrCreate(['email' => $email], [
                'name' => 'User '.$position->name,
                'password' => $password,
                'position_id' => $position->id,
            ]);

            $role = Role::firstOrCreate(['name' => 'Direktur Utama']);
            $perms = Permission::where('name', 'NOT LIKE', '%master%')
                                ->where('name', 'NOT LIKE', '%setting%')
                                ->where('name', 'NOT LIKE', '%create%')
                                ->where('name', 'NOT LIKE', '%edit%')
                                ->where('name', 'NOT LIKE', '%delete%')
                                ->pluck('id')
                                ->toArray();
            $role->permissions()->sync($perms);
            $user->assignRole($role);
        }
        
        // Direktur
        foreach (OrgStruct::director()->get() as $struct) {
            $position = $struct->positions()
                            ->firstOrCreate(['name' => $struct->name], ['code' => (new Position)->getNewCode()]);
            
            $email = strtolower($position->name);
            $email = str_replace('direktur', 'dir', $email);
            $email = str_replace([' ','/',',','-'], '.', $email);
            $email = $email.'@email.com';

            $user = User::firstOrCreate(['email' => $email], [
                'name' => 'User '.$position->name,
                'password' => $password,
                'position_id' => $position->id,
            ]);
            $role = Role::firstOrCreate(['name' => $position->name]);
            $perms = Permission::where('name', 'NOT LIKE', '%master%')
                                ->where('name', 'NOT LIKE', '%setting%')
                                ->where('name', 'NOT LIKE', '%create%')
                                ->where('name', 'NOT LIKE', '%edit%')
                                ->where('name', 'NOT LIKE', '%delete%')
                                ->pluck('id')
                                ->toArray();
            $role->permissions()->sync($perms);
            $user->assignRole($role);
        }

        // Kepala Divisi Audit
        if ($struct = OrgStruct::divisionIa()->first()) {
            $position = $struct->positions()
                            ->firstOrCreate(['name' => 'Kepala '.$struct->name], ['code' => (new Position)->getNewCode()]);
            
            $email = 'kadiv.ia@email.com';
            $user = User::firstOrCreate(['email' => $email], [
                'name' => 'User '.$position->name,
                'password' => $password,
                'position_id' => $position->id,
            ]);

            $role = Role::firstOrCreate(['name' => 'Kepala Divisi Audit']);
            $perms = Permission::where('name', 'NOT LIKE', '%master%')
                                ->where('name', 'NOT LIKE', '%setting%')
                                ->where('name', 'NOT LIKE', '%create%')
                                ->where('name', 'NOT LIKE', '%edit%')
                                ->where('name', 'NOT LIKE', '%delete%')
                                ->pluck('id')
                                ->toArray();
            $role->permissions()->sync($perms);
            $user->assignRole($role);
        }

        // Auditor
        if ($struct = OrgStruct::divisionIa()->first()) {
            $position = $struct->positions()
                            ->firstOrCreate(['name' => 'Staf Auditor'], ['code' => (new Position)->getNewCode()]);
            for ($i=1; $i <= 10; $i++) { 
                $email = 'auditor.'.lpad($i, 2).'@email.com';
                $user = User::firstOrCreate(['email' => $email], [
                    'name' => 'User '.$position->name.' '.lpad($i, 2),
                    'password' => $password,
                    'position_id' => $position->id,
                ]);

                $role = Role::firstOrCreate(['name' => 'Auditor']);
                $perms = Permission::where('name', 'NOT LIKE', '%approve%')
                                    ->where('name', '!=', 'preparation.doc-full.create')
                                    ->where('name', '!=', 'preparation.doc-full.edit')
                                    ->pluck('id')
                                    ->toArray();
                $role->permissions()->sync($perms);
                $user->assignRole($role);
            }
        }

        // PIC Auditee
        $objects = OrgStruct::whereIn('level', ['division','branch'])->orderBy('level')->orderBy('name')->get();
        foreach ($objects as $struct) {
            if ($struct->type == 0) {
                $position = $struct->positions()
                                ->firstOrCreate([
                                    'name' => 'Kepala '.$struct->name
                                ], [
                                    'code' => (new Position)->getNewCode()
                                ]);
                
                $email = strtolower($position->name);
                $email = str_replace(['kepala divisi', 'kepala cabang', 'kepala kantor cabang'], ['kadiv','kacab','kacab'], $email);
                $email = str_replace([' ','/',',','-'], '.', $email);
                $email = $email.'@email.com';

                $user = User::firstOrCreate(['email' => $email], [
                    'name' => 'User '.$position->name,
                    'password' => $password,
                    'position_id' => $position->id,
                ]);

                $role = Role::firstOrCreate(['name' => 'PIC Auditee']);
                $perms = Permission::whereIn('name', [
                                        'dashboard.view',
                                        'preparation.doc-full.view',
                                        'preparation.doc-full.create',
                                        'preparation.doc-full.edit',
                                        'preparation.doc-full.approve',
                                        'conducting.opening.view',
                                        'conducting.closing.view',
                                        'conducting.exit.view',
                                        'monitoring.register.view',
                                        'monitoring.register.edit',
                                        'survey.register.view',
                                        'survey.register.edit',
                                    ])
                                    ->pluck('id')
                                    ->toArray();
                $role->permissions()->sync($perms);
                $user->assignRole($role);
            }
        }


        // Flow Approval
        foreach (Menu::doesntHave('child')->get() as $menu) {
            if ($menu->module == 'preparation_assignment') {
                $role = Role::firstOrCreate(['name' => 'Direktur Utama']);
                $menu->flows()->firstOrCreate(['role_id' => $role->id], [
                    'type' => 1,
                    'order' => 2,
                ]);
            }
            elseif ($menu->module == 'preparation_doc-full') {
                $role = Role::firstOrCreate(['name' => 'PIC Auditee']);
                $menu->flows()->firstOrCreate(['role_id' => $role->id], [
                    'type' => 1,
                    'order' => 1,
                ]);
            }
            else {
                $role = Role::firstOrCreate(['name' => 'Kepala Divisi Audit']);
                $menu->flows()->firstOrCreate(['role_id' => $role->id], [
                    'type' => 1,
                    'order' => 1,
                ]);
                $role = Role::firstOrCreate(['name' => 'Direktur Utama']);
                $menu->flows()->firstOrCreate(['role_id' => $role->id], [
                    'type' => 1,
                    'order' => 2,
                ]);
            }


        }

        // Clear Perms Cache
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
