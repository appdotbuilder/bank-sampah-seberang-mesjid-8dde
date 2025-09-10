<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNasabahRequest;
use App\Http\Requests\UpdateNasabahRequest;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Nasabah::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode_nasabah', 'like', "%{$search}%")
                  ->orWhere('nik_nip', 'like', "%{$search}%");
            });
        }

        $nasabah = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('nasabah/index', [
            'nasabah' => $nasabah,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('nasabah/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNasabahRequest $request)
    {
        Nasabah::create($request->validated());

        return redirect()->route('nasabah.index')
            ->with('success', 'Data nasabah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nasabah $nasabah)
    {
        $nasabah->load(['transaksiSetoran.jenisSampah', 'transaksiPenarikan']);

        return Inertia::render('nasabah/show', [
            'nasabah' => $nasabah,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nasabah $nasabah)
    {
        return Inertia::render('nasabah/edit', [
            'nasabah' => $nasabah,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNasabahRequest $request, Nasabah $nasabah)
    {
        $nasabah->update($request->validated());

        return redirect()->route('nasabah.show', $nasabah)
            ->with('success', 'Data nasabah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nasabah $nasabah)
    {
        $nasabah->delete();

        return redirect()->route('nasabah.index')
            ->with('success', 'Data nasabah berhasil dihapus.');
    }
}