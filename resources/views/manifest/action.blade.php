<form method="POST" action="/manifest/{{$dt->id}}" style="white-space:nowrap">
<!-- <a href="{{ url('manifest/'.$dt->id.'/spb') }}" class="warning p-0" data-original-title="" title="Manifest SPB">
    <i class="ft-map font-medium-3 mr-2"></i> -->
</a>
<a href="{{ url('manifest/'.$dt->id.'/report') }}" target="_blank" class="primary p-0" data-original-title="" title="Manifest Report">
    <i class="ft-printer font-medium-3 mr-2"></i>
</a>
@if($dt->count_spb)
<a href="{{ url('manifest/'.$dt->id.'/excel') }}" class="primary p-0" data-original-title="" title="Export Excel">
    <i class="ft-layout font-medium-3 mr-2"></i>
</a>
@endif
<!-- <a href="{{ url('manifest/'.$dt->id) }}" class="info p-0" data-original-title="" title="">
        <i class="ft-zoom-in font-medium-3 mr-2"></i> -->
    </a>
@if(session('privilege')[3]["edit"] ?? 0)
<a href="{{ url('manifest/'.$dt->id.'/edit') }}" class="success p-0" data-original-title="" title="">
        <i class="ft-edit-2 font-medium-3 mr-2"></i>
    </a>
@endif
{{ csrf_field() }}
@if(session('privilege')[3]["delete"] ?? 0)
{{ method_field('DELETE') }}
    <a class="danger p-0" onclick="if(confirm('Hapus data ini?')) this.closest('form').submit()">
        <i class="ft-x font-medium-3 mr-2"></i>
    </a>
@endif
</form>