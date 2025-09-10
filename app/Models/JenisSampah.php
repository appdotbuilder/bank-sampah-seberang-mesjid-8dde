<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\JenisSampah
 *
 * @property int $id
 * @property string $kode_sampah
 * @property string $jenis_sampah
 * @property float $harga_beli
 * @property float $harga_jual
 * @property float $stok_kg
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiSetoran> $transaksiSetoran
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiPenjualan> $transaksiPenjualan
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah query()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereKodeSampah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereJenisSampah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereHargaBeli($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereHargaJual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereStokKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereUpdatedAt($value)
 * @method static \Database\Factories\JenisSampahFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class JenisSampah extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jenis_sampah';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode_sampah',
        'jenis_sampah',
        'harga_beli',
        'harga_jual',
        'stok_kg',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'stok_kg' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the transaksi setoran for the jenis sampah.
     */
    public function transaksiSetoran(): HasMany
    {
        return $this->hasMany(TransaksiSetoran::class);
    }

    /**
     * Get the transaksi penjualan for the jenis sampah.
     */
    public function transaksiPenjualan(): HasMany
    {
        return $this->hasMany(TransaksiPenjualan::class);
    }

    /**
     * Generate kode sampah automatically.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jenisSampah) {
            if (empty($jenisSampah->kode_sampah)) {
                $lastSampah = static::orderBy('id', 'desc')->first();
                $lastNumber = $lastSampah ? intval(substr($lastSampah->kode_sampah, 3)) : 0;
                $jenisSampah->kode_sampah = 'SPH' . str_pad((string)($lastNumber + 1), 4, '0', STR_PAD_LEFT);
            }
        });
    }
}