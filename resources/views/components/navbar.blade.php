<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <!-- <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol> -->
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <!-- <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Sign In</span>
              </a>
            </li> -->
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                        <span class="position-absolute translate-middle badge rounded-pill bg-danger"
                            style="font-size: 7px; text-align: center;">
                            <span id='counter__notif'>{{ $countNotif }}</span>
                        </span>
                    </a>
                    <!-- <a type="button" class="btn btn-primary position-relative">
                        Inbox
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            99+
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a> -->
                    <ul class="dropdown-menu pusher-append  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        @foreach($notifList as $item)
                        <li class="mb-2" onclick="">
                            <a class="dropdown-item border-radius-md" href="{{url($item->path)}}">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{asset('./assets/img/icon/alert.webp')}}"
                                            class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold" href="{{url($item->path)}}">Request Ticket
                                                #{{$item->id}}</span> Helpdesk
                                        </h6>
                                        <p class="text-xs text-secondary mb-0 text-sm">
                                            <i class="fa fa-clock me-1"></i>
                                            <?php
                                                $toDate = $item->created_at->diffForHumans(null, true, true, 2);

                                                echo str_replace(['h', 'm', 'd'], [' hours', ' minutes', ' days'], $toDate)." ago ";
                                            ?>
                                            <!-- 13 minutes ago -->
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                        <li>
                             <!-- <hr style="border: 2px solid black; border-radius: 5px;"> -->
                            <div style="background-color: #54b95b; width : 100%; position: fixed; margin-left: -8px; border-radius: 0px 0px 5px 5px;" class="text-center">
                                <a href="{{route('index_notification')}}"><span style="font-size: 12px; color: white;">View All</span></a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
