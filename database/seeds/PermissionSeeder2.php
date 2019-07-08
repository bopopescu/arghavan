<?php

use Illuminate\Database\Seeder;

class PermissionSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Permission::create([
            'key' => 'menu_base_contractor',
            'name' => 'منوی اطلاعات پایه ـ فعال سازی آیتم پیمانکار',
            'description' => 'فعال یا غیرفعال کردن آیتم پیمانکار در منوی اطلاعات پایه'
        ]);

        
        \App\Permission::create([
            'key' => 'menu_referral',
            'name' => 'منوی مدیریت مراجعه کنندگان',
            'description' => 'فعال یا غیرفعال کردن منوی مدیریت مراجعه کنندگان'
        ]);

        \App\Permission::create([
            'key' => 'menu_referral_warranty',
            'name' => 'مدیریت مراجعه کنندگان ـ فعال سازی آیتم ثبت ضمانت نامه',
            'description' => 'فعال یا غیرفعال کردن آیتم ثبت ضمانت نامه در منوی مدیریت مراجعه کنندگان'
        ]);

        \App\Permission::create([
            'key' => 'menu_referral_type',
            'name' => 'مدیریت مراجعه کنندگان ـ فعال سازی آیتم ثبت نوع مراجعه کننده',
            'description' => 'فعال یا غیرفعال کردن آیتم ثبت نوع مراجعه کننده در منوی مدیریت مراجعه کنندگان'
        ]);

        \App\Permission::create([
            'key' => 'menu_referral_referral',
            'name' => 'مدیریت مراجعه کنندگان ـ فعال سازی آیتم مراجعه کنندگان',
            'description' => 'فعال یا غیرفعال کردن آیتم  مراجعه کنندگان در منوی مدیریت مراجعه کنندگان'
        ]);

        \App\Permission::create([
            'key' => 'menu_educational_term',
            'name' => 'منوی اطلاعات تحصیلی ـ فعال سازی آیتم نیمسال تحصیلی',
            'description' => 'فعال یا غیرفعال کردن آیتم نیمسال تحصیلی در منوی اطلاعات تحصیلی'
        ]);
    }
}
