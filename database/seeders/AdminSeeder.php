<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
        	"secret_key" 		=> "3745821",
        	"username" 			=> "Admin",
        	"email" 			=> "admin@gmail.com",
        	"password" 			=> '$2y$10$pmNHwQhyhP.dmPUxVMXzQOtB9IUo3q5NYqJSpaAvGEMI8aK5eyVx6',
            "status"            => "1",
            "middleware"        => "admin",
        ]);
    }
}
