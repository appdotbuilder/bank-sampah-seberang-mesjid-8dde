import React from 'react';
import { Head } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface DashboardStats {
    total_nasabah: number;
    total_jenis_sampah: number;
    total_transaksi_setoran: number;
    total_saldo_nasabah: number;
    total_saldo_dapat_ditarik: number;
    permintaan_tarik_saldo: number;
    total_stok_sampah: number;
    total_sampah_terkirim: number;
    total_keuntungan: number;
}

interface RecentTransaction {
    id: number;
    no_transaksi: string;
    created_at: string;
    nilai_setoran?: number;
    nilai_jual?: number;
    jumlah_penarikan?: number;
    nasabah?: {
        nama: string;
        kode_nasabah: string;
    };
    pengepul?: {
        nama: string;
        kode_pengepul: string;
    };
    jenis_sampah?: {
        jenis_sampah: string;
    };
    status?: string;
}

interface Props {
    stats: DashboardStats;
    recentDeposits: RecentTransaction[];
    recentSales: RecentTransaction[];
    pendingWithdrawals: RecentTransaction[];
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

export default function Dashboard({ stats, recentDeposits, recentSales, pendingWithdrawals }: Props) {
    return (
        <AppShell>
            <Head title="Dashboard Admin" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">📊 Dashboard Admin</h1>
                        <p className="text-gray-600 mt-2">
                            Ringkasan data Bank Sampah Kelurahan Seberang Mesjid
                        </p>
                    </div>
                    <div className="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                        <span className="font-medium">🕐 Terakhir diupdate: {formatDate(new Date().toISOString())}</span>
                    </div>
                </div>

                {/* Stats Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <Card className="bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200">
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-blue-600">👥 Total Nasabah</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold text-blue-900">{stats.total_nasabah}</div>
                            <p className="text-sm text-blue-700 mt-1">Nasabah terdaftar</p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-green-50 to-green-100 border-green-200">
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-green-600">♻️ Jenis Sampah</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold text-green-900">{stats.total_jenis_sampah}</div>
                            <p className="text-sm text-green-700 mt-1">Jenis sampah terdaftar</p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-purple-50 to-purple-100 border-purple-200">
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-purple-600">📦 Total Setoran</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold text-purple-900">{stats.total_transaksi_setoran}</div>
                            <p className="text-sm text-purple-700 mt-1">Transaksi setoran</p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-yellow-50 to-yellow-100 border-yellow-200">
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-yellow-600">💰 Saldo Total</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-yellow-900">
                                {formatCurrency(stats.total_saldo_nasabah)}
                            </div>
                            <p className="text-sm text-yellow-700 mt-1">Total saldo nasabah</p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-emerald-50 to-emerald-100 border-emerald-200">
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-emerald-600">💵 Dapat Ditarik</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-emerald-900">
                                {formatCurrency(stats.total_saldo_dapat_ditarik)}
                            </div>
                            <p className="text-sm text-emerald-700 mt-1">Saldo dapat ditarik</p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-red-50 to-red-100 border-red-200">
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-red-600">⏳ Pending</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold text-red-900">{stats.permintaan_tarik_saldo}</div>
                            <p className="text-sm text-red-700 mt-1">Permintaan penarikan</p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-indigo-50 to-indigo-100 border-indigo-200">
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-indigo-600">📦 Stok Sampah</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-indigo-900">{stats.total_stok_sampah.toFixed(2)} kg</div>
                            <p className="text-sm text-indigo-700 mt-1">Total stok tersedia</p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-teal-50 to-teal-100 border-teal-200">
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-teal-600">🚚 Terkirim</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-teal-900">{stats.total_sampah_terkirim.toFixed(2)} kg</div>
                            <p className="text-sm text-teal-700 mt-1">Sampah ke pengepul</p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-orange-50 to-orange-100 border-orange-200 md:col-span-2 lg:col-span-1">
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-orange-600">💎 Keuntungan</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-orange-900">
                                {formatCurrency(stats.total_keuntungan)}
                            </div>
                            <p className="text-sm text-orange-700 mt-1">Total keuntungan</p>
                        </CardContent>
                    </Card>
                </div>

                {/* Recent Activities */}
                <div className="grid lg:grid-cols-3 gap-6">
                    {/* Recent Deposits */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center text-lg">
                                <span className="mr-2">📥</span>
                                Setoran Terbaru
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            {recentDeposits.length > 0 ? (
                                recentDeposits.map((deposit) => (
                                    <div key={deposit.id} className="flex justify-between items-start border-b pb-3 last:border-b-0">
                                        <div>
                                            <p className="font-medium text-sm">{deposit.nasabah?.nama}</p>
                                            <p className="text-xs text-gray-600">{deposit.jenis_sampah?.jenis_sampah}</p>
                                            <p className="text-xs text-gray-500">{formatDate(deposit.created_at)}</p>
                                        </div>
                                        <div className="text-right">
                                            <p className="font-medium text-green-600">{formatCurrency(deposit.nilai_setoran || 0)}</p>
                                            <p className="text-xs text-gray-500">{deposit.no_transaksi}</p>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <p className="text-gray-500 text-center py-4">Belum ada setoran hari ini</p>
                            )}
                        </CardContent>
                    </Card>

                    {/* Recent Sales */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center text-lg">
                                <span className="mr-2">📤</span>
                                Penjualan Terbaru
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            {recentSales.length > 0 ? (
                                recentSales.map((sale) => (
                                    <div key={sale.id} className="flex justify-between items-start border-b pb-3 last:border-b-0">
                                        <div>
                                            <p className="font-medium text-sm">{sale.pengepul?.nama}</p>
                                            <p className="text-xs text-gray-600">{sale.jenis_sampah?.jenis_sampah}</p>
                                            <p className="text-xs text-gray-500">{formatDate(sale.created_at)}</p>
                                        </div>
                                        <div className="text-right">
                                            <p className="font-medium text-blue-600">{formatCurrency(sale.nilai_jual || 0)}</p>
                                            <p className="text-xs text-gray-500">{sale.no_transaksi}</p>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <p className="text-gray-500 text-center py-4">Belum ada penjualan hari ini</p>
                            )}
                        </CardContent>
                    </Card>

                    {/* Pending Withdrawals */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center text-lg">
                                <span className="mr-2">⏳</span>
                                Penarikan Pending
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            {pendingWithdrawals.length > 0 ? (
                                pendingWithdrawals.map((withdrawal) => (
                                    <div key={withdrawal.id} className="flex justify-between items-start border-b pb-3 last:border-b-0">
                                        <div>
                                            <p className="font-medium text-sm">{withdrawal.nasabah?.nama}</p>
                                            <p className="text-xs text-gray-600">{withdrawal.nasabah?.kode_nasabah}</p>
                                            <p className="text-xs text-gray-500">{formatDate(withdrawal.created_at)}</p>
                                        </div>
                                        <div className="text-right">
                                            <p className="font-medium text-orange-600">{formatCurrency(withdrawal.jumlah_penarikan || 0)}</p>
                                            <p className="text-xs text-orange-500 uppercase">{withdrawal.status}</p>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <p className="text-gray-500 text-center py-4">Tidak ada penarikan pending</p>
                            )}
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppShell>
    );
}