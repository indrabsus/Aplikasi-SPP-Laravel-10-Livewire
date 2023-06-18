<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<table>
    <thead>
    <tr>
        <th>No</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Bulan Tahun</th>
        <th>Makan</th>
        <th>SPP</th>
        <th>Subsidi</th>
        <th>Total</th>
        <th>Tgl Input Bayar</th>
        <th>Tgl Update Bayar</th>
    </tr>
    </thead>
    <tbody>
        <?php $no=1; ?>
    @foreach($data as $d)
        <tr>
            <td>{{$no++}}</td>
            <td>{{ $d->nis }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{$d->nama_kelas}}</td>
            <td>{{$d->bulan}} {{$d->tahun}}</td>
            <td>{{ $d->makan }}</td>
            <td>{{$d->spp}}</td>
            <td>{{$d->subsidi}}</td>
            <td>{{$d->total}}</td>
            <td>{{$d->created_at}}</td>
            <td>{{$d->updated_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>