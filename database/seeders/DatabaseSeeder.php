<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::insert([
            [
                'name' => 'مدير النظام',
                'email' => 'admin@example.com',
                'phone' => '0900000000',
                'password' => Hash::make('admin1234'),
                'role' => 'admin',
            ],
            [
                'name' => 'الشيخ أبو حذيفة',
                'email' => 'abu_huthaifa@example.com',
                'phone' => '0944879340',
                'password' => Hash::make('1234'),
                'role' => 'teacher',
            ],
            [
                'name' => 'الشيخ علاء',
                'email' => 'alaa@example.com',
                'phone' => '0945223954',
                'password' => Hash::make('1111'),
                'role' => 'teacher',
            ],
            [
                'name' => 'الشيخ أبو جعفر',
                'email' => 'abu_jaafar@example.com',
                'phone' => '0949538403',
                'password' => Hash::make('4444'),
                'role' => 'teacher',
            ],
            [
                'name' => 'الشيخ عبد الرحمن عودة',
                'email' => 'abdurrahman_oda@example.com',
                'phone' => '0957268742',
                'password' => Hash::make('5555'),
                'role' => 'teacher',
            ],
            [
                'name' => 'الشيخ عبد الرحمن محفوض',
                'email' => 'abdurrahman_mahfouz@example.com',
                'phone' => '0940507679',
                'password' => Hash::make('6666'),
                'role' => 'teacher',
            ],
            [
                'name' => 'الشيخ حذيفة',
                'email' => 'huthaifa@example.com',
                'phone' => '0953570085',
                'password' => Hash::make('112233'),
                'role' => 'teacher',
            ],
                    [
                'name' => 'الشيخ محمد',
                'email' => 'mohamed@example.com',
                'phone' => '0935018983',
                'password' => Hash::make('كريم رسول الله و الله أكرم'),
                'role' => 'teacher',
            ],
        ]);
    }
}
