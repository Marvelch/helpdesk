@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body mb-5">
                    <div class="row justify-content-md-center mt-5">
                        @if ($alert = Session::get('failed'))
                        <div class="alert alert-primary w-80 mb-3" role="alert" style="font-size: 12px; color: white;">
                            <i class="fa-solid fa-bell" style="padding-right: 15px;"></i>{{$alert}}
                        </div>
                        @endif
                        @if ($alert = Session::get('success'))
                        <div class="alert alert-info w-80 mb-3" role="alert" style="font-size: 12px; color: white;">
                            <i class="fa-solid fa-bell" style="padding-right: 15px;"></i>{{$alert}}
                        </div>
                        @endif
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                @if(!$requestTickets->attachment)
                                <div class="card shadow-sm card-blog card-plain">
                                    <div class="position-relative">
                                        <a class="d-block border-radius-xl p-2">
                                            <img src="{{asset('./assets/img/gif/404.gif')}}" alt="img-blur-shadow"
                                                class="img-fluid border-radius-xl" style="width: 100%;">
                                        </a>
                                    </div>
                                </div>
                                @elseif(Str::contains($requestTickets->attachment,['.jpg','.png']))
                                <div class="card shadow-sm" style="width: 18rem;">
                                    <img src="{{asset('storage/'.$requestTickets->attachment)}}" class="card-img-top"
                                        alt="" srcset="" data-action="zoom">
                                    <div class="card-body">
                                        <p class="fw-bold">Request Docs #{{$requestTickets->id}}</p>
                                        <p
                                            style="font-size: 11px; margin-top: -10px; font-family: var(--bs-font-quicksand);">
                                            Terlampir file pendukung laporan</p>
                                        <a class="btn btn-sm w-60 mt-2"
                                            href="{{route('download_bank_accounts',['id' => Crypt::encryptString($requestTickets->attachment)])}}"
                                            {{$requestTickets->attachment ? '': 'disabled'}}
                                            style="margin-bottom: 10px;">download</a>
                                    </div>
                                </div>
                                <!-- <div class="card shadow card-blog card-plain">
                                    <div class="card-body">
                                        <img src="{{asset('storage/'.$requestTickets->attachment)}}"
                                            class="card-img-top" alt="" srcset="" data-action="zoom">
                                        <div class="row mt-3 d-flex justify-content-center">
                                            <hr style="border: 1px solid green;">
                                            <div class="col">
                                                <p class="fw-bold text-sm mt-2">Docs Request #{{@$requestTickets->id}}
                                                </p>
                                            </div>
                                            <div class="col">
                                                <a class="btn btn-sm"
                                                    href="{{route('download_bank_accounts',['id' => Crypt::encryptString($requestTickets->attachment)])}}"
                                                    {{$requestTickets->attachment ? '': 'disabled'}}>download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                @else
                                <div class="card shadow-sm" style="width: 18rem;">
                                    <img src="{{asset('./assets/img/icon/file-loading.gif')}}" class="card-img-top"
                                        alt="" srcset="" data-action="zoom">
                                    <div class="card-body">
                                        <p class="fw-bold">Request Docs #{{$requestTickets->id}}</p>
                                        <p
                                            style="font-size: 11px; margin-top: -10px; font-family: var(--bs-font-quicksand);">
                                            Terlampir file pendukung laporan</p>
                                        <a class="btn btn-sm w-60 mt-2"
                                            href="{{route('download_bank_accounts',['id' => Crypt::encryptString($requestTickets->attachment)])}}"
                                            {{$requestTickets->attachment ? '': 'disabled'}}
                                            style="margin-bottom: 10px;">download</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <!-- <img src="{{asset('./assets/img/3.png')}}" alt="" srcset="" style="max-width: 100%;"> -->
                        </div>
                        <div class="col-md-6 m-2" style="font-size: 12px;">
                            <div class="card shadow-sm">
                                <div class="card-body m-2">
                                    <table class="table table-borderless text-small">
                                        <tr>
                                            <td class="w-40">Permintaan Pengguna</td>
                                            <td>: {{@$requestTickets->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>Perusahaan</td>
                                            <td>: {{$requestTickets->company->company}}</td>
                                        </tr>
                                        <tr>
                                            <td>Devisi</td>
                                            <td>: {{$requestTickets->division->division}}</td>
                                        </tr>
                                        <tr>
                                            <td>Hingga Tanggal</td>
                                            <td>: {{@date('d-m-Y',strtotime($requestTickets->deadline))}}</td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Pekerjaan</td>
                                            <td>: {{@$requestTickets->work_type->type}}</td>
                                        </tr>
                                        <tr>
                                            <td>Lokasi</td>
                                            <td>: {{@$requestTickets->location}}</td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td>: {!! strip_tags($requestTickets->description) !!}</td>
                                        </tr>
                                        @if(@$requestTickets->assignment_on_user_id)
                                        <tr>
                                            <td>Ditugaskan Kepada</td>
                                            <td>: {{Str::ucfirst($requestTickets->usersAss->name)}}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            @if(@Auth::user()->level_id == env('LEVEL_ADMIN') OR
                            @Auth::user()->level_id == env('LEVEL_EDITOR'))
                            <form action="{{route('update_request_ticket',['id' => $requestTickets->id])}}"
                                method="post">
                                @method('PUT')
                                @csrf
                                @if(!$requestTickets->assignment_on_user_id)
                                <div class="form-group mt-4">
                                    <small>Perbaharui status dan assign kepada :</small>
                                    <select name="approvement" class="approvement w-60 mt-3 form-select form-select-sm"
                                        aria-label=".form-select-sm example">
                                        <option value="0" selected>Tidak Diterima</option>
                                        <option value="1">Diterima</option>
                                    </select>
                                </div>
                                @endif
                                @error('assignTo')
                                <p class="error__required">* {{ $message }}</p>
                                @enderror
                                <input type="hidden" name="notification"
                                    value="{{Crypt::encryptString($requestTickets->id)}}">
                                <div class="form-group" id="assignToToggle">
                                    <p style="margin-bottom: 12px; font-size: 11px;">Ditugaskan Kepada :</p>
                                    <select name="assignTo" id="assignTo"
                                        class="form-select assignTo form-select-sm w-60 mt-1 text-capitalize">
                                    </select>
                                </div>
                                @if($requestTickets->status == env('DEFAULT'))
                                <div class="form-group mt-4 d-flex justify-content-end">
                                    <button type="submit"
                                        class="{{$requestTickets->assignment_on_user_id ? 'disabled' : ''}} btn bg-gradient-info w-40 mt-4 mb-0">simpan</button>
                                </div>
                                @endif
                            </form>
                            @endif
                            @if(@$requestTickets->assignment_on_user_id == Auth::user()->id AND
                            @$requestTickets->status
                            == env('INPROGRESS') OR Auth::user()->level_id == env('LEVEL_ADMIN') OR
                            Auth::user()->level_id == env('LEVEL_EDITOR'))
                            @if($requestTickets->status == env('COMPLETED'))
                            <div class="form-group mt-2">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <small class="text-capitalize"><i class="fa-solid fa-bell fa-lg"
                                                style="margin-right: 12px;"></i> permintaan tiket
                                            #{{@$requestTickets->id}} telah selesai</small>
                                    </div>
                                </div>
                            </div>
                            @elseif($requestTickets->status == env('INPROGRESS'))
                            <form action="{{route('update_status_request_ticket',['id' => $requestTickets->id])}}"
                                method="post">
                                @method('PUT')
                                @csrf
                                <!-- 
                                <div class="form-group mt-4 text-capitalize">
                                    <small>Pemintaan untuk <a
                                            href="{{route('create_ticket_request_hardware_software',['id' => Crypt::encryptString($requestTickets->id)])}}"><u>pengadaan
                                                hadware/software</u></a></small>
                                </div>
                                <p style="font-size: 11px; margin-top: 20px; margin-bottom: 5px;">Konfirmasi Status
                                    Permintaan</p>
                                <select name="status" id="" class="form-control form-control-sm w-50">
                                    <option value="{{env('COMPLETED')}}">SELESAI</option>
                                    <option value="{{env('UNCOMPLETED')}}">BATAL</option>
                                </select>
                                <div class="form-group mt-4 d-flex justify-content-end">
                                    <button type="submit" class="btn bg-gradient-info w-40 mt-4 mb-0">simpan</button>
                                </div> -->
                                <div class="form-group mt-3">
                                    <small>Pemintaan untuk <a
                                            href="{{route('create_ticket_request_hardware_software',['id' => Crypt::encryptString($requestTickets->id)])}}"><u>pengadaan
                                                hadware/software</u></a></small>
                                </div>
                                @if(is_null($hardwareSoftware))
                                <div class="form-group mt-3">
                                    <p style="font-size: 11px;">Pilih Status Permintaan</p>
                                    <select name="status" id="" class="form-control form-control-sm w-40">
                                        <option value="{{env('COMPLETED')}}">SELESAI</option>
                                        <option value="{{env('UNCOMPLETED')}}">BATAL</option>
                                    </select>
                                </div>
                                <div class="form-group mt-4 d-flex justify-content-end">
                                    <button type="submit" class="btn bg-gradient-info w-30 mt-4 mb-0">simpan</button>
                                </div>
                                @else
                                @if($itemsRequests->isEmpty())
                                <div class="form-group mt-4 d-flex justify-content-end">
                                    <button class="btn bg-gradient-info w-30 mt-4 mb-0" disabled>Menunggu</button>
                                </div>
                                @else
                                <div class="form-group mt-4 d-flex justify-content-end">
                                    <a class="btn bg-gradient-info w-30 mt-4 mb-0" data-bs-toggle="modal"
                                        href="#exampleModalToggle" role="button">periksa</a>
                                </div>
                                @endif
                                <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                                    aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                    <div class="modal-dialog modal-fullscreen">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" style="color: black;"><i
                                                        class="fa-solid fa-xmark"></i></button>
                                            </div>
                                            <div class="row m-4">
                                                <div class="form-group">
                                                    <p style="font-size: 11px; margin-bottom: 4px;">Pilih Status Permintaan</p>
                                                    <select name="status" id=""
                                                        class="form-control form-control-sm w-20 shadow" style="border-radius: 0px;">
                                                        <option value="{{env('COMPLETED')}}">SELESAI</option>
                                                        <option value="{{env('UNCOMPLETED')}}">BATAL</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table table-responsive">
                                                    <table class="table table-striped">
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th>Nama Barang</th>
                                                                <th>Qty</th>
                                                                <th>Bantuan</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach($itemsRequests as $item)
                                                        <tbody>
                                                            <tr class="text-capitalize">
                                                                <td>
                                                                    {{$item->item_name}}
                                                                    <input type="hidden" name="items_id"
                                                                        value="{{$item->items_id}}">
                                                                    <input type="hidden" name="inventory_unique[]"
                                                                        value="{{$item->inventory_unique}}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" class="form-control form-control-sm text-center" name="qty[]"
                                                                        value="{{$item->qty}}" style="border: none; background-color: transparent;">
                                                                </td>
                                                                <td class="w-30">
                                                                    <div
                                                                        class="form-check form-switch d-flex justify-content-center">
                                                                        <input name="item_use[]"
                                                                            class="form-check-input" type="checkbox"
                                                                            id="flexSwitchCheckDefault"
                                                                            style="font-size: 16px;">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    {{@$item->status == 2 ? '' : 'disabled'}}>simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </form>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('zoom_images')
<script>
    $('#assignToToggle').hide();

    $('.approvement').on('change', function () {
        if ($('.approvement').find(':selected').val() == 1) {
            $('#assignToToggle').show();

            $('.assignTo').select2({
                ajax: {
                    url: '{{url("/request-tickets/searching/users/assign/to")}}',
                    dataType: 'json',
                    processResults: function ({
                        data
                    }) {
                        console.log(data);
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        }
                    }
                }
            });
        } else {
            $('#assignToToggle').hide();
        }
    });

    +
    function ($) {
        "use strict";

        /**
         * The zoom service
         */
        function ZoomService() {
            this._activeZoom =
                this._initialScrollPosition =
                this._initialTouchPosition =
                this._touchMoveListener = null

            this._$document = $(document)
            this._$window = $(window)
            this._$body = $(document.body)

            this._boundClick = $.proxy(this._clickHandler, this)
        }

        ZoomService.prototype.listen = function () {
            this._$body.on('click', '[data-action="zoom"]', $.proxy(this._zoom, this))
        }

        ZoomService.prototype._zoom = function (e) {
            var target = e.target

            if (!target || target.tagName != 'IMG') return

            if (this._$body.hasClass('zoom-overlay-open')) return

            if (e.metaKey || e.ctrlKey) {
                return window.open((e.target.getAttribute('data-original') || e.target.src), '_blank')
            }

            if (target.width >= ($(window).width() - Zoom.OFFSET)) return

            this._activeZoomClose(true)

            this._activeZoom = new Zoom(target)
            this._activeZoom.zoomImage()

            // todo(fat): probably worth throttling this
            this._$window.on('scroll.zoom', $.proxy(this._scrollHandler, this))

            this._$document.on('keyup.zoom', $.proxy(this._keyHandler, this))
            this._$document.on('touchstart.zoom', $.proxy(this._touchStart, this))

            // we use a capturing phase here to prevent unintended js events
            // sadly no useCapture in jquery api (http://bugs.jquery.com/ticket/14953)
            if (document.addEventListener) {
                document.addEventListener('click', this._boundClick, true)
            } else {
                document.attachEvent('onclick', this._boundClick, true)
            }

            if ('bubbles' in e) {
                if (e.bubbles) e.stopPropagation()
            } else {
                // Internet Explorer before version 9
                e.cancelBubble = true
            }
        }

        ZoomService.prototype._activeZoomClose = function (forceDispose) {
            if (!this._activeZoom) return

            if (forceDispose) {
                this._activeZoom.dispose()
            } else {
                this._activeZoom.close()
            }

            this._$window.off('.zoom')
            this._$document.off('.zoom')

            document.removeEventListener('click', this._boundClick, true)

            this._activeZoom = null
        }

        ZoomService.prototype._scrollHandler = function (e) {
            if (this._initialScrollPosition === null) this._initialScrollPosition = $(window).scrollTop()
            var deltaY = this._initialScrollPosition - $(window).scrollTop()
            if (Math.abs(deltaY) >= 40) this._activeZoomClose()
        }

        ZoomService.prototype._keyHandler = function (e) {
            if (e.keyCode == 27) this._activeZoomClose()
        }

        ZoomService.prototype._clickHandler = function (e) {
            if (e.preventDefault) e.preventDefault()
            else event.returnValue = false

            if ('bubbles' in e) {
                if (e.bubbles) e.stopPropagation()
            } else {
                // Internet Explorer before version 9
                e.cancelBubble = true
            }

            this._activeZoomClose()
        }

        ZoomService.prototype._touchStart = function (e) {
            this._initialTouchPosition = e.touches[0].pageY
            $(e.target).on('touchmove.zoom', $.proxy(this._touchMove, this))
        }

        ZoomService.prototype._touchMove = function (e) {
            if (Math.abs(e.touches[0].pageY - this._initialTouchPosition) > 10) {
                this._activeZoomClose()
                $(e.target).off('touchmove.zoom')
            }
        }


        /**
         * The zoom object
         */
        function Zoom(img) {
            this._fullHeight =
                this._fullWidth =
                this._overlay =
                this._targetImageWrap = null

            this._targetImage = img

            this._$body = $(document.body)
        }

        Zoom.OFFSET = 80
        Zoom._MAX_WIDTH = 2560
        Zoom._MAX_HEIGHT = 4096

        Zoom.prototype.zoomImage = function () {
            var img = document.createElement('img')
            img.onload = $.proxy(function () {
                this._fullHeight = Number(img.height)
                this._fullWidth = Number(img.width)
                this._zoomOriginal()
            }, this)
            img.src = this._targetImage.src
        }

        Zoom.prototype._zoomOriginal = function () {
            this._targetImageWrap = document.createElement('div')
            this._targetImageWrap.className = 'zoom-img-wrap'

            this._targetImage.parentNode.insertBefore(this._targetImageWrap, this._targetImage)
            this._targetImageWrap.appendChild(this._targetImage)

            $(this._targetImage)
                .addClass('zoom-img')
                .attr('data-action', 'zoom-out')

            this._overlay = document.createElement('div')
            this._overlay.className = 'zoom-overlay'

            document.body.appendChild(this._overlay)

            this._calculateZoom()
            this._triggerAnimation()
        }

        Zoom.prototype._calculateZoom = function () {
            this._targetImage.offsetWidth // repaint before animating

            var originalFullImageWidth = this._fullWidth
            var originalFullImageHeight = this._fullHeight

            var scrollTop = $(window).scrollTop()

            var maxScaleFactor = originalFullImageWidth / this._targetImage.width

            var viewportHeight = ($(window).height() - Zoom.OFFSET)
            var viewportWidth = ($(window).width() - Zoom.OFFSET)

            var imageAspectRatio = originalFullImageWidth / originalFullImageHeight
            var viewportAspectRatio = viewportWidth / viewportHeight

            if (originalFullImageWidth < viewportWidth && originalFullImageHeight < viewportHeight) {
                this._imgScaleFactor = maxScaleFactor

            } else if (imageAspectRatio < viewportAspectRatio) {
                this._imgScaleFactor = (viewportHeight / originalFullImageHeight) * maxScaleFactor

            } else {
                this._imgScaleFactor = (viewportWidth / originalFullImageWidth) * maxScaleFactor
            }
        }

        Zoom.prototype._triggerAnimation = function () {
            this._targetImage.offsetWidth // repaint before animating

            var imageOffset = $(this._targetImage).offset()
            var scrollTop = $(window).scrollTop()

            var viewportY = scrollTop + ($(window).height() / 2)
            var viewportX = ($(window).width() / 2)

            var imageCenterY = imageOffset.top + (this._targetImage.height / 2)
            var imageCenterX = imageOffset.left + (this._targetImage.width / 2)

            this._translateY = viewportY - imageCenterY
            this._translateX = viewportX - imageCenterX

            var targetTransform = 'scale(' + this._imgScaleFactor + ')'
            var imageWrapTransform = 'translate(' + this._translateX + 'px, ' + this._translateY + 'px)'

            if ($.support.transition) {
                imageWrapTransform += ' translateZ(0)'
            }

            $(this._targetImage)
                .css({
                    '-webkit-transform': targetTransform,
                    '-ms-transform': targetTransform,
                    'transform': targetTransform
                })

            $(this._targetImageWrap)
                .css({
                    '-webkit-transform': imageWrapTransform,
                    '-ms-transform': imageWrapTransform,
                    'transform': imageWrapTransform
                })

            this._$body.addClass('zoom-overlay-open')
        }

        Zoom.prototype.close = function () {
            this._$body
                .removeClass('zoom-overlay-open')
                .addClass('zoom-overlay-transitioning')

            // we use setStyle here so that the correct vender prefix for transform is used
            $(this._targetImage)
                .css({
                    '-webkit-transform': '',
                    '-ms-transform': '',
                    'transform': ''
                })

            $(this._targetImageWrap)
                .css({
                    '-webkit-transform': '',
                    '-ms-transform': '',
                    'transform': ''
                })

            if (!$.support.transition) {
                return this.dispose()
            }

            $(this._targetImage)
                .one($.support.transition.end, $.proxy(this.dispose, this))
                .emulateTransitionEnd(300)
        }

        Zoom.prototype.dispose = function () {
            if (this._targetImageWrap && this._targetImageWrap.parentNode) {
                $(this._targetImage)
                    .removeClass('zoom-img')
                    .attr('data-action', 'zoom')

                this._targetImageWrap.parentNode.replaceChild(this._targetImage, this._targetImageWrap)
                this._overlay.parentNode.removeChild(this._overlay)

                this._$body.removeClass('zoom-overlay-transitioning')
            }
        }

        // wait for dom ready (incase script included before body)
        $(function () {
            new ZoomService().listen()
        })

    }(jQuery)

</script>
@endpush
@endsection
