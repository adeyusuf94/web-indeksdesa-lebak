<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Village extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_desa',
        'id_kecamatan',
        'nama_desa',
    ];

    protected $table = 'desa';

    protected $primaryKey = 'id_desa';

    public $incrementing = false;

    protected $keyType = 'string';

    public function kecamatan()
    {
        return $this->belongsTo(
            District::class,
            'id_kecamatan',   // FK di desa
            'id_kecamatan'    // PK di kecamatan
        );
    }

    public function indeksDesa()
    {
        return $this->hasMany(
            IndexVillage::class,
            'id_desa',   // FK di indeks_desa
            'id_desa'    // PK di desa
        );
    }
}
