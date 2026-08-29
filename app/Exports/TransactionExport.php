<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionExport implements FromView
{
    protected $startDate;
    protected $endDate;
    protected $tipe;
    protected $kategori;
    protected $sumber;

    public function __construct($startDate = null, $endDate = null, $tipe = null, $kategori = null, $sumber = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->tipe = $tipe;
        $this->kategori = $kategori;
        $this->sumber = $sumber;
    }

    public function view(): View
    {
        $query = Transaction::query();

        // Filter tanggal
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ]);
        }

        // Filter tipe
        if ($this->tipe) {
            $query->where('tipe', strtolower($this->tipe));
        }

        // Filter kategori
        if ($this->kategori) {
            $query->where('kategori', 'like', '%' . $this->kategori . '%');
        }

        // Filter sumber
        if ($this->sumber) {
            $query->where('sumber', $this->sumber);
        }

        $transactions = $query->get();

        return view('transactions.export-excel', [
            'transactions' => $transactions,
        ]);
    }
}



