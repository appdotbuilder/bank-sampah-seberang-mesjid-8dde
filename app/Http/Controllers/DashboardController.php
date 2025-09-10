<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\TransaksiPenarikan;
use App\Models\TransaksiPenjualan;
use App\Models\TransaksiSetoran;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     */
    public function index(Request $request)
    {
        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            return $this->nasabahDashboard();
        }

        // Admin dashboard statistics
        $stats = [
            'total_nasabah' => Nasabah::count(),
            'total_jenis_sampah' => JenisSampah::count(),
            'total_transaksi_setoran' => TransaksiSetoran::count(),
            'total_saldo_nasabah' => Nasabah::sum('saldo_total'),
            'total_saldo_dapat_ditarik' => Nasabah::sum('saldo_dapat_ditarik'),
            'permintaan_tarik_saldo' => TransaksiPenarikan::where('status', 'pending')->count(),
            'total_stok_sampah' => JenisSampah::sum('stok_kg'),
            'total_sampah_terkirim' => TransaksiPenjualan::sum('berat_kg'),
            'total_keuntungan' => TransaksiPenjualan::sum('keuntungan'),
        ];

        // Recent transactions
        $recentDeposits = TransaksiSetoran::with(['nasabah', 'jenisSampah'])
            ->latest()
            ->take(5)
            ->get();

        $recentSales = TransaksiPenjualan::with(['pengepul', 'jenisSampah'])
            ->latest()
            ->take(5)
            ->get();

        $pendingWithdrawals = TransaksiPenarikan::with('nasabah')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'recentDeposits' => $recentDeposits,
            'recentSales' => $recentSales,
            'pendingWithdrawals' => $pendingWithdrawals,
        ]);
    }

    /**
     * Display the nasabah dashboard.
     */
    protected function nasabahDashboard()
    {
        $user = auth()->user();
        
        // Find nasabah by NIK/NIP
        $nasabah = Nasabah::where('nik_nip', $user->nik_nip)->first();
        
        if (!$nasabah) {
            return Inertia::render('nasabah-dashboard', [
                'error' => 'Data nasabah tidak ditemukan. Silakan hubungi admin.',
            ]);
        }

        // Get transaction history
        $deposits = TransaksiSetoran::with('jenisSampah')
            ->where('nasabah_id', $nasabah->id)
            ->latest()
            ->take(10)
            ->get();

        $withdrawals = TransaksiPenarikan::where('nasabah_id', $nasabah->id)
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('nasabah-dashboard', [
            'nasabah' => $nasabah,
            'deposits' => $deposits,
            'withdrawals' => $withdrawals,
        ]);
    }
}