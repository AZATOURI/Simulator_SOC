<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'title',
        'category',
        'description',
        'severity',
        'status',
        'source_ip',
        'target_syste m',
        'recommendation',
        'raw_log',
    ];

    public function logs()
    {
        return $this->hasMany(AlertLog::class)->latest();
    }
}
