<?php

use Illuminate\Database\Seeder;

class CarPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Permission::create([
            'key' => 'menu_parking',
            'name' => 'منوی اطلاعات پایه خودرو',
            'description' => 'فعال یا غیرفعال کردن منوی اطلاعات پایه خودرو'
        ]);

         \App\Permission::create([
              'key' => 'menu_base_parking',
              'name' => 'منوی اطلاعات پایه خودرو ـ فعال سازی آیتم اطلاعات پایه',
              'description' => 'فعال یا غیرفعال کردن آیتم اطلاعات پایه در منوی اطلاعات پایه خودرو'
            ]);

            \App\Permission::create([
                'key' => 'menu_base_car_site',
                'name' => 'منوی اطلاعات پایه خودرو ـ فعال سازی آیتم تعریف پارکینگ',
                'description' => 'فعال یا غیرفعال کردن آیتم تعریف پارکینگ در منوی اطلاعات پایه خودرو'
              ]);

              \App\Permission::create([
                'key' => 'menu_base_car_color',
                'name' => 'منوی اطلاعات پایه خودرو ـ فعال سازی آیتم رنگ خودرو',
                'description' => 'فعال یا غیرفعال کردن آیتم رنگ خودرو در منوی اطلاعات پایه خودرو'
              ]);

              \App\Permission::create([
                'key' => 'menu_base_car_fuel',
                'name' => 'منوی اطلاعات پایه خودرو ـ فعال سازی آیتم سوخت خودرو',
                'description' => 'فعال یا غیرفعال کردن آیتم سوخت خودرو در منوی اطلاعات پایه خودرو'
              ]);

               \App\Permission::create([
                'key' => 'menu_base_car_level',
                'name' => 'منوی اطلاعات پایه خودرو ـ فعال سازی آیتم تیپ خودرو',
                'description' => 'فعال یا غیرفعال کردن آیتم تیپ خودرو در منوی اطلاعات پایه خودرو'
              ]);

                \App\Permission::create([
                'key' => 'menu_base_car_model',
                'name' => 'منوی اطلاعات پایه خودرو ـ فعال سازی آیتم مدل خودرو',
                'description' => 'فعال یا غیرفعال کردن آیتم مدل خودرو در منوی اطلاعات پایه خودرو'
              ]);

              \App\Permission::create([
                'key' => 'menu_base_car_system',
                'name' => 'منوی اطلاعات پایه خودرو ـ فعال سازی آیتم سیستم خودرو',
                'description' => 'فعال یا غیرفعال کردن آیتم سیستم خودرو در منوی اطلاعات پایه خودرو'
              ]);

              \App\Permission::create([
                'key' => 'menu_base_car_type',
                'name' => 'منوی اطلاعات پایه خودرو ـ فعال سازی آیتم نوع خودرو',
                'description' => 'فعال یا غیرفعال کردن آیتم نوع خودرو در منوی اطلاعات پایه خودرو'
              ]);

              \App\Permission::create([
                'key' => 'menu_base_car_plate_type',
                'name' => 'منوی اطلاعات پایه خودرو ـ فعال سازی آیتم نوع پلاک خودرو',
                'description' => 'فعال یا غیرفعال کردن آیتم نوع پلاک خودرو در منوی اطلاعات پایه خودرو'
              ]);

              \App\Permission::create([
                'key' => 'menu_car_management_parking',
                'name' => 'منوی مدیریت خودرو ـ فعال سازی آیتم ثبت خودرو',
                'description' => 'فعال یا غیرفعال کردن آیتم ثبت خودرو در منوی مدیریت خودرو'
              ]);

              \App\Permission::create([
                'key' => 'menu_car_capacity_parking',
                'name' => 'منوی مدیریت خودرو ـ فعال سازی آیتم ثبت ظرفیت پارکینگ',
                'description' => 'فعال یا غیرفعال کردن آیتم ثبت ظرفبت پارکینگ در منوی مدیریت خودرو'
              ]);
    }
}
