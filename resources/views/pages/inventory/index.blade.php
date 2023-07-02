@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="my-auto text-end">
                            <div class="dropdown float-lg-end pe-4">
                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-secondary"></i>
                                </a>
                                <ul class="ticket__tables dropdown-menu px-2 py-3 ms-sm-n4 ms-n5"
                                    aria-labelledby="dropdownTable" style="font-family: var(--bs-font-roboto);">
                                    <li><a class="dropdown-item border-radius-md small"
                                            href="{{route('create_inventory')}}"><i
                                                class="fa-light fa-boxes-stacked"
                                                style="margin-right: 10px;"></i>
                                            Tambah Master</a></li>
                                    <li><a class="dropdown-item border-radius-md small"
                                            href="{{route('create_transaction_inventory')}}"><i
                                                class="fa-light fa-bag-shopping"
                                                style="margin-right: 13px;"></i>
                                            Pengelolaan Stok</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-responsive-sm">
                        <table id="myTable" data-order='[[ 1, "asc" ]]' data-page-length='10'
                            class="display table-striped table-hover">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Barang</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Stok</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kode</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Keterangan
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inventorys as $item)
                                <tr>
                                    <td class="align-middle small">
                                        <span class="text-xs font-weight-bold text-capitalize">{{@$item->item_name}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{@$item->stock}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{@$item->inventory_unique}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{@$item->description}}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <a href="{{route('show_inventory',['id' => Crypt::encryptString($item->inventory_unique)])}}"
                                            class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                            data-original-title="Edit user">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <a class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{$item->id}}">
                                            <i class="fa-duotone fa-trash"></i>
                                        </a>
                                        <div class="modal fade" id="deleteModal{{$item->id}}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                @if($item->stock <= 0)
                                                                <small>Penghapusan diperbolehkan karena belum memiliki stok pada inventori barang</small>
                                                                @else
                                                                <small>Penghapusan tidak diperbolehkan apabila barang memiliki stok pada inventori</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        @if($item->stock <= 0)
                                                            <form
                                                            action="{{route('destroy_bank_accounts',['id' => $item->id])}}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm">Hapus</button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            select: true,
            // info: false,
            // lengthChange: false,
            "oLanguage": {
                "sSearch": " "
            },
        });
    });
</script>
@endsection
