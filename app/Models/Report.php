<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'admin_id',
        'type',
        'title',
        'content',
        'data',
        'report_date',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'report_date' => 'date',
        'data' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}


