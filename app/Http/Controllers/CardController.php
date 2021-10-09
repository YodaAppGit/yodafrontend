<?php

namespace App\Http\Controllers;

use App\Http\Traits\ImageTrait;
use App\Http\Traits\KeywordTrait;
use App\Http\Traits\PermissionTrait;
use App\Models\Card;
use App\Models\CardRefinancing;
use App\Models\Penjual;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CardController extends Controller
{
    use PermissionTrait, KeywordTrait, ImageTrait;

    public function mobileCardCount($type)
    {
        if ($this->checkPermission(auth()->user(), 'mobile-login') == false) {
            return response([
                'message' => 'Unauthorized.'
            ], 403);
        }
        if ($type == 'financing') {
            $cards = Card::where('type', $type)->get();
            $pipelines = [
                'unit_listing',
                'unit_visiting',
                'unit_visit_done',
                'assigning_credit_surveyor',
                'credit_surveying',
                'credit_approval',
                'credit_purchasing_order',
                'credit_rejected',
                'unit_not_available',
            ];
            $result = [];
            foreach ($pipelines as $pipeline) {
                $result[$pipeline] = $cards->where($pipeline, 1)->count();
            }
            return response($result, 200);
        } else if ($type ==  'refinancing') {
            $cards = CardRefinancing::where('type', $type)->get();
            $pipelines = [
                'unit_listing',
                'slik_checking',
                'assigning_credit_surveyor',
                'credit_surveying',
                'credit_approval',
                'credit_purchasing_order',
                'credit_rejected',
                'slik_rejected',
            ];
            $result = [];
            foreach ($pipelines as $pipeline) {
                $result[$pipeline] = $cards->where($pipeline, 1)->count();
            }
            return response($result, 200);
        }

        return response([
            'message' => 'Invalid Type.'
        ], 403);
    }

    public function index()
    {
        $card = Card::with('creator')->get();
        return response([
            'cards' => $card
        ], 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'type' => 'required|string',
            'unit_listing' => 'required|boolean',
            'unit_visiting' => 'required|boolean',
            'unit_visit_done' => 'required|boolean',
            'assigning_credit_surveyor' => 'required|boolean',
            'credit_surveying' => 'required|boolean',
            'credit_approval' => 'required|boolean',
            'credit_purchasing_order' => 'required|boolean',
            'credit_rejected' => 'required|boolean',
            'unit_not_available' => 'required|boolean',
            'creator' => 'required|exists:users,id',
            'unit_id' => 'required|exists:units,id',
            'pic_1' => 'exists:users,id|nullable',
            'pic_2' => 'exists:users,id|nullable',
            'pic_3' => 'exists:users,id|nullable',
        ]);

        $card = Card::create($fields);
        $this->cardFinancingKeyword($card->id);
        return response([
            'message' => 'Success',
            'card' => $card
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'type' => 'required|string',
            'unit_listing' => 'required|boolean',
            'unit_visiting' => 'required|boolean',
            'unit_visit_done' => 'required|boolean',
            'assigning_credit_surveyor' => 'required|boolean',
            'credit_surveying' => 'required|boolean',
            'credit_approval' => 'required|boolean',
            'credit_purchasing_order' => 'required|boolean',
            'credit_rejected' => 'required|boolean',
            'unit_not_available' => 'required|boolean',
            'creator' => 'required|exists:users,id',
            'unit_id' => 'required|exists:units,id',
        ]);

        $card = Card::find($id);
        if (!$card) {
            return response([
                'message' => 'Data Not Found'
            ], 400);
        }
        $card->type = $fields['type'];
        $card->unit_listing = $fields['unit_listing'];
        $card->unit_visiting = $fields['unit_visiting'];
        $card->unit_visit_done = $fields['unit_visit_done'];
        $card->assigning_credit_surveyor = $fields['assigning_credit_surveyor'];
        $card->credit_surveying = $fields['credit_surveying'];
        $card->credit_approval = $fields['credit_approval'];
        $card->credit_purchasing_order = $fields['credit_purchasing_order'];
        $card->credit_rejected = $fields['credit_rejected'];
        $card->unit_not_available = $fields['unit_not_available'];
        $card->credit_rejected = $fields['credit_rejected'];
        $card->unit_not_available = $fields['unit_not_available'];
        $card->unit_id = $fields['unit_id'];
        $this->cardFinancingKeyword($card->id);
        return response([
            'message' => 'Success',
            'card' => $card
        ], 201);
    }

    public function getSingle($id)
    {
        $card = Card::find($id);

        if (!$card) {
            return response([
                'message' => 'Card Not Found'
            ], 404);
        }

        $unit = Unit::find($card->unit_id);
        $image = $this->getImageListDetailed($unit->id);
        $penjual = Penjual::find($unit->penjual_id);
        $unit->image = $image;
        $result = [
            'card_info' => $card,
            'unit' => $unit,
            'penjual' => $penjual,
        ];

        return response([
            'result' => $result
        ], 200);
    }

    public function changePipeline(Request $request)
    {
        $id = $request->input('id');
        $pipeline = $request->input('pipeline');
        $index = $request->input('index');
        $card = Card::find($id);

        if ($card->unit_listing == 1) $current_pipeline = 'unit_listing';
        if ($card->unit_visiting == 1) $current_pipeline = 'unit_visiting';
        if ($card->unit_visit_done == 1) $current_pipeline = 'unit_visit_done';
        if ($card->assigning_credit_surveyor == 1) $current_pipeline = 'assigning_credit_surveyor';
        if ($card->credit_surveying == 1) $current_pipeline = 'credit_surveying';
        if ($card->credit_approval == 1) $current_pipeline = 'credit_approval';
        if ($card->credit_purchasing_order == 1) $current_pipeline = 'credit_purchasing_order';
        if ($card->credit_rejected == 1) $current_pipeline = 'credit_rejected';
        if ($card->unit_not_available == 1) $current_pipeline = 'unit_not_available';
        if ($card->credit_rejected == 1) $current_pipeline = 'credit_rejected';
        if ($card->unit_not_available == 1) $current_pipeline = 'unit_not_available';
        $current_index = $card->index;
        if (!$card) {
            return response([
                'message' => 'Card Not Found'
            ], 400);
        }

        $card->unit_listing = 0;
        $card->unit_visiting = 0;
        $card->unit_visit_done = 0;
        $card->assigning_credit_surveyor = 0;
        $card->credit_surveying = 0;
        $card->credit_approval = 0;
        $card->credit_purchasing_order = 0;
        $card->credit_rejected = 0;
        $card->unit_not_available = 0;
        $card->credit_rejected = 0;
        $card->unit_not_available = 0;

        $card->{$pipeline} = 1;
        $card->index = $index;
        $this->indexDownBefore($current_index, $current_pipeline);
        $this->indexUpAfter($index, $pipeline);

        $card->save();
        return response([
            'message' => 'Success',
            'card' => $card,
        ], 200);
    }

    public function indexUpAfter($index, $pipeline)
    {
        $card = Card::where($pipeline, 1)->get();
        foreach ($card as $c) {
            if ($c->index >= $index) {
                $c->index++;
                $c->save();
            }
        }
    }

    public function indexDownBefore($index, $pipeline)
    {
        $card = Card::where($pipeline, 1)->get();
        foreach ($card as $c) {
            if ($c->index > $index) {
                $c->index--;
                $c->save();
            }
        }
    }
}
