<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaksiSetoranRequest;
use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\TransaksiSetoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TransaksiSetoranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TransaksiSetoran::with(['nasabah', 'jenisSampah']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('nasabah', function ($nq) use ($search) {
                      $nq->where('nama', 'like', "%{$search}%")
                        ->orWhere('kode_nasabah', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            $query->whereBetween('created_at', [
                $request->tanggal_dari . ' 00:00:00',
                $request->tanggal_sampai . ' 23:59:59'
            ]);
        }

        $transaksi = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('transaksi/setoran/index', [
            'transaksi' => $transaksi,
            'filters' => $request->only(['search', 'tanggal_dari', 'tanggal_sampai']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nasabah = Nasabah::orderBy('nama')->get();
        $jenisSampah = JenisSampah::orderBy('jenis_sampah')->get();

        return Inertia::render('transaksi/setoran/create', [
            'nasabah' => $nasabah,
            'jenisSampah' => $jenisSampah,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiSetoranRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $jenisSampah = JenisSampah::findOrFail($validated['jenis_sampah_id']);
            
            // Calculate nilai setoran
            $nilai_setoran = $validated['berat_kg'] * $jenisSampah->harga_beli;
            
            // Create transaction
            TransaksiSetoran::create([
                'nasabah_id' => $validated['nasabah_id'],
                'jenis_sampah_id' => $validated['jenis_sampah_id'],
                'berat_kg' => $validated['berat_kg'],
                'harga_per_kg' => $jenisSampah->harga_beli,
                'nilai_setoran' => $nilai_setoran,
            ]);

            // Update nasabah saldo total
            $nasabah = Nasabah::findOrFail($validated['nasabah_id']);
            $nasabah->increment('saldo_total', $nilai_setoran);

            // Update stok jenis sampah
            $jenisSampah->increment('stok_kg', $validated['berat_kg']);
        });

        return redirect()->route('transaksi.setoran.index')
            ->with('success', 'Transaksi setoran berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiSetoran $setoran)
    {
        $setoran->load(['nasabah', 'jenisSampah']);

        return Inertia::render('transaksi/setoran/show', [
            'transaksi' => $setoran,
        ]);
    }
}