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
        <td rowspan=2 style=""><strong>No</strong></td>
        <td rowspan=2 style=""><strong>SPB</strong></td>
        <td rowspan=2 style=""><strong>Pengirim</strong></td>
        <td rowspan=2 style=""><strong>Penerima</strong></td>
        <td colspan=8 style=""><strong>Jenis Pengiriman</strong></td>
        <td rowspan=2 style=""><strong>Handling</strong></td></tr>
    <tr style="">
        <td style=""><strong>Nama Barang</strong></td>
        <td style=""><strong>Koli</strong></td>
        <td style=""><strong>Berat</strong></td>
        <td style=""><strong>T.Berat</strong></td>
        <td style=""><strong>Dimensi</strong></td>
        <td style=""><strong>Vol</strong></td>
        <td style=""><strong>Packing</strong></td>
        <td style=""><strong>PO</strong></td>
    </tr>
    </thead>
    <tbody>
    <?php $i=0; ?>
    @foreach($spb as $s)
        <?php
            $i++;
            $itemcount = $s->items->count()? $s->items->count():0;
        ?>
        @if($itemcount == 0)
            <tr style="">
                <td style="" rowspan="2">{{ $i }}</td>
                <td style="" rowspan="2">{{ $s->no_spb }}</td>
                <td style=""><strong>{{ $s->customer }}</strong></td>
                <td style=""><strong>{{ $s->recipient }}</strong></td>
                <td style="" rowspan="2"></td>
                <td style="" rowspan="2"></td>
                <td style="" rowspan="2"></td>
                <td style="" rowspan="2"></td>
                <td style="" rowspan="2"></td>
                <td style="" rowspan="2"></td>
                <td style="" rowspan="2"></td>
                <td style="" rowspan="2"></td>
                <td style="" rowspan="2"></td>
            </tr>
            <tr style="">
                <td style="">{{ $s->address }}</td>
                <td style="">{{ $s->spbaddress }}</td>
            </tr>
        @elseif($itemcount == 1)
            <tr style="">
                <td style="" rowspan="2">{{ $i }}</td>
                <td style="" rowspan="2">{{ $s->no_spb }}</td>
                <td style=""><strong>{{ $s->customer }}</strong></td>
                <td style=""><strong>{{ $s->recipient }}</strong></td>
                <td style="" rowspan="2">{{ $s->items[0]->item }}</td>
                <td style="" rowspan="2">{{ $s->items[0]->bale }}</td>
                <td style="" rowspan="2">{{ $s->items[0]->weight }}</td>
                <td style="" rowspan="2">{{ $s->items[0]->weight*$s->items[0]->bale }}</td>
                <td style="" rowspan="2">{{ $s->items[0]->length.'x'.$s->items[0]->width.'x'.$s->items[0]->height }}</td>
                <td style="" rowspan="2">{{ $s->items[0]->length*$s->items[0]->width*$s->items[0]->height*$s->items[0]->bale/1000 }}</td>
                <td style="" rowspan="2">{{ $s->items[0]->packaging }}</td>
                <td style="" rowspan="2">{{ $s->items[0]->no_po }}</td>
                <td style="" rowspan="2"></td>
            </tr>
            <tr style="">
                <td style="">{{ $s->address }}</td>
                <td style="">{{ $s->spbaddress }}</td>
            </tr>
        @elseif($itemcount == 2)
            <tr style="">
                <td style="" rowspan="2">{{ $i }}</td>
                <td style="" rowspan="2">{{ $s->no_spb }}</td>
                <td style=""><strong>{{ $s->customer }}</strong></td>
                <td style=""><strong>{{ $s->recipient }}</strong></td>
                <td style="">{{ $s->items[0]->item }}</td>
                <td style="">{{ $s->items[0]->bale }}</td>
                <td style="">{{ $s->items[0]->weight }}</td>
                <td style="">{{ $s->items[0]->weight*$s->items[0]->bale }}</td>
                <td style="">{{ $s->items[0]->length.'x'.$s->items[0]->width.'x'.$s->items[0]->height }}</td>
                <td style="">{{ $s->items[0]->length*$s->items[0]->width*$s->items[0]->height*$s->items[0]->bale/1000 }}</td>
                <td style="">{{ $s->items[0]->packaging }}</td>
                <td style="">{{ $s->items[0]->no_po }}</td>
                <td style="" rowspan="2"></td>
            </tr>
            <tr style="">
                <td style="">{{ $s->address }}</td>
                <td style="">{{ $s->spbaddress }}</td>
                <td style="">{{ $s->items[1]->item }}</td>
                <td style="">{{ $s->items[1]->bale }}</td>
                <td style="">{{ $s->items[1]->weight }}</td>
                <td style="">{{ $s->items[1]->weight*$s->items[0]->bale }}</td>
                <td style="">{{ $s->items[1]->length.'x'.$s->items[1]->width.'x'.$s->items[1]->height }}</td>
                <td style="">{{ $s->items[1]->length*$s->items[1]->width*$s->items[1]->height*$s->items[1]->bale/1000 }}</td>
                <td style="">{{ $s->items[1]->packaging }}</td>
                <td style="">{{ $s->items[1]->no_po }}</td>
            </tr>
        @elseif($itemcount > 2)
            <tr style="">
                <td style="" rowspan="{{ $itemcount }}">{{ $i }}</td>
                <td style="" rowspan="{{ $itemcount }}">{{ $s->no_spb }}</td>
                <td style=""><strong>{{ $s->customer }}</strong></td>
                <td style=""><strong>{{ $s->recipient }}</strong></td>
                <td style="">{{ $s->items[0]->item }}</td>
                <td style="">{{ $s->items[0]->bale }}</td>
                <td style="">{{ $s->items[0]->weight }}</td>
                <td style="">{{ $s->items[0]->weight*$s->items[0]->bale }}</td>
                <td style="">{{ $s->items[0]->length.'x'.$s->items[0]->width.'x'.$s->items[0]->height }}</td>
                <td style="">{{ $s->items[0]->length*$s->items[0]->width*$s->items[0]->height*$s->items[0]->bale/1000 }}</td>
                <td style="">{{ $s->items[0]->packaging }}</td>
                <td style="">{{ $s->items[0]->no_po }}</td>
                <td style="" rowspan="{{ $itemcount }}"></td>
            </tr>
            <tr style="">
                <td style=""rowspan="{{ $itemcount-1 }}">{{ $s->address }}</td>
                <td style=""rowspan="{{ $itemcount-1 }}">{{ $s->spbaddress }}</td>
                <td style="">{{ $s->items[1]->item }}</td>
                <td style="">{{ $s->items[1]->bale }}</td>
                <td style="">{{ $s->items[1]->weight }}</td>
                <td style="">{{ $s->items[1]->weight*$s->items[0]->bale }}</td>
                <td style="">{{ $s->items[1]->length.'x'.$s->items[1]->width.'x'.$s->items[1]->height }}</td>
                <td style="">{{ $s->items[1]->length*$s->items[1]->width*$s->items[1]->height*$s->items[1]->bale/1000 }}</td>
                <td style="">{{ $s->items[1]->packaging }}</td>
                <td style="">{{ $s->items[1]->no_po }}</td>
            </tr>
            @for($i=2;$i<$itemcount;$i++)
            <tr style="">
                <td style="">{{ $s->items[1]->item }}</td>
                <td style="">{{ $s->items[1]->bale }}</td>
                <td style="">{{ $s->items[1]->weight }}</td>
                <td style="">{{ $s->items[1]->weight*$s->items[0]->bale }}</td>
                <td style="">{{ $s->items[1]->length.'x'.$s->items[1]->width.'x'.$s->items[1]->height }}</td>
                <td style="">{{ $s->items[1]->length*$s->items[1]->width*$s->items[1]->height*$s->items[1]->bale/1000 }}</td>
                <td style="">{{ $s->items[1]->packaging }}</td>
                <td style="">{{ $s->items[1]->no_po }}</td>
            </tr>
            @endfor
        @endif
    @endforeach
    </tbody>
</table>