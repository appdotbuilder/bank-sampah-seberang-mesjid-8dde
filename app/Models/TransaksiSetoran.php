<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TransaksiSetoran
 *
 * @property int $id
 * @property string $no_transaksi
 * @property int $nasabah_id
 * @property int $jenis_sampah_id
 * @property float $berat_kg
 * @property float $harga_per_kg
 * @property float $nilai_setoran
 * @property bool $sudah_dijual
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Nasabah $nasabah
 * @property-read \App\Models\JenisSampah $jenisSampah
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran whereNoTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran whereNasabahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran whereJenisSampahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran whereBeratKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran whereHargaPerKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran whereNilaiSetoran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran whereSudahDijual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiSetoran whereUpdatedAt($value)
 * @method static \Database\Factories\TransaksiSetoranFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class TransaksiSetoran extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaksi_setoran';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'no_transaksi',
        'nasabah_id',
        'jenis_sampah_id',
        'berat_kg',
        'harga_per_kg',
        'nilai_setoran',
        'sudah_dijual',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'berat_kg' => 'decimal:2',
        'harga_per_kg' => 'decimal:2',
        'nilai_setoran' => 'decimal:2',
        'sudah_dijual' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the nasabah that owns the transaksi setoran.
     */
    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class);
    }

    /**
     * Get the jenis sampah that owns the transaksi setoran.
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
                $lastTransaksi = static::where('no_transaksi', 'like', "TRS{$today}%")
                    ->orderBy('no_transaksi', 'desc')
                    ->first();
                
                if ($lastTransaksi) {
                    $lastNumber = intval(substr($lastTransaksi->no_transaksi, -4));
                    $newNumber = $lastNumber + 1;
                } else {
                    $newNumber = 1;
                }
                
                $transaksi->no_transaksi = "TRS{$today}" . str_pad((string)$newNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}