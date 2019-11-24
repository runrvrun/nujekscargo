<form method="POST" action="/manifest/spb/destroy">
{{ csrf_field() }}
    {{ Form::hidden('spb_id', $dt->id) }}
    {{ Form::hidden('manifest_id', $dt->manifest_id) }}
    <a class="danger p-0" onclick="if(confirm('Hapus data ini?')) this.closest('form').submit()">
        <i class="ft-x font-medium-3 mr-2"></i>
    </a>
</form>