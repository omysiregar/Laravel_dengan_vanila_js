<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kariawan;


class KariawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $kariawans = Kariawan::all(); // Ambil data dari database
        return view('kariawan.kariawans', compact('kariawans'));

        // return view('kariawan.kariawans');
    }

    public function data()
    {
        return response()->json(Kariawan::all());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'nomor_identifikasi' => 'required',
            'alamat' => 'required',
            'pekerjaan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        if (Kariawan::where('nomor_identifikasi', $request->nomor_identifikasi)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nomor Identifikasi sudah digunakan!'
            ], 422);
        }
        Kariawan::create($validatedData);

        return response()->json([
            'message' => 'Karyawan berhasil ditambahkan!'
        ]);
    }
}
