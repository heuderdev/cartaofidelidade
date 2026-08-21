<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'tenant_id',
        'name',
        'email',
        'phone',
        'cpf',
        'birth_date',
        'status',
        'external_reference',
        'metadata',
        'last_visit_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'last_visit_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

}
