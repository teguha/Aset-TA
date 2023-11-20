<?php

namespace Database\Seeders\Dummy;

use App\Models\Auth\User;
use App\Models\Master\Ict\IctObject;
use App\Models\Master\Org\OrgStruct;
use App\Models\Rkia\Rkia;
use Illuminate\Database\Seeder;

class DummySummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->operationAudit();
        // $this->specialAudit();
        // $this->ictAudit();
    }

    public function operationAudit()
    {
        $module = 'rkia_operation';
        request()->merge(['module' => $module]);

        for ($year=2022; $year < 2023; $year++) {
            // Operational
            if (!Rkia::where('category', 'operation')->where('year', $year)->exists()) {
                $rkia = Rkia::create([
                    'category' => 'operation',
                    'year' => $year,
                    'version' => 0,
                    'status' => $year <= 2022 ? 'completed' : 'draft',
                ]);

                // History
                $rkia->addLog('Membuat Data RKIA '.$rkia->show_category.' '.$rkia->year);

                // Cc
                $rkia->cc()->sync(User::where('name', 'LIKE', '%direktur%')->pluck('id')->toArray());

                // Summary
                $auditors = User::inRandomOrder()->limit(5)->role('Auditor')->pluck('id')->toArray();
                if (!empty($auditors)) {
                    $objects = OrgStruct::inRandomOrder()->limit(10)->whereIn('level', ['division', 'branch'])->get();
                    foreach ($objects as $i => $object) {
                        $month = rand(1, 10);
                        $summary = $rkia->summary()
                                    ->firstOrCreate([
                                        'object_id' => $object->id,
                                        'pic_id' => $auditors[rand(0, count($auditors)-1)],
                                        'leader_id' => $auditors[rand(0, count($auditors)-1)],
                                        'date_start' => $year.'-'.$month.'-01',
                                        'date_end' => $year.'-'.$month.'-05',
                                        'theme' => 'Audit '.$rkia->show_category,
                                    ]);
                        $summary->members()->sync($auditors);
                    }
                }

                // History
                $rkia->addLog('Seeding Data RKIA '.$rkia->show_category.' '.$rkia->year);

                // Approval
                if ($rkia->status == 'completed') {
                    $rkia->generateApproval($module);
                    foreach ($rkia->approval($module)->get() as $approval) {
                        if ($approval->role && ($user = $approval->role->users()->first())) {
                            $approval->update([
                                'status' => 'approved',
                                'user_id' => $user->id,
                                'position_id' => $user->position_id,
                                'approved_at' => now(),
                            ]);
                            $rkia->addLog('Seeding Approval RKIA '.$rkia->show_category.' '.$rkia->year);
                        }
                    }
                }
            }
        }
    }

    public function specialAudit()
    {
        $module = 'rkia_special';
        request()->merge(['module' => $module]);

        for ($year=2022; $year < 2023; $year++) {
            // Special
            if (!Rkia::where('category', 'special')->where('year', $year)->exists()) {
                $rkia = Rkia::create([
                    'category' => 'special',
                    'year' => $year,
                    'version' => 0,
                    'status' => $year <= 2022 ? 'completed' : 'draft',
                ]);

                // History
                $rkia->addLog('Membuat Data RKIA '.$rkia->show_category.' '.$rkia->year);

                // Cc
                $rkia->cc()->sync(User::where('name', 'LIKE', '%direktur%')->pluck('id')->toArray());

                // Summary
                $auditors = User::inRandomOrder()->limit(5)->role('Auditor')->pluck('id')->toArray();
                if (!empty($auditors)) {
                    $objects = OrgStruct::inRandomOrder()->limit(3)->whereIn('level', ['division', 'branch'])->get();
                    foreach ($objects as $i => $object) {
                        $month = rand(1, 10);
                        $summary = $rkia->summary()
                                    ->firstOrCreate([
                                        'object_id' => $object->id,
                                        'pic_id' => $auditors[rand(0, count($auditors)-1)],
                                        'leader_id' => $auditors[rand(0, count($auditors)-1)],
                                        'date_start' => $year.'-'.$month.'-01',
                                        'date_end' => $year.'-'.$month.'-05',
                                        'theme' => 'Audit Khusus',
                                    ]);
                        $summary->members()->sync($auditors);
                    }
                }

                // Approval
                if ($rkia->status == 'completed') {
                    $rkia->generateApproval($module);
                    foreach ($rkia->approval($module)->get() as $approval) {
                        if ($approval->role && ($user = $approval->role->users()->first())) {
                            $approval->update([
                                'status' => 'approved',
                                'user_id' => $user->id,
                                'position_id' => $user->position_id,
                                'approved_at' => now(),
                            ]);
                            $rkia->addLog('Menyetujui RKIA '.$rkia->show_category.' '.$rkia->year);
                        }
                    }
                }
            }
        }
    }

    public function ictAudit()
    {
        $module = 'rkia_ict';
        request()->merge(['module' => $module]);

        for ($year=2022; $year < 2023; $year++) {
            // TI
            if (!Rkia::where('category', 'ict')->where('year', $year)->exists()) {
                $rkia = Rkia::create([
                        'category' => 'ict',
                        'year' => $year,
                        'version' => 0,
                        'status' => $year <= 2022 ? 'completed' : 'draft',
                    ]);

                // History
                $rkia->addLog('Membuat Data RKIA '.$rkia->show_category.' '.$rkia->year);

                // Cc
                $rkia->cc()->sync(User::where('name', 'LIKE', '%direktur%')->pluck('id')->toArray());

                // Summary
                $auditors = User::inRandomOrder()->limit(5)->role('Auditor')->pluck('id')->toArray();
                if (!empty($auditors)) {
                    $objects = IctObject::inRandomOrder()->limit(5)->has('ictType')->get();
                    foreach ($objects as $i => $object) {
                        $month = rand(1, 10);
                        $summary = $rkia->summary()
                                    ->firstOrCreate([
                                        'ict_object_id' => $object->id,
                                        'pic_id' => $auditors[rand(0, count($auditors)-1)],
                                        'leader_id' => $auditors[rand(0, count($auditors)-1)],
                                        'date_start' => $year.'-'.$month.'-01',
                                        'date_end' => $year.'-'.$month.'-05',
                                        'theme' => 'Audit Khusus',
                                    ]);
                        $summary->members()->sync($auditors);
                    }
                }

                // Approval
                if ($rkia->status == 'completed') {
                    $rkia->generateApproval($module);
                    foreach ($rkia->approval($module)->get() as $approval) {
                        if ($approval->role && ($user = $approval->role->users()->first())) {
                            $approval->update([
                                'status' => 'approved',
                                'user_id' => $user->id,
                                'position_id' => $user->position_id,
                                'approved_at' => now(),
                            ]);
                            $rkia->addLog('Menyetujui RKIA '.$rkia->show_category.' '.$rkia->year);
                        }
                    }
                }
            }
        }
    }
}
