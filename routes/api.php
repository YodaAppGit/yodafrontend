<?php

use App\Http\Controllers\AngsuranPertamaController;
use App\Http\Controllers\BahanBakarController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ContentManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenNasabahController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\IndonesiaController;
use App\Http\Controllers\JarakTempuhController;
use App\Http\Controllers\JenisUnitController;
use App\Http\Controllers\KantorController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KesertaanAsuransiController;
use App\Http\Controllers\KondisiController;
use App\Http\Controllers\MerekModelVarianController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\NilaiPertanggunganController;
use App\Http\Controllers\PembayaranAsuransiController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TahunPembuatanController;
use App\Http\Controllers\TenorController;
use App\Http\Controllers\TipeAsuransiController;
use App\Http\Controllers\TransmisiController;
use App\Http\Controllers\TujuanPenggunaanController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarnaController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Non Token Route
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/forgot-password', [UserController::class, 'forgot']);
Route::post('/reset-password', [UserController::class, 'reset'])->name('password.reset');
Route::post('/check-email', [UserController::class, 'checkEmail']);

//Get ImageFile 
Route::get('/get-image/{model}/{name}', [ImageController::class, 'getImage']);

//Filter & Dropdown
Route::post('/upload-excel', [ExcelController::class, 'import']);
Route::post('/filterMMV', [SearchController::class, 'filterMMV']);
Route::post('/filterTahun', [SearchController::class, 'filterTahun']);
Route::post('/filterWilayah', [SearchController::class, 'filterWilayah']);
Route::post('/filterUser', [SearchController::class, 'filterUser']);
Route::post('/filterExternal', [SearchController::class, 'filterExternal']);
Route::post('/filter2', [SearchController::class, 'buttonFilter']);
Route::post('/buttonUser', [SearchController::class, 'buttonUser']);
Route::get('/query', [SearchController::class, 'queryGetter']);
Route::get('/dropdown-roles', [SearchController::class, 'listRole']);
Route::get('/dropdown-kantor', [SearchController::class, 'listKantor']);
Route::get('/dropdown-pic', [SearchController::class, 'listPic']);
Route::get('/dropdown/tambah-unit', [ContentManagementController::class, 'tambahUnitDD']);
Route::get('/dropdown/indonesia', [IndonesiaController::class, 'index']);
Route::get('/dropdown/nama-cabang', [KantorController::class, 'getNamaCabang']);
//temp

/**
 * Need Login Before use (Token Required)
 */

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/token', [UserController::class, 'gettokenss']);

    //Route User
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/user-management', [UserController::class, 'userManagement']);
    Route::get('/user-profile', [UserController::class, 'profile']);
    Route::get('/profile-picture/{id}', [UserController::class, 'getProfilePicture']);
    Route::get('/um/delete/{id}', [UserController::class, 'deleteRejected']);
    Route::post('/um/updateNamaEmail', [UserController::class, 'updateNamaEmail']);
    Route::post('/um/updateNoHP', [UserController::class, 'updateNoHP']);
    Route::post('/um/updateKantor', [UserController::class, 'updateKantor']);
    Route::post('/um/updateRole', [UserController::class, 'updateRole']);
    Route::post('/um/updateStatus', [UserController::class, 'updateStatus']);

    //Content Management Route
    Route::get('/cm/merek-model-varian', [MerekModelVarianController::class, 'index']);
    Route::post('/cm/merek-model-varian/insert', [MerekModelVarianController::class, 'store']);
    Route::post('/cm/merek-model-varian/update/{id}', [MerekModelVarianController::class, 'update']);
    Route::get('/cm/merek-model-varian/delete/{id}', [MerekModelVarianController::class, 'destroy']);
    //Route::resource('/cm/merek-model-varian', MerekModelVarianController::class);

    Route::get('/cm/tahun-pembuatan', [TahunPembuatanController::class, 'index']);
    Route::post('/cm/tahun-pembuatan/insert', [TahunPembuatanController::class, 'store']);
    Route::post('/cm/tahun-pembuatan/update/{id}', [TahunPembuatanController::class, 'update']);
    Route::get('/cm/tahun-pembuatan/delete/{id}', [TahunPembuatanController::class, 'destroy']);
    //Route::resource('/cm/tahun-pembuatan', TahunPembuatanController::class);
    Route::get('/cm/jarak-tempuh', [JarakTempuhController::class, 'index']);
    Route::post('/cm/jarak-tempuh/insert', [JarakTempuhController::class, 'store']);
    Route::post('/cm/jarak-tempuh/update/{id}', [JarakTempuhController::class, 'update']);
    Route::get('/cm/jarak-tempuh/delete/{id}', [JarakTempuhController::class, 'destroy']);
    //Route::resource('/cm/jarak-tempuh', JarakTempuhController::class);
    Route::get('/cm/warna', [WarnaController::class, 'index']);
    Route::post('/cm/warna/insert', [WarnaController::class, 'store']);
    Route::post('/cm/warna/update/{id}', [WarnaController::class, 'update']);
    Route::get('/cm/warna/delete/{id}', [WarnaController::class, 'destroy']);
    //Route::resource('/cm/warna', WarnaController::class);

    Route::get('/cm/bahan-bakar', [BahanBakarController::class, 'index']);
    Route::post('/cm/bahan-bakar/insert', [BahanBakarController::class, 'store']);
    Route::post('/cm/bahan-bakar/update/{id}', [BahanBakarController::class, 'update']);
    Route::get('/cm/bahan-bakar/delete/{id}', [BahanBakarController::class, 'destroy']);
    //Route::resource('/cm/bahan-bakar', BahanBakarController::class);

    Route::get('/cm/transmisi', [TransmisiController::class, 'index']);
    Route::post('/cm/transmisi/insert', [TransmisiController::class, 'store']);
    Route::post('/cm/transmisi/update/{id}', [TransmisiController::class, 'update']);
    Route::get('/cm/transmisi/delete/{id}', [TransmisiController::class, 'destroy']);
    //Route::resource('/cm/transmisi', TransmisiController::class);

    Route::get('/cm/kondisi', [KondisiController::class, 'index']);
    Route::post('/cm/kondisi/insert', [KondisiController::class, 'store']);
    Route::post('/cm/kondisi/update/{id}', [KondisiController::class, 'update']);
    Route::get('/cm/kondisi/delete/{id}', [KondisiController::class, 'destroy']);
    //Route::resource('/cm/kondisi', KondisiController::class);

    Route::get('/cm/jenis-unit', [JenisUnitController::class, 'index']);
    Route::post('/cm/jenis-unit/insert', [JenisUnitController::class, 'store']);
    Route::post('/cm/jenis-unit/update/{id}', [JenisUnitController::class, 'update']);
    Route::get('/cm/jenis-unit/delete/{id}', [JenisUnitController::class, 'destroy']);
    //Route::resource('/cm/jenis-unit', JenisUnitController::class);

    Route::get('/cm/kantor', [KantorController::class, 'index']);
    Route::post('/cm/kantor/insert', [KantorController::class, 'store']);
    Route::post('/cm/kantor/update/{id}', [KantorController::class, 'update']);
    Route::get('/cm/kantor/delete/{id}', [KantorController::class, 'destroy']);
    //Route::resource('/cm/kantor', KantorController::class);

    Route::get('/cm/wilayah', [WilayahController::class, 'index']);
    Route::post('/cm/wilayah/insert', [WilayahController::class, 'store']);
    Route::post('/cm/wilayah/update/{id}', [WilayahController::class, 'update']);
    Route::get('/cm/wilayah/delete/{id}', [WilayahController::class, 'destroy']);
    //Route::resource('/cm/wilayah', WilayahController::class);

    Route::get('/cm/tujuan-penggunaan', [TujuanPenggunaanController::class, 'index']);
    Route::post('/cm/tujuan-penggunaan/insert', [TujuanPenggunaanController::class, 'store']);
    Route::post('/cm/tujuan-penggunaan/update/{id}', [TujuanPenggunaanController::class, 'update']);
    Route::get('/cm/tujuan-penggunaan/delete/{id}', [TujuanPenggunaanController::class, 'destroy']);
    //Route::resource('/cm/tujuan-penggunaan', TujuanPenggunaanController::class);

    Route::get('/cm/kategori', [KategoriController::class, 'index']);
    Route::post('/cm/kategori/insert', [KategoriController::class, 'store']);
    Route::post('/cm/kategori/update/{id}', [KategoriController::class, 'update']);
    Route::get('/cm/kategori/delete/{id}', [KategoriController::class, 'destroy']);
    //Route::resource('/cm/kategori', KategoriController::class);

    Route::get('/cm/tipe-asuransi', [TipeAsuransiController::class, 'index']);
    Route::post('/cm/tipe-asuransi/insert', [TipeAsuransiController::class, 'store']);
    Route::post('/cm/tipe-asuransi/update/{id}', [TipeAsuransiController::class, 'update']);
    Route::get('/cm/tipe-asuransi/delete/{id}', [TipeAsuransiController::class, 'destroy']);
    //Route::resource('/cm/tipe-asuransi', TipeAsuransiController::class);

    Route::get('/cm/kesertaan-asuransi', [KesertaanAsuransiController::class, 'index']);
    Route::post('/cm/kesertaan-asuransi/insert', [KesertaanAsuransiController::class, 'store']);
    Route::post('/cm/kesertaan-asuransi/update/{id}', [KesertaanAsuransiController::class, 'update']);
    Route::get('/cm/kesertaan-asuransi/delete/{id}', [KesertaanAsuransiController::class, 'destroy']);
    //Route::resource('/cm/kesertaan-asuransi', KesertaanAsuransiController::class);

    Route::get('/cm/nilai-pertanggungan', [NilaiPertanggunganController::class, 'index']);
    Route::post('/cm/nilai-pertanggungan/insert', [NilaiPertanggunganController::class, 'store']);
    Route::post('/cm/nilai-pertanggungan/update/{id}', [NilaiPertanggunganController::class, 'update']);
    Route::get('/cm/nilai-pertanggungan/delete/{id}', [NilaiPertanggunganController::class, 'destroy']);
    //Route::resource('/cm/nilai-pertanggungan', NilaiPertanggunganController::class);

    Route::get('/cm/pembayaran-asuransi', [PembayaranAsuransiController::class, 'index']);
    Route::post('/cm/pembayaran-asuransi/insert', [PembayaranAsuransiController::class, 'store']);
    Route::post('/cm/pembayaran-asuransi/update/{id}', [PembayaranAsuransiController::class, 'update']);
    Route::get('/cm/pembayaran-asuransi/delete/{id}', [PembayaranAsuransiController::class, 'destroy']);
    //Route::resource('/cm/pembayaran-asuransi', PembayaranAsuransiController::class);

    Route::get('/cm/tenor', [TenorController::class, 'index']);
    Route::post('/cm/tenor/insert', [TenorController::class, 'store']);
    Route::post('/cm/tenor/update/{id}', [TenorController::class, 'update']);
    Route::get('/cm/tenor/delete/{id}', [TenorController::class, 'destroy']);
    //Route::resource('/cm/tenor', TenorController::class);

    Route::get('/cm/angsuran-pertama', [AngsuranPertamaController::class, 'index']);
    Route::post('/cm/angsuran-pertama/insert', [AngsuranPertamaController::class, 'store']);
    Route::post('/cm/angsuran-pertama/update/{id}', [AngsuranPertamaController::class, 'update']);
    Route::get('/cm/angsuran-pertama/delete/{id}', [AngsuranPertamaController::class, 'destroy']);
    //Route::resource('/cm/angsuran-pertama', AngsuranPertamaController::class);

    Route::get('/cm/penjual', [PenjualController::class, 'index']);
    Route::post('/cm/penjual/insert', [PenjualController::class, 'store']);
    Route::post('/cm/penjual/update/{id}', [PenjualController::class, 'update']);
    Route::get('/cm/penjual/delete/{id}', [PenjualController::class, 'destroy']);
    //Route::resource('/cm/penjual', PenjualController::class);

    //Mobile Dashboard Route
    Route::get('/m/card-count/{type}', [CardController::class, 'mobileCardCount']);
    Route::resource('/m/card', CardController::class);

    //Unit
    Route::get('/unit', [UnitController::class, 'index']);
    Route::post('/unit', [UnitController::class, 'storeFinancing']);
    Route::post('/unit/{id}', [UnitController::class, 'update']);

    //Search
    Route::post('/omnisearch', [SearchController::class, 'omnisearch']);
    Route::post('/m/search-card', [SearchController::class, 'searchCard']);
    Route::post('/search-plat', [SearchController::class, 'searchByPlat']);
    Route::post('/search-penjual', [SearchController::class, 'searchPenjualByNama']);

    //Delete Multi
    Route::post('/delete/angsuran-pertama', [AngsuranPertamaController::class, 'deleteMulti']);
    Route::post('/delete/bahan-bakar', [BahanBakarController::class, 'deleteMulti']);
    Route::post('/delete/jarak-tempuh', [JarakTempuhController::class, 'deleteMulti']);
    Route::post('/delete/jenis-unit', [JenisUnitController::class, 'deleteMulti']);
    Route::post('/delete/kantor', [KantorController::class, 'deleteMulti']);
    Route::post('/delete/kategori', [KategoriController::class, 'deleteMulti']);
    Route::post('/delete/kesertaan-asuransi', [KesertaanAsuransiController::class, 'deleteMulti']);
    Route::post('/delete/kondisi', [KondisiController::class, 'deleteMulti']);
    Route::post('/delete/merek-model-varian', [MerekModelVarianController::class, 'deleteMulti']);
    Route::post('/delete/nilai-pertanggungan', [NilaiPertanggunganController::class, 'deleteMulti']);
    Route::post('/delete/pembayaran-asuransi', [PembayaranAsuransiController::class, 'deleteMulti']);
    Route::post('/delete/penjual', [PenjualController::class, 'deleteMulti']);
    Route::post('/delete/tahun-pembuatan', [TahunPembuatanController::class, 'deleteMulti']);
    Route::post('/delete/tenor', [TenorController::class, 'deleteMulti']);
    Route::post('/delete/tipe-asuransi', [TipeAsuransiController::class, 'deleteMulti']);
    Route::post('/delete/transmisi', [TransmisiController::class, 'deleteMulti']);
    Route::post('/delete/tujuan-penggunaan', [TujuanPenggunaanController::class, 'deleteMulti']);
    Route::post('/delete/warna', [WarnaController::class, 'deleteMulti']);
    Route::post('/delete/wilayah', [WilayahController::class, 'deleteMulti']);

    //image
    Route::post('/delete/unit-images', [ImageController::class, 'deleteMulti']);
    Route::get('/set/unit-cover/{id}', [ImageController::class, 'setUnitCover']);
    Route::post('/upload/unit-images', [ImageController::class, 'uploadMultiUnitImage']);

    //Cards
    Route::get('/cards', [CardController::class, 'index']);
    Route::get('/cards/{id}', [CardController::class, 'getSingle']);
    Route::post('/financing/pipeline', [CardController::class, 'changePipeline']);


    //Nasabah
    //info
    Route::get('/fin-nasabah/card/{id}', [NasabahController::class, 'getByCard']);
    Route::post('/fin-nasabah/insert', [NasabahController::class, 'store']);
    Route::post('/fin-nasabah/update-all', [NasabahController::class, 'updateAll']);
    Route::post('/fin-nasabah/update-identitas', [NasabahController::class, 'updateIdentitas']);
    Route::post('/fin-nasabah/update-domisili', [NasabahController::class, 'updateDomisili']);
    Route::post('/fin-nasabah/update-pasangan', [NasabahController::class, 'updatePasangan']);
    //dokumen nasabah
    Route::get('/fin-dok-nasabah/nasabah/{id}', [DokumenNasabahController::class, 'allNasabahDokumen']);
    Route::post('/fin-dok-nasabah/insert', [DokumenNasabahController::class, 'storeDokumen']);
    Route::post('/fin-dok-nasabah/keterangan', [DokumenNasabahController::class, 'getDokumenByKeterangan']);
    Route::post('/fin-dok-nasabah/delete', [DokumenNasabahController::class, 'deleteDokumen']);

    //Kanban
    //financing
    Route::get('/unit-listing-cards', [DashboardController::class, 'getFinancingUnitListing']);
    Route::get('/unit-visiting-cards', [DashboardController::class, 'getFinancingUnitVisiting']);
    Route::get('/unit-visitdone-cards', [DashboardController::class, 'getFinancingUnitVisitDone']);
    Route::get('/assigning-cs-cards', [DashboardController::class, 'getFinancingACS']);
    Route::get('/credit-surveying-cards', [DashboardController::class, 'getFinancingCreditSurveying']);
    Route::get('/credit-approval-cards', [DashboardController::class, 'getFinancingCreditApproval']);
    Route::get('/credit-po-cards', [DashboardController::class, 'getFinancingCreditPO']);
    Route::get('/credit-rejected-cards', [DashboardController::class, 'getFinancingCreditRejected']);
    Route::get('/unit-notavailable-cards', [DashboardController::class, 'getFinancingUnitNotAvailable']);

    /**
     * 
     * REFINANCING
     * 
     * */
    Route::get('/re-silk-checking-cards', [DashboardController::class, 'getRefinancingChecking']);
    Route::get('/re-assigning-cs-cards', [DashboardController::class, 'getRefinancingACS']);
    Route::get('/re-credit-surveying-cards', [DashboardController::class, 'getRefinancingCreditSurveying']);
    Route::get('/re-credit-approval-cards', [DashboardController::class, 'getRefinancingCreditApproval']);
    Route::get('/re-credit-po-cards', [DashboardController::class, 'getRefinancingCreditPO']);
    Route::get('/re-credit-rejected-cards', [DashboardController::class, 'getRefinancingCreditRejected']);
    Route::get('/re-silk-rejected-cards', [DashboardController::class, 'getRefinancingRejected']);
});
