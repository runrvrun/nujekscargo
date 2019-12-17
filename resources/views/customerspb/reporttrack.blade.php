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
                        </td></tr></table>
                    </td>
                </tr>
            </table>
            <div style="font-weight:16px; margin-top:20px;font-weight:bold">SPB TRACKING</div>
            <table class="item">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    <tr>
                </thead>
                <tbody>
                    <?php $tbale = $tweight = $ttweight = $tvolume = 0; ?>
                    @foreach($track as $key=>$val)
                    <tr>
                        <td>{{ $val->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $val->status }}</td>
                        <td><div>{{ $val->process.$val->city }}</div>{{ $val->track }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </body>
</html>