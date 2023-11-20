<?php

return [
    [
        'section' => 'NAVIGASI',
        'name' => 'navigasi',
        'perms' => 'dashboard',
    ],
    // Dashboard
    [
        'name' => 'dashboard',
        'perms' => 'dashboard',
        'title' => 'Dashboard',
        'icon' => 'fa fa-th-large',
        'url' => '/home',
    ],
    [
        'name' => 'master',
        'perms' => 'master',
        'title' => 'Data Master',
        'icon' => 'fa fa-database',
        'submenu' => [
            [
                'name' => 'master_org',
                'title' => 'Struktur Organisasi',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'master_org_root',
                        'title' => 'Root',
                        'url' => '/master/org/root'
                    ],
                    [
                        'name' => 'master_org_bod',
                        'title' => 'Direksi',
                        'url' => '/master/org/bod',
                    ],
                    [
                        'name' => 'master_org_department',
                        'title' => 'Departemen',
                        'url' => '/master/org/department',
                    ],
                    [
                        'name' => 'master_org_subdepartment',
                        'title' => 'Sub Departemen',
                        'url' => '/master/org/subdepartment',
                    ],
                    [
                        'name' => 'master_org_subsection',
                        'title' => 'Sub Unit Departemen',
                        'url' => '/master/org/subsection',
                    ],
                    [
                        'name' => 'master_org_position',
                        'title' => 'Jabatan',
                        'url' => '/master/org/position',
                    ],

                ]
            ],
            [
                'name' => 'Geografis',
                'title' => 'Geografis',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'master_province',
                        'title' => 'Provinsi',
                        'url' => '/master/geografis/province'
                    ],
                    [
                        'name' => 'master_city',
                        'title' => 'Kota / Kabupaten',
                        'url' => '/master/geografis/city'
                    ],
                ]
            ],
            [
                'name' => 'master.coa',
                'title' => 'Chart of Accounts',
                'url' => '/master/coa',
            ],
            [
                'name' => 'Vendor',
                'title' => 'Vendor',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'master.type-vendor',
                        'title' => 'Jenis',
                        'url' => '/master/type-vendor',
                    ],
                    [
                        'name' => 'master.vendor',
                        'title' => 'Vendor',
                        'url' => '/master/vendor',
                    ],
                ]
            ],
        ]
    ],
    [
        'name' => 'setting',
        'perms' => 'setting',
        'title' => 'Pengaturan Umum',
        'icon' => 'fa fa-cogs',
        'submenu' => [
            [
                'name' => 'setting_role',
                'title' => 'Hak Akses',
                'url' => '/setting/role',
            ],
            [
                'name' => 'setting_flow',
                'title' => 'Flow Approval',
                'url' => '/setting/flow',
            ],
            [
                'name' => 'setting_user',
                'title' => 'Manajemen User',
                'url' => '/setting/user',
            ],
            [
                'name' => 'setting_activity',
                'title' => 'Audit Trail',
                'url' => '/setting/activity',
            ],
        ]
    ],
];
