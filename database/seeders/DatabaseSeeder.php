<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\Role;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\DeviceBrand;
use App\Models\DeviceSeries;
use App\Models\DeviceType;
use App\Models\Facility;
use App\Models\FacilityType;
use App\Models\Product;
use App\Models\Staff;
use Carbon\Carbon;
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
            'role' => Role::ADMIN,
            "email_verified_at" => Carbon::now()
        ]);

        Customer::create(['name' => 'Danuartha'])->user()->create([
            'username' => 'danu21_',
            'email' => 'danuart21@gmail.com',
            'password' => '123456',
            'role' => Role::CUSTOMER,
            "email_verified_at" => Carbon::now()
        ]);

        Staff::create(['name' => 'Putu'])->user()->create([
            'username' => 'putu123',
            'email' => 'dandevofficial@gmail.com',
            'password' => '123456',
            'role' => Role::STAFF,
            "email_verified_at" => Carbon::now()
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

        Product::create([
            'device_series_id' => 1,
            'name' => "Sony A5000 Keren Mantap Jiwa",
            'rental_price' => '100000',
            'stock' => 20,
            'description' => 'ini sony emang mantap pokoknya',
        ]);
        Product::create([
            'device_series_id' => 2,
            'name' => "Canon 600D Anti Pecah",
            'rental_price' => '75000',
            'stock' => 15,
            'description' => 'ini canon lebih mantap pokoknya',
        ]);

        FacilityType::create(['name' => 'Lensa']);
        FacilityType::create(['name' => 'Tripod']);
        FacilityType::create(['name' => 'Lighting']);

        Facility::create([
            'facility_type_id' => 1,
            'name' => "Lensa bisa liat bulan",
            'rental_price' => '60000',
            'stock' => 30,
            'description' => 'ini lensa emang mantap pokoknya',
        ]);
        Facility::create([
            'facility_type_id' => 3,
            'name' => "Lighting Yang Bisa Mencerahkan Kulit Hitam",
            'rental_price' => '35000',
            'stock' => 25,
            'description' => 'ini lighting bisa mencerahkan kulit hitammu',
        ]);
    }
}
