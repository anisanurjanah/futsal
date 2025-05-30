<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_pelanggan')->get();

        return view('member.index', ['data' => $data]);
    }

    public function create()
    {
        return view('member.add');
    }

    public function add(Request $request)
    {

        DB::table('tbl_pelanggan')->insert([
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect('member/index')->with('add_sukses', 1);
    }

    public function edit($id)
    {
        $row = DB::table('tbl_pelanggan')->where('tbl_pelanggan.id', $id)->first();

        return view('member.edit', [
            'row' => $row,
        ]);
    }

    public function update(Request $request)
    {
        DB::table('tbl_pelanggan')
            ->where('id', $request->id)
            ->update([
                'nama' => $request->nama,
                'no_telepon' => $request->no_telepon,
            ]);

        return redirect('member/index')->with('edit_sukses', 1);
    }

    public function delete($id)
    {
        DB::table('tbl_pelanggan')->where('id', $id)->delete();
        return redirect()->back()->with('delete_sukses', 1);
    }
}
