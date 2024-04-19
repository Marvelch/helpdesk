@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mt-4">
                <div class="card-body d-flex justify-content-center">
                    <div class="col-md-8 mt-5">
                        <form method="POST" action="{{ route('reservation_update', ['id' => $results->unique]) }}">
                            @method('PUT')
                            @csrf
                            <p class="text-muted text-sm">Hi {{Auth::user()->name}}, thank you for your time.
                                If your registration is approved, you will get a notification from email or whatsApp
                                which
                                can be used to enter through the guard post. If there is no reply within a few days,
                                please
                                contact us via email : it@sekarbumi.com</p>
                            <div class="col-md-12">
                                <label for="">Signature : </label>
                                <br />
                                <canvas id="sig" class="sig" style="border-radius: 10px;"></canvas>
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
    </div>
</div>
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
