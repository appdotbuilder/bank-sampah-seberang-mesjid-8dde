import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

interface Nasabah {
    id: number;
    kode_nasabah: string;
    nama: string;
    nik_nip: string;
    alamat: string;
    instansi: string | null;
    saldo_total: number;
    saldo_dapat_ditarik: number;
    created_at: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedData {
    data: Nasabah[];
    links: PaginationLink[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface Props {
    nasabah: PaginatedData;
    filters: {
        search?: string;
    };
    [key: string]: unknown;
}

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(amount);
};

export default function NasabahIndex({ nasabah, filters }: Props) {
    const [search, setSearch] = React.useState(filters.search || '');

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get('/nasabah', { search }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handleClearSearch = () => {
        setSearch('');
        router.get('/nasabah', {}, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    return (
        <AppShell>
            <Head title="Data Nasabah" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">👥 Data Nasabah</h1>
                        <p className="text-gray-600 mt-2">
                            Kelola data nasabah Bank Sampah Kelurahan Seberang Mesjid
                        </p>
                    </div>
                    <Link href="/nasabah/create">
                        <Button className="bg-green-600 hover:bg-green-700">
                            <span className="mr-2">➕</span>
                            Tambah Nasabah
                        </Button>
                    </Link>
                </div>

                {/* Search and Filters */}
                <Card>
                    <CardContent className="pt-6">
                        <form onSubmit={handleSearch} className="flex gap-4">
                            <div className="flex-1">
                                <Input
                                    type="text"
                                    placeholder="Cari nama, kode nasabah, atau NIK/NIP..."
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    className="w-full"
                                />
                            </div>
                            <Button type="submit" variant="outline">
                                🔍 Cari
                            </Button>
                            {filters.search && (
                                <Button type="button" variant="outline" onClick={handleClearSearch}>
                                    ❌ Clear
                                </Button>
                            )}
                        </form>
                    </CardContent>
                </Card>

                {/* Stats */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <Card>
                        <CardContent className="pt-6">
                            <div className="text-2xl font-bold text-blue-600">{nasabah.total}</div>
                            <p className="text-sm text-gray-600">Total Nasabah</p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardContent className="pt-6">
                            <div className="text-2xl font-bold text-green-600">
                                {formatCurrency(nasabah.data.reduce((sum, n) => sum + n.saldo_total, 0))}
                            </div>
                            <p className="text-sm text-gray-600">Total Saldo</p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardContent className="pt-6">
                            <div className="text-2xl font-bold text-emerald-600">
                                {formatCurrency(nasabah.data.reduce((sum, n) => sum + n.saldo_dapat_ditarik, 0))}
                            </div>
                            <p className="text-sm text-gray-600">Dapat Ditarik</p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardContent className="pt-6">
                            <div className="text-2xl font-bold text-purple-600">
                                {nasabah.data.filter(n => n.saldo_dapat_ditarik > 0).length}
                            </div>
                            <p className="text-sm text-gray-600">Ada Saldo</p>
                        </CardContent>
                    </Card>
                </div>

                {/* Nasabah List */}
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center justify-between">
                            <span>📋 Daftar Nasabah</span>
                            <span className="text-sm font-normal text-gray-500">
                                Halaman {nasabah.current_page} dari {nasabah.last_page}
                            </span>
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        {nasabah.data.length > 0 ? (
                            <div className="space-y-4">
                                {nasabah.data.map((item) => (
                                    <div key={item.id} className="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                        <div className="flex items-center justify-between">
                                            <div className="flex-1">
                                                <div className="flex items-center space-x-4">
                                                    <div className="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <span className="text-blue-600 font-semibold text-lg">
                                                            {item.nama.charAt(0).toUpperCase()}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h3 className="font-semibold text-lg text-gray-900">{item.nama}</h3>
                                                        <div className="flex items-center space-x-4 text-sm text-gray-600">
                                                            <span className="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                                                {item.kode_nasabah}
                                                            </span>
                                                            <span>{item.nik_nip}</span>
                                                            {item.instansi && <span>• {item.instansi}</span>}
                                                        </div>
                                                        <p className="text-sm text-gray-500 mt-1">{item.alamat}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div className="text-right mr-4">
                                                <div className="space-y-1">
                                                    <div>
                                                        <span className="text-xs text-gray-500">Saldo Total</span>
                                                        <p className="font-semibold text-blue-600">{formatCurrency(item.saldo_total)}</p>
                                                    </div>
                                                    <div>
                                                        <span className="text-xs text-gray-500">Dapat Ditarik</span>
                                                        <p className="font-semibold text-green-600">{formatCurrency(item.saldo_dapat_ditarik)}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div className="flex flex-col space-y-2">
                                                <Link href={`/nasabah/${item.id}`}>
                                                    <Button variant="outline" size="sm" className="w-full">
                                                        👁️ Detail
                                                    </Button>
                                                </Link>
                                                <Link href={`/nasabah/${item.id}/edit`}>
                                                    <Button variant="outline" size="sm" className="w-full">
                                                        ✏️ Edit
                                                    </Button>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="text-center py-12">
                                <div className="text-6xl mb-4">👥</div>
                                <h3 className="text-lg font-medium text-gray-900 mb-2">Tidak ada data nasabah</h3>
                                <p className="text-gray-500">
                                    {filters.search ? 'Tidak ditemukan nasabah dengan kata kunci tersebut.' : 'Mulai dengan menambahkan nasabah baru.'}
                                </p>
                                {!filters.search && (
                                    <Link href="/nasabah/create" className="mt-4 inline-block">
                                        <Button className="bg-green-600 hover:bg-green-700">
                                            <span className="mr-2">➕</span>
                                            Tambah Nasabah Pertama
                                        </Button>
                                    </Link>
                                )}
                            </div>
                        )}

                        {/* Pagination */}
                        {nasabah.last_page > 1 && (
                            <div className="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                                <div className="text-sm text-gray-500">
                                    Menampilkan {((nasabah.current_page - 1) * nasabah.per_page) + 1} sampai {Math.min(nasabah.current_page * nasabah.per_page, nasabah.total)} dari {nasabah.total} data
                                </div>
                                <div className="flex space-x-2">
                                    {nasabah.links.map((link, index) => (
                                        <button
                                            key={index}
                                            onClick={() => link.url && router.get(link.url)}
                                            disabled={!link.url}
                                            className={`px-3 py-2 text-sm rounded ${
                                                link.active
                                                    ? 'bg-blue-600 text-white'
                                                    : link.url
                                                    ? 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'
                                                    : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                            }`}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    ))}
                                </div>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}