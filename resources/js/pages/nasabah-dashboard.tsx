import React from 'react';
import { Head, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';

interface Nasabah {
    id: number;
    kode_nasabah: string;
    nama: string;
    nik_nip: string;
    alamat: string;
    instansi: string | null;
    saldo_total: number;
    saldo_dapat_ditarik: number;
}

interface Deposit {
    id: number;
    no_transaksi: string;
    berat_kg: number;
    harga_per_kg: number;
    nilai_setoran: number;
    created_at: string;
    jenis_sampah: {
        jenis_sampah: string;
        kode_sampah: string;
    };
}

interface Withdrawal {
    id: number;
    no_transaksi: string;
    jumlah_penarikan: number;
    status: string;
    created_at: string;
    keterangan: string | null;
}

interface Props {
    nasabah?: Nasabah;
    deposits?: Deposit[];
    withdrawals?: Withdrawal[];
    error?: string;
    [key: string]: unknown;
}

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(amount);
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const getStatusBadge = (status: string) => {
    const statusConfig = {
        pending: { color: 'bg-yellow-100 text-yellow-800', text: 'Menunggu' },
        approved: { color: 'bg-green-100 text-green-800', text: 'Disetujui' },
        rejected: { color: 'bg-red-100 text-red-800', text: 'Ditolak' },
    };
    
    const config = statusConfig[status as keyof typeof statusConfig] || statusConfig.pending;
    
    return (
        <span className={`px-2 py-1 text-xs font-medium rounded-full ${config.color}`}>
            {config.text}
        </span>
    );
};

export default function NasabahDashboard({ nasabah, deposits = [], withdrawals = [], error }: Props) {
    if (error) {
        return (
            <AppShell>
                <Head title="Dashboard Nasabah" />
                <div className="flex items-center justify-center h-64">
                    <Card className="w-full max-w-md">
                        <CardContent className="text-center py-8">
                            <div className="text-6xl mb-4">⚠️</div>
                            <h2 className="text-xl font-bold text-red-600 mb-2">Data Tidak Ditemukan</h2>
                            <p className="text-gray-600 mb-4">{error}</p>
                            <Button 
                                onClick={() => router.post('/logout')}
                                variant="outline"
                            >
                                Logout
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </AppShell>
        );
    }

    if (!nasabah) {
        return (
            <AppShell>
                <Head title="Dashboard Nasabah" />
                <div className="text-center py-8">Loading...</div>
            </AppShell>
        );
    }

    return (
        <AppShell>
            <Head title="Dashboard Nasabah" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">👋 Halo, {nasabah.nama}!</h1>
                        <p className="text-gray-600 mt-2">
                            Selamat datang di portal nasabah Bank Sampah
                        </p>
                    </div>
                    <div className="text-right">
                        <p className="text-sm text-gray-600">Kode Nasabah</p>
                        <p className="text-lg font-bold text-green-600">{nasabah.kode_nasabah}</p>
                    </div>
                </div>

                {/* Profile Summary */}
                <Card className="bg-gradient-to-r from-green-50 to-blue-50">
                    <CardHeader>
                        <CardTitle className="flex items-center text-xl">
                            <span className="mr-2">👤</span>
                            Profil Nasabah
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="grid md:grid-cols-2 gap-6">
                            <div className="space-y-3">
                                <div>
                                    <label className="text-sm font-medium text-gray-600">Nama Lengkap</label>
                                    <p className="text-lg font-semibold">{nasabah.nama}</p>
                                </div>
                                <div>
                                    <label className="text-sm font-medium text-gray-600">NIK/NIP</label>
                                    <p className="text-lg">{nasabah.nik_nip}</p>
                                </div>
                                {nasabah.instansi && (
                                    <div>
                                        <label className="text-sm font-medium text-gray-600">Instansi</label>
                                        <p className="text-lg">{nasabah.instansi}</p>
                                    </div>
                                )}
                            </div>
                            <div>
                                <label className="text-sm font-medium text-gray-600">Alamat</label>
                                <p className="text-lg">{nasabah.alamat}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                {/* Balance Cards */}
                <div className="grid md:grid-cols-2 gap-6">
                    <Card className="bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200">
                        <CardHeader className="pb-3">
                            <CardTitle className="flex items-center text-blue-700">
                                <span className="mr-2">💰</span>
                                Saldo Total
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold text-blue-900 mb-2">
                                {formatCurrency(nasabah.saldo_total)}
                            </div>
                            <p className="text-sm text-blue-700">
                                Total akumulasi dari semua setoran sampah
                            </p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-green-50 to-green-100 border-green-200">
                        <CardHeader className="pb-3">
                            <CardTitle className="flex items-center text-green-700">
                                <span className="mr-2">💵</span>
                                Saldo Dapat Ditarik
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold text-green-900 mb-2">
                                {formatCurrency(nasabah.saldo_dapat_ditarik)}
                            </div>
                            <p className="text-sm text-green-700">
                                Saldo yang sudah dapat dicairkan
                            </p>
                        </CardContent>
                    </Card>
                </div>

                {/* Transaction History */}
                <div className="grid lg:grid-cols-2 gap-6">
                    {/* Deposit History */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center text-lg">
                                <span className="mr-2">📥</span>
                                Riwayat Setoran
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4 max-h-96 overflow-y-auto">
                                {deposits.length > 0 ? (
                                    deposits.map((deposit) => (
                                        <div key={deposit.id} className="border border-gray-200 rounded-lg p-4">
                                            <div className="flex justify-between items-start mb-2">
                                                <div>
                                                    <p className="font-medium text-sm">{deposit.jenis_sampah.jenis_sampah}</p>
                                                    <p className="text-xs text-gray-500">{deposit.no_transaksi}</p>
                                                </div>
                                                <div className="text-right">
                                                    <p className="font-bold text-green-600">{formatCurrency(deposit.nilai_setoran)}</p>
                                                    <p className="text-xs text-gray-500">{deposit.berat_kg} kg</p>
                                                </div>
                                            </div>
                                            <div className="flex justify-between items-center text-xs text-gray-500">
                                                <span>{formatDate(deposit.created_at)}</span>
                                                <span>{formatCurrency(deposit.harga_per_kg)}/kg</span>
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <div className="text-center py-8 text-gray-500">
                                        <div className="text-4xl mb-2">📦</div>
                                        <p>Belum ada riwayat setoran</p>
                                    </div>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Withdrawal History */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center text-lg">
                                <span className="mr-2">💸</span>
                                Riwayat Penarikan
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4 max-h-96 overflow-y-auto">
                                {withdrawals.length > 0 ? (
                                    withdrawals.map((withdrawal) => (
                                        <div key={withdrawal.id} className="border border-gray-200 rounded-lg p-4">
                                            <div className="flex justify-between items-start mb-2">
                                                <div>
                                                    <p className="font-medium text-sm">Penarikan Saldo</p>
                                                    <p className="text-xs text-gray-500">{withdrawal.no_transaksi}</p>
                                                </div>
                                                <div className="text-right">
                                                    <p className="font-bold text-red-600">{formatCurrency(withdrawal.jumlah_penarikan)}</p>
                                                    {getStatusBadge(withdrawal.status)}
                                                </div>
                                            </div>
                                            <div className="flex justify-between items-center text-xs text-gray-500 mb-2">
                                                <span>{formatDate(withdrawal.created_at)}</span>
                                            </div>
                                            {withdrawal.keterangan && (
                                                <div className="text-xs text-gray-600 bg-gray-50 rounded p-2">
                                                    <strong>Keterangan:</strong> {withdrawal.keterangan}
                                                </div>
                                            )}
                                        </div>
                                    ))
                                ) : (
                                    <div className="text-center py-8 text-gray-500">
                                        <div className="text-4xl mb-2">💸</div>
                                        <p>Belum ada riwayat penarikan</p>
                                    </div>
                                )}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Quick Actions */}
                <Card className="bg-gradient-to-r from-purple-50 to-pink-50">
                    <CardHeader>
                        <CardTitle className="flex items-center text-lg">
                            <span className="mr-2">⚡</span>
                            Aksi Cepat
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <Button 
                                variant="outline" 
                                className="flex items-center justify-center py-3"
                                disabled
                            >
                                <span className="mr-2">📊</span>
                                Cetak Laporan
                            </Button>
                            <Button 
                                variant="outline" 
                                className="flex items-center justify-center py-3"
                                disabled
                            >
                                <span className="mr-2">💰</span>
                                Ajukan Penarikan
                            </Button>
                            <Button 
                                variant="outline" 
                                className="flex items-center justify-center py-3"
                                disabled
                            >
                                <span className="mr-2">📞</span>
                                Hubungi Admin
                            </Button>
                        </div>
                        <p className="text-sm text-gray-500 mt-4 text-center">
                            💡 Fitur-fitur ini akan segera tersedia dalam pembaruan berikutnya
                        </p>
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}