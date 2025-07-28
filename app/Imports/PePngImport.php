<?php

namespace App\Imports;

use App\Models\PePng;
use App\Models\Plumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PePngImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Find or create plumber based on name
        $plumber = null;
        if (!empty($row['plumber_name'])) {
            $plumber = Plumber::firstOrCreate(
                ['name' => $row['plumber_name']],
                ['status' => 'active']
            );
        }

        return new PePng([
            'job_order_number' => $row['job_order_number'],
            'category' => strtolower($row['category']),
            'plumbing_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['plumbing_date']),
            'plumber_id' => $plumber ? $plumber->id : null,
            'gc_date' => !empty($row['gc_date']) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['gc_date']) : null,
            'mmt_date' => !empty($row['mmt_date']) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['mmt_date']) : null,
            'remarks' => $row['remarks'] ?? null,
            'bill_ra_no' => $row['bill_ra_no'] ?? null,
            'plb_bill_status' => strtolower($row['plb_bill_status'] ?? 'pending'),
            'sla_days' => $row['sla_days'] ?? null,
            'pe_dpr' => $row['pe_dpr'] ?? null,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'job_order_number' => 'required|unique:pe_pngs,job_order_number',
            'category' => 'required',
            'plumbing_date' => 'required',
        ];
    }
}