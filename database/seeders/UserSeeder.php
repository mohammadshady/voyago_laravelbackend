<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'email' => 'admin@gmail.com',
            'merchant' => 'mechial',
            'password' => '123456789',  
            'english_name' => 'System Admin',
            'national_id' => '122455689',
            'entry_type' => 'person',
            'iban' => 'SA12345678216216789012',
            'public_code' => 'ABC473',
            'mobile' => '0599138065',
        ]);
    }
}
