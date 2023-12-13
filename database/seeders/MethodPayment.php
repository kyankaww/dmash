<?php

namespace Database\Seeders;

use App\Models\MethodPayment as ModelsMethodPayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MethodPayment extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsMethodPayment::create([
            'type' => 'transfer',
            'method' => 'BCA',
            'transfer_destination' => '1234567890 - Kyanka Wisnu Wardhana',
        ]);
        
        ModelsMethodPayment::create([
            'type' => 'transfer',
            'method' => 'BNI',
            'transfer_destination' => '1234567890 - Kyanka Wisnu Wardhana',
        ]);

        ModelsMethodPayment::create([
            'type' => 'transfer',
            'method' => 'BRI',
            'transfer_destination' => '1234567890 - Kyanka Wisnu Wardhana',
        ]);

        ModelsMethodPayment::create([
            'type' => 'transfer',
            'method' => 'Mandiri',
            'transfer_destination' => '1234567890 - Kyanka Wisnu Wardhana',
        ]);

        ModelsMethodPayment::create([
            'type' => 'W-Wallet',
            'method' => 'OVO',
            'transfer_destination' => '081234567890 - Kyanka Wisnu Wardhana',
        ]);

        ModelsMethodPayment::create([
            'type' => 'W-Wallet',
            'method' => 'DANA',
            'transfer_destination' => '081234567890 - Kyanka Wisnu Wardhana',
        ]);

        ModelsMethodPayment::create([
            'type' => 'W-Wallet',
            'method' => 'GoPay',
            'transfer_destination' => '081234567890 - Kyanka Wisnu Wardhana',
        ]);
    }
}
