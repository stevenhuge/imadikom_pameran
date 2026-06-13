<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = \App\Models\User::where('role', 'admin')->latest()->paginate(10);
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        $validated['role'] = 'admin';

        \App\Models\User::create($validated);

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil ditambahkan!');
    }

    public function edit(\App\Models\User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, \App\Models\User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()->route('admin.admins.index')->with('success', 'Data Admin berhasil diperbarui!');
    }

    public function destroy(\App\Models\User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        $admin->delete();

        return back()->with('success', 'Admin berhasil dihapus!');
    }
}
