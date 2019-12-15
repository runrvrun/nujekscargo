@extends('layouts.custapp')

@section('pagetitle')
    <title>{{ config('app.name', 'Laravel') }} | SPB</title>
@endsection

@section('content')
        <!-- BEGIN : Main Content-->
        <div class="">
          <div class="content-wrapper"><!-- DOM - jQuery events table -->
<section id="browse-table">
  <div class="row">
    <div class="col-12">
      @if(Session::has('message'))
      <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ ucfirst(Session::get('message')) }}</p>
      @endif
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">SPB <strong>{{ $customer->customer }}</strong></h4>
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
  .status_code a{color:#fff}
  .WHS,.OTW,.DLY,.RCV{display: inline-block; padding: 0.375rem 0.75rem;font-size: 1rem;line-height: 1;border-radius: 0.25rem;color: #fff;background-color: #000;}
  .WHS{background-color: #ff8040;}
  .OTW{background-color: #0080ff;}
  .DLY{background-color: #ffff00;color:#000;}
  .RCV{background-color: #408080;}
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
    var resp = false;
    if(window.innerWidth <= 800) resp=true;

    var table = $('.browse-table').DataTable({
        responsive: resp,
        processing: true,
        language: {
          processing: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="color:#bbbbbb"></i><span class="sr-only">Loading...</span> '
        },
        serverSide: true,
        ajax: {
          url: '{!! url('customerspb/indexjson') !!}',
          data : function(d){
            d.customer_id = '{{ $customer->id }}';
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
        ],
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'B>>"+
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            { extend: 'colvis', text: 'Column' },'copy', 'csv', 'excel', 'pdf', 'print',
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
            targets: ['id'],
            visible: false,
            searchable: false,
        },{
            targets: ['customer','payment_type','no_manifest','province','city','address','pic_contact','pic_phone','type'],
            visible: false,
        },{
            targets:['datetime'], render:function(data){
              return moment(data).format('DD-MM-YYYY HH:mm');
            }
        },
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
