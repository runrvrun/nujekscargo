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
              <div class="col-md-6">
                <button class="btn btn-primary btn-outline-primary" id="nomanifest">Belum Ada Manifest</button>
                <button class="btn btn-primary btn-outline-primary" id="havemanifest">Sudah Ada Manifest</button>
                {{ Form::hidden('filtermanifest',-1,['id'=>'filtermanifest'])}}
              </div>
              <div class="col-md-6">
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
@section('pagecss')
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
<style>
  .WHS,.OTW,.DLY,.RCV,.BTO,.ORD,.NEW,.SEN,.IOP,.PAI,.CLR{display: inline-block; padding: 0.375rem 0.75rem;font-size: 1rem;line-height: 1;border-radius: 0.25rem;color: #fff;background-color: #000;}
  .WHS{background-color: #ff8040;}
  .OTW{background-color: #0080ff;}
  .DLY{background-color: #ffff00;color:#000;}
  .RCV{background-color: #408080;}
  .BTO,.ORD{background-color: #FF586B;}
  .PAI,.CLR{background-color: #008000;}
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
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>    
<script>
$(document).ready(function() {

    $('.browse-table thead tr').clone(true).appendTo( '.browse-table thead' );
    
    $('.browse-table thead tr:eq(0) th').html('');//clear content
    $('.browse-table thead tr:eq(0) th').not(':first').not(':last').each( function (i){//skip first and last
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" />' );
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i+1).search() !== this.value ) {
                table
                    .column(i+1)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    var resp = false;
    if(window.innerWidth <= 800) resp=true;

    var table = $('.browse-table').DataTable({
        responsive: resp,
        processing: true,
        serverSide: true,
        ajax: {
          url: '{!! url('spb/indexjson') !!}',
          data : function(d){
            d.filtermanifest = $('#filtermanifest').val();
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
            {
              text: '<i class="ft-plus"></i> Add New', className: 'buttons-add',
              action: function ( e, dt, node, config ) {
                  window.location = '{{ url('spb/create') }}'
              }
            },  
            { extend: 'colvis', text: 'Column' },'copy', 'csv', 'excel', 'pdf', 'print',
            {
              extend: 'csv',
              text: 'CSV All',
              className: 'buttons-csvall',
              action: function ( e, dt, node, config ) {
                  window.location = '{{ url('spb/csvall') }}'
              }
            },
            {
              text: '<i class="ft-trash"></i> Delete', className: 'buttons-deletemulti',
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
            targets: ['id','created_at','updated_at','created_by','updated_by'],
            visible: false,
            searchable: false,
        },{
            targets: ['no_po','no_manifest'],
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
        }
    });
    $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel, .buttons-colvis, .buttons-csvall').addClass('btn btn-outline-primary mr-1');
    $('.buttons-add').addClass('btn mr-1');
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

    $('#nomanifest').click( function() {
        $(this).toggleClass('btn-outline-primary');
        if($(this).hasClass('btn-outline-primary')){
          $('#filtermanifest').val(-1);
        }else{
          $('#filtermanifest').val(0);
          $('#havemanifest').addClass('btn-outline-primary');
        }
        table.draw();
    } );
    $('#havemanifest').click( function() {
        $(this).toggleClass('btn-outline-primary');
        if($(this).hasClass('btn-outline-primary')){
          $('#filtermanifest').val(-1);
        }else{
          $('#filtermanifest').val(1);
          $('#nomanifest').addClass('btn-outline-primary');
        }
        table.draw();
    } );

    $('#filterdaterange').click( function() {
      daterange = $('#daterange').data('daterangepicker');
      $('#startdate').val(daterange.startDate.format('YYYY-MM-DD'));
      $('#enddate').val(daterange.endDate.format('YYYY-MM-DD'));
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
