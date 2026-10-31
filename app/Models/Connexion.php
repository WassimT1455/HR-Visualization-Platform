<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connexion extends Model
{
    use HasFactory;

    protected $table = 'connexions';

    protected $fillable = [
        'user_id',
        'ip_address',
        'device',
        'browser',
        'operating_system',
        'country',
        'login_time',
        'heure_connexion',
        'navigateur',
        'appareil',
        'date',
        'time',
        'cs_user_agent',
        'distance_horaire',
        'cs_status',
        'suspicious',
    ];

    // 🔗 Relation vers le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
