<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;
use Carbon\Carbon;
use DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('package')->delete();

        $users = [
            [
                'name' => 'KG',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),],
            [
                'name' => 'GM',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name' => 'ML',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ]
        ];
        DB::table('package')->insert($users);
    }
}
