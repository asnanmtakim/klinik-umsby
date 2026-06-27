<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class BaksosServiceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_pelayanan' => 'Pemeriksaan Kesehatan (Cek Kesehatan + Lab)',
                'kuota'          => 130,
                'deskripsi'      => 'Pemeriksaan kesehatan umum dan pengecekan laboratorium dasar.',
                'created_at'     => Time::now(),
                'updated_at'     => Time::now(),
            ],
            [
                'nama_pelayanan' => 'Pemeriksaan Gigi - Cek Kesehatan Gigi',
                'kuota'          => 40,
                'deskripsi'      => 'Pemeriksaan kesehatan gigi umum.',
                'created_at'     => Time::now(),
                'updated_at'     => Time::now(),
            ],
            [
                'nama_pelayanan' => 'Pemeriksaan Gigi - Pembersihan Karang Gigi',
                'kuota'          => 10,
                'deskripsi'      => 'Pelayanan pembersihan karang gigi (scaling).',
                'created_at'     => Time::now(),
                'updated_at'     => Time::now(),
            ],
            [
                'nama_pelayanan' => 'Pemeriksaan Kehamilan (Cek + Konsultasi KB)',
                'kuota'          => 50,
                'deskripsi'      => 'Pemeriksaan kehamilan rutin dan konsultasi Keluarga Berencana (KB).',
                'created_at'     => Time::now(),
                'updated_at'     => Time::now(),
            ],
            [
                'nama_pelayanan' => 'Pelayanan Khitan',
                'kuota'          => 20,
                'deskripsi'      => 'Pelayanan khitan gratis untuk anak.',
                'created_at'     => Time::now(),
                'updated_at'     => Time::now(),
            ],
        ];

        $this->db->table('baksos_services')->insertBatch($data);
    }
}
