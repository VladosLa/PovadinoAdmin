<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;

class UpdateUserPasswords extends Command
{
    protected $signature = 'update:user-passwords';
    protected $description = 'Update user passwords to use Bcrypt algorithm';

    public function handle()
    {
        $users = Admin::all();

        foreach ($users as $user) {
            $user->password = bcrypt($user->password);
            $user->save();
        }

        $this->info('User passwords updated successfully.');
    }
}
