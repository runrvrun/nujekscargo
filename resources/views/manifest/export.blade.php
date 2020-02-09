<table>
    <thead>
    <tr>
        <th colspan=13 style="vertical-align:top;font-size: 14pt; text-align:center;"><strong>CARGO MANIFEST {{ $manifest->no_manifest }}</strong></th>
    </tr>
    <tr>
        <th colspan=13 style="vertical-align:top;font-size: 12pt; text-align:center;">No. &nbsp;&nbsp; / {{ $manifest->created_at->format("j F Y") }}</th>
    </tr>
    <tr><td></td><td>Kepada Yth</td><td colspan=2>: <strong>{{ $manifest->title }}</strong></td></tr>
    <tr><td></td><td>Prepared By</td><td colspan=2>: {{ $manifest->name }}</td></tr>
    <tr>
        <td style="vertical-align:top;border-left:1px solid black;border-top:1px solid black;width:4"><strong>No</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-top:1px solid black;width:13"><strong>SPB</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-top:1px solid black;width:30"><strong>Pengirim</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-top:1px solid black;width:30"><strong>Penerima</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-top:1px solid black;width:20"><strong>Jenis Pengiriman</strong></td>
        <td style="vertical-align:top;border-top:1px solid black;width:5">&nbsp;</td>
        <td style="vertical-align:top;border-top:1px solid black;width:5">&nbsp;</td>
        <td style="vertical-align:top;border-top:1px solid black;width:7">&nbsp;</td>
        <td style="vertical-align:top;border-top:1px solid black;width:11">&nbsp;</td>
        <td style="vertical-align:top;border-top:1px solid black;width:6">&nbsp;</td>
        <td style="vertical-align:top;border-top:1px solid black;width:12">&nbsp;</td>
        <td style="vertical-align:top;border-top:1px solid black;width:12">&nbsp;</td>
        <td style="vertical-align:top;border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:10"><strong>Handling</strong></td>
    <tr>
        <td style="vertical-align:top;border-left:1px solid black"></td>
        <td style="vertical-align:top;border-left:1px solid black"></td>
        <td style="vertical-align:top;border-left:1px solid black"></td>
        <td style="vertical-align:top;border-left:1px solid black"></td>
        <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"><strong>Nama Barang</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"><strong>Koli</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"><strong>Berat</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"><strong>T.Berat</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"><strong>Dimensi</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"><strong>Vol</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"><strong>Packing</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"><strong>PO</strong></td>
        <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
    </tr>
    </thead>
    <tbody>
    <?php $i=0; $tweight=0; $tbale=0; $tvolume=0; ?>
    @foreach($spb as $s)
        <?php
            $i++;
            $itemcount = $s->items->count()? $s->items->count():0;
            $stweight=0; $stbale=0; $stvolume=0;
        ?>
        @if($itemcount == 0)
            <tr>
                <td style="vertical-align:top;border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $i }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->no_spb }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word"><strong>{{ $s->customer }}</strong></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word"><strong>{{ $s->recipient }}</strong></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
            </tr>
            <tr>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->address }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->spbaddress }} <p>PIC: {{ $s->pic_contact }} - {{ $s->pic_phone }}</p></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
            </tr>
            <?php $tbale += $stbale;?>
            <?php $tweight += $stweight;?>
            <?php $tvolume += $stvolume;?>
        @elseif($itemcount == 1)
            <tr>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $i }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->no_spb }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word"><strong>{{ $s->customer }}</strong></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word"><strong>{{ $s->recipient }}</strong></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word">{{ $s->items[0]->item }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->bale }}<?php $stbale+=$s->items[0]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->weight }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->weight*$s->items[0]->bale }}<?php $stweight+=$s->items[0]->weight*$s->items[0]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;text-align:right">{{ $s->items[0]->length.'x'.$s->items[0]->width.'x'.$s->items[0]->height }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->length*$s->items[0]->width*$s->items[0]->height*$s->items[0]->bale/1000000 }}<?php $stvolume+=$s->items[0]->length*$s->items[0]->width*$s->items[0]->height*$s->items[0]->bale/1000000;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word">{{ $s->items[0]->packaging }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word">{{ $s->items[0]->no_po }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
            </tr>
            <tr>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word;word-wrap: break-word">{{ $s->address }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->spbaddress }} <p>PIC: {{ $s->pic_contact }} - {{ $s->pic_phone }}</p></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
            </tr>
            <?php $tbale += $stbale;?>
            <?php $tweight += $stweight;?>
            <?php $tvolume += $stvolume;?>
        @elseif($itemcount == 2)
            <tr>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $i }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->no_spb }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word"><strong>{{ $s->customer }}</strong></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word"><strong>{{ $s->recipient }}</strong></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word">{{ $s->items[0]->item }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->bale }}<?php $stbale+=$s->items[0]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->weight }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->weight*$s->items[0]->bale }}<?php $stweight+=$s->items[0]->weight*$s->items[0]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;text-align:right">{{ $s->items[0]->length.'x'.$s->items[0]->width.'x'.$s->items[0]->height }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->length*$s->items[0]->width*$s->items[0]->height*$s->items[0]->bale/1000000 }}<?php $stvolume+=$s->items[0]->length*$s->items[0]->width*$s->items[0]->height*$s->items[0]->bale/1000000;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word">{{ $s->items[0]->packaging }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word">{{ $s->items[0]->no_po }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
            </tr>
            <tr>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->address }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->spbaddress }} <p>PIC: {{ $s->pic_contact }} - {{ $s->pic_phone }}</p></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->items[1]->item }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[1]->bale }}<?php $stbale+=$s->items[1]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[1]->weight }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[1]->weight*$s->items[1]->bale }}<?php $stweight+=$s->items[1]->weight*$s->items[1]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;text-align:right">{{ $s->items[1]->length.'x'.$s->items[1]->width.'x'.$s->items[1]->height }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[1]->length*$s->items[1]->width*$s->items[1]->height*$s->items[1]->bale/1000000 }}<?php $stvolume+=$s->items[1]->length*$s->items[1]->width*$s->items[1]->height*$s->items[1]->bale/1000000;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->items[1]->packaging }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->items[1]->no_po }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
            </tr>
            <tr>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">TOTAL</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $stbale }}<?php $tbale += $stbale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">&nbsp;</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $stweight }}<?php $tweight += $stweight;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">&nbsp;</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $stvolume }}<?php $tvolume += $stvolume;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">&nbsp;</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">&nbsp;</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
            </tr>
        @elseif($itemcount > 2)
            <tr>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $i }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->no_spb }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word"><strong>{{ $s->customer }}</strong></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word"><strong>{{ $s->recipient }}</strong></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word">{{ $s->items[0]->item }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->bale }}<?php $stbale+=$s->items[0]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->weight }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->weight*$s->items[0]->bale }}<?php $stweight+=$s->items[0]->weight*$s->items[0]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;text-align:right">{{ $s->items[0]->length.'x'.$s->items[0]->width.'x'.$s->items[0]->height }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $s->items[0]->length*$s->items[0]->width*$s->items[0]->height*$s->items[0]->bale/1000000 }}<?php $stvolume+=$s->items[0]->length*$s->items[0]->width*$s->items[0]->height*$s->items[0]->bale/1000000;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word">{{ $s->items[0]->packaging }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;word-wrap: break-word">{{ $s->items[0]->no_po }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
            </tr>
            <tr>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->address }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->spbaddress }} <p>PIC: {{ $s->pic_contact }} - {{ $s->pic_phone }}</p></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->items[1]->item }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[1]->bale }}<?php $stbale+=$s->items[1]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[1]->weight }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[1]->weight*$s->items[1]->bale }}<?php $stweight+=$s->items[1]->weight*$s->items[1]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;text-align:right">{{ $s->items[1]->length.'x'.$s->items[1]->width.'x'.$s->items[1]->height }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[1]->length*$s->items[1]->width*$s->items[1]->height*$s->items[1]->bale/1000000 }}<?php $stvolume+=$s->items[1]->length*$s->items[1]->width*$s->items[1]->height*$s->items[1]->bale/1000000;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->items[1]->packaging }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->items[1]->no_po }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
            </tr>
            @for($i=2;$i<$itemcount;$i++)
            <tr>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->items[$i]->item }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[$i]->bale }}<?php $stbale+=$s->items[$i]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[$i]->weight }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[$i]->weight*$s->items[$i]->bale }}<?php $stweight+=$s->items[$i]->weight*$s->items[$i]->bale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;text-align:right">{{ $s->items[$i]->length.'x'.$s->items[$i]->width.'x'.$s->items[$i]->height }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black">{{ $s->items[$i]->length*$s->items[$i]->width*$s->items[$i]->height*$s->items[$i]->bale/1000000 }}<?php $stvolume+=$s->items[$i]->length*$s->items[$i]->width*$s->items[$i]->height*$s->items[$i]->bale/1000000;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->items[$i]->packaging }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;word-wrap: break-word">{{ $s->items[$i]->no_po }}</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
            </tr>
            @endfor
            <tr>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black"></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">TOTAL</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $stbale }}<?php $tbale += $stbale;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">&nbsp;</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $stweight }}<?php $tweight += $stweight;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">&nbsp;</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">{{ $stvolume }}<?php $tvolume += $stvolume;?></td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">&nbsp;</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black">&nbsp;</td>
                <td style="vertical-align:top;border-left:1px solid black;border-right:1px solid black;border-top:1px solid black"></td>
            </tr>
        @endif
    @endforeach
    </tbody>
    <tr>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
        <td style="vertical-align:top;border-top:1px solid black"></td>
    </tr>
    <tr><td colspan=4></td><td style="vertical-align:top;border:1px solid black"><b>TOTAL</b></td><td style="vertical-align:top;border:1px solid black">{{ $tbale }}</td><td style="vertical-align:top;border:1px solid black">&nbsp;</td><td style="vertical-align:top;border:1px solid black">{{ $tweight }}</td><td style="vertical-align:top;border:1px solid black">&nbsp;</td><td style="vertical-align:top;border:1px solid black">{{ $tvolume }}</td></tr>
</table>