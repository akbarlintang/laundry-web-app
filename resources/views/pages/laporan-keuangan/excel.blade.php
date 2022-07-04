<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Pemasukan</th>
        <th>Pengeluaran</th>
        <th>Keuntungan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($query as $key => $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ date('d F Y', strtotime($item['tgl'])) }}</td>
            <td>Rp {{ isset($item['masuk']) ? number_format($item['masuk']) : '0'  }}</td>
            <td>Rp {{ isset($item['keluar']) ? number_format($item['keluar']) : '0'  }}</td>

            @php
                $total = 0;
                if(isset($item['masuk']) && isset($item['keluar'])){
                    $total += ($item['masuk'] - $item['keluar']);
                } elseif (isset($item['masuk'])) {
                    $total += $item['masuk'];
                } elseif (isset($item['keluar'])) {
                    $total -= $item['keluar'];
                }
            @endphp
            <td>{{ $total < 0 ? '-' : '+' }} Rp {{ number_format(abs($total)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>