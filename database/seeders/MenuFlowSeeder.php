<?php

namespace Database\Seeders;

use App\Models\Globals\Menu;
use App\Models\Globals\MenuFlow;
use Illuminate\Database\Seeder;

class MenuFlowSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // RISK ASSESSMENT
            [
                'module'   => 'risk-assessment',
                'submenu' => [
                    [
                        'module'   => 'risk-assessment_risk-register',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'risk-assessment_current-risk',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'risk-assessment_inherent-risk',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'risk-assessment_residual-risk',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                ]
            ],
            // PROGRAM KERJA
            [
                'module'   => 'rkia',
                'submenu' => [
                    [
                        'module'   => 'rkia_operation',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'rkia_special',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'rkia_ict',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    // [
                    //     'module'   => 'rkia_ext',
                    // ],
                ]
            ],
            // Persiapan Audit
            [
                'module'   => 'preparation',
                'submenu' => [
                    [
                        'module'   => 'preparation_assignment',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'preparation_instruction',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    // [
                    //     'module'   => 'preparation_doc-req',
                    // ],
                    // [
                    //     'module'   => 'preparation_doc-full',
                    // ],
                    [
                        'module'   => 'preparation_program',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    // [
                    //     'module'   => 'preparation_langkah-kerja',
                    //     'FLOWS'     => [
                    //         [
                    //             "role_id"   => 8,
                    //             "type"      => 1,
                    //         ],
                    //     ],
                    // ],
                    [
                        'module'   => 'preparation_apm',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'preparation_fee',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                ]
            ],
            // Pelaksanaan Audit
            [
                'module'   => 'conducting',
                'submenu' => [
                    [
                        'module'   => 'conducting_memo-opening',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'conducting_memo-closing',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                ]
            ],
            // Pelaporan Audit
            [
                'module'   => 'reporting',
                'submenu' => [
                    [
                        'module'    => 'reporting_memo-exiting',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'    => 'reporting_memo-lhp',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'    => 'reporting_lha',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                ]
            ],
            // Tindak Lanjut Audit
            [
                'module'   => 'followup',
                'submenu' => [
                    [
                        'module'   => 'followup_memo-tindak-lanjut',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'followup_reschedule',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'followup_followup-monitor',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                ]
            ],
            // investigasi_pemeriksaan_pelanggaran
            [
                'module'    => 'investigasi',
                'code'      => 'investigasi',
                'name'      => 'Investigasi',
                'submenu'   => [
                    [
                        'module'    => 'investigasi_surat-tugas-investigasi',
                        'code'      => 'investigasi_surat-tugas-investigasi',
                        'name'      => 'Investigasi/Surat Tugas Investigasi',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'    => 'investigasi_surat-pemanggilan-investigasi',
                        'code'      => 'investigasi_surat-pemanggilan-investigasi',
                        'name'      => 'Investigasi/Surat Pemanggilan',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'    => 'investigasi_pemeriksaan-pelanggaran',
                        'code'      => 'investigasi_pemeriksaan-pelanggaran',
                        'name'      => 'Investigasi/Pemeriksaan Pelanggaran',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                ]
            ],
            // Audit Eksternal
            [
                'module'   => 'extern',
                'submenu' => [
                    [
                        'module'   => 'extern_extern-reg',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'extern_extern-followup',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'extern_extern-reschedule',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                ]
            ],
            // Konsultasi
            [
                'module'    => 'consultation',
                'submenu'   => [
                    [
                        'module'   => 'consultation.work-plan',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'consultation.realization',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                ]
            ],
            [
                'module'    => 'training-auditor',
                'submenu'   => [
                    [
                        'module'   => 'training-auditor.planning',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                    [
                        'module'   => 'training-auditor.realization',
                        'FLOWS'     => [
                            [
                                "role_id"   => 8,
                                "type"      => 1,
                            ],
                        ],
                    ],
                ]
            ],
            // Penilaian Kinerja
            [
                'module'   => 'penilaian-kinerja',
                'FLOWS'     => [
                    [
                        "role_id"   => 8,
                        "type"      => 1,
                    ],
                ],
            ],
        ];

        $this->generate($data);
    }

    public function generate($data)
    {
        ini_set("memory_limit", -1);
        $exists = [];
        $order = 1;
        foreach ($data as $row) {
            $menu = Menu::firstOrNew(['module' => $row['module']]);
            $menu->order = $order;
            $menu->save();
            $exists[] = $menu->id;
            $order++;
            if (!empty($row['submenu'])) {
                foreach ($row['submenu'] as $val) {
                    $submenu = $menu->child()->firstOrNew(['module' => $val['module']]);
                    $submenu->order = $order;
                    $submenu->save();
                    $exists[] = $submenu->id;
                    $order++;
                    if (isset($val['FLOWS'])) {
                        $submenu->flows()->delete();
                        $f = 1;
                        foreach ($val['FLOWS'] as $key => $flow) {
                            $record = MenuFlow::firstOrNew([
                                'menu_id'   => $submenu->id,
                                'role_id'   => $flow['role_id'],
                                'type'      => $flow['type'],
                                'order'     => $f++,
                            ]);
                            $record->save();
                        }
                    }
                }
            }
            if (isset($row['FLOWS'])) {
                $menu->flows()->delete();
                $f = 1;
                foreach ($row['FLOWS'] as $key => $flow) {
                    $record = MenuFlow::firstOrNew([
                        'menu_id'   => $menu->id,
                        'role_id'   => $flow['role_id'],
                        'type'      => $flow['type'],
                        'order'     => $f++,
                    ]);
                    $record->save();
                }
            }
        }
        Menu::whereNotIn('id', $exists)->delete();
    }

    public function countActions($data)
    {
        $count = 0;
        foreach ($data as $row) {
            $count++;
            if (!empty($row['submenu'])) {
                $count += count($row['submenu']);
            }
        }
        return $count;
    }
}
