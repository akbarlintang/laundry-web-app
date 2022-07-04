<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Milla Laundry</title>
    <style>
        body {
            margin: -40px;
            font-family: Arial, Helvetica, sans-serif;
        }
        
        .f20 {
            font-size: 20px;
        }

        .f14 {
            font-size: 14px;
        }

        .f12 {
            font-size: 12px;
        }

        .f10 {
            font-size: 10px;
        }

        .page-break {
            page-break-after: always;
            page-break-inside:avoid;
        }

        footer {
            position: fixed; 
            bottom: 0cm; 
            left: 0cm; 
            right: 0cm;
            height: 0.5cm;

            /** Extra personal styles **/
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- HALAMAN 1 GAN -->
    <div style="margin: 2em;">
        <table style="border: 0px solid black; width: 100%; border-collapse: collapse;" class="f12">
            <thead>
                <tr>
                    <th colspan="6" style="padding-top: 30px; padding-bottom: 30px;"><div class="f20">INVOICE MILLA LAUNDRY & DRY CLEANING</div></th>
                </tr>
                {{-- <tr>
                    <th colspan="6" style="padding-bottom: 30px;"><div class="f14">No. Invoice : {{ $transaksi->no_invoice }}</div></th>
                </tr> --}}
            </thead>
            <tbody>
                <tr class="f12">
                    <td colspan="6" style="">
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px; width: 30%;">
                                        No. Invoice
                                    </td>
                                    <td style="padding: 10px; width: 5%;">:</td>
                                    <td style="padding: 10px;">
                                        {{ $transaksi->no_invoice }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; width: 30%;">
                                        Tanggal Laundry
                                    </td>
                                    <td style="padding: 10px; width: 5%;">:</td>
                                    <td style="padding: 10px;">
                                        {{ date('d F Y', strtotime($transaksi->tgl_order)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; width: 30%;">
                                        Nama Pelanggan
                                    </td>
                                    <td style="padding: 10px; width: 5%;">:</td>
                                    <td style="padding: 10px;">
                                        {{ $transaksi->Pelanggan->nama }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; width: 30%;">
                                        No. Telp
                                    </td>
                                    <td style="padding: 10px; width: 5%;">:</td>
                                    <td style="padding: 10px;">
                                        {{ $transaksi->Pelanggan->no_hp }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; width: 30%;">
                                        Alamat
                                    </td>
                                    <td style="padding: 10px; width: 5%;">:</td>
                                    <td style="padding: 10px;">
                                        {{ $transaksi->Pelanggan->alamat }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; width: 30%;">
                                        Paket
                                    </td>
                                    <td style="padding: 10px; width: 5%;">:</td>
                                    <td style="padding: 10px;">
                                        {{ $transaksi->Paket->nama }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; width: 30%;">
                                        Berat
                                    </td>
                                    <td style="padding: 10px; width: 5%;">:</td>
                                    <td style="padding: 10px;">
                                        {{ $transaksi->berat }} Kg
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; width: 30%;">
                                        Tanggal Estimasi Selesai
                                    </td>
                                    <td style="padding: 10px; width: 5%;">:</td>
                                    <td style="padding: 10px;">
                                        {{ date('d F Y', strtotime($transaksi->tgl_selesai)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; width: 30%;">
                                        Status Pembayaran
                                    </td>
                                    <td style="padding: 10px; width: 5%;">:</td>
                                    <td style="padding: 10px;">
                                        {{ ucwords(str_replace('-', ' ', $transaksi->pembayaran)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; width: 30%;">
                                        Total Harga
                                    </td>
                                    <td style="padding: 10px; width: 5%;">:</td>
                                    <td style="padding: 10px;">
                                        Rp {{ number_format($transaksi->total) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="font-weight: bold; text-align: center; padding-top: 30px; padding-bottom: 20px;" class="f12">Daftar Cucian</td>
                </tr>
                <tr class="f12">
                    <td colspan="6" style="border: 1px solid black; padding: 20px;">
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Jenis Pakaian</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($transaksi->jenis)
                                    @foreach ($transaksi->jenis as $item)
                                        <tr>
                                            <td style="padding: 5px 10px; width: 70%; text-align: left;">
                                                {{ $item->nama }}
                                            </td>
                                            <td style="padding: 5px 10px; text-align: center;">
                                                {{ $item->jumlah }} pcs
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <footer class="f10">
        Anda dapat cek progress transaksi dengan nomor invoice melalui www.millalaundry.id
    </footer>
</body>

</html>
