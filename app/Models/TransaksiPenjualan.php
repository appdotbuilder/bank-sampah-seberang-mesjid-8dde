<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TransaksiPenjualan
 *
 * @property int $id
 * @property string $no_transaksi
 * @property int $pengepul_id
 * @property int $jenis_sampah_id
 * @property float $berat_kg
 * @property float $harga_per_kg
 * @property float $nilai_jual
 * @property float $keuntungan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Pengepul $pengepul
 * @property-read \App\Models\JenisSampah $jenisSampah
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan whereNoTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan wherePengepulId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan whereJenisSampahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan whereBeratKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan whereHargaPerKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan whereNilaiJual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan whereKeuntungan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenjualan whereUpdatedAt($value)
 * @method static \Database\Factories\TransaksiPenjualanFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class TransaksiPenjualan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaksi_penjualan';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'no_transaksi',
        'pengepul_id',
        'jenis_sampah_id',
        'berat_kg',
        'harga_per_kg',
        'nilai_jual',
        'keuntungan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'berat_kg' => 'decimal:2',
        'harga_per_kg' => 'decimal:2',
        'nilai_jual' => 'decimal:2',
        'keuntungan' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the pengepul that owns the transaksi penjualan.
     */
    public function pengepul(): BelongsTo
    {
        return $this->belongsTo(Pengepul::class);
    }

    /**
     * Get the jenis sampah that owns the transaksi penjualan.
     */
    public function jenisSampah(): BelongsTo
    {
        return $this->belongsTo(JenisSampah::class);
    }

    /**
     * Generate no transaksi automatically.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            if (empty($transaksi->no_transaksi)) {
                $today = now()->format('Ymd');
                $lastTransaksi = static::where('no_transaksi', 'like', "TPJ{$today}%")
                    ->orderBy('no_transaksi', 'desc')
                    ->first();
                
                if ($lastTransaksi) {
                    $lastNumber = intval(substr($lastTransaksi->no_transaksi, -4));
                    $newNumber = $lastNumber + 1;
                } else {
                    $newNumber = 1;
                }
                
                $transaksi->no_transaksi = "TPJ{$today}" . str_pad((string)$newNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}