@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{route('result_report_request_ticket')}}" method="post">
                                @csrf
                                <div class="d-flex bd-highlight mb-3 d-grid gap-3">
                                    <div class="form-group">
                                        <label for="">Dari Tanggal</label>
                                        <input name="start_date" type="date" class="form-control form-control-sm"
                                            value="{{date('Y-m-d',strtotime(now()))}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Hingga Tanggal</label>
                                        <input name="end_date" type="date" class="form-control form-control-sm"
                                            value="{{date('Y-m-d',strtotime(now()))}}">
                                    </div>
                                    <div class="ms-auto">
                                        <div class="ms-auto">
                                        <div class="form-group">
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary btn-sm"><span
                                                        style="margin-left: 4px;">Cari</span></button>
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
    </div>
</div>
</div>
<script>

</script>
@endsection
