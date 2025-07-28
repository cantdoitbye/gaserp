<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeTracker extends Model
{
use HasFactory;

    protected $fillable = [
        'date',
        'dpr_no',
        'sites_names',
        'activity',
        'mukadam_name',
        'supervisor',
        'tpi_name',
        'ra_bill_no',
        'measurements',
        'installation_data',
        'pipe_fittings',
        'testing_data',
        'total_laying_length',
        'project_status'
    ];

    protected $casts = [
        'date' => 'date',
        'measurements' => 'array',
        'installation_data' => 'array',
        'pipe_fittings' => 'array',
        'testing_data' => 'array',
        'total_laying_length' => 'decimal:2'
    ];

    protected $dates = ['date'];

    // Activity options
    public static function getActivityOptions()
    {
        return [
            'LAYING' => 'Laying',
            'COMMISSIONING' => 'Commissioning',
            'EXCAVATION' => 'Excavation',
            'FLUSHING' => 'Flushing',
            'JOINT' => 'Joint',
            'SR INSTALLATION' => 'SR Installation'
        ];
    }

    // Accessor for formatted date
    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('d-m-Y') : '';
    }

    // Get specific measurement value
    public function getMeasurement($key, $default = null)
    {
        return data_get($this->measurements, $key, $default);
    }

    // Set specific measurement value
    public function setMeasurement($key, $value)
    {
        $measurements = $this->measurements ?? [];
        data_set($measurements, $key, $value);
        $this->measurements = $measurements;
    }

    // Get specific installation data
    public function getInstallationData($key, $default = null)
    {
        return data_get($this->installation_data, $key, $default);
    }

    // Get specific pipe fitting data
    public function getPipeFitting($key, $default = null)
    {
        return data_get($this->pipe_fittings, $key, $default);
    }

    // Get specific testing data
    public function getTestingData($key, $default = null)
    {
        return data_get($this->testing_data, $key, $default);
    }

    // Calculate total laying from measurements
    public function calculateTotalLaying()
    {
        $total = 0;
        $measurements = $this->measurements ?? [];
        
        // Add up all the laying measurements
        $layingFields = [
            '32_mm_laying_open_cut',
            '63_mm_laying_open_cut', 
            '90_mm_laying_open_cut',
            '125_mm_laying_open_cut',
            '32_mm_manual_boring',
            '63_mm_manual_boring',
            '90_mm_manual_boring',
            '125_mm_manual_boring'
        ];
        
        foreach ($layingFields as $field) {
            $value = data_get($measurements, $field, 0);
            $total += is_numeric($value) ? (float)$value : 0;
        }
        
        return $total;
    }

    // Scope for filtering by activity
    public function scopeByActivity($query, $activity)
    {
        return $activity ? $query->where('activity', $activity) : $query;
    }

    // Scope for filtering by date range
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        if ($startDate && $endDate) {
            return $query->whereBetween('date', [$startDate, $endDate]);
        } elseif ($startDate) {
            return $query->where('date', '>=', $startDate);
        } elseif ($endDate) {
            return $query->where('date', '<=', $endDate);
        }
        return $query;
    }

    // Scope for filtering by supervisor
    public function scopeBySupervisor($query, $supervisor)
    {
        return $supervisor ? $query->where('supervisor', 'like', "%{$supervisor}%") : $query;
    }

    // Get all unique supervisors
    public static function getUniqueSupervisors()
    {
        return static::whereNotNull('supervisor')
            ->distinct()
            ->pluck('supervisor')
            ->filter()
            ->sort()
            ->values();
    }

    // Get all unique mukadams
    public static function getUniqueMukadams()
    {
        return static::whereNotNull('mukadam_name')
            ->distinct()
            ->pluck('mukadam_name')
            ->filter()
            ->sort()
            ->values();
    }
}
