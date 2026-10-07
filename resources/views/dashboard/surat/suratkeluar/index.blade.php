@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            @include('dashboard.surat.suratkeluar.header')

            @include('dashboard.surat.suratkeluar.tabel')

        </div>
    </div>
@endsection
