import React from "react";
import Link from "next/link";
import { ArrowRight, Trophy, Users, Calendar } from "lucide-react";

export default function HomePage() {
  return (
    <div className="flex flex-col min-h-screen">
      {/* Navbar Placeholder */}
      <header className="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div className="container mx-auto px-4 h-20 flex items-center justify-between">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">
              IM
            </div>
            <span className="font-bold text-xl text-primary tracking-tight">IMADIKOM</span>
          </div>
          <nav className="hidden md:flex gap-8 font-medium text-gray-600">
            <Link href="/" className="text-primary font-semibold">Beranda</Link>
            <Link href="/committees" className="hover:text-primary transition">Pengurus</Link>
            <Link href="/events" className="hover:text-primary transition">Agenda & Event</Link>
          </nav>
          <div className="flex items-center gap-4">
            <Link href="/login" className="text-primary font-medium hover:opacity-80">Masuk</Link>
            <Link href="/register" className="bg-primary text-white px-5 py-2.5 rounded-full font-medium hover:bg-primary/90 transition shadow-lg shadow-primary/20">
              Daftar
            </Link>
          </div>
        </div>
      </header>

      {/* Hero Section */}
      <main className="flex-grow pt-32 pb-20">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto text-center space-y-8">
            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-secondary/20 text-secondary-dark font-medium text-sm mb-4">
              <span className="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
              Pendaftaran OPREC Pengurus 2026 Telah Dibuka!
            </div>
            
            <h1 className="text-5xl md:text-7xl font-extrabold text-primary leading-tight tracking-tight">
              Wadah Kolaborasi Mahasiswa <br/>
              <span className="text-transparent bg-clip-text bg-gradient-to-r from-secondary to-yellow-500">
                Bidikmisi & KIP-K
              </span>
            </h1>
            
            <p className="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
              Ikatan Mahasiswa Bidikmisi dan KIP-K Universitas Amikom Yogyakarta. Mari bersama membangun prestasi, solidaritas, dan kontribusi nyata untuk masyarakat.
            </p>

            <div className="flex flex-col sm:flex-row items-center justify-center gap-4 pt-8">
              <Link href="/events/oprec-2026" className="w-full sm:w-auto px-8 py-4 rounded-full bg-primary text-white font-bold hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/30 transition-all flex items-center justify-center gap-2">
                Daftar Event Sekarang <ArrowRight size={20} />
              </Link>
              <Link href="/voting/ketua-2026" className="w-full sm:w-auto px-8 py-4 rounded-full bg-white text-primary border-2 border-primary/20 font-bold hover:border-secondary hover:text-secondary transition-all flex items-center justify-center gap-2">
                Arena Voting Publik <Trophy size={20} />
              </Link>
            </div>
          </div>

          {/* Quick Stats / Highlights */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto mt-24">
            {[
              { icon: Users, title: "1500+ Anggota", desc: "Mahasiswa aktif Bidikmisi & KIP-K Amikom" },
              { icon: Calendar, title: "24+ Proker", desc: "Agenda kerja nyata setiap tahunnya" },
              { icon: Trophy, title: "Ratusan Prestasi", desc: "Pencapaian akademik & non-akademik" }
            ].map((stat, i) => (
              <div key={i} className="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                <div className="w-14 h-14 rounded-xl bg-primary/5 flex items-center justify-center text-primary mb-6 group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all">
                  <stat.icon size={28} />
                </div>
                <h3 className="text-xl font-bold text-gray-800 mb-2">{stat.title}</h3>
                <p className="text-gray-500">{stat.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </main>

      {/* Minimal Footer */}
      <footer className="border-t border-gray-100 bg-white py-12">
        <div className="container mx-auto px-4 text-center text-gray-500">
          <p>© {new Date().getFullYear()} Imadikom Universitas Amikom Yogyakarta. Hak Cipta Dilindungi.</p>
        </div>
      </footer>
    </div>
  );
}
