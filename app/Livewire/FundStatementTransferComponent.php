<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fund;
use App\Models\FundStatement;
use App\Models\FundStatementDetail;
use Auth;

class FundStatementTransferComponent extends Component
{
    public $open=false;
    public $fund;
    public $amount,$info,$fund_transfer;

    public function mount(Fund $fund){
        $this->fund=$fund;
    }

    protected $rules = [
        'amount' => 'required',
        'info' => 'required',
        'fund_transfer' => 'required'
    ];
    public function render()
    {
        $funds = Fund::where('status',1)->where('id','<>',$this->fund->id)->get();
        return view('livewire.fund-statement-transfer-component',compact('funds'));
    }
    public function save(){

        $this->validate();

        $user=Auth::user();

        //Origen
        $last_statement=FundStatement::where('fund_id',$this->fund->id)->orderBy('id','desc')->first();
        $fund_destination = Fund::where('id',$this->fund_transfer)->first();
        $fund_statament=FundStatement::create([
            'fund_id' => $this->fund->id,
            'date' => date('Y-m-d H:i:s'),
            'type' => 6,
            'credit' => 0,
            'debit' => $this->amount,
            'balance' => $last_statement->balance - $this->amount,
            'create_user' => $user->id
        ]);
        FundStatementDetail::create([
            'fund_statement_id' => $fund_statament->id,
            'credit_code' => '',
            'info' => '095 - Traslado de Fondo hacia "'.$fund_destination->name.'" | '.$this->info,
            'receipt_number' => '',
            'amount' => $this->amount
        ]);

        //Destino
        $last_statement_destination=FundStatement::where('fund_id',$this->fund_transfer)->orderBy('id','desc')->first();
        $fund_statament=FundStatement::create([
            'fund_id' => $this->fund_transfer,
            'date' => date('Y-m-d H:i:s'),
            'type' => 3,
            'credit' => $this->amount,
            'debit' => 0,
            'balance' => $last_statement_destination->balance + $this->amount,
            'create_user' => $user->id
        ]);
        FundStatementDetail::create([
            'fund_statement_id' => $fund_statament->id,
            'credit_code' => '',
            'info' => '096 - Traslado de Fondo desde "'.$this->fund->name.'" | '.$this->info,
            'receipt_number' => '',
            'amount' => $this->amount
        ]);

        $this->reset('amount','info','open');
        $this->dispatch('ok');
        $this->dispatch('redirect');

    }
}
