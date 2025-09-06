<?php

namespace Database\Seeders;

use App\Models\Authorizations;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Roleseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permessions = [];
        foreach(config('authorization.permissions') as $permession=>$value){
            $permessions[] = $permession;
        }

        Authorizations::create([
            'role'=>'Manager',
            'permissions'=>json_encode($permessions),
        ]);
    }
}
