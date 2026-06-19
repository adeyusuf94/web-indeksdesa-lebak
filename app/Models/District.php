<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class District extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_kecamatan',
        'nama_kecamatan',
    ];

    protected $table = 'kecamatan';

    protected $primaryKey = 'id_kecamatan';

    public $incrementing = false;

    protected $keyType = 'string';

    public function desa()
    {
        return $this->hasMany(
            Village::class,
            'id_kecamatan',   // FK di desa
            'id_kecamatan'    // PK di kecamatan
        );
    }

    public function indeksDesa()
    {
        return $this->hasMany(
            IndexVillage::class,
            'id_kecamatan',   // FK di indeks_desa
            'id_kecamatan'    // PK di kecamatan
        );
    }
}
