<form method="POST" action="/manifest/spb/destroy" style="white-space:nowrap">
<a class="primary p-0" id="changestatus{{ $dt->id }}" data-spbid="{{ $dt->id }}" data-spbstatus="{{ $dt->spb_status_id }}"><i class="ft-edit-2 font-medium-3"></i>Status</a>
{{ csrf_field() }}
    {{ Form::hidden('spb_id', $dt->id) }}
    {{ Form::hidden('manifest_id', $dt->manifest_id) }}
    <a class="danger p-0" onclick="if(confirm('Hapus data ini?')) this.closest('form').submit()">
        <i class="ft-x font-medium-3 mr-2"></i>
    </a>
</form>

<script>
    $('#changestatus{{ $dt->id }}').click(function(data){
      var spbid = $(this).data('spbid');
      var spbstatus = $(this).data('spbstatus');
      $("#sel_spb_id").val(spbid);
      $("#spb_status_id").val(spbstatus);
      $("#spb-status-modal").modal('show');
    });
</script>