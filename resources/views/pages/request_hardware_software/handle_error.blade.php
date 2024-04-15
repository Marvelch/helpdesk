@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 p-5" style="font-size: 10px; font-family: var(--bs-font-roboto);">
                            <h6>Data Belum Lengkap</h6>
                            <p style="font-size: 10px;" class="text-muted">Bila terdapat error telah pengisian divisi
                                harap hubungi administator helpdesk</p>
                            <form action="{{route('update.division.request.hardware.software')}}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="mt-5">
                                    @if(Auth::user()->division_id == null)
                                    <div class="form-group">
                                        <label for="" style="font-size: 10px; font-family: var(--bs-font-roboto);">PILIH
                                            DIVISI</label>
                                        <select name="division_id" id="" class="form-control form-control-sm w-75">
                                            @foreach($divisionData as $item)
                                            <option value="{{$item->id}}">{{$item->division}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    <div class="form-group d-flex justify-content-end">
                                        <button class="btn btn-sm btn-primary mt-3"
                                            style="margin-right: 170px;">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <img src="https://www.pngitem.com/pimgs/m/164-1646974_error-image-oops-looks-like-the-page-is.png"
                                class="rounded" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
