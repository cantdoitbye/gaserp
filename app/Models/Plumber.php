<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_number',
        'email',
        'address',
        'status',
         'plumber_id'
    ];

    /**
     * Get all PE/PNG jobs for this plumber
     */
    public function pePngs()
    {
        return $this->hasMany(PePng::class);
    }
}
