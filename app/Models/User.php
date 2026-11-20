<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $plan
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'email', 'password', 'plan'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const PLAN_FREE = 'free';

    public const PLAN_PRO = 'pro';

    /**
     * Every plan a user can be on. There is no payment integration:
     * the plan is changed by hand.
     *
     * @var list<string>
     */
    public const PLANS = [self::PLAN_FREE, self::PLAN_PRO];

    /**
     * New accounts start on the free plan.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'plan' => self::PLAN_FREE,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }

    public function isPro(): bool
    {
        return $this->plan === self::PLAN_PRO;
    }

    public function isFree(): bool
    {
        return $this->plan === self::PLAN_FREE;
    }

    public function planName(): string
    {
        return match ($this->plan) {
            self::PLAN_PRO => 'Pro',
            default => 'Ücretsiz',
        };
    }

    public function workspaces()
    {
        return $this->belongsToMany(Workspaces::class, 'workspace_user', 'user_id', 'workspace_id')
            ->withPivot('role')
            ->withTimestamps();
    }
}
