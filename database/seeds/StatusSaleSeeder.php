<?php

use Illuminate\Database\Seeder;
use App\Models\StatusSales;

class StatusSaleSeeder extends Seeder
{
    public function run()
    {
        $statusList = [
            ['description' => 'Vendidos'],
            ['description' => 'Cancelados'],
            ['description' => 'Devoluções']
        ];

        foreach($statusList as $status){
            StatusSales::create($status);
        }
    }
}
