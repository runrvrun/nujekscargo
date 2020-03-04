@extends('layouts.app')

@section('pagetitle')
    <title>{{ config('app.name', 'Laravel') }} | SPB</title>
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
        <div class="card-header">
          <h4 class="card-title">SPB</h4>
        </div>
        <div class="card-content">
          <div class="card-body card-dashboard">
            <div class="card-filter row">
              <div class="col-md-5">
                <button class="btn btn-primary-outline OTW filterstatus" data-status="OTW">OTW</button>
                <button class="btn btn-primary-outline WHS filterstatus" data-status="WHS">WHS</button>
                <button class="btn btn-primary-outline DLY filterstatus" data-status="DLY">DLY</button>
                <button class="btn btn-primary-outline RCV filterstatus" data-status="RCV">RCV</button>
                <button class="btn btn-primary-outline DIS filterstatus" data-status="DIS">DIS</button>
                {{ Form::hidden('filterstatus',-1,['id'=>'filterstatus'])}}
              </div>
              <div class="col-md-7">
                <div class="input-group">
                  <div id="daterange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                      <i class="fa fa-calendar"></i>&nbsp;
                      <span></span> <i class="fa fa-caret-down"></i>
                      {{ Form::hidden('startdate',null,['id'=>'startdate']) }}
                      {{ Form::hidden('enddate',null,['id'=>'enddate']) }}
                  </div>
                  <button class="btn btn-info" id="filterdaterange"><i class="ft-filter"></i> Filter</button>
                </div>
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
                  <th class="{{ $val['column'] }} {{ $val['type'] }}">@lang($val['caption'])</th>
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
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
<style>
  .status_code a{color:#fff}
  .WHS,.OTW,.DLY,.RCV,.BTO,.ORD,.NEW,.SEN,.IOP,.PAI,.CLR,.DIS{display: inline-block; padding: 0.375rem 0.75rem;font-size: 1rem;line-height: 1;border-radius: 0.25rem;color: #fff;background-color: #000;}
  .WHS{background-color: #ff8040;}
  .OTW{background-color: #0080ff;}
  .DLY{background-color: #ffff00;color:#000;}
  .RCV{background-color: #408080;}
  .BTO,.ORD{background-color: #FF586B;}
  .PAI,.CLR{background-color: #008000;}
  .DIS{background-color: #cc1818;}
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('pagejs')
<script src="app-assets/vendors/js/datatable/datatables.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/datatable/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/datatable/buttons.flash.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/datatable/jszip.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/datatable/pdfmake.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/datatable/vfs_fonts.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/datatable/buttons.html5.min.js" type="text/javascript"></script>
<script src="app-assets/vendors/js/datatable/buttons.print.min.js" type="text/javascript"></script>
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.15/dataRender/datetime.js"></script>    
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>    
<script>
$(document).ready(function() {

    // $('.browse-table thead tr').clone(true).appendTo( '.browse-table thead' );    
    // $('.browse-table thead tr:eq(0) th').html('');//clear content
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

    var resp = false;
    if(window.innerWidth <= 800) resp=true;

    var table = $('.browse-table').DataTable({
        responsive: resp,
        processing: true,
        language: {
            processing: 'Loading ... <i class="fa ft-loader fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span> '
        },
        serverSide: true,
        ajax: {
          url: '{!! url('spb/indexjson') !!}',
          data : function(d){
            @if(isset($branch->id))
            d.branch_id = {{ $branch->id }};
            @endif
            d.filterstatus = $('#filterstatus').val();
            d.enddate = $('#enddate').val();
            d.startdate = $('#enddate').val();
          }
        },
        columns: [
          { data: 'id', name: 'checkbox' },
          @foreach($cols as $val)
          @if($val['B'])
          { data: '{{ $val['column'] }}', name: '{{ $val['dbcolumn'] }}', className:'{{ $val['column'] }}' },
          @endif
          @endforeach
          { data: 'action', name: 'action' },
        ],
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'B>>"+
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            @if(session('privilege')[2]["add"] ?? 0)
            {
              text: '<i class="ft-plus"></i> Add New', className: 'buttons-add',
              action: function ( e, dt, node, config ) {
                  window.location = '{{ url('spb/create') }}'
              }
            },
            @endif  
            @if(session('privilege')[3]["add"] ?? 0)
            {
              text: '<i class="ft-layers"></i> Make Manifest', className: 'buttons-makemanifest',
              action: function ( e, dt, node, config ) {
              }
            },
            @endif  
            { extend: 'colvis', text: 'Column' },'copy', 'csv', 'excel', 'pdf', 'print',
            {
              extend: 'csv',
              text: 'CSV All',
              className: 'buttons-csvall',
              action: function ( e, dt, node, config ) {
                  window.location = '{{ url('spb/csvall') }}'
              }
            },
            @if(session('privilege')[2]["add"] ?? 0)
            {
              text: '<i class="ft-trash"></i> Hapus', className: 'buttons-deletemulti',
              action: function ( e, dt, node, config ) {
              }
            },  
            @endif
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
            targets: ['id','updated_at','created_by','updated_by'],
            visible: false,
            searchable: false,
        },{
            targets: ['no_po','no_manifest','province','city','pic_contact','pic_phone','type'],
            visible: false,
        },{
            targets:['datetime'], render:function(data){
              return moment(data).format('DD-MM-YYYY HH:mm');
            }
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
    $('.buttons-add, .buttons-makemanifest').addClass('btn mr-1');
    $('.buttons-deletemulti').addClass('btn-danger mr-1');

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
          window.location = '{{ url('spb/destroymulti?id=') }}'+deleteids_str
        } 
      }
    });
    
    $('.buttons-makemanifest').click(function(){
      var spbids_arr = [];
      var rows_selected = table.column(0).checkboxes.selected();
      $.each(rows_selected, function(index, rowId){
        spbids_arr.push(rowId);
      });
      var spbids_str = encodeURIComponent(spbids_arr);

      // Check any checkbox checked or not
      if(spbids_arr.length > 0){
        var confirmmake = confirm("Buat manifest dengan SPB terpilih?");
        if (confirmmake == true) {
          window.location = '{{ url('manifest/createfromspb?id=') }}'+spbids_str
        } 
      }
    });

    $('#filterdaterange').click( function() {
      daterange = $('#daterange').data('daterangepicker');
      $('#startdate').val(daterange.startDate.format('YYYY-MM-DD'));
      $('#enddate').val(daterange.endDate.format('YYYY-MM-DD'));
      table.draw();
    } );

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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#daterange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Hari ini': [moment(), moment()],
           'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           '7 Hari': [moment().subtract(6, 'days'), moment()],
           '30 Hari': [moment().subtract(29, 'days'), moment()],
           'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
           'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});
</script>
@endsection
