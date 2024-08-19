<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Confirmation;
use App\Models\Complain;

class DashboardController extends Controller
{
    public function index()
    {
        // transaksi po yg siap divalidasi
        $pre_orders = Transaction::where('transaction_status', 'menunggu validasi admin')->count();

        // transaksi po yg siap kirim
        $transactions = Transaction::where('transaction_status', 'sedang dikerjakan')->count();

        // pembayaran masuk
        $payments = Confirmation::where('status', 0)->count();

        // komplain masuk
        $complains = Complain::where('status', 'menunggu validasi')->count();

        // pendapatan
        $incomes = Transaction::where('payment_status', 'lunas')->sum('total_price');

        // DP
        $down_payment = Transaction::where('payment_status', 'baru DP')->sum('total_price') / 2;
        $incomes += $down_payment;

        // barang siap kirim
        $shipping = Transaction::where('shipping_status', 'siap dikirim')->count();

        // barang komplain siap kirim
        $complain_shipping = Complain::where('status', 'barang dikirim dari pembeli')
        ->orWhere('status', 'barang diterima toko')->count();
        

        if(auth()->user()->role == 'pemilik'){
            return view('pages.admin.dashboard.pemilik', [
                'payments' => $payments,
                'complains' => $complains,
                'incomes' => $incomes,
                'pre_orders' => $pre_orders
            ]);
        } elseif(auth()->user()->role == 'pegawai'){
            return view('pages.admin.dashboard.pegawai', [
                'transactions' => $transactions,
                'shipping' => $shipping,
                'complain_shipping' => $complain_shipping
            ]);
        }

    }
}
