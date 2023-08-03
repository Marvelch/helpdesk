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
                            <h6 class="mb-3 text-sm text-capitalize">{{$requestTickets->usersReq->name}}</h6>
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
                @error('qty')
                    <p class="error__required">* {{ $message }}</p>
                @enderror
                <form action="{{route('store_hardware_software_request_hardware_software')}}" method="post">
                    @csrf
                    <input type="hidden" name="ticketId" value="{{$requestTickets->id}}">
                    @if(!$requestHardwareSoftwares)
                    <table class="table-responsive">
                        <div class="table table-stiped" id="myTable">
                            <thead>
                                <tr style="font-size: 12px;">
                                    <th style="padding-left: 0px;">Nama Barang</th>
                                    <th style="padding-left: 10px;">Jumlah</th>
                                    <th style="padding-left: 10px;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 33%; padding: 0px 10px 0px 0px; margin-top:-50px">
                                        <div class="form-group">
                                            <select name="itemName[]" id="itemName"
                                                class="itemName form-select form-select-sm text-capitalize" required>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width: 33%; padding: 10px;">
                                        <div class="form-group">
                                            <input type="text" name="qty[]" class="form-control form-control-sm" required>
                                        </div>
                                    </td>
                                    <td style="width: 33%; padding: 10px;">
                                        <div class="form-group">
                                            <input type="text" name="description[]" class="form-control form-control-sm">
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
                    @else
                    <small>Pengajuan barang telah dilakukan pada nomor transakai <b>#{{$requestHardwareSoftwares->unique_request}}</b></small>
                    @endif
                    <div class="form-group mt-4">
                        <div class="text-center d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-info w-15 mt-4 mb-0">simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var i = 0;
    $('.new-button').on('click', function () {
        ++i;
        $('tbody').append(
            "<tr> <td style='width: 33%; padding: 0px 10px 0px 0px; margin-top:-50px'> <div class='form-group'> <select name='itemName[]' id='' class='itemName"+i+" form-control form-control-sm' required> </select> </div> </td> <td style='width: 33%; padding: 10px;'> <div class='form-group'> <input name='qty[]' type='text' class='form-control form-control-sm' required> </div> </td> <td style='width: 33%; padding: 10px;'> <div class='form-group'> <input type='text' name='description[]' class='form-control form-control-sm'> </div> </td> <td> <div class='form-group'> <i class='remove-button fa-solid fa-circle-minus fa-lg' style='color: #ec2727;'></i> </div> </td> </tr>"
        ).delay(800).fadeIn(400);
        // $('.itemName' + i + '').select2({
        //     tags: true
        // });
        $('.itemName' + i + '').select2({
            ajax: {
                url: '{{url("/request-hardware-software/searching-inventory")}}',
                dataType: 'json',
                processResults: function ({
                    data
                }) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.item_name
                            }
                        })
                    }
                }
            }
        });
    });

    // $(".itemName").select2({
    //     tags: true
    // });

    $('.itemName').select2({
        ajax: {
            url: '{{url("/request-hardware-software/searching-inventory")}}',
            dataType: 'json',
            processResults: function ({
                data
            }) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.item_name
                        }
                    })
                }
            }
        }
    });

    $(document).on('click', '.remove-button', function () {
        $(this).closest('tr').remove();
    });

</script>
@endsection
