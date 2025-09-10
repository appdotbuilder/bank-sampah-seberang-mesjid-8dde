<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Nasabah
 *
 * @property int $id
 * @property string $kode_nasabah
 * @property string $nama
 * @property string $nik_nip
 * @property string $alamat
 * @property string|null $instansi
 * @property float $saldo_total
 * @property float $saldo_dapat_ditarik
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiSetoran> $transaksiSetoran
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiPenarikan> $transaksiPenarikan
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah query()
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereKodeNasabah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereNikNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereInstansi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereSaldoTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereSaldoDapatDitarik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereUpdatedAt($value)
 * @method static \Database\Factories\NasabahFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Nasabah extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nasabah';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode_nasabah',
        'nama',
        'nik_nip',
        'alamat',
        'instansi',
        'saldo_total',
        'saldo_dapat_ditarik',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'saldo_total' => 'decimal:2',
        'saldo_dapat_ditarik' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the transaksi setoran for the nasabah.
     */
    public function transaksiSetoran(): HasMany
    {
        return $this->hasMany(TransaksiSetoran::class);
    }

    /**
     * Get the transaksi penarikan for the nasabah.
     */
    public function transaksiPenarikan(): HasMany
    {
        return $this->hasMany(TransaksiPenarikan::class);
    }

    /**
     * Generate kode nasabah automatically.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($nasabah) {
            if (empty($nasabah->kode_nasabah)) {
                $lastNasabah = static::orderBy('id', 'desc')->first();
                $lastNumber = $lastNasabah ? intval(substr($lastNasabah->kode_nasabah, 3)) : 0;
                $nasabah->kode_nasabah = 'NSB' . str_pad((string)($lastNumber + 1), 4, '0', STR_PAD_LEFT);
            }
        });
    }
}