<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OfficeIp; // ✅ ini import modelnya

class IpAddressController extends Controller
{
    public function index(Request $request)
    {
        $ips = OfficeIp::all(); // ✅ Ambil semua IP dari database
        return Inertia::render('admin/IPAddress', [
            'ips' => $ips,
            'office_ip' => $request->getClientIp()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ip_address' => 'required',
        ]);

        OfficeIp::create($request->only('ip_address'));
        return redirect()->back()->with('success', 'IP berhasil ditambahkan');
    }

    public function destroy($id)
    {
        OfficeIp::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'IP berhasil dihapus');
    }
}
