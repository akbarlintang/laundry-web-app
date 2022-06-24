<table>
    <thead>
    <tr>
        <th style="width: 50px;">No</th>
        <th style="width: 50px;">Tanggal</th>
        <th style="width: 50px;">Total</th>
        <th style="width: 50px;">Keterangan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pengeluaran as $keluar)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $keluar->tgl_pengeluaran }}</td>
            <td>{{ $keluar->total }}</td>
            <td>{{ $keluar->keterangan }}</td>
        </tr>
    @endforeach
    </tbody>
</table>