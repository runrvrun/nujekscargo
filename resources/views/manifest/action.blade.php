<form method="POST" action="/manifest/{{$dt->id}}" style="white-space:nowrap">
<a href="{{ url('manifest/'.$dt->id.'/spb') }}" class="warning p-0" data-original-title="" title="Manifest SPB">
    <i class="ft-map font-medium-3 mr-2"></i>
</a>
<a href="{{ url('manifest/'.$dt->id.'/report') }}" class="primary p-0" data-original-title="" title="Manifest Report">
    <i class="ft-printer font-medium-3 mr-2"></i>
</a>
<a href="{{ url('manifest/'.$dt->id) }}" class="info p-0" data-original-title="" title="">
        <i class="ft-zoom-in font-medium-3 mr-2"></i>
    </a>
<a href="{{ url('manifest/'.$dt->id.'/edit') }}" class="success p-0" data-original-title="" title="">
        <i class="ft-edit-2 font-medium-3 mr-2"></i>
    </a>
{{ csrf_field() }}
{{ method_field('DELETE') }}
    <a class="danger p-0" onclick="if(confirm('Hapus data ini?')) this.closest('form').submit()">
        <i class="ft-x font-medium-3 mr-2"></i>
    </a>
</form>