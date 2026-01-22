<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\CloudinaryService;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('status')->where('role', 'user')->get();

        return Inertia::render('admin/Employee', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = User::updateOrCreate(
            ['id' => $request->id], // 🔑 kunci pencarian
            [
                'name'    => $request->name,
                'email'   => $request->email,
                'jabatan' => $request->jabatan,
                'role'    => 'user',

                // password hanya di-set kalau ada
                 ...($request->filled('password') ? [
                    'password' => Hash::make($request->password),
                ] : []),
            ]
        );

        if ($request->filled('password')) {
            UserStatus::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'status' => 'new',
            ]);
        }

        if ($request->hasFile('photo')) {
            $photoPath = CloudinaryService::uploadImage(
                $request->file('photo'),
                'user',
                $user->id,
                'photo-profile'
            );

            $user->update([
                'photo'      => $photoPath['url'],
                'storage_id' => $photoPath['public_id'],
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
