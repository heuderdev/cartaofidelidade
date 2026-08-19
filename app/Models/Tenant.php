<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tenant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'type',
        'status',
        'timezone',
        'locale',
    ];

    protected static function booted(): void
    {

        static::creating(function (Tenant $tenant): void {
            $tenant->uuid ??= (string) Str::uuid();
            $tenant->slug ??= sprintf(
                '%s-%s',
                Str::slug($tenant->name),
                Str::lower(Str::random(6))
            );
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(TenantUser::class)
            ->withPivot([
                'role',
                'status',
                'joined_at',
            ])
            ->withTimestamps();
    }


    public function isPlatform(): bool
    {
        return $this->type === 'platform';
    }

    public function invitations(): HasMany
{
    return $this->hasMany(TenantInvitation::class);
}
}
