@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Input Data Pegawai</h3>
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
                        <a href="{{ route('index.Pegawai') }}">Data Pegawai</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Input Data Pegawai</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-xl-10">
                            <div class="card">

                                <form action="{{ route('store.Pegawai') }}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lengkap Beserta Gelar <span class="text-danger">*</span></label>
                                                <input type="text" name="nama" class="form-control"
                                                    value="{{ old('nama') }}" required>
                                                @error('nama')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>NIP <span class="text-danger">*</span></label>
                                                <input type="text" name="nip" class="form-control"
                                                    value="{{ old('nip') }}" maxlength="18" pattern="[0-9]{1,18}"
                                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                                                @error('nip')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Pangkat/Gol <span class="text-danger">*</span></label>
                                                <select name="pangkat_id" class="form-select" required>
                                                    <option value="">-- Pilih Pangkat/Gol --</option>
                                                    @foreach ($dataPangkat as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->nm_pangkat }}/{{ $item->nm_gol }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jabatan <span class="text-danger">*</span></label>
                                                <textarea name="jabatan" class="form-control" rows="3" required>{{ old('jabatan') }}</textarea>
                                                @error('jabatan')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No HP <span class="text-danger">*</span></label>
                                                <input type="text" name="no_hp" class="form-control"
                                                    value="{{ old('no_hp') }}" maxlength="15"
                                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                                                @error('no_hp')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Email <span class="text-danger">*</span></label>

                                                <input type="email" name="email" class="form-control"
                                                    value="{{ old('email') }}" placeholder="example@gmail.com"
                                                    pattern="[a-zA-Z0-9._%+-]+@gmail\.com"
                                                    title="Format email harus menggunakan @gmail.com, contoh example@gmail.com"
                                                    required>
                                                @error('email')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>No. Urut Hirarki</label>
                                                <input type="number" name="urut_hirarki" class="form-control"
                                                    value="{{ old('urut_hirarki') }}"
                                                    placeholder="Masukkan nomor urut hirarki">
                                                @error('urut_hirarki')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alamat </label>
                                                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                                                @error('alamat')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card-action text-center mt-3">
                                        <a href="{{ route('index.Pegawai') }}" class="btn btn-danger">
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
@endsection

@push('myscript')
    <script>
        $('#togglePassword').click(function() {
            let password = $('#password');
            let icon = $(this).find('i');

            if (password.attr('type') === 'password') {
                password.attr('type', 'text');
                icon.removeClass('fa-eye');
                icon.addClass('fa-eye-slash');
            } else {
                password.attr('type', 'password');
                icon.removeClass('fa-eye-slash');
                icon.addClass('fa-eye');
            }
        });
    </script>
@endpush
