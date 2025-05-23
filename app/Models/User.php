<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Althinect\FilamentSpatieRolesPermissions\Concerns\HasSuperAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasSuperAdmin;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile && $this->profile->avatar ? asset('storage/' . $this->profile->avatar) : null;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasVerifiedEmail();
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(invoice::class, 'invoice_principal')->withPivot(['commission_fee', 'is_payment', 'ppn', 'pph']);
    }

    public function commission()
    {
        return $this->belongsToMany(Sale::class, 'principal_sale')->withPivot(['commission_fee', 'is_payment', 'ppn', 'pph']);
    }
}
