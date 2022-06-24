<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Invoice</th>
        <th>Pelanggan</th>
        <th>Tanggal Order</th>
        <th>Paket</th>
        <th>Berat</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pemasukan as $masuk)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $masuk->no_invoice }}</td>
            <td>{{ $masuk->Pelanggan->nama }}</td>
            <td>{{ $masuk->tgl_order }}</td>
            <td>{{ $masuk->Paket->nama }}</td>
            <td>{{ $masuk->berat }}</td>
            <td>{{ $masuk->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>