<!--
=========================================================
* Soft UI Dashboard - v1.0.7
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

@include('components.head')

<body class="">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                <nav
                    class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid pe-0">
                        <a class="navbar-brand font-weight-bolder " href="{{url('/')}}">
                            Reservation Online
                        </a>
                        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon mt-2">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </span>
                        </button>
                        <div class="collapse navbar-collapse d-flex justify-content-end" id="navigation">
                            <!-- <ul class="navbar-nav mx-auto ms-xl-auto me-xl-7">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="../pages/dashboard.html">
                    <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                    Dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="../pages/profile.html">
                    <i class="fa fa-user opacity-6 text-dark me-1"></i>
                    Profile
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="../pages/sign-up.html">
                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                    Sign Up
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="../pages/sign-in.html">
                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                    Sign In
                  </a>
                </li>
              </ul> -->
                            <!-- <li class="nav-item d-flex align-items-center">
                                <a class="btn btn-round btn-sm mb-0 btn-outline-primary me-2" target="_blank"
                                    href="https://www.creative-tim.com/builder?ref=navbar-soft-ui-dashboard">Online
                                    Builder</a>
                            </li> -->
                            <ul class="navbar-nav d-lg-block d-none">
                                <li class="nav-item">
                                    <a class="btn btn-sm btn-round mb-0 me-1 bg-gradient-dark" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">Baca Penggunaan</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-45 mobile-header">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <!-- <div class="col-md-4 d-flex justify-content-center">
                            <img src="{{asset('/assets/reservation.png')}}" class="reservation-img" alt="" srcset="">
                        </div> -->
                        <div class="col-md-8">
                            <form action="{{route('reservation_store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Full Name</label>
                                            <input name="full_name" type="text" class="form-control text-capitalize"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Company/Organization</label>
                                            <input name="company" type="text" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">How many individuals</label>
                                            <input name="total_visitor" type="number" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Full names of all individuals</label>
                                            <input name="visitor_name" type="text" class="form-control text-capitalize" required>
                                            <p style="font-size: 10px;" class="text-muted mt-1">Please provide the full names
                                                of all
                                                individuals traveling with you. (Indicate "N/a" if you are travelling
                                                alone)</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Purpose of Visit</label>
                                            <select name="purpose_of_visit" id="" class="form-control" required>
                                                <option value="Business Meeting">Business Meeting</option>
                                                <option value="Interview">Interview</option>
                                                <option value="Inspection / Audit">Inspection / Audit</option>
                                                <option value="Event Attendance">Event Attendance</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Date of Visit</label>
                                            <input name="visit_date" type="date" class="form-control"
                                                value="{{date('Y-m-d',strtotime(now()))}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Expected Arrival Time</label>
                                            <input name="expected_arrival_time" type="time" class="form-control"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Want to meet</label>
                                            <select name="employee" class="js-data-example-ajax w-100"></select>
                                            <input type="hidden" name="companyEmployee" id="companyEmployeeInput">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Mobile (Whatsapp)</label>
                                            <input name="phone" type="number" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="from-group d-flex justify-content-end pt-3">
                                    <button type="submit" class="btn btn-primary">Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-sm">
                        Thank you for choosing to visit us. To ensure a smooth and secure experience, we kindly ask you
                        to
                        complete the following visitor registration form. Your cooperation is greatly appreciated.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <!-- <div class="col-8 mx-auto text-center mt-1">
          <small class="mb-0 text-secondary">
            Copyright ©
            <script>
              document.write(new Date().getFullYear())
            </script>
            - IT Devision.
          </small>
        </div> -->
            </div>
        </div>
    </footer>
    <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        $('.js-data-example-ajax').select2({
            ajax: {
                url: 'http://10.10.30.14:1024/api/reservation',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.code,
                                text: item.name + ' - ' + item.company,
                                companyEmployee: item.company
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 3,
        }).on('change', function (e) {
            var selectedOption = $(this).select2('data')[0];
            $('#companyEmployeeInput').val(selectedOption.companyEmployee);
        });

        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>
