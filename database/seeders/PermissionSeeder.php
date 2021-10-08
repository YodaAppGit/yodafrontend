<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'web-login',
            'web-forgot-password',
            'web-dashboard',
            'nav-user-management-access',
            'nav-user-management-disabled',
            'nav-content-management-access',
            'nav-content-management-disabled',
            'nav-laporan-kinerja-access',
            'nav-laporan-kinerja-disabled',
            'nav-audit-trail-access',
            'nav-audit-trail-disabled',
            'user-management-access',
            'content-management-access',
            'web-kanban-access',
            'web-kanban-view',
            'web-upload-data-access',
            'web-upload-data-disabled',
            'web-card-cust-info',
            'web-card-unit-info',
            'web-card-credit-info',
            'web-duplicate-card',
            'web-chat-access',
            'web-chat-view',
            'web-profile-access',
            'web-profile-view',
            'performance-report-access',
            'performance-report-disabled',
            'input-performance-report-access',
            'input-performance-report-disabled',
            'mobile-login',
            'mobile-dashboard-graph',
            'mobile-dashboard-nongraph',
            'mobile-add-unit-access',
            'mobile-add-unit-disabled',
            'mobile-ecom-access',
            'mobile-ecom-disabled',
            'mobile-search-cards',
            'mobile-view-cards',
            'mobile-card-info-access',
            'mobile-card-info-disabled',
            'mobile-card-pic-access',
            'mobile-card-pic-view',
            'mobile-chat',
            'mobile-wa-seller',
            'mobile-wa-mo',
            'mobile-cust-info-access',
            'mobile-cust-info-view',
            'mobile-cust-wa-access',
            'mobile-cust-wa-disabled',
            'mobile-credit-info-access',
            'mobile-credit-info-view',
            'mobile-jaminan-refin-access',
            'mobile-jaminan-refin-view',
            'mobile-nasabah-refin-access',
            'mobile-nasabah-refin-view',
            'mobile-kredit-refin-access',
            'mobile-kredit-refin-view',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}
