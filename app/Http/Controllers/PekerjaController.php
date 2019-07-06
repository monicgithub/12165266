<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pekerja;

class PekerjaController extends Controller
{
    public function index()
    {
        $pekerjas = pekerja::orderBy('created_at', 'DESC')->paginate(10);
        return view('pekerja.index', compact('pekerjas'));
    }

    public function create()
    {
        return view('pekerja.add');
    }

    public function save(Request $request)
{
    //VALIDASI DATA
    $this->validate($request, [
        'name' => 'required|string',
        'phone' => 'required|max:13', //maximum karakter 13 digit
        'address' => 'required|string',
        //unique berarti email ditable tidak boleh sama
        'email' => 'required|email|string|unique:pekerjas,email' // format yag diterima harus email
    ]);

    try {
        $pekerja = Pekerja::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email
        ]);
        return redirect('/pekerja')->with(['success' => 'Data telah disimpan']);
    } catch (\Exception $e) {
        return redirect()->back()->with(['error' => $e->getMessage()]);
    }
}

public function destroy($id)
    {
        $Pekerja = Pekerja::find($id);
        $Pekerja->delete();
        return redirect()->back()->with(['success' => '<strong>' . $Pekerja->name . '</strong> Telah dihapus']);
    }

}
