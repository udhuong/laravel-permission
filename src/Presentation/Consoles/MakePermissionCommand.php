<?php

namespace Udhuong\Permission\Presentation\Consoles;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Udhuong\Permission\Domain\Config\RolePermissionMapping;

class MakePermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo các quyền và vai trò trong hệ thống';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        foreach (RolePermissionMapping::getData() as $item) {
            $role = Role::firstOrCreate([
                'name' => $item['role']->value,
                'guard_name' => 'api',
            ]);
            $this->info("Role: {$item['role']->getLabel()}");

            foreach ($item['permissions'] as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission->value,
                    'guard_name' => 'api',
                ])->assignRole($role);
                $this->info("Permission: {$permission->getLabel()}");
            }

            $this->info('----------------------------');
        }
    }
}
