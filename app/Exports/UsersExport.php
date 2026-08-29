<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UsersExport implements FromView
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $users = (new \App\Http\Controllers\UserController)->getFilteredUsers($this->request);
        return view('users.export.excel', compact('users'));
    }
}
