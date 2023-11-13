<!DOCTYPE html>
<html>
<body>
<table>
    <thead>
    <tr>
        <th>Tanggal</th>
        <th>Masalah</th>
        <th>Keterangan</th>
        <th>PIC</th>
        <th>Status</th>
        <th>Kategori</th>
    </tr>
    </thead>
    <tbody>
    @foreach($requestTickets as $item)
        <tr>
            <td>{{@date('d-m-Y',strtotime($item->created_at))}}</td>
            <td>{{@$item->title}}</td>
            <td>{{@$item->description}}</td>
            <td>{{@$item->usersAss->name}}</td>
            <td>
                @if($item->status == 0)
                    Menunggu
                @elseif($item->status == 1)
                    Diproses
                @elseif($item->status == 2)
                    Selesai
                @elseif($item->status == 3)
                    Ditolak
                @endif
            </td>
            <td>{{@$item->work_type->type}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
