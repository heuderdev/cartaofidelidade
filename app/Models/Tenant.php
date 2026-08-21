<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;

class Tenant extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Billable;

    public const SUBSCRIPTION_DEFAULT = 'default';

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'type',
        'status',
        'timezone',
        'locale',
        'billing_access_granted',
        'billing_access_granted_until',
        'is_free'
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

    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tenant_user')
            ->using(TenantUser::class)
            ->withPivot([
                'role',
                'status',
                'joined_at',
            ])
            ->wherePivot('role', 'owner')
            ->wherePivot('status', 'active')
            ->withTimestamps();
    }

    public function members(): HasMany
    {
        return $this->hasMany(
            TenantUser::class,
            'tenant_id'
        );
    }

    public function stripeName(): ?string
    {
        return $this->name;
    }

    public function stripeEmail(): ?string
    {
        return $this->owners()->first()?->email
            ?? $this->users()->orderByPivot('created_at')->first()?->email;
    }

    public function isOwner(User $user): bool
    {
        return $this->users()
            ->whereKey($user->getKey())
            ->wherePivot('role', 'owner')
            ->wherePivot('status', 'active')
            ->exists();
    }

    public function isSubscribed(): bool
    {
        return $this->subscribed(self::SUBSCRIPTION_DEFAULT);
    }

    public function isPaidOrFree(): bool
    {
        return $this->hasBillingAccess();
    }

    public function onGracePeriod(): bool
    {
        return $this->subscription(self::SUBSCRIPTION_DEFAULT)?->onGracePeriod() ?? false;
    }


    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    protected function casts(): array
    {
        return [
            'billing_access_granted' => 'boolean',
            'billing_access_granted_until' => 'datetime',
            'trial_ends_at' => 'datetime',
        ];
    }

    public function hasBillingAccess(): bool
    {
        return $this->isFree()
            || $this->hasValidTrial()
            || $this->hasActiveBilling()
            || $this->hasManualBillingAccess();
    }

    public function isFree(): bool
    {
        return (bool) $this->is_free;
    }

    public function hasValidTrial(): bool
    {
        return $this->trial_ends_at?->isFuture() ?? false;
    }

    public function hasActiveBilling(): bool
    {
        return $this->subscribed(
            self::SUBSCRIPTION_DEFAULT
        );
    }

    public function hasManualBillingAccess(): bool
    {
        return $this->billing_access_granted
            && (
                $this->billing_access_granted_until === null
                || $this->billing_access_granted_until->isFuture()
            );
    }
}
