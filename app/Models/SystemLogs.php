<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_ARCHIVED = 2;

    // Action types
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_RESTORE = 'restore';
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_FAILED_LOGIN = 'failed_login';
    const ACTION_EXPORT = 'export';
    const ACTION_IMPORT = 'import';
    const ACTION_VIEW = 'view';

    // Modules
    const MODULE_USERS = 'users';
    const MODULE_PATIENTS = 'patients';
    const MODULE_DOCTORS = 'doctors';
    const MODULE_NURSES = 'nurses';
    const MODULE_APPOINTMENTS = 'appointments';
    const MODULE_CONSULTATIONS = 'consultations';
    const MODULE_PRESCRIPTIONS = 'prescriptions';
    const MODULE_MEDICATIONS = 'medications';
    const MODULE_INVOICES = 'invoices';
    const MODULE_PAYMENTS = 'payments';
    const MODULE_SETTINGS = 'settings';
    const MODULE_AUTH = 'authentication';

    protected $fillable = [
        'user_id',
        'action',
        'module',
        'reference_table',
        'reference_id',
        'ip_address',
        'old_values',
        'new_values',
        'description',
        'user_agent',
        'status',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Get the user that performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Create a new log entry
     *
     * @param string $action The action performed (create, update, delete, etc)
     * @param string $module The module where the action was performed
     * @param string|null $referenceTable The database table affected
     * @param int|null $referenceId The ID of the affected record
     * @param array|null $oldValues The old values before the change
     * @param array|null $newValues The new values after the change
     * @param string|null $description A human-readable description of the action
     * @param int|null $userId The ID of the user who performed the action
     * @return SystemLog
     */
    public static function createLog(
        string $action,
        string $module,
        ?string $referenceTable = null,
        ?int $referenceId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null,
        ?int $userId = null
    ): SystemLog {
        return self::create([
            'user_id' => $userId ?: (auth()->check() ? auth()->id() : null),
            'action' => $action,
            'module' => $module,
            'reference_table' => $referenceTable,
            'reference_id' => $referenceId,
            'ip_address' => request()->ip(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description,
            'user_agent' => request()->userAgent(),
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Scope a query to only include logs of a specific action.
     */
    public function scopeOfAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope a query to only include logs of a specific module.
     */
    public function scopeOfModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope a query to only include logs related to a specific record.
     */
    public function scopeOfRecord($query, $table, $id)
    {
        return $query->where('reference_table', $table)
                     ->where('reference_id', $id);
    }

    /**
     * Scope a query to only include logs from a specific user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include logs from a specific date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}
