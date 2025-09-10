import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

export default function Welcome() {
    return (
        <>
            <Head title="Bank Sampah Kelurahan Seberang Mesjid" />
            <div className="min-h-screen bg-gradient-to-br from-green-50 to-blue-50">
                <div className="relative overflow-hidden">
                    <div className="absolute inset-0 bg-gradient-to-br from-green-600/10 to-blue-600/10"></div>
                    
                    {/* Header */}
                    <header className="relative bg-white/80 backdrop-blur-sm border-b border-green-200">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                            <div className="flex items-center justify-between">
                                <div className="flex items-center space-x-3">
                                    <div className="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                                        <span className="text-white font-bold text-lg">♻</span>
                                    </div>
                                    <div>
                                        <h1 className="text-xl font-bold text-gray-900">Bank Sampah</h1>
                                        <p className="text-sm text-gray-600">Kelurahan Seberang Mesjid</p>
                                    </div>
                                </div>
                                <div className="flex space-x-4">
                                    <Link href="/login">
                                        <Button variant="outline" className="border-green-600 text-green-600 hover:bg-green-50">
                                            Masuk
                                        </Button>
                                    </Link>
                                    <Link href="/register">
                                        <Button className="bg-green-600 hover:bg-green-700">
                                            Daftar
                                        </Button>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </header>

                    {/* Hero Section */}
                    <section className="relative py-20 px-4 sm:px-6 lg:px-8">
                        <div className="max-w-7xl mx-auto text-center">
                            <h2 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                                🌱 Bank Sampah Digital
                            </h2>
                            <p className="text-xl md:text-2xl text-gray-700 mb-8 max-w-3xl mx-auto">
                                Sistem manajemen bank sampah modern untuk Kelurahan Seberang Mesjid. 
                                Kelola transaksi, pantau saldo, dan dukung lingkungan yang lebih bersih.
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link href="/login">
                                    <Button size="lg" className="bg-green-600 hover:bg-green-700 text-lg px-8 py-3">
                                        🚀 Mulai Sekarang
                                    </Button>
                                </Link>
                                <Button size="lg" variant="outline" className="border-green-600 text-green-600 hover:bg-green-50 text-lg px-8 py-3">
                                    📖 Pelajari Lebih Lanjut
                                </Button>
                            </div>
                        </div>
                    </section>

                    {/* Features Section */}
                    <section className="py-16 bg-white">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div className="text-center mb-16">
                                <h3 className="text-3xl font-bold text-gray-900 mb-4">
                                    ✨ Fitur Unggulan
                                </h3>
                                <p className="text-xl text-gray-600">
                                    Solusi lengkap untuk manajemen bank sampah yang efisien
                                </p>
                            </div>
                            
                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {/* Admin Features */}
                                <div className="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8 border border-blue-200">
                                    <div className="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
                                        <span className="text-white text-2xl">👨‍💼</span>
                                    </div>
                                    <h4 className="text-xl font-bold text-gray-900 mb-4">Dashboard Admin</h4>
                                    <ul className="space-y-2 text-gray-700">
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Kelola data nasabah & pengepul
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Transaksi setoran & penarikan
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Laporan real-time
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Cetak nota & bukti transaksi
                                        </li>
                                    </ul>
                                </div>

                                {/* Customer Features */}
                                <div className="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-8 border border-green-200">
                                    <div className="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-6">
                                        <span className="text-white text-2xl">👥</span>
                                    </div>
                                    <h4 className="text-xl font-bold text-gray-900 mb-4">Portal Nasabah</h4>
                                    <ul className="space-y-2 text-gray-700">
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Cek saldo total & dapat ditarik
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Riwayat transaksi lengkap
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Permintaan penarikan saldo
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Laporan pribadi
                                        </li>
                                    </ul>
                                </div>

                                {/* System Features */}
                                <div className="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-8 border border-purple-200 md:col-span-2 lg:col-span-1">
                                    <div className="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-6">
                                        <span className="text-white text-2xl">⚙️</span>
                                    </div>
                                    <h4 className="text-xl font-bold text-gray-900 mb-4">Sistem Canggih</h4>
                                    <ul className="space-y-2 text-gray-700">
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Kode otomatis untuk semua transaksi
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Tracking keuntungan real-time
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Manajemen stok sampah
                                        </li>
                                        <li className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            Sistem persetujuan penarikan
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                    {/* Stats Section */}
                    <section className="py-16 bg-gradient-to-r from-green-600 to-blue-600">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                            <h3 className="text-3xl font-bold text-white mb-12">
                                📊 Dampak Positif Bank Sampah
                            </h3>
                            <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
                                <div className="text-center">
                                    <div className="text-4xl font-bold text-white mb-2">100+</div>
                                    <div className="text-green-100">Nasabah Aktif</div>
                                </div>
                                <div className="text-center">
                                    <div className="text-4xl font-bold text-white mb-2">50+</div>
                                    <div className="text-green-100">Jenis Sampah</div>
                                </div>
                                <div className="text-center">
                                    <div className="text-4xl font-bold text-white mb-2">1000+</div>
                                    <div className="text-green-100">Kg Sampah/Bulan</div>
                                </div>
                                <div className="text-center">
                                    <div className="text-4xl font-bold text-white mb-2">95%</div>
                                    <div className="text-green-100">Kepuasan Nasabah</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {/* CTA Section */}
                    <section className="py-20 bg-gray-50">
                        <div className="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                            <h3 className="text-3xl font-bold text-gray-900 mb-6">
                                🤝 Bergabung dengan Bank Sampah
                            </h3>
                            <p className="text-xl text-gray-600 mb-10">
                                Mari bersama-sama menciptakan lingkungan yang lebih bersih dan hijau 
                                untuk generasi masa depan. Daftar sekarang dan mulai berkontribusi!
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link href="/register">
                                    <Button size="lg" className="bg-green-600 hover:bg-green-700 text-lg px-10 py-4">
                                        💚 Daftar sebagai Nasabah
                                    </Button>
                                </Link>
                                <Link href="/login">
                                    <Button size="lg" variant="outline" className="border-green-600 text-green-600 hover:bg-green-50 text-lg px-10 py-4">
                                        🔑 Login Admin
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </section>

                    {/* Footer */}
                    <footer className="bg-gray-900 text-white py-12">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div className="grid md:grid-cols-3 gap-8">
                                <div>
                                    <div className="flex items-center space-x-3 mb-4">
                                        <div className="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                            <span className="text-white font-bold">♻</span>
                                        </div>
                                        <span className="text-lg font-bold">Bank Sampah</span>
                                    </div>
                                    <p className="text-gray-400">
                                        Sistem manajemen bank sampah digital untuk mendukung 
                                        program lingkungan berkelanjutan.
                                    </p>
                                </div>
                                <div>
                                    <h4 className="text-lg font-semibold mb-4">Kontak</h4>
                                    <div className="space-y-2 text-gray-400">
                                        <p>📍 Kelurahan Seberang Mesjid</p>
                                        <p>📞 (0xxx) xxx-xxxx</p>
                                        <p>✉️ info@banksampah.id</p>
                                    </div>
                                </div>
                                <div>
                                    <h4 className="text-lg font-semibold mb-4">Jam Operasional</h4>
                                    <div className="space-y-2 text-gray-400">
                                        <p>Senin - Jumat: 08:00 - 16:00</p>
                                        <p>Sabtu: 08:00 - 12:00</p>
                                        <p>Minggu: Tutup</p>
                                    </div>
                                </div>
                            </div>
                            <div className="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                                <p>&copy; 2024 Bank Sampah Kelurahan Seberang Mesjid. Semua hak dilindungi.</p>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </>
    );
}