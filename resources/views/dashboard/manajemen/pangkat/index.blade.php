@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            @include('dashboard.manajemen.pangkat.header')

            @include('dashboard.manajemen.pangkat.tabel')

        </div>
    </div>
@endsection
