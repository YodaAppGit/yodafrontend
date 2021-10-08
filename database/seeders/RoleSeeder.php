<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rejected = Role::create([
            'name' => 'Non Aktif'
        ]);
        $permissions = [
            'web-login',
            'web-forgot-password',
            'web-dashboard',
            'nav-user-management-access',
            'nav-content-management-access',
            'nav-laporan-kinerja-access',
            'nav-audit-trail-access',
            'user-management-access',
            'content-management-access',
            'web-kanban-access',
            'web-upload-data-access',
            'web-card-cust-info',
            'web-card-unit-info',
            'web-card-credit-info',
            'web-duplicate-card',
            'web-chat-access',
            'web-profile-access',
            'performance-report-access',
            'input-performance-report-access',
            'mobile-login',
            'mobile-dashboard-graph',
            'mobile-add-unit-access',
            'mobile-ecom-access',
            'mobile-search-cards',
            'mobile-view-cards',
            'mobile-card-info-access',
            'mobile-card-pic-access',
            'mobile-chat',
            'mobile-wa-seller',
            'mobile-wa-mo',
            'mobile-cust-info-access',
            'mobile-cust-wa-access',
            'mobile-credit-info-access',
            'mobile-jaminan-refin-access',
            'mobile-nasabah-refin-access',
            'mobile-kredit-refin-access',
        ];
        $superAdmin = Role::create([
            'name' => 'Super Admin'
        ]);
        foreach ($permissions as $permission) {
            $superAdmin->givePermissionTo($permission);
        }

        $officePusatPermissions = [
            'web-login',
            'web-forgot-password',
            'web-dashboard',
            'nav-user-management-access',
            'nav-content-management-disabled',
            'nav-laporan-kinerja-disabled',
            'nav-audit-trail-disabled',
            'web-kanban-view',
            'web-upload-data-disabled',
            'web-card-cust-info',
            'web-card-unit-info',
            'web-card-credit-info',
            'web-chat-view',
            'web-profile-view',
            'performance-report-access',
            'input-performance-report-access',
        ];
        $officePusat = Role::create([
            'name' => 'Manajemen Kantor Pusat'
        ]);
        foreach ($officePusatPermissions as $permission) {
            $officePusat->givePermissionTo($permission);
        }

        $officeAreaPermission = [
            'web-login',
            'web-forgot-password',
            'web-dashboard',
            'nav-user-management-disabled',
            'nav-content-management-disabled',
            'nav-laporan-kinerja-access',
            'nav-audit-trail-disabled',
            'web-kanban-view',
            'web-upload-data-disabled',
            'web-card-cust-info',
            'web-card-unit-info',
            'web-card-credit-info',
            'web-chat-view',
            'web-profile-view',
            'performance-report-access',
            'input-performance-report-access',
        ];
        $officeArea = Role::create([
            'name' => 'Manajemen Kantor Area'
        ]);
        foreach ($officeAreaPermission as $permission) {
            $officeArea->givePermissionTo($permission);
        }

        $adminPermissions = [
            'web-login',
            'web-forgot-password',
            'nav-user-management-access',
            'nav-content-management-access',
            'nav-audit-trail-access',
            'user-management-access',
            'content-management-access',
        ];
        $admin = Role::create([
            'name' => 'Admin'
        ]);
        foreach ($adminPermissions as $permission) {
            $admin->givePermissionTo($permission);
        }

        $customerRelationPermissions = [
            'web-login',
            'web-forgot-password',
            'web-dashboard',
            'nav-user-management-disabled',
            'nav-content-management-disabled',
            'nav-laporan-kinerja-disabled',
            'nav-audit-trail-disabled',
            'web-kanban-access',
            'web-upload-data-access',
            'web-card-cust-info',
            'web-card-unit-info',
            'web-card-credit-info',
            'web-duplicate-card',
            'web-chat-access',
            'web-profile-access',
            'performance-report-disabled',
            'input-performance-report-disabled',
        ];

        $customerRelation = Role::create([
            'name' => 'Customer Relation'
        ]);
        foreach ($customerRelationPermissions as $permission) {
            $customerRelation->givePermissionTo($permission);
        }


        $marketingHeadPermissions = [
            'web-login',
            'web-forgot-password',
            'web-dashboard',
            'nav-user-management-disabled',
            'nav-content-management-disabled',
            'nav-laporan-kinerja-access',
            'nav-audit-trail-disabled',
            'web-kanban-access',
            'web-upload-data-disabled',
            'web-card-cust-info',
            'web-card-unit-info',
            'web-card-credit-info',
            'web-chat-access',
            'web-profile-view',
            'performance-report-access',
            'performance-report-disabled',
            'input-performance-report-access',
            'input-performance-report-disabled',
            'mobile-login',
            'mobile-dashboard-graph',
            'mobile-add-unit-disabled',
            'mobile-ecom-disabled',
            'mobile-search-cards',
            'mobile-view-cards',
            'mobile-card-info-access',
            'mobile-card-info-disabled',
            'mobile-card-pic-view',
            'mobile-chat',
            'mobile-wa-seller',
            'mobile-cust-info-view',
            'mobile-cust-wa-disabled',
            'mobile-credit-info-view',
            'mobile-jaminan-refin-view',
            'mobile-nasabah-refin-view',
            'mobile-kredit-refin-view',
        ];
        $marketingHead = Role::create([
            'name' => 'Marketing Head'
        ]);
        foreach ($marketingHeadPermissions as $permission) {
            $marketingHead->givePermissionTo($permission);
        }

        $marketingOfficerPermissions = [
            'mobile-login',
            'mobile-dashboard-graph',
            'mobile-add-unit-access',
            'mobile-ecom-access',
            'mobile-search-cards',
            'mobile-view-cards',
            'mobile-card-info-access',
            'mobile-card-pic-view',
            'mobile-chat',
            'mobile-wa-seller',
            'mobile-cust-info-access',
            'mobile-cust-wa-access',
            'mobile-credit-info-access',
            'mobile-jaminan-refin-access',
            'mobile-nasabah-refin-access',
            'mobile-kredit-refin-access',
        ];
        $marketingOfficer = Role::create([
            'name' => 'Marketing Officer'
        ]);
        foreach ($marketingOfficerPermissions as $permission) {
            $marketingOfficer->givePermissionTo($permission);
        }

        $creditOfficerPermissions = [
            'mobile-login',
            'mobile-dashboard-graph',
            'mobile-add-unit-disabled',
            'mobile-ecom-disabled',
            'mobile-search-cards',
            'mobile-view-cards',
            'mobile-card-info-access',
            'mobile-card-pic-view',
            'mobile-chat',
            'mobile-wa-seller',
            'mobile-cust-info-access',
            'mobile-cust-wa-access',
            'mobile-credit-info-access',
            'mobile-jaminan-refin-access',
            'mobile-nasabah-refin-access',
            'mobile-kredit-refin-access',
        ];

        $creditOfficer = Role::create([
            'name' => 'Credit Officer'
        ]);
        foreach ($creditOfficerPermissions as $permission) {
            $creditOfficer->givePermissionTo($permission);
        }

        $externalPermissions = [
            'mobile-login',
            'mobile-dashboard-nongraph',
            'mobile-add-unit-access',
            'mobile-ecom-access',
            'mobile-search-cards',
            'mobile-view-cards',
            'mobile-card-info-disabled',
            'mobile-card-pic-view',
            'mobile-wa-mo',
        ];
        $external = Role::create([
            'name' => 'External'
        ]);
        foreach ($externalPermissions as $permission) {
            $external->givePermissionTo($permission);
        }
    }
}
