<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageRecord extends Model
{
    use HasFactory;
    protected $table = 'usage_records'; 

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'smart_meter_id',
        'consumption',
        'recorded_at',
    ];

    // Definisikan relasi dengan model SmartMeter
    // Pastikan relasi ke SmartMeter sudah terdefinisi
    public function smartMeter()
    {
        return $this->belongsTo(SmartMeter::class);
    }

    protected static function booted()
    {
        static::created(function ($usageRecord) {
            // Perbarui last_reading pada smart_meter terkait setelah pencatatan baru
            $smartMeter = $usageRecord->smartMeter;
            $smartMeter->last_reading = $usageRecord->consumption; // Update dengan konsumsi terbaru
            $smartMeter->save();
        });
    }
}
