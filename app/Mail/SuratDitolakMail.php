<?php

namespace App\Mail;

use App\Models\Letter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuratDitolakMail extends Mailable
{
    use Queueable, SerializesModels;

    public $letter;

    public function __construct(Letter $letter)
    {
        $this->letter = $letter;
    }

    public function build()
    {
        return $this->subject('Pengajuan Surat Anda Ditolak')
                    ->view('emails.surat_ditolak');
    }
}
