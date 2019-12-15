<form method="POST" action="/manifest/spb/destroy" style="white-space:nowrap">
<a title="Ubah Status SPB" class="primary p-0" id="changestatus{{ $dt->id }}" data-spbid="{{ $dt->id }}" data-spbstatus="{{ $dt->spb_status_id }}"><i class="ft-box font-medium-3"></i><i class="ft-chevrons-right font-medium-3"></i></a>
{{ csrf_field() }}
    {{ Form::hidden('spb_id', $dt->id) }}
    {{ Form::hidden('manifest_id', $dt->manifest_id) }}
    <a title="Hapus SPB dari Manifest" class="danger p-0" onclick="if(confirm('Hapus data ini?')) this.closest('form').submit()">
        <i class="ft-slash font-medium-3 mr-2"></i>
    </a>
@if(!empty($dt->note))
<a title="Catatan" class="warning p-0 show-spb-note-modal" data-note="{{ $dt->note }}"><i class="ft-file-text font-medium-3"></i></a>
@endif
</form>

<script>
    $('#changestatus{{ $dt->id }}').click(function(data){
      var spbid = $(this).data('spbid');
      var spbstatus = $(this).data('spbstatus');
      $("#sel_spb_id").val(spbid);
      $("#spb_status_id").val(spbstatus);
      if(spbstatus == 1){
        $("#branchdriver").show();
      }else{
        $("#branchdriver").hide();
      }
      $("#spb_status_note").val('{{ $dt->note }}');
      $("#spb-status-modal").modal('show');
    });
    
    $(".show-spb-note-modal").click(function(){
      $("#spb-note-modal-note").html($(this).data("note"));
      $("#spb-note-modal").modal('show');
    });
</script>