<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user'; // Ensure table name is correct
    protected $primaryKey = 'user_id'; // Ensure the primary key is set
    public $timestamps = false;

    protected $fillable = [
        'username',
        'nama',
        'level_id',
        'password',
    ];

    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id'); // Ensure correct foreign key
    }
}

