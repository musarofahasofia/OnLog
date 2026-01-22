<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'type',
    //     'photo',
    //     'storage_id',
    //     'jabatan'
    // ];

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
            'password'          => 'hashed',
        ];
    }

    public function status()
    {
        return $this->hasOne(UserStatus::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function attendance_history()
    {
        return $this->hasMany(AttendanceHistory::class);
    }

    public function requestPermissions()
    {
        return $this->hasMany(RequestPermission::class);
    }

    public function requestDuties()
    {
        return $this->hasMany(RequestDuty::class);
    }

    public function badgeStatusAt(Carbon | string $date): string
    {
        $date = $date ? Carbon::parse($date) : now();

        // 1. Attendance (prioritas tertinggi)
        $attendance = $this->attendance()
            ->whereDate('created_at', $date)
            ->first();

        if ($attendance) {
            if ($attendance->status === 'late' && $attendance->overtime) {
                return 'terlambat_lembur';
            }

            if ($attendance->overtime) {
                return 'lembur';
            }

            if ($attendance->status === 'late') {
                return 'terlambat';
            }

            return 'masuk';
        }

        // 2. Permission
        $permission = $this->requestPermissions()
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->exists();

        if ($permission) {
            return 'izin';
        }

        // 3. Duty
        $duty = $this->requestDuties()
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->exists();

        if ($duty) {
            return 'dinas_luar';
        }

        // 4. Default
        return 'none';
    }

    protected $appends = ['badge_status'];

    public function getBadgeStatusAttribute()
    {
        return $this->badgeStatusAt(today());
    }
}
