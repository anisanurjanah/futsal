<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        $data = Lapangan::all();

        return view('lapangan.index', ['data' => $data]);
    }

    public function create()
    {
        return view('lapangan.add');
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $validated = $request->validate([
            'name' => 'required|string|max:64',
            'price' => 'required|numeric|min:0',
        ]);

        Lapangan::create($validated);

        return redirect('/dashboard/lapangan')->with('add_sukses', 1);
    }

    public function show()
    {

    }

    public function edit($id)
    {
        $row = Lapangan::findOrFail($id);

        return view('lapangan.edit', [
            'row' => $row,
        ]);
    }

    public function update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $row = Lapangan::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:64',
            'price' => 'required|numeric|min:0',
        ]);

        $row->update($validated);

        return redirect('/dashboard/lapangan')->with('edit_sukses', 1);
    }

    public function destroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        $lapangan->delete();

        return redirect()->back()->with('delete_sukses', 1);
    }
}
