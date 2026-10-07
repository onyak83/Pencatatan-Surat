@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            @include('dashboard.surat.suratmasuk.header')

            @include('dashboard.surat.suratmasuk.tabel')

        </div>
    </div>
@endsection
