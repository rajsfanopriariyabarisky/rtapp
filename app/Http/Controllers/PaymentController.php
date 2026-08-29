<?php

namespace App\Http\Controllers;


use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
   public function index(Request $request)
    {
        $query = Payment::with('user');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan judul tagihan
        if ($request->filled('title') && $request->title !== 'all') {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal jatuh tempo
        if ($request->filled('due_date_mulai')) {
            $query->where('due_date', '>=', $request->due_date_mulai);
        }

        if ($request->filled('due_date_akhir')) {
            $query->where('due_date', '<=', $request->due_date_akhir);
        }

        // Filter berdasarkan range nominal
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $payments = $query->get();

        // Data untuk dropdown filter
        $titleList = \App\Models\Payment::distinct()->pluck('title')->filter()->sort();
        $statusList = ['belum', 'proses', 'lunas'];

        return view('admin.payments.index', compact('payments', 'titleList', 'statusList', 'sort', 'direction'));
    }

    // ADMIN - Form tambah tagihan
    public function create()
    {
        $total = Payment::sum('amount');
        $payments = Payment::with('user')->get();

        return view('admin.payments.create', compact('total', 'payments'));
    }

    // ADMIN - Simpan tagihan
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        Payment::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'status' => 'belum', // default status awal
        ]);

        return redirect()->route('payments.index')->with('success', 'Tagihan berhasil dibuat');
    }

    //  ADMIN - Form edit tagihan
    public function edit(Payment $payment)
    {
        if ($payment->status === 'lunas') {
        return redirect()->route('payments.index')->with('error', 'Tagihan yang sudah lunas tidak bisa diedit.');
        }

        return view('admin.payments.edit', compact('payment'));
    }

    //  ADMIN - Update tagihan
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        $payment->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('payments.index')->with('success', 'Tagihan diperbarui.');
    }

    // ADMIN - Hapus tagihan
    public function destroy(Payment $payment)
    {
        if ($payment->status === 'lunas') {
            return redirect()->route('payments.index')->with('error', 'Tagihan yang sudah lunas tidak dapat dihapus.');
        }

        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Tagihan berhasil dihapus.');
    }

    // USER - Lihat pembayaran miliknya
    public function userIndex()
    {
        $payments = Payment::where('user_id', Auth::id())->latest()->get();
        return view('payments.index', compact('payments'));
    }

    // USER - Upload bukti bayar
    public function uploadProof(Request $request, Payment $payment)
    {
        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($payment->user_id != Auth::id()) {
            abort(403); // keamanan
        }

        $path = $request->file('proof')->store('proofs', 'public');
        $payment->update([
            'proof' => $path,
            'status' => 'proses'
        ]);

        return back()->with('success', 'Bukti pembayaran dikirim, menunggu verifikasi');
    }

    // ADMIN - Verifikasi
    public function verify(Payment $payment)
    {
        $payment->update(['status' => 'lunas']);
        return back()->with('success', 'Pembayaran diverifikasi sebagai lunas');
    }

    // history user
    public function history()
    {
        $payments = Payment::where('user_id', Auth::id())->latest()->get();
        return view('payments.history', compact('payments'));
    }

    // laporan admin
    public function report()
    {
    $payments = Payment::with('user')->get();

    $grouped = $payments->groupBy('title');

    // Ambil statistik total dan nominal
    $summary = $payments->groupBy(['title', 'status'])
        ->map(function ($statusGroup) {
            return $statusGroup->map(function ($items) {
                return [
                    'total' => $items->count(),
                    'total_amount' => $items->sum('amount'),
                ];
            });
        });

    return view('admin.payments.report', compact('grouped', 'summary'));
    }


    public function kasReport()
    {
    $payments = Payment::with('user')
        ->where('status', 'lunas')
        ->where('title', 'Kas RT') // Ganti jika kamu pakai field 'jenis' atau 'kategori'
        ->latest()
        ->get();

    $total = $payments->sum('amount');

    return view('admin.kas.index', compact('payments', 'total'));
    }

    public function exportPdf()
    {
    $payments = Payment::with('user')->get(); // ⬅️ relasi user dimuat!

    $grouped = $payments->groupBy('title');

    $pdf = PDF::loadView('admin.payments.report_pdf', compact('grouped'));

    return $pdf->stream('laporan-pembayaran.pdf');
    }

    // Laporan pembayaran berdasarkan jenis tagihan
    public function paymentReport()
    {
        $payments = Payment::with('user')->get();
        
        // Kelompokkan berdasarkan jenis tagihan
        $groupedByType = $payments->groupBy('title');
        
        // Hitung total per jenis tagihan
        $totalsByType = [];
        $grandTotal = 0;
        
        foreach ($groupedByType as $type => $typePayments) {
            $totalAmount = $typePayments->sum('amount');
            $totalPaid = $typePayments->where('status', 'lunas')->sum('amount');
            $totalPending = $typePayments->whereIn('status', ['belum', 'proses'])->sum('amount');
            
            $totalsByType[$type] = [
                'total_amount' => $totalAmount,
                'total_paid' => $totalPaid,
                'total_pending' => $totalPending,
                'count' => $typePayments->count(),
                'paid_count' => $typePayments->where('status', 'lunas')->count(),
                'pending_count' => $typePayments->whereIn('status', ['belum', 'proses'])->count(),
            ];
            
            $grandTotal += $totalAmount;
        }
        
        // Total keseluruhan
        $overallStats = [
            'total_amount' => $grandTotal,
            'total_paid' => $payments->where('status', 'lunas')->sum('amount'),
            'total_pending' => $payments->whereIn('status', ['belum', 'proses'])->sum('amount'),
            'count' => $payments->count(),
            'paid_count' => $payments->where('status', 'lunas')->count(),
            'pending_count' => $payments->whereIn('status', ['belum', 'proses'])->count(),
        ];
        
        return view('admin.payments.payment_report', compact('groupedByType', 'totalsByType', 'overallStats'));
    }
    
    // Export PDF per jenis tagihan
    public function exportPdfByType($type)
    {
        $payments = Payment::with('user')
            ->where('title', $type)
            ->get();
            
        $totalAmount = $payments->sum('amount');
        $totalPaid = $payments->where('status', 'lunas')->sum('amount');
        $totalPending = $payments->whereIn('status', ['belum', 'proses'])->sum('amount');
        
        $stats = [
            'total_amount' => $totalAmount,
            'total_paid' => $totalPaid,
            'total_pending' => $totalPending,
            'count' => $payments->count(),
            'paid_count' => $payments->where('status', 'lunas')->count(),
            'pending_count' => $payments->whereIn('status', ['belum', 'proses'])->count(),
        ];
        
        $pdf = PDF::loadView('admin.payments.report_pdf_by_type', compact('payments', 'stats', 'type'));
        
        return $pdf->stream("laporan-pembayaran-{$type}.pdf");
    }
    
    // Export PDF total keseluruhan
    public function exportPdfTotal()
    {
        $payments = Payment::with('user')->get();
        
        // Kelompokkan berdasarkan jenis tagihan
        $groupedByType = $payments->groupBy('title');
        
        // Hitung total per jenis tagihan
        $totalsByType = [];
        $grandTotal = 0;
        
        foreach ($groupedByType as $type => $typePayments) {
            $totalAmount = $typePayments->sum('amount');
            $totalPaid = $typePayments->where('status', 'lunas')->sum('amount');
            $totalPending = $typePayments->whereIn('status', ['belum', 'proses'])->sum('amount');
            
            $totalsByType[$type] = [
                'total_amount' => $totalAmount,
                'total_paid' => $totalPaid,
                'total_pending' => $totalPending,
                'count' => $typePayments->count(),
                'paid_count' => $typePayments->where('status', 'lunas')->count(),
                'pending_count' => $typePayments->whereIn('status', ['belum', 'proses'])->count(),
            ];
            
            $grandTotal += $totalAmount;
        }
        
        // Total keseluruhan
        $overallStats = [
            'total_amount' => $grandTotal,
            'total_paid' => $payments->where('status', 'lunas')->sum('amount'),
            'total_pending' => $payments->whereIn('status', ['belum', 'proses'])->sum('amount'),
            'count' => $payments->count(),
            'paid_count' => $payments->where('status', 'lunas')->count(),
            'pending_count' => $payments->whereIn('status', ['belum', 'proses'])->count(),
        ];
        
        $pdf = PDF::loadView('admin.payments.report_pdf_total', compact('groupedByType', 'totalsByType', 'overallStats'));
        
        return $pdf->stream('laporan-pembayaran-total.pdf');
    }
}
    

   
