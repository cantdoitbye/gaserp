<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LegalDocumentType;


class LegalDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documentTypes = [
            ['name' => 'Bank Guarantee (BG)', 'description' => 'Financial guarantee provided by a bank', 'requires_expiry' => true],
            ['name' => 'Labour License', 'description' => 'License to employ contract labor', 'requires_expiry' => true],
            ['name' => 'Building and Other Construction Workers (BOCW)', 'description' => 'Construction worker welfare registration', 'requires_expiry' => true],
            ['name' => 'Public Liability Insurance (PLI)', 'description' => 'Insurance covering public liabilities', 'requires_expiry' => true],
            ['name' => 'Marine/Cargo Policy', 'description' => 'Insurance for goods in transit', 'requires_expiry' => true],
            ['name' => 'Workmen Compensation Insurance (WC)', 'description' => 'Insurance for worker injuries', 'requires_expiry' => true],
            ['name' => 'Erection All Risk Insurance (EAR)', 'description' => 'Insurance for construction/erection work', 'requires_expiry' => true],
            ['name' => 'Group Personal Accident (GPA)', 'description' => 'Accident coverage for group of employees', 'requires_expiry' => true],
        ];

        foreach ($documentTypes as $documentType) {
            LegalDocumentType::create($documentType);
        }
    }
}
