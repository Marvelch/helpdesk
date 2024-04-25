<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Visitor Logbook</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            font-size : 12px;
        }

        .container {
            width: 100%;
            padding-right: 5%;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-header {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .form-row {
            display: flex;
            margin-bottom: 10px;
        }

        .form-row label {
            width: 150px;
            text-align: right;
        }

        .form-row input[type="text"] {
            width: 100%;
        }

        .form-row textarea {
            width: 100%;
            height: 100px;
            resize: none;
        }

        .form-signature {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .form-signature label {
            width: 150px;
            text-align: right;
        }

        .form-signature input[type="text"] {
            width: 33%;
        }

        .form-signature input[type="text"]:first-child {
            margin-right: 20px;
        }

        * {
        box-sizing: border-box;
        }

        /* Create two equal columns that floats next to each other */
        .column {
        float: left;
        width: 33%;
        padding: 8px;
        }

        .column-50 {
            float: left;
            width: 50%;
            padding: 5px 11px 5px 11px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .content-center {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-weight: bold;
        }

        .border {
            border: 1px solid black;
        }

        table {
            margin-top: 4%;
            width: 60%;
        }

        </style>
        </head>
        <body>
        <div class="container">
            <div class="row">
                <div class="column border">
                    <img src="https://assets.tracegains.net/suppliers/b56287d7-1f50-4f57-880c-38b998cd4331/logos/688e9665-c927-497d-a9e1-f533987e08a9.jpg" style="width: 37%;"
                </div>
                <div class="column content-center border">
                    <p>FORM KUNJUNGAN TAMU</p>
                </div>
                <div class="column content-center border">
                    <p>{{$data->unique}}</p>
                </div>
            </div>
            <table>
            <tr>
                <td style="padding-bottom: 8px;">Hari / Tanggal</td>
                <td style="padding-bottom: 8px;">: {{date('d-m-Y',strtotime(@$data->visit_date))}}</td>
            </tr>
            <tr>
                <td style="padding-bottom: 8px;">Nama</td>
                <td style="padding-bottom: 8px;">: {{ucwords(@$data->full_name)}}</td>
            </tr>
            <tr>
                <td style="padding-bottom: 8px;">Instansi</td>
                <td style="padding-bottom: 8px;">: {{ucwords(@$data->company)}}<</td>
            </tr>
            <tr>
                <td style="padding-bottom: 8px;">Jabatan</td>
                <td style="padding-bottom: 8px;">: -</td>
            </tr>
            <tr>
                <td style="padding-bottom: 8px;">Bertemu</td>
                <td style="padding-bottom: 8px;">: {{ucwords(strtolower(@$data->employee_name))}}</td>
            </tr>
            <tr>
                <td style="padding-bottom: 8px;">Maksud Kunjungan</td>
                <td style="padding-bottom: 8px;">: {{ucwords(@$data->purpose_of_visit)}}</td>
            </tr>
            <tr>
                <td style="padding-bottom: 8px;">Sudah Janji / Belum</td>
                <td style="padding-bottom: 8px;">: {{@$data->signature_employee == null ? "Belum" : "Sudah Buat Janji";}}</td>
            </tr>
            </table>
            <div class="row" style="margin-top: 3%;">
                <div class="column-50 content-center border">
                    <p>PARAF TAMU</p>
                </div>
                <div class="column-50 content-center border">
                    <p>PARAF - YANG DIKUNJUNGI</p>
                </div>
            </div>
            <div class="row" style="margin-top: -1;">
                <div class="column-50 content-center border">
                    @if($data->signature_visitor)
                    <img src="{{ public_path("storage/".$data->signature_visitor) }}" style="width: 100%; height: 70px;">
                    @else
                        <p>TIDAK TERSEDIA</p>
                    @endif
                </div>
                <div class="column-50 content-center border">
                    @if($data->signature_employee)
                    <img src="{{ public_path("storage/".$data->signature_employee) }}" style="width: 100%; height: 70px;">
                    @else
                        <p>TIDAK TERSEDIA</p>
                    @endif
                </div>
            </div>
            <br>
            <p>CATATAN UNTUK PETUGAS KEAMANAN</p>
            <div class="row">
                <div class="column content-center border">
                    <p>JAM MASUK</p>
                </div>
                <div class="column content-center border">
                    <p>JAM KELUAR</p>
                </div>
                <div class="column content-center border">
                    <p>PARAF PETUGAS</p>
                </div>
            </div>
            <div class="row" style="margin-top: -1;">
                <div class="column content-center border">
                    <p>{{@$data->in}}</p>
                </div>
                <div class="column content-center border">
                    <p>{{@$data->out}}</p>
                </div>
                <div class="column content-center border">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/04/Giang_%C6%A0i_signature.png/480px-Giang_%C6%A0i_signature.png" style="width: 100%; height: 38px;">
                </div>
            </div>
        </div>
        </body>
        </html>
