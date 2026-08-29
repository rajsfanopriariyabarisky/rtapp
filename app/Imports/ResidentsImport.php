<?php

namespace App\Imports;

use App\Models\Resident;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ResidentsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Resident([
            'nik' => $row['nik'],
            'nama_lengkap' => $row['nama_lengkap'],
            'tempat_lahir' => $row['tempat_lahir'] ?? '',
            'tanggal_lahir' => $row['tanggal_lahir'] ?? now(),
            'jenis_kelamin' => $row['jenis_kelamin'] === 'Laki-laki' ? 'L' : 'P',
            'agama' => $row['agama'] ?? null,
            'pekerjaan' => $row['pekerjaan'] ?? '',
            'status_perkawinan' => $row['status_perkawinan'] ?? 'Belum Menikah',
            'status_tinggal' => $row['status_tinggal'] ?? 'Tetap',
            'alamat' => $row['alamat'],
            'rt' => $row['rt'] ?? '',
            'rw' => $row['rw'] ?? '',
            'telepon' => $row['telepon'] ?? '',
            'email' => $row['email'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|unique:residents,nik',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
        ];
    }
}
