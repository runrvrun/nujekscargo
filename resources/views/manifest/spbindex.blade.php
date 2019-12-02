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
        <hr/>
        <div class="card-content ">
        <form class="form-inline" method="POST" action="{{ url('manifest/spb/setmanifestmulti') }}">
            @csrf
            <div class="form-group mx-sm-3 mb-2 ui-widget">
                <label for="spb" class="mr-2">SPB</label>
                {{ Form::hidden('manifest_id',$manifest->id) }}
                <input type="spb" name="spb_add" size=50 class="form-control" id="spb" placeholder="Cari SPB">
            </div>
            <button type="submit" class="btn btn-primary mb-2"><i class="ft-plus"></i>Tambahkan SPB</button>
        </form>
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
<div class="modal fade text-left" id="spb-status-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="/manifest/spb/updatestatus" method="POST">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1">Update SPB Status: no_spb</h4>
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
          Keterangan: {{ Form::textarea('log',null,['class'=>'form-control','rows'=>3]) }}
          <div id="branchdriver" style="display:none">
          @lang('City'): {{ Form::select('city_id',\App\City::pluck('city','id'),null,['class'=>'form-control','id'=>'city_id','placeholder'=>' ']) }}
          @lang('PIC'): {{ Form::select('user_id',\App\User::pluck('name','id'),null,['class'=>'form-control','id'=>'user_id','placeholder'=>' ']) }}
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary"><i class="ft-save"></i> Simpan</button>
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

    // $('.browse-table thead tr').clone(true).appendTo( '.browse-table thead' );    
    // $('.browse-table thead tr:eq(0) th:first').html('');//clear content
    // $('.browse-table thead tr:eq(0) th:last').html('');//clear content
    // $('.browse-table thead tr:eq(0) th').not(':first').not(':last').each( function (i){//skip first and last
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" class="form-control" />' );
    //     $( 'input', this ).on( 'keyup change', function () {
    //         if ( table.column(i+1).search() !== this.value ) {
    //             table
    //                 .column(i+1)
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );

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
        ajax: '{!! url('manifest/'.$manifest->id.'/spb/indexjson') !!}',
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
            {
              text:'<i class="ft-eye"></i> Ubah Status', className: 'buttons-statusmulti',
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

    $('.buttons-deletemulti').click(function(){
      var deleteids_arr = [];
      var rows_selected = table.column(0).checkboxes.selected();
      $.each(rows_selected, function(index, rowId){
         deleteids_arr.push(rowId);
      });
      var deleteids_str = encodeURIComponent(deleteids_arr);

      // Check any checkbox checked or not
      if(deleteids_arr.length > 0){
        var confirmdelete = confirm("Hapus seluruh data terpilih?");
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
});
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) {
        return split( term ).pop();
    }

    $( "#spb" )
        // don't navigate away from the field on tab when selecting an item
        .on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
        })
        .autocomplete({
        source: function( request, response ) {
            $.getJSON( "{{ url('/spb/searchjson') }}", {
            term: extractLast( request.term )
            }, response );
        },
        search: function() {
            // custom minLength
            var term = extractLast( this.value );
            if ( term.length < 3 ) {
            return false;
            }
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
            var terms = split( this.value );
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( ", " );
            return false;
        }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
            .append( "<div>" + item.value + "<br>" + item.desc + "</div>" )
            .appendTo( ul );
        };
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script>
$(document).ready(function(){
  $("select[name='user_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='user_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='user_id']").attr('data-size','4'); // dropdown search with bootstrap select
  $("select[name='city_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='city_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='city_id']").attr('data-size','4'); // dropdown search with bootstrap select
});
</script>
@endsection
