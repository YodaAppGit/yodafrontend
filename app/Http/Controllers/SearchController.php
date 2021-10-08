<?php

namespace App\Http\Controllers;

use App\Http\Traits\ImageTrait;
use App\Models\Area;
use App\Models\Card;
use App\Models\Kantor;
use App\Models\Penjual;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

use function Ramsey\Uuid\v1;

class SearchController extends Controller
{
    use ImageTrait;
    public function searchByPlat(Request $request)
    {
        $unit = Unit::where('plat_nomor', $request->input('plat_nomor'))->first();
        if (!$unit) {
            return response([
                'message' => 'Plat Belum Terdaftar'
            ], 200);
        }

        $unit->image_links = $this->getImageList($unit->id, 'units');
        return response($unit, 200);
    }

    public function searchPenjualByNama(Request $request)
    {
        $fields = $request->validate([
            'nama' => 'required|string'
        ]);
        $penjual = Penjual::where('nama', 'like', '%' . $fields['nama'] . '%')->first();

        if ($penjual) {
            return response([
                'penjual' => $penjual
            ], 200);
        }

        return response([
            'message' => 'Not Found'
        ], 404);
    }

    public function searchCard(Request $request)
    {
        $fields = $request->validate([
            'unit_listing' => 'required|boolean',
            'unit_visiting' => 'required|boolean',
            'unit_visit_done' => 'required|boolean',
            'assigning_credit_surveyor' => 'required|boolean',
            'credit_surveying' => 'required|boolean',
            'credit_approval' => 'required|boolean',
            'credit_purchasing_order' => 'required|boolean',
            'credit_rejected' => 'required|boolean',
            'unit_not_available' => 'required|boolean',
            'keyword' => 'string'
        ]);
        $cards = Card::where('keyword', 'like', '%' . $fields['keyword'] . '%')->with('unit', 'creator')->get();

        if ($fields['unit_listing']) {
            $tmp = Card::where('keyword', 'like', '%' . $fields['keyword'] . '%')
                ->where('unit_listing', $fields['unit_listing'])->with('unit', 'creator')->get();
            $cards = $cards->merge($tmp);
        }
        if ($fields['unit_visiting']) {
            $tmp = Card::where('keyword', 'like', '%' . $fields['keyword'] . '%')
                ->where('unit_visiting', $fields['unit_visiting'])->with('unit', 'creator')->get();
            $cards = $cards->merge($tmp);
        }
        if ($fields['unit_visiting']) {
            $tmp = Card::where('keyword', 'like', '%' . $fields['keyword'] . '%')
                ->where('unit_visiting', $fields['unit_visiting'])->with('unit', 'creator')->get();
            $cards = $cards->merge($tmp);
        }
        if ($fields['unit_visit_done']) {
            $tmp = Card::where('keyword', 'like', '%' . $fields['keyword'] . '%')
                ->where('unit_visit_done', $fields['unit_visit_done'])->with('unit', 'creator')->get();
            $cards = $cards->merge($tmp);
        }
        if ($fields['assigning_credit_surveyor']) {
            $tmp = Card::where('keyword', 'like', '%' . $fields['keyword'] . '%')
                ->where('assigning_credit_surveyor', $fields['assigning_credit_surveyor'])->with('unit', 'creator')->get();
            $cards = $cards->merge($tmp);
        }
        if ($fields['credit_surveying']) {
            $tmp = Card::where('keyword', 'like', '%' . $fields['keyword'] . '%')
                ->where('credit_surveying', $fields['credit_surveying'])->with('unit', 'creator')->get();
            $cards = $cards->merge($tmp);
        }
        if ($fields['credit_approval']) {
            $tmp = Card::where('credit_approval', $fields['credit_approval'])->with('unit', 'creator')->get();
        }
        if ($fields['credit_purchasing_order']) {
            $tmp = Card::where('keyword', 'like', '%' . $fields['keyword'] . '%')
                ->where('credit_purchasing_order', $fields['credit_purchasing_order'])->with('unit', 'creator')->get();
            $cards = $cards->merge($tmp);
        }
        if ($fields['credit_rejected']) {
            $tmp = Card::where('keyword', 'like', '%' . $fields['keyword'] . '%')
                ->where('credit_rejected', $fields['credit_rejected'])->with('unit', 'creator')->get();
            $cards = $cards->merge($tmp);
        }
        if ($fields['unit_not_available']) {
            $tmp = Card::where('keyword', 'like', '%' . $fields['keyword'] . '%')
                ->where('unit_not_available', $fields['unit_not_available'])->with('unit', 'creator')->get();
            $cards = $cards->merge($tmp);
        }
        return response([
            'cards' => $cards
        ], 200);
    }

    public function omnisearch(Request $request)
    {
        $keyword = $request->input('keyword');
        $cards = Card::where('keyword', 'like', '%' . $keyword . '%')->with('unit', 'creator')->get();
        return response([
            'cards' => $cards
        ], 200);
    }

    public function filterContent(Request $request)
    {
        $tmp = $request->input('table');
        $table = '';
        if ($tmp == "Merek, model, varian") {
            $table = 'merek_model_varians';
        }
        if ($tmp == "Tahun") {
            $table = 'tahuns';
        }
        if ($tmp == "Jarak tempuh") {
            $table = 'jarak_tempuhs';
        }
        if ($tmp == "Warna") {
            $table = 'warnas';
        }
        if ($tmp == "Bahan bakar") {
            $table = 'bahan_bakars';
        }
        if ($tmp == "Transmisi") {
            $table = 'transmisis';
        }
        if ($tmp == "Kondisi unit") {
            $table = 'kondisis';
        }
        if ($tmp == "Jenis unit") {
            $table = 'jenis_units';
        }
        if ($tmp == "Kantor") {
            $table = 'kantors';
        }
        if ($tmp == "Tujuan penggunaan") {
            $table = 'tujuan_pengunaans';
        }
        if ($tmp == "Kategori") {
            $table = 'kategoris';
        }
        if ($tmp == "Tipe asuransi") {
            $table = 'tipe_asuransis';
        }
        if ($tmp == "Kesertaan asuransi") {
            $table = 'kesertaan_asuransis';
        }
        if ($tmp == "Nilai pertanggungan") {
            $table = 'nilai_pertanggungas';
        }
        if ($tmp == "Pembayaran asuransi") {
            $table = 'pembayaran_asuransis';
        }
        if ($tmp == "Tenor") {
            $table = 'tenors';
        }
        if ($tmp == "Angsuran pertama") {
            $table = 'angsuran_pertamas';
        }
        if ($tmp == "Penjual") {
            $table = 'penjuals';
        }
        $filters = $request->input('filters');
        $results = DB::table($table)->Where(function ($query) use ($filters) {
            foreach ($filters as $key => $value) {
                $query->orwhere($key, 'like',  '%' . $value . '%');
            }
        })->get();

        return response([
            'results' => $results
        ], 200);
    }

    public function buttonFilter(Request $request)
    {
        $table = $request->input('table');
        $keyword = explode(',', $request->input('keyword'));

        $columns = Schema::getColumnListing($table);
        if ($columns) {
            $results = [];
            foreach ($keyword as $k) {
                foreach ($columns as $col) {
                    if ($col !== 'id') {
                        $tmp = DB::table($table)->select($columns)->where($col, 'like', '%' . $k . '%')->get()->toArray();
                        if (count($tmp) > 0) {
                            $results = array_merge($results, $tmp);
                        }
                    }
                }
            }
            if ($table == 'users') {
                foreach ($results as $res) {
                    $user = User::find($res->id);
                    $role = $user->roles->pluck('name');
                    $res->role = $role[0];
                }
            }
            return response([
                'results' => $results
            ], 200);
        }

        return response([
            'message' => 'Table Not Found.'
        ], 400);
    }

    public function filterMMV(Request $request)
    {
        $merek = explode(',', $request->input('merek'));
        $model = explode(',', $request->input('model'));
        $varian = explode(',', $request->input('varian'));
        if (count($merek) == 1 && $merek[0] == null) {
            $merek = [];
        }
        if (count($model) == 1 && $model[0] == null) {
            $model = [];
        }
        if (count($varian) == 1 && $varian[0] == null) {
            $varian = [];
        }
        $columns = Schema::getColumnListing('merek_model_varians');
        if ($columns) {
            $results = [];
            if (($key = array_search('created_at', $columns)) !== false) {
                unset($columns[$key]);
            }
            if (($key = array_search('updated_at', $columns)) !== false) {
                unset($columns[$key]);
            }
            if (($key = array_search('deleted_at', $columns)) !== false) {
                unset($columns[$key]);
            }
            if (($key = array_search('registered_at', $columns)) !== false) {
                unset($columns[$key]);
            }
        }

        $results = DB::table('merek_model_varians')
            ->select($columns)->where(function ($query) use ($merek, $model, $varian) {
                if (count($merek) > 0) {
                    $query->orWhereIn('merek', $merek);
                }
                if (count($model) > 0) {
                    $query->orWhereIn('model', $model);
                }
                if (count($varian) > 0) {
                    $query->orWhereIn('varian', $varian);
                }
                return $query;
            })
            ->get()->toArray();
        return response([
            'results' => $results
        ], 200);
    }

    public function filterTahun(Request $request)
    {
        $tahun = explode(',', $request->input('tahun'));
        if (count($tahun) == 1 && $tahun[0] == null) {
            $tahun = [];
        }
        $columns = Schema::getColumnListing('tahun_pembuatans');
        if ($columns) {
            $results = [];
            if (($key = array_search('created_at', $columns)) !== false) {
                unset($columns[$key]);
            }
            if (($key = array_search('updated_at', $columns)) !== false) {
                unset($columns[$key]);
            }
            if (($key = array_search('deleted_at', $columns)) !== false) {
                unset($columns[$key]);
            }
            if (($key = array_search('registered_at', $columns)) !== false) {
                unset($columns[$key]);
            }
        }

        $results = DB::table('tahun_pembuatans')
            ->select($columns)->where(function ($query) use ($tahun) {
                if (count($tahun) > 0) {
                    $query->orWhereIn('tahun', $tahun);
                }
                return $query;
            })
            ->get()->toArray();

        return response([
            'results' => $results
        ], 200);
    }

    public function filterWilayah(Request $request)
    {
        $provinsi = explode(',', $request->input('provinsi'));
        $kota = explode(',', $request->input('kota'));
        $kecamatan = explode(',', $request->input('kecamatan'));
        $cabang_pengelola = explode(',', $request->input('cabang_pengelola'));
        if (count($provinsi) == 1 && $provinsi[0] == null) {
            $provinsi = [];
        }
        if (count($kota) == 1 && $kota[0] == null) {
            $kota = [];
        }
        if (count($kecamatan) == 1 && $kecamatan[0] == null) {
            $kecamatan = [];
        }
        if (count($cabang_pengelola) == 1 && $cabang_pengelola[0] == null) {
            $cabang_pengelola = [];
        }
        $columns = Schema::getColumnListing('wilayahs');
        if ($columns) {
            $results = [];
            if (($key = array_search('created_at', $columns)) !== false) {
                unset($columns[$key]);
            }
            if (($key = array_search('updated_at', $columns)) !== false) {
                unset($columns[$key]);
            }
            if (($key = array_search('deleted_at', $columns)) !== false) {
                unset($columns[$key]);
            }
            if (($key = array_search('registered_at', $columns)) !== false) {
                unset($columns[$key]);
            }
        }

        $results = DB::table('wilayahs')
            ->select($columns)->where(function ($query) use ($provinsi, $kota, $kecamatan, $cabang_pengelola) {
                if (count($provinsi) > 0) {
                    $query->orWhereIn('provinsi', $provinsi);
                }
                if (count($kota) > 0) {
                    $query->orWhereIn('kota', $kota);
                }
                if (count($kecamatan) > 0) {
                    $query->orWhereIn('kecamatan', $kecamatan);
                }
                if (count($cabang_pengelola) > 0) {
                    $query->orWhereIn('cabang_pengelola', $cabang_pengelola);
                }
                return $query;
            })
            ->get()->toArray();

        return response([
            'results' => $results
        ], 200);
    }

    public function filterExternal(Request $request)
    {
        $nama = explode(',', $request->input('nam'));
        $email = explode(',', $request->input('email'));
        $phone_number = explode(',', $request->input('phone_number'));
        $created_at = explode(',', $request->input('tanggal_registrasi'));
        foreach ($created_at as $ca => $value) {
            $created_at[$ca] = Carbon::parse($value)->toDatetimeString();
        }
        if (count($nama) == 1 && $nama[0] == null) {
            $nama = [];
        }
        if (count($email) == 1 && $email[0] == null) {
            $email = [];
        }
        if (count($phone_number) == 1 && $phone_number[0] == null) {
            $phone_number = [];
        }
        if (count($created_at) == 1 && $created_at[0] == null) {
            $created_at = [];
        }
        $columns = Schema::getColumnListing('users');


        $results = DB::table('users')
            ->select($columns)->where(function ($query) use ($nama, $email, $phone_number, $created_at) {
                if (count($nama) > 0) {
                    $query->orWhereIn('nama', $nama);
                }
                if (count($email) > 0) {
                    $query->orWhereIn('email', $email);
                }
                if (count($phone_number) > 0) {
                    $query->orWhereIn('phone_number', $phone_number);
                }
                if (count($created_at) > 0) {
                    $query->orWhereDate('created_at', $created_at);
                }
                return $query;
            })
            ->get()->toArray();

        return response([
            'results' => $results
        ], 200);
    }

    public function filterUser(Request $request)
    {
        $cabang = explode(',', $request->input('cabang'));
        $role = explode(',', $request->input('role'));
        $status = explode(',', $request->input('status'));
        if (count($cabang) == 1 && $cabang[0] == null) {
            $cabang = [];
        }
        if (count($role) == 1 && $role[0] == null) {
            $role = [];
        }
        if (count($status) == 1 && $status[0] == null) {
            $status = [];
        }
        $columns = Schema::getColumnListing('users');
        $results = [];
        if (count($cabang) + count($role) + count($status) == 0) {
            $results = User::get();
        }
        $results = DB::table('users')
            ->select($columns)->where(function ($query) use ($cabang, $role, $status) {
                if (count($cabang) > 0) {
                    foreach ($cabang as $c) {
                        $query->orWhere('location',  $c);
                    }
                }
                if (count($role) > 0) {
                    $roles = [];
                    $ids = [];
                    foreach ($role as $r) {
                        $user = Role::where('name', $r)->get()->toArray();
                        $roles = array_merge($roles, $user);
                    }
                    foreach ($roles as $rr) {
                        array_push($ids, $rr['id']);
                    }
                    $ids = array_unique($ids);
                    $query->orWhereIn('id', $ids);
                }
                if (count($status) > 0) {
                    foreach ($status as $st) {
                        $query->orWhere('user_status', $st);
                    }
                }
                return $query;
            })
            ->get()->toArray();

        foreach ($results as $res) {
            $user = User::find($res->id);
            $role = $user->roles->pluck('name');
            $res->role = $role[0];
        }
        return response([
            'results' => $results
        ], 200);
    }

    public function buttonUser(Request $request)
    {
        $keywords = explode(',', $request->input('keyword'));

        $columns = Schema::getColumnListing('users');

        $results = DB::table('users')
            ->select($columns)->where(function ($query) use ($keywords) {
                $ids = [];
                $roles = [];
                foreach ($keywords as $k) {

                    $query->orWhere('location', 'like', '%' . $k . '%');
                    $query->orWhere('user_status', 'like', '%' . $k . '%');
                    try {
                        $role_name = Role::where('name', 'like', '%' . $k . '%')->get();

                        foreach ($role_name as $rn) {

                            $user = User::role($rn)->get()->toArray();
                            $roles = array_merge($roles, $user);
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
                foreach ($roles as $rr) {
                    array_push($ids, $rr['id']);
                }
                $ids = array_unique($ids);
                $query->orWhereIn('id', $ids);
                return $query;
            })
            ->get()->toArray();
        foreach ($results as $res) {
            $user = User::find($res->id);
            $role = $user->roles->pluck('name');
            $res->role = $role[0];
        }
        return response([
            'results' => $results
        ], 200);
    }

    public function queryGetter()
    {
        $query = request()->query();
        $results = [];
        return $query;
        foreach ($query as $key => $value) {
            if ($key !== 'table') {
                $keywords = explode(',', $value);
            }
        }
    }

    public function listRole()
    {
        $roles = \Spatie\Permission\Models\Role::select(['id', 'name'])->where('name', '<>', 'Super Admin')->get();
        return response([
            'roles' => $roles
        ], 200);
    }

    public function listKantor()
    {
        $kantors = DB::table('kantors')->select(['id', 'nama_cabang'])->get();
        return response([
            'kantor' => $kantors
        ], 200);
    }

    public function listPic()
    {
        $pic = DB::table('users')->select(['id', 'name'])->get();
        return response([
            'pic' => $pic
        ], 200);
    }

    public function listButtonDashboard($keyword)
    {
        $area = Area::where('nama_area', 'like', '%' . $keyword . '%')->get();
        $cabang = Kantor::where('nama_cabang', 'like', '%' . $keyword . '%')->get();

        return response([
            'area' => $area,
            'cabang' => $cabang,
        ], 200);
    }

    public function searchBarDashboardFinancing(Request $request)
    {
        $pipeline = $request->input('pipeline');
        $card = Card::where('keyword', 'like')->get();
    }
}
