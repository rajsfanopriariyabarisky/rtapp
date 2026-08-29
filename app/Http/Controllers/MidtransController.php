<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MidtransController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Midtrans config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function pay(Payment $payment)
{
    if ($payment->user_id !== Auth::id()) {
        abort(403);
    }

    $params = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . $payment->id . '-' . time(),
            'gross_amount' => $payment->amount,
        ],
        'customer_details' => [
            'first_name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ],
        // Jangan tambahkan 'callbacks' di sini
    ];
    

    $snapToken = Snap::getSnapToken($params);

    return view('payments.midtrans', compact('snapToken', 'payment'));
}


    public function finish()
    {
        return view('midtrans.success'); // ✅ Sesuai struktur kamu
    }

    public function unfinish()
    {
        return view('midtrans.unfinish'); // ✅ Sesuai struktur kamu
    }

    public function error()
    {
        return view('midtrans.error'); // ✅ Sesuai struktur kamu
    }
}
