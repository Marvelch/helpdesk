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

<!-- End Signature  -->
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
                        <div class="col-md-8">
                            <form method="POST" action="{{ route('signature_store', ['unique' => $result->unique]) }}">
                                @csrf
                                <p class="text-muted text-sm">Hi {{$result->full_name}}, thank you for your time.
If your registration is approved, you will get a notification from email or whatsApp which can be used to enter through the guard post. If there is no reply within a few days, please contact us via email : it@sekarbumi.com</p>
                                <div class="col-md-12">
                                    <label for="">Signature : </label>
                                    <br />
                                    <canvas id="sig" class="sig"></canvas>
                                    <br />
                                    <button type="button" id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                    <input type="hidden" id="signatureInput" name="signature">
                                </div>
                                <br />
                                <!-- Custom Signature -->

                                <!-- End Custom Signature -->
                                <div class="form-group d-flex justify-content-end">
                                    <button class="btn btn-success">Submit Reservation</button>
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
    <script src="{{asset('./assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('./assets/js/core/bootstrap.min.js')}}"></script>
    <!-- <script src="{{asset('./js/plugins/perfect-scrollbar.min.js')}}"></script> -->
    <script src="{{asset('./js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script>
        var sig = $('#sig').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
        });

        // Signature Pad initialization
        var signaturePad = new SignaturePad(document.getElementById('sig'), {
        backgroundColor: 'rgba(255, 255, 255, 0)',
        penColor: 'rgb(0, 0, 0)'
        });

        // Form submission event listener
        document.querySelector('form').addEventListener('submit', function (event) {
            // Prevent form submission
            event.preventDefault();

            // Get the signature data URL
            var signatureData = signaturePad.toDataURL();

            // Set the signature data to the hidden input field
            document.getElementById('signatureInput').value = signatureData;

            // Submit the form
            this.submit();
        });

        // Clear signature button event listener
        var clearButton = document.getElementById('clear');
        clearButton.addEventListener('click', function (event) {
            // Clear the signature pad
            signaturePad.clear();
        });
        // End Signature

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
    <script src="{{asset('./assets/js/soft-ui-dashboard.min.js?v=1.0.7')}}"></script>
</body>

</html>
