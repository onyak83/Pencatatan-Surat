@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            @include('dashboard.manajemen.pegawai.header')

            @include('dashboard.manajemen.pegawai.tabel')

        </div>
    </div>
@endsection
