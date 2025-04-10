<?php

namespace Udhuong\Permission\Presentation\Consoles;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Udhuong\Permission\Domain\ValueObjects\Permission as PermissionEnum;
use Udhuong\Permission\Domain\ValueObjects\Role as RoleEnum;

class AssignPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:assign-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gán quyền cho user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $user = User::where('username', 'admin')->first();
        if (! $user) {
            $this->error('User not found');

            return;
        }
        $role = Role::firstWhere([
            'name' => RoleEnum::ADMIN->value,
            'guard_name' => 'api',
        ]);
        $user->assignRole($role);

        $permissions = Permission::whereIn('name', [
            PermissionEnum::USER_CREATE->value,
            PermissionEnum::USER_VIEW->value,
            PermissionEnum::USER_UPDATE->value,
            PermissionEnum::USER_DELETE->value,
            PermissionEnum::USER_ASSIGN->value,
        ])->where('guard_name', 'api')->get();
        $user->givePermissionTo($permissions);

        $this->info('Add role and permissions to user successfully');
    }
}
