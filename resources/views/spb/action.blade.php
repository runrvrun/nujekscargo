<form method="POST" action="/spb/{{$dt->id}}" style="white-space:nowrap">
<a href="{{ url('spb/'.$dt->id.'/item') }}" class="warning p-0" data-original-title="" title="">
    <i class="ft-package font-medium-3 mr-2"></i>
</a>
<a href="{{ url('spb/'.$dt->id) }}" class="primary p-0" data-original-title="" title="">
    <i class="ft-zoom-in font-medium-3 mr-2"></i>
</a>
<a href="{{ url('spb/'.$dt->id.'/edit') }}" class="success p-0" data-original-title="" title="">
    <i class="ft-edit-2 font-medium-3 mr-2"></i>
</a>
{{ csrf_field() }}
{{ method_field('DELETE') }}
    <a class="danger p-0" onclick="if(confirm('Hapus data ini?')) this.closest('form').submit()">
        <i class="ft-x font-medium-3 mr-2"></i>
    </a>
</form>