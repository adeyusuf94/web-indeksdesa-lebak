<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class IndexVillage extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'id_desa',
        'id_kecamatan',
        'dimensi_layanan_dasar',
        'dimensi_sosial',
        'dimensi_ekonomi',
        'dimensi_lingkungan',
        'dimensi_aksesibilitas',
        'dimensi_tata_kelola_pemerintah',
        'skor',
        'status_indeks',
        'tahun',
    ];

    protected $table = 'indeks_desa';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public function desa()
    {
        return $this->belongsTo(
            Village::class,
            'id_desa',
            'id_desa'
        );
    }

    public function kecamatan()
    {
        return $this->belongsTo(
            District::class,
            'id_kecamatan',
            'id_kecamatan'
        );
    }
}
