<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Pengepul
 *
 * @property int $id
 * @property string $kode_pengepul
 * @property string $nama
 * @property string $alamat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiPenjualan> $transaksiPenjualan
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Pengepul newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengepul newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengepul query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengepul whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengepul whereKodePengepul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengepul whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengepul whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengepul whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengepul whereUpdatedAt($value)
 * @method static \Database\Factories\PengepulFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Pengepul extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengepul';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode_pengepul',
        'nama',
        'alamat',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the transaksi penjualan for the pengepul.
     */
    public function transaksiPenjualan(): HasMany
    {
        return $this->hasMany(TransaksiPenjualan::class);
    }

    /**
     * Generate kode pengepul automatically.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengepul) {
            if (empty($pengepul->kode_pengepul)) {
                $lastPengepul = static::orderBy('id', 'desc')->first();
                $lastNumber = $lastPengepul ? intval(substr($lastPengepul->kode_pengepul, 3)) : 0;
                $pengepul->kode_pengepul = 'PNG' . str_pad((string)($lastNumber + 1), 4, '0', STR_PAD_LEFT);
            }
        });
    }
}