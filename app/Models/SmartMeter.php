<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartMeter extends Model
{
    use HasFactory;
    protected $table = 'smart_meters'; 

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'serial_number',
        'location',
        'status',
    ];
    // Accessor untuk 'last_reading' yang dihitung otomatis
    public function getLastReadingAttribute()
    {
        // Ambil pembacaan terakhir dari UsageRecord untuk SmartMeter ini
        $lastUsage = $this->usageRecords()
            ->orderBy('recorded_at', 'desc')
            ->first(); // Ambil pembacaan terakhir

        // Kembalikan nilai konsumsi terakhir atau 0 jika tidak ada data
        return $lastUsage ? $lastUsage->consumption : 0.00;
    }

    // Relasi ke UsageRecord
    public function usageRecords()
    {
        return $this->hasMany(UsageRecord::class);
    }
}
