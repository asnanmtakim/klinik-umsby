<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiteMenusSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'type' => 'dashboard-title',
                'name' => 'Menu Pengguna',
                'name_en' => 'User Menu',
                'route' => null,
                'parent' => null,
                'icon' => null,
                'filter' => 'session',
                'filter_value' => null,
                'order' => 1,
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Dashboard
            [
                'id' => 2,
                'type' => 'dashboard',
                'name' => 'Dasbor',
                'name_en' => 'Dashboard',
                'route' => 'dashboard',
                'parent' => null,
                'icon' => 'ri-dashboard-2-line',
                'filter' => 'session',
                'filter_value' => null,
                'order' => 2,
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            // Menu Admin
            [
                'id' => 4,
                'type' => 'dashboard-title',
                'name' => 'Menu Admin',
                'name_en' => 'Admin Menu',
                'route' => null,
                'parent' => null,
                'icon' => null,
                'filter' => 'session',
                'filter_value' => null,
                'order' => 4,
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Baksos
            [
                'id' => 5,
                'type' => 'dashboard',
                'name' => 'Bakti Sosial',
                'name_en' => 'Social Service',
                'route' => null,
                'parent' => null,
                'icon' => 'ri-heart-pulse-line',
                'filter' => 'session',
                'filter_value' => null,
                'order' => 5,
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Kuota & Layanan
            [
                'id' => 6,
                'type' => 'dashboard',
                'name' => 'Layanan & Kuota',
                'name_en' => 'Services & Quota',
                'route' => 'admin-baksos-services',
                'parent' => 5,
                'icon' => null,
                'filter' => 'session',
                'filter_value' => null,
                'order' => 1,
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Pendaftar
            [
                'id' => 7,
                'type' => 'dashboard',
                'name' => 'Data Pendaftar',
                'name_en' => 'Registrants Data',
                'route' => 'admin-baksos-registrations',
                'parent' => 5,
                'icon' => null,
                'filter' => 'session',
                'filter_value' => null,
                'order' => 2,
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Pengaturan
            [
                'id' => 8,
                'type' => 'dashboard-title',
                'name' => 'Pengaturan',
                'name_en' => 'Settings',
                'route' => null,
                'parent' => null,
                'icon' => null,
                'filter' => 'session',
                'filter_value' => null,
                'order' => 6,
                'active' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 9,
                'type' => 'dashboard',
                'name' => 'Pengaturan Website',
                'name_en' => 'Website Settings',
                'route' => 'settings',
                'parent' => null,
                'icon' => 'ri-settings-3-line',
                'filter' => 'session',
                'filter_value' => null,
                'order' => 7,
                'active' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('site_menus')->truncate();
        $this->db->table('site_menus')->insertBatch($data);
    }
}
