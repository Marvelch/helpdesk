@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card" style="z-index: 1; font-family: var(--bs-font-roboto);">
                <div class="card-body">
                    <form action="{{route('store_news')}}" method="post" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center mt-5 mb-5">
                            <div class="col-8" style="z-index: 3;">
                                <div class="form-group">
                                    <label for="">Judul  </label>
                                    <input name="title" type="text" class="form-control form-control-sm "
                                        value="{{old('name')}}">
                                    @error('name')
                                    <p class="error__required">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Isi Berita</label>
                                    <textarea style="font-size: 10px;" name="article">
                                    </textarea>
                                    @error('email')
                                    <p class="error__required">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
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
@push('custom-scripts')
<script>
    tinymce.init({
        selector: 'textarea',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        content_style: "body { font-size: 12px; }",
    });
</script>
@endpush
@endsection
