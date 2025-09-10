<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TransaksiPenarikan
 *
 * @property int $id
 * @property string $no_transaksi
 * @property int $nasabah_id
 * @property float $jumlah_penarikan
 * @property string $status
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Nasabah $nasabah
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenarikan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenarikan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenarikan query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenarikan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenarikan whereNoTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenarikan whereNasabahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenarikan whereJumlahPenarikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenarikan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenarikan whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenarikan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiPenarikan whereUpdatedAt($value)
 * @method static \Database\Factories\TransaksiPenarikanFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class TransaksiPenarikan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaksi_penarikan';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'no_transaksi',
        'nasabah_id',
        'jumlah_penarikan',
        'status',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jumlah_penarikan' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the nasabah that owns the transaksi penarikan.
     */
    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class);
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
                $lastTransaksi = static::where('no_transaksi', 'like', "TPR{$today}%")
                    ->orderBy('no_transaksi', 'desc')
                    ->first();
                
                if ($lastTransaksi) {
                    $lastNumber = intval(substr($lastTransaksi->no_transaksi, -4));
                    $newNumber = $lastNumber + 1;
                } else {
                    $newNumber = 1;
                }
                
                $transaksi->no_transaksi = "TPR{$today}" . str_pad((string)$newNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}