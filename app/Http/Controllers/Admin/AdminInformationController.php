<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AdminInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $information = Information::get();

        return Inertia::render('admin/Information', [
            'information' => $information
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {

            Information::create([
                'title'    => $request->title,
                'type'     => $request->type,
                'end_date' => $request->end_date,
                'content'  => $request->content,
                'status'   => 'aktif'
            ]);

        } catch (\Exception $e) {
            Log::warning('Attend warning: ' . $e->getMessage());

            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $th) {
            Log::error('Attend error: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);

            return response()->json([
                'message' => 'Terjadi kesalahan pada server.',
            ], 500);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
