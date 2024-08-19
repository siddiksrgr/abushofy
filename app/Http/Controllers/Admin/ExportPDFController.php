<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\AccessoriesStock;
use App\Models\ClothingStock;
use App\Models\Complain;
use App\Models\Confirmation;
use App\Models\Shipping;
use App\Models\Transaction;

class ExportPDFController extends Controller
{
    public function stock_accessories()
    {
        $accessories_stocks = AccessoriesStock::latest()->get();
    	$pdf = PDF::loadview('pages.admin.laporan.accessories-stock',['accessories_stocks'=> $accessories_stocks]);
    	return $pdf->stream();
    }

    public function stock_clothing()
    {
        $clothing_stocks = ClothingStock::latest()->get();
    	$pdf = PDF::loadview('pages.admin.laporan.clothing-stock',['clothing_stocks'=> $clothing_stocks]);
    	return $pdf->stream();
    }

    public function complain()
    {
        $complains = Complain::latest()->get();
    	$pdf = PDF::loadview('pages.admin.laporan.complain',['complains'=> $complains]);
    	return $pdf->stream();
    }

    public function payment()
    {   
        $confirmations = Confirmation::latest()->get(); 
        // pendapatan
        $incomes = Transaction::where('payment_status', 'lunas')->sum('total_price');

        // DP
        $down_payment = Transaction::where('payment_status', 'baru DP')->sum('total_price') / 2;
        $incomes += $down_payment;

    	$pdf = PDF::loadview('pages.admin.laporan.payment',['confirmations'=> $confirmations, 'incomes' => $incomes]);
    	return $pdf->stream();
    }

    public function shipping()
    {
        $shippings = Shipping::latest()->get();
    	$pdf = PDF::loadview('pages.admin.laporan.shipping',['shippings'=> $shippings]);
    	return $pdf->stream();
    }

    public function transaction()
    {
        $transactions = Transaction::latest()->get();
    	$pdf = PDF::loadview('pages.admin.laporan.transaction',['transactions'=> $transactions]);
    	return $pdf->stream();
    }
}
