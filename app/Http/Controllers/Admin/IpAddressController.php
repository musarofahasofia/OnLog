<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OfficeIp; // ✅ ini import modelnya

class IpAddressController extends Controller
{
    public function index()
    {
        $ips = OfficeIp::all(); // ✅ Ambil semua IP dari database
        return Inertia::render('admin/IPAddress', [
            'ips' => $ips
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip|unique:office_ips,ip_address',
            'description' => 'nullable|string'
        ]);

        OfficeIp::create($request->only('ip_address', 'description'));

        return redirect()->back()->with('success', 'IP berhasil ditambahkan');
    }

    public function destroy($id)
    {
        OfficeIp::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'IP berhasil dihapus');
    }
}
