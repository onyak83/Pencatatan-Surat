@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Input Pangkat/Gol</h3>
                </div>

                <ul class="breadcrumbs mb-0">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('index.Pangkat') }}">Data Pangkat/Gol</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Input Pangkat/Gol</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8 col-sm-12">
                            <div class="card shadow">
                                <div class="card-body">

                                    <form action="{{ route('store.Pangkat') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label>Golongan</label>
                                            <input type="text" name="nm_gol" class="form-control"
                                                value="{{ old('nm_gol') }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Pangkat</label>
                                            <input type="text" name="nm_pangkat" class="form-control"
                                                value="{{ old('nm_pangkat') }}" required>
                                        </div>

                                        <div class="card-action text-center mt-3">

                                            <a href="{{ route('index.Pangkat') }}" class="btn btn-danger">
                                                Batal
                                            </a>

                                            <button type="submit" class="btn btn-success">
                                                Simpan
                                            </button>

                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
