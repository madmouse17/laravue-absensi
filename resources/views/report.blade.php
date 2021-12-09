<!DOCTYPE html>
<html lang="en">

<head>
    <title>Report</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @foreach ($data as $e)

    <div class="d-flex flex-column mb-3 align-items-end">
        <div class="p-2">Nama Karyawan = {{ $e['karyawan'] }}</div>
    </div>
    <div class="p-2">Jabatan = {{ $e['jabatan'] }}</div>
    <div class="p-2">Gaji = {{ $e['gaji'] }}</div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Jabatan</th>
                <th>Tanggal</th>
                <th>Masuk</th>
                <th>Ijin</th>
                <th>Pulang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($e['employee'] as $employee)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $employee->employe->position->name}}</td>
                <td>{{ $employee->attended_at }}</td>
                <td @if ($employee->in ==null )
                    bgcolor="red"
                    @endif>{{ $employee->in }}</td>
                @if ($employee->permission != null)
                <td>Ijin</td>
                @else
                <td bgcolor="red"></td>
                @endif
                <td @if ($employee->out ==null )
                    bgcolor="red"
                    @endif>{{ $employee->out }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    Jumlah Masuk = {{ $e['masuk'] }}
    Jumlah Ijin = {{ $e['ijin'] }}
    Total Gaji = {{ ($e['masuk']+$e['ijin'])*$e['gaji'] }}
    <div class="page-break"></div>
    @endforeach
</body>

</html>