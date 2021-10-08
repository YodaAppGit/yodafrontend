<?php

namespace App\Http\Traits;

use App\Models\Card;
use App\Models\Penjual;
use App\Models\Unit;

trait KeywordTrait
{
    public function penjualKeyword($id)
    {
        $penjual = Penjual::find($id);
        $penjual->keyword = $penjual->nama . ';' .
            $penjual->kode . ';' .
            $penjual->no_telepon . ';' .
            $penjual->alamat . ';' .
            $penjual->provinsi . ';' .
            $penjual->kota . ';' .
            $penjual->kecamatan . ';';
        $penjual->save();
    }

    public function unitKeyword($id)
    {
        $unit = Unit::find($id);
        $penjual = Penjual::find($unit->penjual_id);
        $unit->keyword = $unit->plat_nomor . ';' .
            $unit->merek . ';' .
            $unit->model . ';' .
            $unit->varian . ';' .
            $unit->tahun . ';' .
            $unit->jarak_tempuh . ';' .
            $unit->bahan_bakar . ';' .
            $unit->catatan . ';' .
            $unit->harga . ';' .
            $penjual->keyword;
        $unit->save();
    }

    public function cardFinancingKeyword($id)
    {
        $card = Card::find($id);
        $unit = Unit::find($card->unit_id);
        $status = '';
        if ($card->unit_listing) $status = '[Unit] Listing';
        if ($card->unit_visiting) $status = '[Unit] Visiting';
        if ($card->unit_visit_done) $status = '[Unit] Visit done';
        if ($card->assigning_credit_surveyor) $status = 'Assigning credit surveyor';
        if ($card->credit_surveying) $status = '[Credit] Surveying';
        if ($card->credit_approval) $status = '[Credit] Approval';
        if ($card->credit_approval) $status = '[Credit] Approval';
        if ($card->credit_purchasing_order) $status = '[Credit] Purchasing order';
        if ($card->credit_rejected) $status = '[Credit] Rejected';
        if ($card->unit_not_available) $status = '[Unit] Not available';
        $card->keyword = $card->type . ';' .
            $status . ';' .
            $unit->keyword;
        $card->save();
    }

    public function cardRefinancingKeyword($id)
    {
        $card = Card::find($id);
        $unit = Unit::find($card->unit_id);
        $status = '';
        if ($card->unit_listing) $status = 'SLIK Checking';
        if ($card->assigning_credit_surveyor) $status = 'Assigning credit surveyor';
        if ($card->credit_surveying) $status = '[Credit] Surveying';
        if ($card->credit_approval) $status = '[Credit] Approval';
        if ($card->credit_approval) $status = '[Credit] Approval';
        if ($card->credit_purchasing_order) $status = '[Credit] Purchasing order';
        if ($card->credit_rejected) $status = '[Credit] Rejected';
        if ($card->unit_not_available) $status = 'SLIK rejected';
        $card->keyword = $card->type . ';' .
            $status . ';' .
            $unit->keyword;
        $card->save();
    }
}
