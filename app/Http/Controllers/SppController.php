<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spps = Spp::paginate(5);
        return view('spp.index', compact('spps'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('spp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tahun' => 'required',
            'nominal' => 'required',
        ]);
        
        try {
            $spp = Spp::create([
                'tahun' => $request->tahun,
                'nominal' => $request->nominal,
            ]);
            
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data Gagal Disimpan');
        }
    
        return redirect()->route('spp.index')->with('success', 'Data Berhasil Disimpan');
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
        $spps = Spp::findOrFail($id);
        return view('spp.edit', compact('spps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'tahun' => 'required',
            'nominal' => 'required',
        ]);

        try {
            $spp = Spp::find($id);
            $spp->tahun = $request->tahun;
            $spp->nominal = $request->nominal;
        
            $spp->save();
        
            
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data Gagal Disimpan');
        }
        
        return redirect('spp')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $spp = Spp::findOrFail($id);
            $spp->delete();
            return redirect()->route('spp.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data Gagal Dihapus');
        }
    }
}
