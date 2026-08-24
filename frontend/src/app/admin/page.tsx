import React from "react";

export default function AdminDashboard() {
  return (
    <div className="flex h-screen bg-gray-50">
      {/* Sidebar */}
      <aside className="w-64 bg-primary text-white flex flex-col">
        <div className="p-6 text-xl font-bold border-b border-white/10">Imadikom Admin</div>
        <nav className="flex-1 px-4 py-6 space-y-2">
          <a href="#" className="block px-4 py-3 bg-white/10 rounded-lg">Dashboard</a>
          <a href="#" className="block px-4 py-3 hover:bg-white/5 rounded-lg transition">Event Forms Builder</a>
          <a href="#" className="block px-4 py-3 hover:bg-white/5 rounded-lg transition">Data Pendaftar</a>
          <a href="#" className="block px-4 py-3 hover:bg-white/5 rounded-lg transition">Live Voting Analytics</a>
        </nav>
      </aside>

      {/* Main Content */}
      <main className="flex-1 p-8 overflow-y-auto">
        <header className="flex justify-between items-center mb-8">
          <h1 className="text-3xl font-bold text-gray-800">Dashboard Analytics</h1>
          <div className="flex items-center gap-4">
            <span className="font-medium text-gray-600">Superadmin</span>
            <div className="w-10 h-10 bg-secondary rounded-full"></div>
          </div>
        </header>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 className="text-gray-500 mb-2">Total Pendaftar Event</h3>
            <p className="text-4xl font-bold text-primary">342</p>
          </div>
          <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 className="text-gray-500 mb-2">Suara Masuk (Voting)</h3>
            <p className="text-4xl font-bold text-primary">1,204</p>
          </div>
          <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 className="text-gray-500 mb-2">Storage Terpakai (S3)</h3>
            <p className="text-4xl font-bold text-primary">450 MB</p>
          </div>
        </div>

        <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <h2 className="text-xl font-bold text-gray-800 mb-4">Pendaftar Terbaru</h2>
          <table className="w-full text-left">
            <thead>
              <tr className="border-b border-gray-200">
                <th className="py-3 text-gray-500 font-medium">Nama Lengkap</th>
                <th className="py-3 text-gray-500 font-medium">Event</th>
                <th className="py-3 text-gray-500 font-medium">Waktu Submit</th>
                <th className="py-3 text-gray-500 font-medium">Berkas CV</th>
              </tr>
            </thead>
            <tbody>
              <tr className="border-b border-gray-50">
                <td className="py-4 font-medium text-gray-800">Budi Santoso</td>
                <td className="py-4 text-gray-600">OPREC 2026</td>
                <td className="py-4 text-gray-500">2 menit yang lalu</td>
                <td className="py-4">
                  <a href="#" className="text-secondary font-medium hover:underline">Lihat PDF</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  );
}
