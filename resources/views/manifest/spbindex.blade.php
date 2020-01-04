@extends('layouts.app')

@section('pagetitle')
    <title>{{ config('app.name', 'Laravel') }} | @lang('Manifest') @lang('SPB')</title>
@endsection

@section('content')
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- DOM - jQuery events table -->
<section id="browse-table">
  <div class="row">
    <div class="col-12">
      @if(Session::has('message'))
      <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ ucfirst(Session::get('message')) }}</p>
      @endif
      <div class="card">
        <div style="position:absolute">
          <a href="{{ url('manifest') }}" class="btn btn-primary pull-left"><i class="ft-arrow-left"></i> Kembali ke Manifest</a>
        </div>
        <div class="card-header">
            <h4 class="card-title">{{ $manifest->no_manifest }}</h4>
        </div>
        <div class="card-header">
        <h5>{{ $manifest->origin }} <i class="ft-arrow-right"></i> {{ $manifest->destination }}</h5>
        </div>
        <div class="card-content">
          <div class="card-body card-dashboard">
            <div class="card-filter row">
              <div class="col-md-5">
                <button class="btn btn-primary-outline OTW filterstatus" data-status="OTW">OTW</button>
                <button class="btn btn-primary-outline WHS filterstatus" data-status="WHS">WHS</button>
                <button class="btn btn-primary-outline DLY filterstatus" data-status="DLY">DLY</button>
                <button class="btn btn-primary-outline RCV filterstatus" data-status="RCV">RCV</button>
                {{ Form::hidden('filterstatus',-1,['id'=>'filterstatus'])}}
              </div>
            </div>
          </div>
        </div>
        <div class="card-content ">
          <div class="card-body card-dashboard table-responsive">
            <table class="table browse-table">
              <thead>
                <tr>
                  <th></th>                  
                  @foreach($cols as $val)
                  @if($val['B'])
                  <th class="{{ $val['column'] }}">@lang($val['caption'])</th>
                  @endif
                  @endforeach
                  <th style="white-space: nowrap;">Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- File export table -->

          </div>
        </div>
@endsection
@section('modal')
<!-- Modal -->
<div class="modal fade text-left bd-example-modal-lg" id="spb-add-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1">Tambah SPB</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">          
          @csrf
          {{ Form::hidden('manifest_id', $manifest->id) }}
            <div class="input-group row">
              <div class="col-sm-4">
                <input id="searchspbterm" type="text" class="form-control" placeholder="Cari SPB">
              </div>
                <span class="input-group-btn">
                    <button id="searchspbbutton" class="btn btn-primary" type="button"><span class="ft-search"></span>Cari</button>
                </span>
            </div>
            <div id="searchspbresult" style="height:250px; overflow-y:scroll">
            </div>
          <hr/>          
          <form class="form-inline" method="POST" action="{{ url('manifest/spb/setmanifestmulti') }}">
              @csrf
              <div class="form-group mx-sm-3 mb-2 ui-widget">
                  {{ Form::hidden('manifest_id',$manifest->id) }}
                  <input name="spb_add" size=65 class="form-control" id="spb2" placeholder="SPB dipilih">
              </div>
                  <button type="submit" class="btn btn-primary mb-2"><i class="ft-plus"></i>Tambah ke Manifest</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>   
<!-- Modal -->
<div class="modal fade text-left" id="spb-status-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="/manifest/spb/updatestatus" method="POST">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1">Update SPB Status</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          @csrf
          {{ Form::hidden('manifest_id', $manifest->id) }}
          {{ Form::hidden('sel_spb_id',null,['id'=>'sel_spb_id']) }}
          {{ Form::hidden('sel_spb_ids',null,['id'=>'sel_spb_ids']) }}
          Status: {{ Form::select('spb_status_id',\App\Spb_status::pluck('status','id'),null,['class'=>'form-control','id'=>'spb_status_id']) }}
          <div class="row" style="margin-top:3px;">
            <div class="col-6">
              {{ Form::select('process',['Posisi barang di'=>'Posisi barang di','Proses bongkar di'=>'Proses bongkar di','Lainnya'=>'Lainnya'],null,['class'=>'form-control','id'=>'process']) }}
              <input type="text" name="processother" style="display:none" placeholder="Lainnya" class="form-control" />
            </div>
            <div class="col-6">
              {{ Form::select('city_id',\App\City::pluck('city','id'),null,['class'=>'form-control','id'=>'city_id']) }}
            </div>
          </div>
          Keterangan: {{ Form::textarea('track',null,['class'=>'form-control','rows'=>3]) }}
          <div id="branchdriver" style="display:none">
          @lang('Warehouse'): {{ Form::select('warehouse_city_id',\App\City::pluck('city','id'),null,['class'=>'form-control','id'=>'warehouse_city_id','placeholder'=>' ']) }}
          @lang('Warehouse PIC'): {{ Form::select('user_id',\App\User::pluck('name','id'),null,['class'=>'form-control','id'=>'user_id','placeholder'=>' ']) }}
          </div>
          Catatan: {{ Form::textarea('spb_status_note',null,['class'=>'form-control','id'=>'spb_status_note','rows'=>3]) }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary"><i class="ft-save"></i> Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>   
<!-- Modal -->
<div class="modal fade text-left" id="spb-note-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1">Catatan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="spb-note-modal-note">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Tutup</button>
      </div>
      </form>
    </div>
  </div>
</div>   
@endsection
@section('pagecss')
<link rel="stylesheet" type="text/css" href="{{ asset('/') }}/app-assets/vendors/css/tables/datatable/datatables.min.css">
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
<style>
  .status_code a{color:#fff}
  .WHS,.OTW,.DLY,.RCV,.BTO,.ORD,.NEW,.SEN,.IOP,.PAI,.CLR{display: inline-block; padding: 0.375rem 0.75rem;font-size: 1rem;line-height: 1;border-radius: 0.25rem;color: #fff;background-color: #000;}
  .WHS{background-color: #ff8040;}
  .OTW{background-color: #0080ff;}
  .DLY{background-color: #ffff00;color:#000;}
  .RCV{background-color: #408080;}
  .BTO,.ORD{background-color: #FF586B;}
  .PAI,.CLR{background-color: #008000;}

  .btn-block{
    text-align:left;
  }
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection
@section('pagejs')
<script src="{{ asset('/') }}/app-assets/vendors/js/datatable/datatables.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}/app-assets/vendors/js/datatable/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}/app-assets/vendors/js/datatable/buttons.flash.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}/app-assets/vendors/js/datatable/jszip.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}/app-assets/vendors/js/datatable/pdfmake.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}/app-assets/vendors/js/datatable/vfs_fonts.js" type="text/javascript"></script>
<script src="{{ asset('/') }}/app-assets/vendors/js/datatable/buttons.html5.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}/app-assets/vendors/js/datatable/buttons.print.min.js" type="text/javascript"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>    
<script>
$(document).ready(function() {
    $("#user_id").change(function(){
      $.ajax({
        url: "{{ url('/user/getcity') }}", 
        data: {user_id: $(this).val()}, 
        success: function(result){
          if(result>0){
          console.log(result);
            $("#warehouse_city_id").val(result);
            $('.selectpicker').selectpicker('refresh');
          }
      }});
    });
    $("#process").change(function(){
      if($(this).val() == 'Lainnya'){
        $("input[name=processother]").show();
      }else{
        $("input[name=processother]").hide();
      }
    });

    $("#spb_status_id").change(function(){
      var sel_status = $("#spb_status_id").val();
      if(sel_status == 1){
        $("#branchdriver").show();
      }else{
        $("#branchdriver").hide();
      }
    });

    var resp = false;
    if(window.innerWidth <= 800) resp=true;

    var table = $('.browse-table').DataTable({
        responsive: resp,
        processing: true,
        serverSide: true,
        ajax: {
          url: '{!! url('manifest/'.$manifest->id.'/spb/indexjson') !!}',
          data : function(d){
            d.filterstatus = $('#filterstatus').val();
          }
        },
        columns: [
          { data: 'id', name: 'checkbox' },
          @foreach($cols as $val)
          @if($val['B'])
          { data: '{{ $val['column'] }}', name: '{{ $val['dbcolumn'] }}', className:'{{ $val['column'] }}'
          @if($val['type'] == 'number')
          , render: $.fn.dataTable.render.number( ',', '.', 2 ) 
          @endif
          },
          @endif
          @endforeach
          { data: 'action', name: 'action' },
        ],
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'B>>"+
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            @if(session('privilege')[3]["add"] ?? 0)
            {
              text:'<i class="ft-map"></i><i class="ft-plus"></i> SPB', className: 'buttons-addspb',
            },
            @endif
            {
              text:'<i class="ft-box"></i><i class="ft-chevrons-right"></i> Status', className: 'buttons-statusmulti',
            },
            { extend: 'colvis', text: 'Column' },'copy', 'csv', 'excel', 'pdf', 'print',
            {
              extend: 'csv',
              text: 'CSV All',
              className: 'buttons-csvall',
              action: function ( e, dt, node, config ) {
                  window.location = '{{ url('manifest/'.$manifest->id.'/spb/csvall') }}'
              }
            },
            {
              text: '<i class="ft-slash"></i> Keluarkan', className: 'buttons-deletemulti',
              action: function ( e, dt, node, config ) {

              }
            },  
        ],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        columnDefs: [ {
            targets: 0,
            data: null,
            defaultContent: '',
            orderable: false,
            searchable: false,
            checkboxes: {
                'selectRow': true
            }
        },{
            targets: ['id','created_at','updated_at','created_by','updated_by','deleted_at'],
            visible: false,
            searchable: false,
        },{
            targets: ['no_po','address','pic_contact','pic_phone','no_manifest','province','city','type'],
            visible: false,
        }
        ],
        select: {
            style:    'multi',
            selector: 'td:first-child'
        },
        order: [[1, 'DESC']],
        fnRowCallback : function(row, data) {
          $('td.status_code', row).addClass(data['status_code']);
          $('td.status_code', row).wrapInner('<a title="Tracking" href="{{ url('spb') }}/'+ data['id'] +'/track" />');
          $('td.no_spb', row).wrapInner('<a title="Daftar Barang" href="{{ url('spb') }}/'+ data['id'] +'/item" />');
        }
    });
    $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel, .buttons-colvis, .buttons-csvall').addClass('btn btn-outline-primary mr-1');
    $('.buttons-add').addClass('btn mr-1');
    $('.buttons-deletemulti').addClass('btn-danger mr-1');
    $('.buttons-statusmulti').addClass('btn-info mr-1');
    $('.buttons-addspb').addClass('btn-warning mr-1');

    $('.buttons-deletemulti').click(function(){
      var deleteids_arr = [];
      var rows_selected = table.column(0).checkboxes.selected();
      $.each(rows_selected, function(index, rowId){
         deleteids_arr.push(rowId);
      });
      var deleteids_str = encodeURIComponent(deleteids_arr);

      // Check any checkbox checked or not
      if(deleteids_arr.length > 0){
        var confirmdelete = confirm("Keluarkan semua SPB terpilih?");
        if (confirmdelete == true) {
          window.location = '{!! url('manifest/spb/destroymulti?manifest_id='.$manifest->id.'&id=') !!}'+deleteids_str
        } 
      }
    });

    $('.buttons-statusmulti').click(function(){
      var updateids_arr = [];
      var rows_selected = table.column(0).checkboxes.selected();
      $.each(rows_selected, function(index, rowId){
        updateids_arr.push(rowId);
      });
      var updateids_str = encodeURIComponent(updateids_arr);

      // Check any checkbox checked or not
      if(updateids_arr.length > 0){
        var confirmupdate = confirm("Ubah seluruh data terpilih?");
        if (confirmupdate == true) {
          $("#sel_spb_ids").val(updateids_str);
          $("#spb-status-modal").modal('show');
        } 
      }
    });

    $('.buttons-addspb').click(function(){
      $("#spb-add-modal").modal('show');
    });

    $('#searchspbterm').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
          $('#searchspbbutton').click();
        }
    });
    $('#searchspbbutton').click(function(){
      $("#searchspbresult").empty();
      var term = $('#searchspbterm').val();
      $.ajax({
        url: "{{ url('/spb/searchjson') }}", 
        data: {term: term, limit: 100}, 
        success: function(result){
        $.each(result, function(k,v) {
          $('#searchspbresult').append( '<button class="btn btn-block btn-outline-primary spbresult mr-1" data-nospb="'+v.value+'" title="'+v.desc+'">'+v.value+' - '+v.desc+'</button>' );
        });
      }});
    });
    $("#searchspbresult").on('click', '.spbresult', function() {
      $(this).toggleClass("btn-outline-primary");
      $(this).toggleClass("btn-primary");      
      var nospb = $(this).data('nospb');
      var $date = $('#spb2');
      $date.val($date.val() + nospb + ',');
    });

    $('.filterstatus').click( function() {
      var clicked = !$(this).hasClass($(this).data("status"));
      // reset all button
      $('.filterstatus').each(function(){
        $(this).addClass($(this).data("status"));
      });
      if(!clicked){
        $(this).toggleClass($(this).data("status"));// turn on/off button
      }
      if(!$(this).hasClass($(this).data("status"))){
        $('#filterstatus').val($(this).data("status"));// clicked, set filter
      }else{
        $('#filterstatus').val(-1);// unclicked, unset filter
      }
      table.draw();
    } );
});
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script>
$(document).ready(function(){
  $("select[name='user_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='user_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='user_id']").attr('data-size','4'); // dropdown search with bootstrap select
  $("select[name='city_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='city_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='city_id']").attr('data-size','4'); // dropdown search with bootstrap select
  $("select[name='warehouse_city_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='warehouse_city_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='warehouse_city_id']").attr('data-size','4'); // dropdown search with bootstrap select
});
</script>
@endsection
