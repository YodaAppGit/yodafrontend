<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardRefinancing;
use App\Models\Penjual;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getFinancingUnitListing()
    {
        $cards = Card::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun',
        ])
            ->where('unit_listing', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            $nama =  Penjual::find($unit->penjual_id)->only('nama');
            $c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getFinancingUnitVisiting()
    {
        $cards = Card::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('unit_visiting', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            $nama =  Penjual::find($unit->penjual_id)->only('nama');
            $c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getFinancingUnitVisitDone()
    {
        $cards = Card::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('unit_visit_done', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            $nama =  Penjual::find($unit->penjual_id)->only('nama');
            $c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getFinancingACS()
    {
        $cards = Card::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('assigning_credit_surveyor', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            $nama =  Penjual::find($unit->penjual_id)->only('nama');
            $c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getFinancingCreditSurveying()
    {
        $cards = Card::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun',
            'unit.penjual:id,name'
        ])
            ->where('credit_surveying', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            $nama =  Penjual::find($unit->penjual_id)->only('nama');
            $c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getFinancingCreditApproval()
    {
        $cards = Card::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('credit_approval', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            $nama =  Penjual::find($unit->penjual_id)->only('nama');
            $c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getFinancingCreditPO()
    {
        $cards = Card::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('credit_purchasing_order', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            $nama =  Penjual::find($unit->penjual_id)->only('nama');
            $c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getFinancingCreditRejected()
    {
        $cards = Card::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('credit_rejected', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            $nama =  Penjual::find($unit->penjual_id)->only('nama');
            $c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getFinancingUnitNotAvailable()
    {
        $cards = Card::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('unit_not_available', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            $nama =  Penjual::find($unit->penjual_id)->only('nama');
            $c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    /**
     * Refinancing
     * CardRefinancing Model
     */

    public function getRefinancingSILKChecking()
    {
        $cards = CardRefinancing::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('silk_checking', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            //$nama =  Penjual::find($unit->penjual_id)->only('nama');
            //$c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getRefinancingACS()
    {
        $cards = CardRefinancing::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('assigning_credit_surveyor', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            //$nama =  Penjual::find($unit->penjual_id)->only('nama');
            //$c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getRefinancingCreditSurveying()
    {
        $cards = CardRefinancing::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun',
            'unit.penjual:id,name'
        ])
            ->where('credit_surveying', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            //$nama =  Penjual::find($unit->penjual_id)->only('nama');
            //$c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getRefinancingCreditApproval()
    {
        $cards = CardRefinancing::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('credit_approval', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            //$nama =  Penjual::find($unit->penjual_id)->only('nama');
            //$c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getRefinancingCreditPO()
    {
        $cards = Card::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('credit_purchasing_order', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            //$nama =  Penjual::find($unit->penjual_id)->only('nama');
            //$c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getRefinancingCreditRejected()
    {
        $cards = CardRefinancing::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('credit_rejected', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            //$nama =  Penjual::find($unit->penjual_id)->only('nama');
            //$c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }

    public function getRefinancingSILKRejected()
    {
        $cards = CardRefinancing::with([
            'pic_1:id,profile_picture',
            'pic_2:id,profile_picture',
            'pic_3:id,profile_picture',
            'unit:id,merek,model,tahun'
        ])
            ->where('silk_rejected', 1)->orderBy('index')
            ->simplePaginate(3);
        foreach ($cards as $c) {
            $unit = Unit::find($c->unit_id);
            //$nama =  Penjual::find($unit->penjual_id)->only('nama');
            //$c->penjual = $nama['nama'];
        }
        return response([
            'result' => $cards,
        ], 200);
    }
}
