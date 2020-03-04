<html>
    <head>
        <style type="text/css" media="all">
            @page {
                header: page-header;
                footer: page-footer;
            }
            body{
                /* font-family: "Avant Garde"; */
                /* font-family: "Rubik", "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; */
                text-transform: uppercase;
                font-size: 10pt;
                font-weight: 100;
                text-transform: uppercase;
            }
            h1{
                font-size: 18px;
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
            .termcondition td{
                font-size: 10px;
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
            p, td{
                font-size:12px;
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
    <p style="font-size:9px;font-style:italic">PT Nusantara Jaya Ekspress - SPB: {{ $spb->no_spb }} - Hal {PAGENO}/{nb}</p>
    </htmlpagefooter>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table class="title">
                <tr>
                    <td style="width:40%;">
                        <div style="text-align: center;">
                            <img src="images/logo-nujeks.png" />
                        </div><br/>
                        <p style="font-size:16px;">PT NUSANTARA JAYA EKSPRESS</p>
                        <p style="font-size:11px;text-transform:uppercase;">{{ $userbranch->address }}</p>
                        <p style="font-size:11px;">No.Telp : {{ $userbranch->phone }}</p>
                        <p style="font-size:11px;">No.Fax : {{ $userbranch->fax }}</p>
                        <p style="font-size:11px;">Website : http://www.nujeks.com</p>
                        <p style="font-size:11px;">Email : {{ $userbranch->email }} {{ $userbranch->email_acc}}</p>
                    </td>
                    <td style="width:20%"></td>
                    <td style="width:40%;">
                        <p style="font-size:24px;">{{ $spb->no_spb }}</p>
                        <br>
                        <p style="font-size:14px;">EKSPEDISI PERKEBUNAN DAN PROJECT CARGO SUMATERA JAWA KALIMANTAN SULAWESI PAPUA</p>
                    </td>
                </tr>
            </table>
            <table class="sender">
                <tr>
                    <td style="width:40%">
                        <table><tr><td style="height: 120px;text-transform:uppercase;">
                            <p style="font-size:14px;">PENGIRIM</p><br>
                            <p style="font-size:11px;">{{ $spb->customer }}</p>
                            <p style="font-size:11px;">{{ $spb->cust_address }}</p>
                        </td></tr></table>
                    </td>
                    <td style="width:20%"></td>
                    <td style="width:40%">
                        <table><tr><td style="height: 120px;text-transform:uppercase;">
                            <p style="font-size:14px;">PENERIMA</p><br>
                            <p style="font-size:11px;">{{ $spb->recipient }}</p>
                            <p style="font-size:11px;">{{ $spb->address }}</p>
                            <p>PIC: {{ $spb->pic_contact }} - {{ $spb->pic_phone }}</p>
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
                        <th>PACKING/ KETERANGAN</th>
                        <th>NO.PO</th>
                    <tr>
                </thead>
                <tbody>
                    <?php $tbale = $tweight = $ttweight = $tvolume = 0; ?>
                    @foreach($spb->items as $key=>$val)
                    <?php
                        $tbale += $val->bale;
                        $tweight += $val->weight;
                        $ttweight += $val->weight*$val->bale;
                        $tvolume += $val->length*$val->width*$val->height*$val->bale/1000000;
                    ?>
                    <tr>
                        <td style="text-align:right">{{ $key+1 }}</td>
                        <td>{{ $val->item }}</td>
                        <td style="text-align:right">{{ $val->bale }}</td>
                        <td style="text-align:right">{{ $val->weight }}</td>
                        <td style="text-align:right">{{ $val->weight*$val->bale }}</td>
                        <td>{{ $val->length.'X'.$val->width.'X'.$val->height }}</td>
                        <td style="text-align:right">{{ number_format($val->length*$val->width*$val->height*$val->bale/1000000,3) }}</td>
                        <td style="text-align:center">{{ $val->packaging }}</td>
                        <td>{{ $val->no_po }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">TOTAL</th>
                        <th style="text-align:right">{{ $tbale }}</th>
                        <th style="text-align:right">{{ $tweight }}</th>
                        <th style="text-align:right">{{ $ttweight }}</th>
                        <th></th>
                        <th style="text-align:right">{{ number_format($tvolume,3) }}</th>
                        <th colspan="2"></th>
                    <tr>
                </tfoot>
            </table>
            <table class="made">
                <tr>
                    <td style="border:none;text-transform:uppercase">DIBUAT DI: {{ $spb->branch }}, {{ date('j-F-Y') }}</td>
                    <td style="border:none;text-align:right;text-transform:uppercase">PEMBAYARAN: {{ $spb->payment_type }}</td>
                </tr>
            </table>
            <table class="signature">
                <tr>
                    <td style="text-align:center;width:30%">
                        <table><tr><td style="text-transform:uppercase">
                        STAFF NJE<br/><br/><br/><br/><br/><br/>{{ $spb->name ?? '_' }}
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