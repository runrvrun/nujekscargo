<html>
    <head>
        <style type="text/css" media="all">
            @page {
                header: page-header;
                footer: page-footer;
            }
            body{
                font-family: "arial";
                font-size: 10pt;
                text-transform: uppercase;
            }
            h1{
                font-size: 20px;
                font-weight: normal;
                text-align:center;
                margin: 3px;
            }
            table {                
                border-collapse: collapse;
                font-size: 10pt;
            }
            table, th, td {
                border: 1px solid black;
            }
            td{
                padding: 4px 6px;
                vertical-align: top;
                text-align: left;
            }
            header,footer{
                font-size:6px;
            }
        </style>
    </head>
    <body>
    <htmlpageheader name="page-header">
        
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
    PT Nusantara Jaya Ekspress - Manifest: {{ $manifest->no_manifest }} - Hal {PAGENO}/{nb}
    </htmlpagefooter>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <div style="text-align: center">
                <img src="images/logo-nujeks.png" />
            </div>
            <div><h1>CARGO MANIFEST: {{ $manifest->no_manifest }}</h1></div>
            <div><h1>{{ $manifest->title }}</h1></div>
            <p>Tanggal: {{ date('j F Y') }}</p>
            <p>Dibuat oleh: {{ Auth::user()->name }}</p>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>SPB</th>
                        <th>Pengirim</th>
                        <th>Penerima</th>
                        <th>Handling</th>
                    <tr>
                </thead>
                <tbody>
                    @foreach($spb as $key=>$val)
                    <tr>
                        <td style="text-align:right" rowspan="2">{{ $key+1 }}</td>
                        <td rowspan="2">{{ $val->no_spb }}</td>
                        <td>{{ $val->customer }}</td>
                        <td>{{ $val->recipient }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                        <table>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Barang</th>
                                        <th>Koli</th>
                                        <th>Berat</th>
                                        <th>Total Berat</th>
                                        <th>Dimensi</th>
                                        <th>Volume</th>
                                        <th>Packing</th>
                                        <th>PO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($val->items as $keyi=>$vali)
                                <tr>
                                    <td>{{ $keyi+1 }}</td>
                                    <td width="200px">{{ $vali->item }}</td>
                                    <td>{{ $vali->bale }}</td>
                                    <td>{{ $vali->weight }}</td>
                                    <td>{{ $vali->weight*$vali->bale }}</td>
                                    <td>{{ $vali->length.'x'.$vali->width.'x'.$vali->height }}</td>
                                    <td>{{ $vali->length*$vali->width*$vali->height*$vali->bale/1000 }}</td>
                                    <td><{{ $vali->packaging }}/td>
                                    <td>{{ $vali->no_po }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table style="width: 100%;border:none;margin-top:40px;">
                <tr>
                    <td style="text-align:center;border:none">PT NJE Jakarta<br/><br/><br/><br/><br/><br/>Boni Sitohang</td>
                    <td style="text-align:center;border:none">Pengemudi<br/><br/><br/><br/><br/><br/>TTD & Nama Jelas</td>
                    <td style="text-align:center;border:none"><br/><br/><br/><br/><br/><br/>TTD & Nama Jelas</td>
                </tr>
            </table>
        </main>
    </body>
</html>