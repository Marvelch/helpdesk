@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- <img src="{{asset('./assets/img/2.png')}}" alt="" srcset="" style="max-width: 100%;"> -->
                        </div>
                        <div class="col-md-8">
                            @if ($alert = Session::get('failed'))
                            <div class="alert alert-primary" role="alert" style="font-size: 12px; color: white;">
                                <i class="fa-solid fa-bell" style="padding-right: 15px;"></i>{{$alert}}
                            </div>
                            @endif
                            @if ($alert = Session::get('success'))
                            <div class="alert alert-info" role="alert" style="font-size: 12px; color: white;">
                                <i class="fa-solid fa-bell" style="padding-right: 15px;"></i>{{$alert}}
                            </div>
                            @endif
                            <form action="{{route('store_division')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Pilih Perusahaan</label>
                                    <select name="company_id" class="form-control form-select-sm" aria-label="example">
                                        @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->company}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Divisi</label>
                                    <div class="mb-3">
                                        <input type="division" name="division" class="form-control form-control-sm"
                                            aria-label="division" aria-describedby="division">
                                    </div>
                                </div>
                                <div class="text-center d-flex justify-content-end">
                                    <button type="submit" class="btn bg-gradient-info w-30 mt-4 mb-0">simpan</button>
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
