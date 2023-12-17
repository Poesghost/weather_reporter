<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alert extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alerts';

    protected $fillable = [
        'zone_id',
        'area_description',
        'sent',
        'effective',
        'onset',
        'expires',
        'ends',
        'status',
        'severity',
        'certainty',
        'urgency',
        'event',
        'sender',
        'headline',
        'description',
        'instruction',
        'title',
        'updated',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'zone_id' => 'integer',
        'sent' => 'datetime',
        'effective' => 'datetime',
        'onset' => 'datetime',
        'expires' => 'datetime',
        'ends' => 'datetime',
        'updated' => 'datetime',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];
}
