<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class Attendance extends Model
{

    protected $guarded = [];
    // protected $fillable = [
    //     'user_id',
    //     'date',
    //     'clock_in',
    //     'clock_out',
    //     'status',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function overtime()
    {
        return $this->hasOne(RequestOvertime::class);
    }
}
