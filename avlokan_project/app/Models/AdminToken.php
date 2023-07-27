<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminToken extends Model
{
    use HasFactory;

    protected $table = 'admin_tokens';

    protected $fillable = [
        'admin_id',
        'token',
    ];
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
