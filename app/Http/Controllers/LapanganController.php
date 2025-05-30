<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_lapangan')->get();

        return view('lapangan.index', ['data' => $data]);
    }

    public function create()
    {
        return view('lapangan.add');
    }

    public function add(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        DB::table('tbl_lapangan')->insert([
            'namalapangan' => $request->namalapangan,
            'hargaperjam' => $request->hargaperjam,
        ]);

        return redirect('lapangan/index')->with('add_sukses', 1);
    }

    public function edit($id)
    {
        $row = DB::table('tbl_lapangan')->where('tbl_lapangan.id', $id)->first();

        return view('lapangan.edit', [
            'row' => $row,
        ]);
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        DB::table('tbl_lapangan')
            ->where('id', $request->id)
            ->update([
                'namalapangan' => $request->namalapangan,
                'hargaperjam' => $request->hargaperjam,
            ]);

        return redirect('lapangan/index')->with('edit_sukses', 1);
    }

    public function delete($id)
    {
        DB::table('tbl_lapangan')->where('id', $id)->delete();
        return redirect()->back()->with('delete_sukses', 1);
    }
}
