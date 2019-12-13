<html>
    <head>
        <style type="text/css" media="all">
            @page {
                header: page-header;
                footer: page-footer;
            }
            body{
                /* font-family: "Avant Garde"; */
                font-family: "Rubik", "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                font-size: 10pt;
                font-weight: 100;
                text-transform: uppercase;
            }
            h1{
                font-size: 20px;
                font-weight: normal;
                text-align:center;
                margin: 3px;
            }
            table {             
                width: 100%;   
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
            .termcondition{
                font-size: 11px;
            }
            .title, .title tr, .title td{
                border:none;
            }
            .title tr td, .signature tr td{
                text-align:center;
                vertical-align:middle;
            }
            h2, h3, h4{
                font-weight: normal;
            }
            .sender, .item, .termcondition, .made, .signature{
                margin-top:20px;
            }
            .signature, .signature tr, .signature td, .sender, .sender tr, .sender td{
                border:none;
            }
        </style>
    </head>
    <body>
    <htmlpageheader name="page-header">
        
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
    PT Nusantara Jaya Ekspress - SPB: {{ $spb->no_spb }} - Hal {PAGENO}/{nb}
    </htmlpagefooter>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table class="title">
                <tr>
                    <td style="width:50%">
                        <div style="text-align: center;">
                            <img src="images/logo-nujeks.png" />
                        </div><br/>
                        <h2>PT NUSANTARA JAYA EKSPRESS</h2>
                        <p>{{ $userbranch->address }}</p>
                        <p>No.Telp : {{ $userbranch->phone }}</p>
                        <p>No.Fax : {{ $userbranch->fax }}</p>
                        <p>Website : http://www.nujeks.com</p>
                        <p>Email : {{ $userbranch->email }} {{ $userbranch->email_acc}}</p>
                    </td>
                    <td style="width:50%">
                        <h1>{{ $spb->no_spb }}</h1>
                        <h3>EKSPEDISI PERKEBUNAN DAN PROJECT CARGO SUMATERA JAWA KALIMANTAN SULAWESI PAPUA</h3>
                    </td>
                </tr>
            </table>
            <table class="sender">
                <tr>
                    <td style="width:40%">
                        <table><tr><td style="height: 120px">
                            <h3>PENGIRIM</h3>
                            <p>{{ $spb->customer }}</p>
                            <p>{{ $spb->cust_address }}</p>
                        </td></tr></table>
                    </td>
                    <td style="width:20%"></td>
                    <td style="width:40%">
                        <table><tr><td style="height: 120px">
                            <h3>PENERIMA</h3>
                            <p>{{ $spb->recipient }}</p>
                            <p>{{ $spb->address }}</p>
                        </td></tr></table>
                    </td>
                </tr>
            </table>
            <div></div>
            <table class="item">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA BARANG</th>
                        <th>KOLI</th>
                        <th>BERAT</th>
                        <th>T.BERAT</th>
                        <th>DIMENSI</th>
                        <th>VOL</th>
                        <th>PACKING/KETERANGAN</th>
                        <th>NO.PO</th>
                    <tr>
                </thead>
                <tbody>
                    @foreach($spb->items as $key=>$val)
                    <tr>
                        <td style="text-align:right">{{ $key+1 }}</td>
                        <td>{{ $val->item }}</td>
                        <td>{{ $val->bale }}</td>
                        <td>{{ $val->weight }}</td>
                        <td>{{ $val->weight*$val->bale }}</td>
                        <td>{{ $val->length.'X'.$val->width.'X'.$val->height }}</td>
                        <td>{{ $val->length*$val->width*$val->height*$val->bale/1000000 }}</td>
                        <td>{{ $val->packaging }}</td>
                        <td>{{ $val->no_po }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="made">
                <tr>
                    <td style="border:none">DIBUAT DI: {{ $spb->branch }}, {{ date('j-F-Y') }}</td>
                    <td style="border:none;text-align:right">PEMBAYARAN: {{ $spb->type }}</td>
                </tr>
            </table>
            <table class="signature">
                <tr>
                    <td style="text-align:center;width:30%">
                        <table><tr><td>
                        STAFF NJE<br/><br/><br/><br/><br/><br/>{{ Auth::user()->name }}
                        </td></tr></table>
                    </td>
                    <td style="width:5%"></td>
                    <td style="text-align:center;width:30%">
                        <table><tr><td>
                            PENGIRIM<br/><br/><br/><br/><br/><br/>NAMA JELAS TGL & TTD
                        </td></tr></table>
                    </td>
                    <td style="width:5%"></td>
                    <td style="text-align:center;width:30%">
                        <table><tr><td>
                            PENERIMA<br/><br/><br/><br/><br/><br/>NAMA JELAS TGL & TTD
                        </td></tr></table>
                    </td>
                </tr>
            </table>
            <table class="termcondition">
                <tr><td colspan="2"><strong>SYARAT DAN KETENTUAN</strong></td></tr>
                <tr><td>1.</td><td>Nujeks tidak memeriksa kembali atas isi barang yang telah dipacking oleh pengirim.</td></tr>
                <tr><td>2.</td><td>Nilai barang diatas Rp1.000.000 wajib diasuransikan.</td></tr>
                <tr><td>3.</td><td>Sebelum menandatangani SPB, pengirim diwajibkan untuk memeriksa barang yang diterimanya.</td></tr>
                <tr><td>4.</td><td>Klaim atas kerusakan atau kehilangan barang yang diajukan setelah SPB ditandatangani, di luar tanggung jawab Nujeks.</td></tr>
                <tr><td>5.</td><td>Nujeks tidak bertanggungjawab atas kerugian yang disebabkan oleh force majeure, kebakaran, dan huru-hara.</td></tr>
            </table>
        </main>
    </body>
</html>