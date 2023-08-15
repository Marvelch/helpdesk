@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="col-12 mt-4">
                        <div class="card-header pb-0 p-2">
                            <h5 class="mb-1">General Access</h5>
                            <small class="text-sm">Pengelolaan menu bantuan dari setiap fitur pada helpdesk</small>
                        </div>
                        <div class="table table-responsive mt-5">
                            <table class="table text-small table-striped">
                                <tbody class="m-3" style="font-size: 12px;">
                                    <tr>
                                        <td class="w-95 p-3 fw-bold">Pengelolaan Divisi</td>
                                        <td class="text-center"><a href="{{route('index_division')}}"><i class="fa-solid fa-arrow-up-right-from-square" style="margin-top:35%;"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td class="w-95 p-3 fw-bold">Pengelolaan Jenis Pekerjaan</td>
                                        <td class="text-center"><a href="{{route('index_type')}}"><i class="fa-solid fa-arrow-up-right-from-square" style="margin-top:35%;"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td class="w-95 p-3 fw-bold">Hak Akses Pengguna Helpdesk</td>
                                        <td class="text-center"><a data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-arrow-up-right-from-square" style="margin-top:35%;"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-uppercase text-small text-center">
        <h4>BELUM TERSEDIA</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection
