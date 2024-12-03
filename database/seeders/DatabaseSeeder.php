<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Doglex',
            'username' => 'dev.rahmaan',
            'password' => Hash::make('mamanrecing'),
            'avatar' => 'images/avatar-1.jpg',
            'phone_number' => '(+62) 895-229-83270',
            'valid' => true,
            'created_at' => now(),
        ]);
        \App\Models\Menu::insert(
            [
                [
                    'name' => 'Dashboard',
                    'route' => 'home',
                    'icon' => 'ri-home-smile-2-fill',
                    'parent' => 0,
                    'place' => 0,
                    'created_at' => '2024-10-26 19:45:22',
                    'updated_at' => '2024-10-26 19:45:22',
                ],
                [
                    'name' => 'Master',
                    'route' => '#master',
                    'icon' => 'bx bxs-data',
                    'parent' => 0,
                    'place' => 0,
                    'created_at' => '2024-10-27 02:48:13',
                    'updated_at' => '2024-10-27 02:48:13',
                ],
                [
                    'name' => 'Menu',
                    'route' => 'master.menu.index',
                    'icon' => 'bx bx-list-ol',
                    'parent' => 2,
                    'place' => 0,
                    'created_at' => '2024-10-27 02:49:12',
                    'updated_at' => '2024-10-27 02:49:12',
                ],
                [
                    'name' => 'Role',
                    'route' => 'master.role.index',
                    'icon' => 'bx bxs-user-check',
                    'parent' => 2,
                    'place' => 0,
                    'created_at' => '2024-10-27 02:54:39',
                    'updated_at' => '2024-10-27 02:54:39',
                ],
                [
                    'name' => 'Mail',
                    'route' => '#mail',
                    'icon' => 'bx bxs-envelope',
                    'parent' => 2,
                    'place' => 0,
                    'created_at' => '2024-10-27 02:56:32',
                    'updated_at' => '2024-10-27 02:56:32',
                ],
                [
                    'name' => 'Priority',
                    'route' => 'master.priority.index',
                    'icon' => 'bx bx-list-check',
                    'parent' => 5,
                    'place' => 0,
                    'created_at' => '2024-10-27 02:52:08',
                    'updated_at' => '2024-10-27 02:52:08',
                ],
                [
                    'name' => 'Agenda',
                    'route' => 'master.agenda.index',
                    'icon' => 'bx bxs-calendar-event',
                    'parent' => 5,
                    'place' => 0,
                    'created_at' => '2024-10-27 02:50:49',
                    'updated_at' => '2024-10-27 02:50:49',
                ],
                [
                    'name' => 'Type',
                    'route' => 'master.type.index',
                    'icon' => 'bx bxs-grid',
                    'parent' => 5,
                    'place' => 0,
                    'created_at' => '2024-10-27 02:49:54',
                    'updated_at' => '2024-10-27 02:49:54',
                ],
                [
                    'name' => 'Sincerely Word',
                    'route' => 'master.sincerely-word.index',
                    'icon' => 'bx bxs-grid',
                    'parent' => 5,
                    'place' => 0,
                    'created_at' => '2024-10-27 02:49:54',
                    'updated_at' => '2024-10-27 02:49:54',
                ],
                [
                    'name' => 'Mail In',
                    'route' => 'mail.in.index',
                    'icon' => 'bx bx-mail-send',
                    'parent' => 0,
                    'place' => 0,
                    'created_at' => '2024-10-27 03:02:20',
                    'updated_at' => '2024-10-27 03:02:20',
                ],
                [
                    'name' => 'Mail Out',
                    'route' => 'mail.out.index',
                    'icon' => 'bx bx-mail-send',
                    'parent' => 0,
                    'place' => 0,
                    'created_at' => '2024-10-27 03:02:20',
                    'updated_at' => '2024-10-27 03:02:20',
                ],
                [
                    'name' => 'Role User',
                    'route' => 'master.role-user.index',
                    'icon' => 'bx bxs-user-voice',
                    'parent' => 2,
                    'place' => 0,
                    'created_at' => '2024-10-27 03:15:57',
                    'updated_at' => '2024-10-27 03:15:57',
                ],
                [
                    'name' => 'User',
                    'route' => 'master.user.index',
                    'icon' => 'bx bxs-group',
                    'parent' => 2,
                    'place' => 0,
                    'created_at' => '2024-10-27 03:48:42',
                    'updated_at' => '2024-10-27 03:48:42',
                ],
                [
                    'name' => 'Organization',
                    'route' => 'master.organization.index',
                    'icon' => 'bx bxs-buildings',
                    'parent' => 2,
                    'place' => 0,
                    'created_at' => '2024-10-29 15:52:41',
                    'updated_at' => '2024-10-29 15:52:41',
                ],
            ]
        );
        \App\Models\Role::insert([
            [
                'name' => 'Developer',
                'description' => 'Developer App',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'name' => 'Admin Sistem',
                'description' => 'Sistem Administrator',
                'created_at' => '2024-10-27 02:46:40',
                'updated_at' => '2024-10-27 02:46:40',
            ],
            [
                'name' => 'Admin Skpd',
                'description' => 'Skpd Administrator',
                'created_at' => '2024-10-27 02:46:40',
                'updated_at' => '2024-10-27 02:46:40',
            ],
            [
                'name' => 'Admin Biro Umum',
                'description' => 'Biro Umum Administrator',
                'created_at' => '2024-10-27 02:47:05',
                'updated_at' => '2024-10-27 02:47:05',
            ],
            [
                'name' => 'User Eselon',
                'description' => 'Sistem Eselon User',
                'created_at' => '2024-10-27 02:47:29',
                'updated_at' => '2024-10-27 02:47:29',
            ],
        ]);
        \App\Models\RoleMenu::insert([
            [
                'role_id' => '1',
                'menu_id' => '1',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '2',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '3',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '4',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '5',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '6',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '7',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '8',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '9',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '10',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '11',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '12',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '1',
                'menu_id' => '13',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
            [
                'role_id' => '2',
                'menu_id' => '1',
                'created_at' => '2024-10-27 02:46:40',
                'updated_at' => '2024-10-27 02:46:40',
            ],
            [
                'role_id' => '3',
                'menu_id' => '1',
                'created_at' => '2024-10-27 02:47:05',
                'updated_at' => '2024-10-27 02:47:05',
            ],
            [
                'role_id' => '4',
                'menu_id' => '1',
                'created_at' => '2024-10-27 02:47:29',
                'updated_at' => '2024-10-27 02:47:29',
            ],
            [
                'role_id' => '5',
                'menu_id' => '1',
                'created_at' => '2024-10-27 02:47:29',
                'updated_at' => '2024-10-27 02:47:29',
            ],
        ]);
        \App\Models\RoleUser::insert([
            [
                'user_id' => '1',
                'role_id' => '1',
                'created_at' => '2024-10-26 19:45:22',
                'updated_at' => '2024-10-26 19:45:22',
            ],
        ]);
        \App\Models\Organization::insert([
            [
                'name' => 'Dinas Pendidikan dan Kebudayaan',
                'description' => 'Bertanggung jawab dalam penyelenggaraan pendidikan dan pelestarian kebudayaan daerah, serta pengembangan kualitas pendidikan dan budaya lokal.',
            ],
            [
                'name' => 'Dinas Kesehatan, Pengendalian Penduduk dan Keluarga Berencana',
                'description' => 'Mengelola layanan kesehatan masyarakat, program keluarga berencana, serta pengendalian penduduk di wilayahnya.',
            ],
            [
                'name' => 'Dinas Pekerjaan Umum dan Perumahan Rakyat',
                'description' => 'Mengelola pembangunan infrastruktur, pemeliharaan jalan, jembatan, dan pengelolaan perumahan serta pemukiman rakyat.',
            ],
            [
                'name' => 'Dinas Kebakaran dan Penyelamatan, Penanggulangan Bencana dan Satuan Polisi Pamong Praja',
                'description' => 'Bertanggung jawab dalam penanggulangan kebakaran, penyelamatan, serta menjaga ketertiban dan keamanan masyarakat melalui satuan polisi pamong praja.',
            ],
            [
                'name' => 'Dinas Sosial, Pemberdayaan Perempuan dan Perlindungan Anak',
                'description' => 'Fokus pada pemberdayaan masyarakat kurang mampu, pemberdayaan perempuan, serta perlindungan anak dari berbagai bentuk kekerasan dan eksploitasi.',
            ],
            [
                'name' => 'Dinas Tenaga Kerja, Transmigrasi, Energi dan Sumber Daya Mineral',
                'description' => 'Mengelola ketenagakerjaan, program transmigrasi, serta mengatur pemanfaatan energi dan sumber daya mineral daerah.',
            ],
            [
                'name' => 'Dinas Lingkungan Hidup, Kehutanan dan Pertanahan',
                'description' => 'Bertanggung jawab dalam pelestarian lingkungan hidup, pengelolaan hutan, dan pengelolaan administrasi pertanahan daerah.',
            ],
            [
                'name' => 'Dinas Kependudukan dan Pencatatan Sipil dan Pemberdayaan Masyarakat dan Kampung',
                'description' => 'Mengelola administrasi kependudukan, pencatatan sipil, serta pemberdayaan masyarakat di tingkat kampung atau desa.',
            ],
            [
                'name' => 'Dinas Perhubungan',
                'description' => 'Mengelola sistem transportasi darat, laut, dan udara, serta infrastruktur transportasi di wilayahnya untuk kelancaran lalu lintas dan mobilitas masyarakat.',
            ],
            [
                'name' => 'Dinas Komunikasi, Informatika, Statistik dan Persandian',
                'description' => 'Bertanggung jawab atas pengelolaan informasi, teknologi komunikasi, data statistik daerah, dan pengamanan informasi.',
            ],
            [
                'name' => 'Dinas Koperasi, Usaha Kecil Menengah, Perindustrian dan Perdagangan',
                'description' => 'Mendorong pertumbuhan koperasi, usaha kecil menengah, dan sektor industri serta perdagangan untuk mendukung ekonomi daerah.',
            ],
            [
                'name' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
                'description' => 'Melakukan pelayanan investasi dan penanaman modal, serta memberikan pelayanan publik dalam perizinan usaha.',
            ],
            [
                'name' => 'Dinas Kepemudaan, Olahraga, Pariwisata dan Ekonomi Kreatif',
                'description' => 'Mengelola program kepemudaan, olahraga, pariwisata, serta pengembangan ekonomi kreatif di daerah.',
            ],
            [
                'name' => 'Dinas Pertanian, Pangan, Kelautan dan Perikanan',
                'description' => 'Mengelola sektor pertanian, pangan, kelautan, dan perikanan untuk mendukung ketahanan pangan dan kesejahteraan masyarakat nelayan.',
            ],
            [
                'name' => 'Sekretariat Daerah',
                'description' => 'Mendukung penyelenggaraan pemerintahan daerah, mengoordinasikan dan memfasilitasi pelaksanaan tugas kepala daerah.',
            ],
            [
                'name' => 'Biro Pemerintahan',
                'description' => 'Mengelola administrasi pemerintahan daerah, hubungan antar lembaga, dan tata kelola pemerintahan di wilayahnya.',
            ],
            [
                'name' => 'Biro Organisasi',
                'description' => 'Mengatur dan mengembangkan struktur organisasi pemerintahan daerah, serta meningkatkan kapasitas birokrasi.',
            ],
            [
                'name' => 'Biro Hukum',
                'description' => 'Memberikan layanan hukum, penyusunan peraturan, dan penyuluhan hukum untuk mendukung tata kelola pemerintahan.',
            ],
            [
                'name' => 'Biro Umum',
                'description' => 'Mengelola kebutuhan umum pemerintahan, termasuk fasilitas, administrasi, dan perlengkapan di lingkup pemerintahan daerah.',
            ],
            [
                'name' => 'Biro Perekonomian Daerah',
                'description' => 'Mengoordinasikan kebijakan ekonomi daerah untuk mendukung pertumbuhan ekonomi yang berkelanjutan.',
            ],
            [
                'name' => 'Biro Pengadaan Barang dan Jasa',
                'description' => 'Mengelola pengadaan barang dan jasa untuk kepentingan pemerintah daerah dengan prinsip transparansi dan akuntabilitas.',
            ],
            [
                'name' => 'Sekretariat Dewan Perwakilan Rakyat Papua Barat Daya',
                'description' => 'Mendukung pelaksanaan tugas DPR Papua Barat Daya, termasuk administrasi dan kegiatan legislasi.',
            ],
            [
                'name' => 'Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah',
                'description' => 'Melakukan perencanaan pembangunan daerah, riset, dan inovasi untuk peningkatan kualitas pembangunan berkelanjutan.',
            ],
            [
                'name' => 'Badan Pengelolaan Pendapatan, Keuangan dan Aset Daerah',
                'description' => 'Mengelola pendapatan, keuangan, dan aset daerah untuk meningkatkan kesejahteraan dan pembangunan.',
            ],
            [
                'name' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia',
                'description' => 'Mengelola manajemen kepegawaian daerah dan pengembangan kompetensi sumber daya manusia pemerintahan.',
            ],
            [
                'name' => 'Inspektorat Daerah',
                'description' => 'Melakukan pengawasan dan pemeriksaan untuk mencegah korupsi serta meningkatkan akuntabilitas dan transparansi dalam pemerintahan.',
            ],
            [
                'name' => 'Badan Kesatuan Bangsa dan Politik',
                'description' => 'Menjaga stabilitas politik dan keamanan serta memelihara kesatuan bangsa dalam masyarakat.',
            ],
            [
                'name' => 'Sekretariat Majelis Rakyat Papua Barat Daya',
                'description' => 'Mendukung pelaksanaan tugas Majelis Rakyat Papua Barat Daya dalam memperjuangkan hak-hak masyarakat asli Papua.',
            ],
        ]);
    }
}
