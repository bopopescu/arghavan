<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
            DegreeSeeder::class,
            GroupSeeder::class,
            NativeSeeder::class,
            SuitStateSeeder::class,
            GenderSeeder::class,
            MelliatSeeder::class,
            KinTypeSeeder::class,
            PartSeeder::class,
            SituationSeeder::class,
            CardTypeSeeder::class,
            ProvinceSeeder::class,
            LevelSeeder::class,
            CitySeeder::class,
            UniversitySeeder::class,
            ContractSeeder::class,
            DepartmentSeeder::class,
            DeviceTypeSeeder::class,
            ZoneSeeder::class,
            FieldSeeder::class,
            GateDirectSeeder::class,
            GateGenderSeeder::class,
            GateMessageSeeder::class,
            GatePassSeeder::class,
            GateZoonSeeder::class,
            GateDeviceSeeder::class,
            GateOptionSeeder::class,
            GateOperatorSeeder::class,
            PeopleSeeder::class,
            PermissionSeeder::class,
            CarPermissionSeeder::class,
            CarPlateCitySeeder::class,
            CarPlateWordSeeder::class,
            CarPlateTypeSeeder::class,

            RoleSeeder::class,
            GroupPermitSeeder::class,
            UserSeeder::class,
            CardSeeder::class,
            StaffSeeder::class,
            GateTrafficSeeder::class,
            VacationStatusSeeder::class,
            VacationTypeSeeder::class,
            ReferralTypeSeeder::class,
            SemesterSeeder::class,
            TermSeeder::class,
            WarrantySeeder::class,
            SystemInfoSeeder::class,
            CommonRangeSeeder::class,
            GateGroupSeeder::class,

            AmoebaSeeder::class,
            FingerprintDeviceSeeder::class,

    ]);


        \App\People::create([
            'name'       => 'طراح',
            'lastname'   => 'سیستم',
            'nationalId' => '9999999999',
            'birthdate' => '2018-01-01',
            'gender_id'  => '1',
            'city_id'    => '1',
            'melliat_id' => '1',
            'picture' => 'j2bgJrrWLJffJ7QphDZGgs9vVo2uiJmu7ZDaMVIp.png'
        ]);

    }
}
