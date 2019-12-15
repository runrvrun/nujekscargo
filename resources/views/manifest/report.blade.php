<html>
    <head>
        <style type="text/css" media="all">
            @page {
                header: page-header;
                footer: page-footer;
            }
            body{
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
        <?php $totalweight = $totalbale = $totalvolume =0; ?>
            <div style="text-align: center">
                <img src="images/logo-nujeks.png" />
            </div>
            <div><h1>CARGO MANIFEST: {{ $manifest->no_manifest }}</h1></div>
            <div><h1>{{ $manifest->title }}</h1></div>
            <table style="width:100%;border:none">
                <tr style="border:none"><td style="border:none">Tanggal: {{ date('j F Y') }}</td><td style="text-align:right;border:none">Dibuat oleh: {{ Auth::user()->name }}</td></tr>
            </table>
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
                                <?php
                                    $totalweight += $vali->bale*$vali->weight;
                                    $totalbale += $vali->bale;
                                    $totalvolume += $vali->length*$vali->width*$vali->height*$vali->bale/1000;
                                ?>
                                <tr>
                                    <td>{{ $keyi+1 }}</td>
                                    <td width="200px">{{ $vali->item }}</td>
                                    <td style="text-align:right">{{ $vali->bale }}</td>
                                    <td style="text-align:right">{{ $vali->weight }}</td>
                                    <td style="text-align:right">{{ $vali->weight*$vali->bale }}</td>
                                    <td style="text-align:right">{{ $vali->length.'x'.$vali->width.'x'.$vali->height }}</td>
                                    <td style="text-align:right">{{ number_format(($vali->length*$vali->width*$vali->height*$vali->bale/1000),3,',','.') }}</td>
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
            <br>
            <table style="width:30%">
                <tr><td>Total Berat</td><td style="text-align:right">{{ number_format($totalweight,0,',','.') }}</td></tr>
                <tr><td>Total Koli</td><td style="text-align:right">{{ number_format($totalbale,0,',','.') }}</td></tr>
                <tr><td>Total Volume</td><td style="text-align:right">{{ number_format($totalvolume,3,',','.') }}</td></tr>
            </table>
            <table style="width: 100%;border:none;margin-top:40px;">
                <tr>
                    <td style="text-align:center">PT NJE Jakarta<br/><br/><br/><br/><br/><br/>{{ $manifest->name }}</td>
                    <td style="text-align:center">Pengemudi<br/><br/><br/><br/><br/><br/>TTD & Nama Jelas</td>
                    <td style="text-align:center"><br/><br/><br/><br/><br/><br/>TTD & Nama Jelas</td>
                </tr>
            </table>
        </main>
    </body>
</html>