<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\Role;
use App\Models\Admin;
use App\Models\DeviceBrand;
use App\Models\DeviceSeries;
use App\Models\DeviceType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create(['name' => 'Admin'])->user()->create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
            'role' => Role::ADMIN
        ]);

        DeviceType::create(['name' => 'Mirrorless']);
        DeviceType::create(['name' => 'DSLR']);
        DeviceType::create(['name' => 'Action Camera']);

        DeviceBrand::create(['device_type_id' => 1, 'name' => 'Sony']);
        DeviceBrand::create(['device_type_id' => 2, 'name' => 'Canon']);
        DeviceBrand::create(['device_type_id' => 3, 'name' => 'Fuji Film']);
        
        DeviceSeries::create(['device_brand_id' => 1, 'name' => 'Sony A5000']);
        DeviceSeries::create(['device_brand_id' => 2, 'name' => 'Canon 600D']);
        DeviceSeries::create(['device_brand_id' => 2, 'name' => 'Canon 60D']);
    }
}
