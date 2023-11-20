<?php

return [
    // CRUD
    'success' => [
        'saved'     => 'Data berhasil disimpan.',
        'created'   => 'Data berhasil ditambahkan.',
        'updated'   => 'Data berhasil diubah.',
        'deleted'   => 'Data berhasil dihapus.',
        'activated' => 'Data berhasil diaktifkan.',
        'disabled'  => 'Data berhasil dinonaktifkan.',
        'approved'  => 'Data berhasil di-approve',
        'rejected'  => 'Data berhasil di-reject',
    ],
    'error' => [
        'saved'     => 'Data gagal disimpan.',
        'created'   => 'Data gagal ditambahkan.',
        'updated'   => 'Data gagal diubah.',
        'deleted'   => 'Data gagal dihapus.',
        'activated' => 'Data gagal diaktifkan.',
        'disabled'  => 'Data gagal dinonaktifkan.',
        'approved'  => 'Data gagal di-approve',
        'rejected'  => 'Data gagal di-reject',
        'related'   => 'Data telah digunakan oleh modul lainnya.',
    ],
    'confirm' => [
        'save' => [
            'title' => 'Apakah Anda yakin?',
            'text' => 'Pastikan data sudah sesuai!',
            'ok' => 'Ya',
            'cancel' => 'Batal',
        ],
        'delete' => [
            'title' => 'Apakah Anda yakin?',
            'text' => 'Data yang telah dihapus tidak dapat dikembalikan!',
            'ok' => 'Hapus',
            'cancel' => 'Batal',
        ],
        'approve' => [
            'title' => 'Apakah Anda yakin?',
            'text' => 'Data yang telah di-approve akan diproses ke tahap selanjutnya!',
            'ok' => 'Approve',
            'cancel' => 'Batal',
        ],
        'reject' => [
            'title' => 'Apakah Anda yakin?',
            'text' => 'Data yang telah ditolak akan dikembalikan untuk diperbaiki!',
            'ok' => 'Reject',
            'cancel' => 'Batal',
        ],
    ],
];