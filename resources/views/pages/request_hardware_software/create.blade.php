@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">Request From Ticket</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">{{$requestTickets->usersReq->name}}</h6>
                            <span class="mb-2 text-xs">Permintaan : <span
                                    class="text-dark font-weight-bold ms-sm-2">{{$requestTickets->title}}</span></span>
                            <span class="mb-2 text-xs">Lokasi : <span
                                    class="text-dark ms-sm-2 font-weight-bold">{{$requestTickets->location}}</span></span>
                            <span class="text-xs">Deadline: <span
                                    class="text-dark ms-sm-2 font-weight-bold">{{date('d-m-Y',strtotime($requestTickets->deadline))}}</span></span>
                        </div>
                        <div class="ms-auto text-end">
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" data-bs-toggle="modal"
                                data-bs-target="#deleteModal"><i class="far fa-trash-alt me-2"></i>Delete</a>
                            <!-- <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a> -->
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body mb-2">
                                            <div class="row">
                                                <div class="col-4">
                                                    <i class="fa-solid fa-triangle-exclamation mt-2"
                                                        style="color: #ff0000; font-size: 100px;"></i>
                                                </div>
                                                <div class="col-md-8 text-center">
                                                    <h3>WARNING!!!</h3>
                                                    <small>Pembatalan request hardware atau software</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">Batal</button>
                                            <form action="" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table class="table-responsive">
                    <div class="table table-stiped" id="myTable">
                        <thead>
                            <tr class="text-sm">
                                <th style="padding-left: 0px;">Nama Barang</th>
                                <th style="padding-left: 10px;">Jumlah</th>
                                <th style="padding-left: 10px;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 33%; padding: 0px 10px 0px 0px; margin-top:-50px">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm">
                                    </div>
                                </td>
                                <td style="width: 33%; padding: 10px;">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm">
                                    </div>
                                </td>
                                <td style="width: 33%; padding: 10px;">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <i class="new-button fa-solid fa-circle-plus color-primary fa-lg"></i>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </div>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('.new-button').on('click',function() {
        $('tbody').append("<tr> <td style='width: 33%; padding: 0px 10px 0px 0px; margin-top:-50px'> <div class='form-group'> <input type='text' class='form-control form-control-sm'> </div> </td> <td style='width: 33%; padding: 10px;'> <div class='form-group'> <input type='text' class='form-control form-control-sm'> </div> </td> <td style='width: 33%; padding: 10px;'> <div class='form-group'> <input type='text' class='form-control form-control-sm'> </div> </td> <td> <div class='form-group'> <i class='remove-button fa-solid fa-circle-minus fa-lg' style='color: #ec2727;'></i> </div> </td> </tr>").delay( 800 ).fadeIn( 400 );
    });

    $(document).on('click', '.remove-button', function() {
        // This will work!
        $(this).closest('tr').remove();
    });
</script>
@endsection
