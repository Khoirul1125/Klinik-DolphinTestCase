<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\eye;
use App\Models\verbal;
use App\Models\motorik;
use App\Models\gcs_nilai;
use App\Models\setweb;

class GcsController extends Controller
{
    public function eye()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "gcs";
        $eye = eye::all();
        return view('gcs.index', compact('title','eye'));
    }

    public function eyeadd(Request $request)
    {
        $data = $request->validate([
            "nama" => 'required',
            "skor" => 'required',
        ]);

        $eye = new eye();
        $eye->nama = $data['nama'];
        $eye->skor = $data['skor'];
        $eye->save();

        return redirect()->route('datmas.eye')->with('Success', 'Eye berhasil ditambahkan');
    }

    public function eyedelet($id)
    {
        $eye = eye::find($id);

        if(!$eye) {
            return redirect()->back();
        }

        $eye->delete();

        return redirect()->route('datmas.eye')->with('Success', 'Eye berhasil dihapus');
    }

    public function eyeedit(Request $request,$id)
    {
        $data = $request->validate([
            "nama" => 'required',
            "skor" => 'required',
        ]);

        $eye = eye::find($id);
        $eye->nama = $data['nama'];
        $eye->skor = $data['skor'];
        $eye->save();

        return redirect()->route('datmas.eye')->with('Success', 'Eye berhasil di edit');
    }

    public function verbal()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "gcs";
        $verbal = verbal::all();
        return view('gcs.verbal', compact('title','verbal'));
    }

    public function verbaladd(Request $request)
    {
        $data = $request->validate([
            "nama" => 'required',
            "skor" => 'required',
        ]);

        $verbal = new verbal();
        $verbal->nama = $data['nama'];
        $verbal->skor = $data['skor'];
        $verbal->save();

        return redirect()->route('datmas.verbal')->with('Success', 'Verbal berhasil ditambahkan');
    }

    public function verbaldelet($id)
    {
        $verbal = verbal::find($id);

        if(!$verbal) {
            return redirect()->back();
        }

        $verbal->delete();

        return redirect()->route('datmas.verbal')->with('Success', 'Verbal berhasil dihapus');
    }

    public function verbaledit(Request $request,$id)
    {
        $data = $request->validate([
            "nama" => 'required',
            "skor" => 'required',
        ]);

        $verbal = verbal::find($id);
        $verbal->nama = $data['nama'];
        $verbal->skor = $data['skor'];
        $verbal->save();

        return redirect()->route('datmas.verbal')->with('Success', 'Eye berhasil di edit');
    }


    public function motorik()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "gcs";
        $motorik = motorik::all();
        return view('gcs.motorik', compact('title','motorik'));
    }

    public function motorikadd(Request $request)
    {
        $data = $request->validate([
            "nama" => 'required',
            "skor" => 'required',
        ]);

        $motorik = new motorik();
        $motorik->nama = $data['nama'];
        $motorik->skor = $data['skor'];
        $motorik->save();

        return redirect()->route('datmas.motorik')->with('Success', 'Motorik berhasil ditambahkan');
    }

    public function motorikdelet($id)
    {
        $motorik = motorik::find($id);

        if(!$motorik) {
            return redirect()->back();
        }

        $motorik->delete();

        return redirect()->route('datmas.motorik')->with('Success', 'Verbal berhasil dihapus');
    }

    public function motorikedit(Request $request,$id)
    {
        $data = $request->validate([
            "nama" => 'required',
            "skor" => 'required',
        ]);

        $motorik = motorik::find($id);
        $motorik->nama = $data['nama'];
        $motorik->skor = $data['skor'];
        $motorik->save();

        return redirect()->route('datmas.motorik')->with('Success', 'Eye berhasil di edit');
    }

    public function nilai()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "GCS Nilai";
        $nilai = gcs_nilai::all();
        return view('gcs.nilai', compact('title','nilai'));
    }

    public function nilaiadd(Request $request)
    {
        $data = $request->validate([
            "nama" => 'required',
            "skor" => 'required',
        ]);

        $nilai = new gcs_nilai();
        $nilai->nama = $data['nama'];
        $nilai->skor = $data['skor'];
        $nilai->save();

        return redirect()->route('datmas.nilai')->with('Success', 'Nilai GCS berhasil ditambahkan');
    }
}

