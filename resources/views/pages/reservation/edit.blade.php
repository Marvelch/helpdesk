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
                            If your registration is approved, you will get a notification from email or whatsApp which
                            can be used to enter through the guard post. If there is no reply within a few days, please
                            contact us via email : it@sekarbumi.com</p>
                        <div class="col-md-12">
                            <label for="">Signature : </label>
                            <br />
                            <div id="sig"></div>
                            <br />
                            <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                            <textarea id="signature64" name="signed" style="display: none;"></textarea>
                        </div>
                        <br />
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
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });

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
