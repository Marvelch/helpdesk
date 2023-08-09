@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            @if ($alert = Session::get('success'))
            <div class="alert alert-success" role="alert" style="font-size: 12px; color: white;">
                <i class="fa-solid fa-bell" style="padding-right: 15px;"></i>{{$alert}}
            </div>
            @endif
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
                                            href="{{route('create_division')}}"><i class="fa-solid fa-book"
                                                style="margin-right: 10px;"></i>
                                            Tambah Divisi</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body m-1">
                    <div class="table-responsive">
                        <table id="myTable" data-order='[[ 0, "desc" ]]' data-page-length='10'
                            class="table table-striped align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs er opacity-7">
                                        ID</th>
                                    <th class="text-uppercase text-secondary text-xxs er opacity-7">
                                        Nama Divisi</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs er opacity-7">
                                        Perusahaan</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs er opacity-7">
                                        Bantuan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs ">{{@$item->id}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs ">{{@Str::ucfirst($item->division)}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs ">{{@$item->company->company}}</span>
                                    </td>
                                    <td class="align-middle text-sm text-center">
                                        <a class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{$item->id}}">
                                            <i class="fa-duotone fa-trash"></i>
                                        </a>
                                        <!-- Modal -->
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
                                                                <small class="mt-2">Konfirmasi permintaan penghapusan data pada Helpdesk</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <form
                                                            action="{{route('destroy_division',['id' => $item->id])}}"
                                                            method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm">Hapus</button>
                                                        </form>
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
