<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * User status constants
     */
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_SUSPENDED = 9;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'last_access',
        'status',
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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_access' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the doctor profile associated with the user.
     */
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    /**
     * Get the nurse profile associated with the user.
     */
    public function nurse()
    {
        return $this->hasOne(Nurse::class);
    }

    /**
     * Get the patient profile associated with the user.
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    /**
     * Check if the user is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if the user has a specific role.
     *
     * @param int $roleId
     * @return bool
     */
    public function hasRole($roleId)
    {
        return $this->role_id === $roleId;
    }

    /**
     * Check if the user has a specific role by name.
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRoleByName($roleName)
    {
        if (!$this->role) {
            return false;
        }

        return strtolower($this->role->name) === strtolower($roleName);
    }

    /**
     * Check if user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role_id === Role::ADMIN;
    }

    /**
     * Check if user is a doctor.
     *
     * @return bool
     */
    public function isDoctor()
    {
        return $this->role_id === Role::DOCTOR;
    }

    /**
     * Check if user is a nurse.
     *
     * @return bool
     */
    public function isNurse()
    {
        return $this->role_id === Role::NURSE;
    }

    /**
     * Check if user is a patient.
     *
     * @return bool
     */
    public function isPatient()
    {
        return $this->role_id === Role::PATIENT;
    }

    /**
     * Check if user is a receptionist.
     *
     * @return bool
     */
    public function isReceptionist()
    {
        return $this->role_id === Role::RECEPTIONIST;
    }

    /**
     * Get user's profile based on role.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getProfile()
    {
        if ($this->isDoctor()) {
            return $this->doctor;
        } elseif ($this->isNurse()) {
            return $this->nurse;
        } elseif ($this->isPatient()) {
            return $this->patient;
        }

        return null;
    }

    /**
     * Get user's full name or email if name is not available.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->name ?: $this->email;
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include users by role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $roleId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByRole($query, $roleId)
    {
        return $query->where('role_id', $roleId);
    }

    /**
     * Update the user's last access timestamp.
     *
     * @return bool
     */
    public function updateLastAccess()
    {
        return $this->update([
            'last_access' => now(),
        ]);
    }
}
