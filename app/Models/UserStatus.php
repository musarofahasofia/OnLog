<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    protected $guarded = [];
    // protected $fillable = [
    //     'user_id',
    //     'status',
    //     'start_date',
    //     'end_date',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
