<form method="POST" action="/spb/{{$dt->id}}" style="white-space:nowrap">
<!-- <a href="{{ url('spb/'.$dt->id.'/item') }}" class="warning p-0" data-original-title="Barang" title="">
    <i class="ft-package font-medium-3 mr-2"></i>
</a>
<a href="{{ url('spb/'.$dt->id.'/log') }}" class="info p-0" data-original-title="" title="Tracking">
    <i class="ft-map-pin font-medium-3 mr-2"></i>
</a>
<a href="{{ url('spb/'.$dt->id) }}" class="primary p-0" data-original-title="" title="Detail">
    <i class="ft-zoom-in font-medium-3 mr-2"></i>
</a> -->
<a href="{{ url('spb/'.$dt->id.'/report') }}" target="_blank" class="primary p-0" data-original-title="" title="SPB Report">
    <i class="ft-printer font-medium-3 mr-2"></i>
</a>
<a href="{{ url('spb/'.$dt->id.'/edit') }}" class="success p-0" data-original-title="" title="Edit">
    <i class="ft-edit-2 font-medium-3 mr-2"></i>
</a>
{{ csrf_field() }}
{{ method_field('DELETE') }}
<a class="danger p-0" onclick="if(confirm('Hapus data ini?')) this.closest('form').submit()" title="Hapus">
        <i class="ft-x font-medium-3 mr-2"></i>
    </a>
@if(!empty($dt->note))
<a title="Catatan" class="warning p-0 show-spb-note-modal" data-note="{{ $dt->note }}"><i class="ft-file-text font-medium-3"></i></a>
@endif
</form>
<script> 
    $(".show-spb-note-modal").click(function(){
      $("#spb-note-modal-note").html($(this).data("note"));
      $("#spb-note-modal").modal('show');
    });
</script>