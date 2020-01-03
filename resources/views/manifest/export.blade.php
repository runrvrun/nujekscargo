<table>
    <thead>
    <tr>
        <th colspan=13 style="font-size: 14pt; text-align:center;"><strong>CARGO MANIFEST {{ $manifest->no_manifest }}</strong></th>
    </tr>
    <tr>
        <th colspan=13 style="font-size: 12pt; text-align:center;">No. &nbsp;&nbsp; / {{ $manifest->created_at->format("j F Y") }}</th>
    </tr>
    <tr><td></td><td>Kepada Yth</td><td colspan=2>: <strong>{{ $manifest->title }}</strong></td></tr>
    <tr><td></td><td>Prepared By</td><td colspan=2>: {{ $manifest->name }}</td></tr>
    <tr>
        <td rowspan=2 style="border:1px solid black"><strong>No</strong></td>
        <td rowspan=2 style="border:1px solid black"><strong>SPB</strong></td>
        <td rowspan=2 style="border:1px solid black"><strong>Pengirim</strong></td>
        <td rowspan=2 style="border:1px solid black"><strong>Penerima</strong></td>
        <td colspan=8 style="border:1px solid black"><strong>Jenis Pengiriman</strong></td>
        <td rowspan=2 style="border:1px solid black"><strong>Handling</strong></td></tr>
    <tr style="border:1px solid black">
        <td style="border:1px solid black"><strong>Nama Barang</strong></td>
        <td style="border:1px solid black"><strong>Koli</strong></td>
        <td style="border:1px solid black"><strong>Berat</strong></td>
        <td style="border:1px solid black"><strong>T.Berat</strong></td>
        <td style="border:1px solid black"><strong>Dimensi</strong></td>
        <td style="border:1px solid black"><strong>Vol</strong></td>
        <td style="border:1px solid black"><strong>Packing</strong></td>
        <td style="border:1px solid black"><strong>PO</strong></td>
    </tr>
    </thead>
    <tbody>
    <?php $i=0; ?>
    @foreach($spb as $s)
        <?php $i++;$k=0; ?>
        <tr style="border:1px solid black">
            <td style="border:1px solid black" rowspan="{{ ($s->items->count())? $s->items->count():1 }}">{{ $i }}</td>
            <td style="border:1px solid black" rowspan="{{ ($s->items->count())? $s->items->count():1 }}">{{ $s->no_spb }}</td>
            <td style="border:1px solid black" rowspan="{{ ($s->items->count())? $s->items->count():1 }}"><div><strong>{{ $s->customer }}</strong></div>{{ $s->address }}</td>
            <td style="border:1px solid black" rowspan="{{ ($s->items->count())? $s->items->count():1 }}"><div><strong>{{ $s->recipient }}</strong></div>{{ $s->spbaddress }}</td>
            @if($s->items->count() > 0)
            @foreach($s->items as $item)
            <?php $k++; ?>
            @if($k>1)
            <tr>
            @endif
                <td style="border:1px solid black">{{ $item->item }}</td>
                <td style="border:1px solid black">{{ $item->bale }}</td>
                <td style="border:1px solid black">{{ $item->weight }}</td>
                <td style="border:1px solid black">{{ $item->weight*$item->bale }}</td>
                <td style="border:1px solid black">{{ $item->length.'x'.$item->width.'x'.$item->height }}</td>
                <td style="border:1px solid black">{{ $item->length*$item->width*$item->height*$item->bale/1000 }}</td>
                <td style="border:1px solid black">{{ $item->packaging }}</td>
                <td style="border:1px solid black">{{ $item->no_po }}</td>
            @if($k==1)
                 <td style="border:1px solid black" rowspan="{{ ($s->items->count())? $s->items->count():1 }}"></td>
            @endif
            @if($k>1)
            </tr>
            @endif
            @endforeach
            @else
            <td style="border:1px solid black">&nbsp;</td>
            <td style="border:1px solid black">&nbsp;</td>
            <td style="border:1px solid black">&nbsp;</td>
            <td style="border:1px solid black">&nbsp;</td>
            <td style="border:1px solid black">&nbsp;</td>
            <td style="border:1px solid black">&nbsp;</td>
            <td style="border:1px solid black">&nbsp;</td>
            <td style="border:1px solid black">&nbsp;</td>
            <td style="border:1px solid black" rowspan="{{ ($s->items->count())? $s->items->count():1 }}"></td>
        </tr>
            @endif
    @endforeach
    </tbody>
</table>