<?php

namespace Database\Seeders;

use App\Models\InvestmentType;
use Illuminate\Database\Seeder;

class InvestmentTypesSeeder extends Seeder
{
    public function run()
    {
        $types = ['Ações', 'FIIs', 'CDBs', 'Tesouro Direto'];
        foreach ($types as $type) {
            InvestmentType::firstOrCreate(['name' => $type]);
        }
    }
}
