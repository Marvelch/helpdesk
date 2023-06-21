@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-8">
                    <form action="{{route('store_type_of_work')}}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success d-flex align-items-center text-light">
                            <i class="fa-regular fa-circle-check m-1"></i>
                            <div>
                                <small>{{ $message }}</small>
                            </div>
                        </div>
                        @endif
                        @if ($message = Session::get('failed'))
                        <div class="alert alert-info d-flex align-items-center text-light">
                            <i class="fa-regular fa-circle-check m-1"></i>
                            <div>
                                <small>{{ $message }}</small>
                            </div>
                        </div>
                        @endif
                        @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger d-flex align-items-center text-light"><small>
                                {{ $error }}
                            </small></div>
                        @endforeach
                        @endif
                        <div class="alert alert-info d-flex align-items-center text-light" role="alert">
                            <i class="fa-solid fa-lightbulb m-1"></i>
                            <div>
                                <small style="margin-left: 10px;">Perhatikan penginputan pada master, pastikan
                                    pengecekan terlebih dahulu</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <!-- kosong -->
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="">Nama Jenis Pekerjaan</label>
                                <input name="typeofwork" type="text" class="form-control form-control-sm"
                                    autocomplete="off">
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-end">
                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn bg-gradient-info w-100 mt-4 mb-0">simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
