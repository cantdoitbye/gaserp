<?php

namespace App\Exports;

use App\Models\PePng;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class PePngExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = PePng::with('plumber');

        // Apply the same filters as in the index method
        if ($this->request->filled('category')) {
            $query->where('category', $this->request->input('category'));
        }

        if ($this->request->filled('plumber_id')) {
            $query->where('plumber_id', $this->request->input('plumber_id'));
        }

        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('plumbing_date', [$this->request->input('start_date'), $this->request->input('end_date')]);
        }

        return $query;
    }

    /**
     * @var PePng $pePng
     */
    public function map($pePng): array
    {
        return [
            $pePng->job_order_number,
            ucfirst($pePng->category),
            $pePng->plumbing_date->format('Y-m-d'),
            $pePng->plumber ? $pePng->plumber->name : '',
            $pePng->gc_date ? $pePng->gc_date->format('Y-m-d') : '',
            $pePng->mmt_date ? $pePng->mmt_date->format('Y-m-d') : '',
            $pePng->remarks,
            $pePng->bill_ra_no,
            ucfirst($pePng->plb_bill_status),
            $pePng->sla_days,
            $pePng->pe_dpr,
        ];
    }

    public function headings(): array
    {
        return [
            'Job Order Number',
            'Category',
            'Plumbing Date',
            'Plumber Name',
            'GC Date',
            'MMT Date',
            'Remarks',
            'Bill RA No',
            'PLB Bill Status',
            'SLA Days',
            'PE DPR',
        ];
    }
}