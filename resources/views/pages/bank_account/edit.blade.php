@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="{{url('/bank-accounts/'.$item->user_id.'/update')}}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="">Pilih Pengguna</label>
                                    <select name="user_id" class="form-select" aria-label=".form-select-sm example">
                                        @foreach($item_users as $item_user)    
                                        <option value="{{$item->user_id}}" @selected($item->user_id == $item_user->id)>{{$item_user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Anydesk</label>
                                    <div class="mb-3">
                                        <input type="anydesk" name="anydesk" class="form-control" aria-label="anydesk"
                                            aria-describedby="anydesk" value="{{$item->anydesk}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>IP Address</label>
                                    <div class="mb-3">
                                        <input type="text" name='ipaddress' class="form-control" aria-label="ipaddress"
                                            aria-describedby="ipaddress" value="{{$item->ip_address}}">
                                    </div>
                                </div>
                                <div class="text-center col-md-3">
                                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">perbaharui</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <img src="{{asset('./assets/img/vector-add.png')}}" alt="" srcset=""
                                style="max-width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
