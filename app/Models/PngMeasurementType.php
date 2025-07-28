<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PngMeasurementType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'png_type',
        'description',
        'measurement_fields',
        'is_active'
    ];

    protected $casts = [
        'measurement_fields' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Get all PNGs using this measurement type
     */
    public function pngs()
    {
        return $this->hasMany(Png::class);
    }

    /**
     * Get all Commercials using this measurement type
     */
    public function commercials()
    {
        return $this->hasMany(Commercial::class);
    }

    /**
     * Get all Risers using this measurement type
     */
    public function risers()
    {
        return $this->hasMany(Riser::class);
    }

    /**
     * Get all Ladders using this measurement type
     */
    public function ladders()
    {
        return $this->hasMany(Hadder::class);
    }

    /**
     * Get PNG types options (updated with new types)
     */
    public static function getPngTypeOptions()
    {
        return [
            // Original PNG types
            'flat' => 'Flat',
            'house' => 'House', 
            'bungalow' => 'Bungalow',
            'row_house' => 'Row House',
            'shop' => 'Shop',
            
            // Commercial types
            'commercial' => 'Commercial',
            'industrial' => 'Industrial',
            'office' => 'Office',
            'retail' => 'Retail',
            'restaurant' => 'Restaurant',
            'hotel' => 'Hotel',
            
            // Riser types
            'riser' => 'Riser',
            'approach' => 'Approach',
            'main_riser' => 'Main Riser',
            'sub_riser' => 'Sub Riser',
            'building_riser' => 'Building Riser',
            
            // Ladder types
            'ladder' => 'Hadder',
            'main_ladder' => 'Main Hadder',
            'sub_ladder' => 'Sub Hadder',
            'cross_ladder' => 'Cross Hadder',
            'distribution_ladder' => 'Distribution Hadder'
        ];
    }

      public static function getCommercialTypeOptions()
    {
        return [
           
            
            // Commercial types
            'commercial' => 'Commercial',
            'industrial' => 'Industrial',
            'office' => 'Office',
            'retail' => 'Retail',
            'restaurant' => 'Restaurant',
            'hotel' => 'Hotel',
        
            
          
        ];
    }

      public static function getRiserTypeOptions()
    {
        return [
           
            
            // Commercial types
            'riser' => 'Riser',
            'approach' => 'Approach',
            'main_riser' => 'Main Riser',
            'sub_riser' => 'Sub Riser',
            'building_riser' => 'Building Riser',
        
            
          
        ];
    }

      public static function getHadderTypeOptions()
    {
        return [
           
            
            'ladder' => 'Hadder',
            'main_ladder' => 'Main Hadder',
            'sub_ladder' => 'Sub Hadder',
            'cross_ladder' => 'Cross Hadder',
            'distribution_ladder' => 'Distribution Hadder'
        
            
          
        ];
    }

    

    /**
     * Get field types for measurements
     */
    public static function getFieldTypes()
    {
        return [
            'text' => 'Text',
            'number' => 'Number',
            'decimal' => 'Decimal (2 places)',
            'integer' => 'Integer',
            'select' => 'Dropdown',
            'textarea' => 'Textarea',
            'calculated' => 'Calculated Field'
        ];
    }

    /**
     * Get default measurement fields template based on type
     */
    public static function getDefaultFields($pngType = 'flat')
    {
        switch ($pngType) {
            case 'commercial':
            case 'industrial':
            case 'office':
            case 'retail':
            case 'restaurant':
            case 'hotel':
                return self::getCommercialDefaultFields($pngType);
                
            case 'riser':
            case 'approach':
            case 'main_riser':
            case 'sub_riser':
            case 'building_riser':
                return self::getRiserDefaultFields($pngType);
                
            case 'ladder':
            case 'main_ladder':
            case 'sub_ladder':
            case 'cross_ladder':
            case 'distribution_ladder':
                return self::getLadderDefaultFields($pngType);
                
            default:
                return self::getPngDefaultFields($pngType);
        }
    }

    /**
     * Get default fields for PNG types
     */
    private static function getPngDefaultFields($pngType)
    {
        $baseFields = [
            [
                'name' => 'gi_guard_to_main_valve',
                'label' => 'GI Guard to Main Valve (1/2")',
                'type' => 'decimal',
                'unit' => 'meters',
                'required' => false,
                'category' => 'gi_measurements',
                'calculated' => false
            ],
            [
                'name' => 'gi_main_valve_to_meter',
                'label' => 'GI Main Valve to Meter (1/2")', 
                'type' => 'decimal',
                'unit' => 'meters',
                'required' => false,
                'category' => 'gi_measurements',
                'calculated' => false
            ],
            [
                'name' => 'gi_meter_to_kitchen',
                'label' => 'GI Meter to Kitchen (1/2")',
                'type' => 'decimal', 
                'unit' => 'meters',
                'required' => false,
                'category' => 'gi_measurements',
                'calculated' => false
            ]
        ];

        switch ($pngType) {
            case 'flat':
                $baseFields[] = [
                    'name' => 'gi_meter_to_geyser',
                    'label' => 'GI Meter to Geyser (1/2")',
                    'type' => 'decimal',
                    'unit' => 'meters', 
                    'required' => false,
                    'category' => 'gi_measurements',
                    'calculated' => false
                ];
                break;

            case 'house':
            case 'bungalow':
                $baseFields = array_merge($baseFields, [
                    [
                        'name' => 'gi_meter_to_geyser_ground',
                        'label' => 'GI Meter to Geyser Ground Floor (1/2")',
                        'type' => 'decimal',
                        'unit' => 'meters',
                        'required' => false, 
                        'category' => 'gi_measurements',
                        'calculated' => false
                    ],
                    [
                        'name' => 'gi_meter_to_geyser_first',
                        'label' => 'GI Meter to Geyser First Floor (1/2")',
                        'type' => 'decimal',
                        'unit' => 'meters',
                        'required' => false,
                        'category' => 'gi_measurements', 
                        'calculated' => false
                    ]
                ]);
                break;
        }

        // Add total calculation field
        $baseFields[] = [
            'name' => 'total_gi',
            'label' => 'Total GI (Auto-calculated)',
            'type' => 'decimal',
            'unit' => 'meters',
            'required' => false,
            'category' => 'gi_measurements',
            'calculated' => true,
            'calculation_formula' => 'sum_category:gi_measurements'
        ];

        // Add fittings
        $fittings = [
            [
                'name' => 'valve_half_inch',
                'label' => 'Valve 1/2"',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ],
            [
                'name' => 'gi_coupling_half_inch', 
                'label' => 'GI Coupling 1/2"',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ],
            [
                'name' => 'gi_elbow_half_inch',
                'label' => 'GI Elbow 1/2"',
                'type' => 'integer',
                'unit' => 'qty', 
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ]
        ];

        return array_merge($baseFields, $fittings);
    }

    /**
     * Get default fields for Commercial types
     */
    private static function getCommercialDefaultFields($commercialType)
    {
        $baseFields = [
            [
                'name' => 'gi_main_supply_line',
                'label' => 'GI Main Supply Line (3/4" or 1")',
                'type' => 'decimal',
                'unit' => 'meters',
                'required' => false,
                'category' => 'gi_measurements',
                'calculated' => false
            ],
            [
                'name' => 'gi_distribution_line',
                'label' => 'GI Distribution Line (1/2")',
                'type' => 'decimal',
                'unit' => 'meters',
                'required' => false,
                'category' => 'gi_measurements',
                'calculated' => false
            ],
            [
                'name' => 'gi_meter_to_appliances',
                'label' => 'GI Meter to Appliances',
                'type' => 'decimal',
                'unit' => 'meters',
                'required' => false,
                'category' => 'gi_measurements',
                'calculated' => false
            ]
        ];

        // Add specific fields based on commercial type
        switch ($commercialType) {
            case 'restaurant':
            case 'hotel':
                $baseFields = array_merge($baseFields, [
                    [
                        'name' => 'gi_kitchen_line',
                        'label' => 'GI Kitchen Main Line (3/4")',
                        'type' => 'decimal',
                        'unit' => 'meters',
                        'required' => false,
                        'category' => 'gi_measurements',
                        'calculated' => false
                    ],
                    [
                        'name' => 'gi_burner_connections',
                        'label' => 'GI Burner Connections (1/2")',
                        'type' => 'decimal',
                        'unit' => 'meters',
                        'required' => false,
                        'category' => 'gi_measurements',
                        'calculated' => false
                    ]
                ]);
                break;
                
            case 'industrial':
                $baseFields = array_merge($baseFields, [
                    [
                        'name' => 'gi_heavy_duty_line',
                        'label' => 'GI Heavy Duty Line (1" or 1.5")',
                        'type' => 'decimal',
                        'unit' => 'meters',
                        'required' => false,
                        'category' => 'gi_measurements',
                        'calculated' => false
                    ]
                ]);
                break;
        }

        // Add total calculation
        $baseFields[] = [
            'name' => 'total_gi_commercial',
            'label' => 'Total GI Commercial (Auto-calculated)',
            'type' => 'decimal',
            'unit' => 'meters',
            'required' => false,
            'category' => 'gi_measurements',
            'calculated' => true,
            'calculation_formula' => 'sum_category:gi_measurements'
        ];

        // Commercial fittings
        $fittings = [
            [
                'name' => 'valve_three_quarter_inch',
                'label' => 'Valve 3/4"',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ],
            [
                'name' => 'valve_one_inch',
                'label' => 'Valve 1"',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ],
            [
                'name' => 'gi_coupling_three_quarter',
                'label' => 'GI Coupling 3/4"',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ],
            [
                'name' => 'pressure_regulator',
                'label' => 'Pressure Regulator',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ]
        ];

        return array_merge($baseFields, $fittings);
    }

    /**
     * Get default fields for Riser types
     */
    private static function getRiserDefaultFields($riserType)
    {
        $baseFields = [
            [
                'name' => 'ms_main_riser_line',
                'label' => 'MS Main Riser Line (2" or 3")',
                'type' => 'decimal',
                'unit' => 'meters',
                'required' => false,
                'category' => 'pipe_measurements',
                'calculated' => false
            ],
            [
                'name' => 'ms_branch_connection',
                'label' => 'MS Branch Connection (1" or 1.5")',
                'type' => 'decimal',
                'unit' => 'meters',
                'required' => false,
                'category' => 'pipe_measurements',
                'calculated' => false
            ],
            [
                'name' => 'approach_line',
                'label' => 'Approach Line',
                'type' => 'decimal',
                'unit' => 'meters',
                'required' => false,
                'category' => 'pipe_measurements',
                'calculated' => false
            ]
        ];

        // Add specific fields based on riser type
        switch ($riserType) {
            case 'main_riser':
                $baseFields = array_merge($baseFields, [
                    [
                        'name' => 'vertical_riser_length',
                        'label' => 'Vertical Riser Length',
                        'type' => 'decimal',
                        'unit' => 'meters',
                        'required' => false,
                        'category' => 'pipe_measurements',
                        'calculated' => false
                    ]
                ]);
                break;
                
            case 'approach':
                $baseFields = array_merge($baseFields, [
                    [
                        'name' => 'approach_depth',
                        'label' => 'Approach Depth',
                        'type' => 'decimal',
                        'unit' => 'meters',
                        'required' => false,
                        'category' => 'excavation',
                        'calculated' => false
                    ]
                ]);
                break;
        }

        // Add total calculation
        $baseFields[] = [
            'name' => 'total_pipe_riser',
            'label' => 'Total Pipe Riser (Auto-calculated)',
            'type' => 'decimal',
            'unit' => 'meters',
            'required' => false,
            'category' => 'pipe_measurements',
            'calculated' => true,
            'calculation_formula' => 'sum_category:pipe_measurements'
        ];

        // Riser fittings
        $fittings = [
            [
                'name' => 'valve_two_inch',
                'label' => 'Valve 2"',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ],
            [
                'name' => 'tee_junction_two_inch',
                'label' => 'Tee Junction 2"',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ],
            [
                'name' => 'flange_connection',
                'label' => 'Flange Connection',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ]
        ];

        return array_merge($baseFields, $fittings);
    }

    /**
     * Get default fields for Ladder types
     */
    private static function getLadderDefaultFields($ladderType)
    {
        $baseFields = [
            [
                'name' => 'ms_main_ladder_line',
                'label' => 'MS Main Hadder Line (4" or 6")',
                'type' => 'decimal',
                'unit' => 'meters',
                'required' => false,
                'category' => 'pipe_measurements',
                'calculated' => false
            ],
            [
                'name' => 'distribution_branch',
                'label' => 'Distribution Branch (2" or 3")',
                'type' => 'decimal',
                'unit' => 'meters',
                'required' => false,
                'category' => 'pipe_measurements',
                'calculated' => false
            ],
            [
                'name' => 'cross_connection_line',
                'label' => 'Cross Connection Line',
                'type' => 'decimal',
                'unit' => 'meters',
                'required' => false,
                'category' => 'pipe_measurements',
                'calculated' => false
            ]
        ];

        // Add specific fields based on ladder type
        switch ($ladderType) {
            case 'main_ladder':
                $baseFields = array_merge($baseFields, [
                    [
                        'name' => 'primary_distribution_length',
                        'label' => 'Primary Distribution Length',
                        'type' => 'decimal',
                        'unit' => 'meters',
                        'required' => false,
                        'category' => 'pipe_measurements',
                        'calculated' => false
                    ]
                ]);
                break;
                
            case 'cross_ladder':
                $baseFields = array_merge($baseFields, [
                    [
                        'name' => 'cross_connection_depth',
                        'label' => 'Cross Connection Depth',
                        'type' => 'decimal',
                        'unit' => 'meters',
                        'required' => false,
                        'category' => 'excavation',
                        'calculated' => false
                    ]
                ]);
                break;
        }

        // Add total calculation
        $baseFields[] = [
            'name' => 'total_pipe_ladder',
            'label' => 'Total Pipe Ladder (Auto-calculated)',
            'type' => 'decimal',
            'unit' => 'meters',
            'required' => false,
            'category' => 'pipe_measurements',
            'calculated' => true,
            'calculation_formula' => 'sum_category:pipe_measurements'
        ];

        // Ladder fittings
        $fittings = [
            [
                'name' => 'valve_four_inch',
                'label' => 'Valve 4"',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ],
            [
                'name' => 'tee_junction_four_inch',
                'label' => 'Tee Junction 4"',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ],
            [
                'name' => 'pressure_reducing_station',
                'label' => 'Pressure Reducing Station',
                'type' => 'integer',
                'unit' => 'qty',
                'required' => false,
                'category' => 'fittings',
                'calculated' => false
            ]
        ];

        return array_merge($baseFields, $fittings);
    }

    /**
     * Scope for active measurement types
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by PNG type
     */
    public function scopeByPngType($query, $pngType)
    {
        return $query->where('png_type', $pngType);
    }

    /**
     * Get measurement fields by category
     */
    public function getFieldsByCategory($category = null)
    {
        if (!$category) {
            return $this->measurement_fields;
        }

        return collect($this->measurement_fields)->filter(function ($field) use ($category) {
            return ($field['category'] ?? 'general') === $category;
        })->values()->toArray();
    }

    /**
     * Get calculated fields
     */
    public function getCalculatedFields()
    {
        return collect($this->measurement_fields)->filter(function ($field) {
            return $field['calculated'] ?? false;
        })->values()->toArray();
    }

    /**
     * Check if this measurement type is used by any module
     */
    public function isInUse()
    {
        return $this->pngs()->exists() || 
               $this->commercials()->exists() || 
               $this->risers()->exists() || 
               $this->ladders()->exists();
    }

    /**
     * Get usage count across all modules
     */
    public function getUsageCount()
    {
        return $this->pngs()->count() + 
               $this->commercials()->count() + 
               $this->risers()->count() + 
               $this->ladders()->count();
    }
}