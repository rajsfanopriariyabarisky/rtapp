<?php

namespace App\Exports;

use App\Models\Resident;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResidentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Resident::all();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Pekerjaan',
            'Status Perkawinan',
            'Status Tinggal',
            'Alamat',
            'RT',
            'RW',
            'Telepon',
            'Email',
            'Tanggal Dibuat',
            'Tanggal Diupdate'
        ];
    }

    public function map($resident): array
    {
        return [
            $resident->nik,
            $resident->nama_lengkap,
            $resident->tempat_lahir,
            $resident->tanggal_lahir,
            $resident->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
            $resident->agama ?? '-',
            $resident->pekerjaan,
            $resident->status_perkawinan,
            $resident->status_tinggal,
            $resident->alamat,
            $resident->rt,
            $resident->rw,
            $resident->telepon,
            $resident->email,
            $resident->created_at->format('d/m/Y H:i'),
            $resident->updated_at->format('d/m/Y H:i')
        ];
    }
}
