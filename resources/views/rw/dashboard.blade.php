@extends('layouts.app')

@section('content')
<h2>Dashboard RW</h2>
<p>Selamat datang RW {{ Auth::user()->name }}!</p>
<ul>
    <li>Data laporan dari RT: ...</li>
    <li>Pengawasan aktivitas kas & surat: ...</li>
</ul>
@endsection
