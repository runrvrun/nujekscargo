@extends('layouts.app')

@section('pagetitle')
    <title>{{ config('app.name', 'Laravel') }} | @lang('Item')</title>
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
          <a href="{{ url('spb') }}" class="btn btn-primary pull-left"><i class="ft-arrow-left"></i> Kembali ke SPB</a>
        </div>
        <div class="card-header">
            <h4 class="card-title"><span class="{{ $spb->status_code }}">{{ $spb->status_code }}</span> {{ $spb->no_spb }}</h4>
        </div>
        <div class="card-header row col-12">
          <div class="sender col-5">
          <p>Pengirim:</p>
          {{ $spb->customer }}<br>{{ $spb->caddress }}<br>{{ $spb->ccity }}<br>{{ $spb->cprovince }}
          </div>
          <div class="col-2"></div>
          <div class="recipient col-5">
          <p>Penerima:</p>
          {{ $spb->recipient }}<br>{{ $spb->address }}<br>{{ $spb->city }}<br>{{ $spb->province }}
          </div>
        </div>
        <div class="card-header row col-12">
          <div class="payment col-5">Pembayaran: {{ $spb->payment_type }}</div>
          <div class="col-2"></div>
          <div class="created col-5">Dibuat oleh: {{ $spb->name }} ({{ $spb->created_at->format("j M Y") }})</div>
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
              <tfoot>
                <tr>
                  <th></th>                  
                  @foreach($cols as $val)
                  @if($val['B'])
                  @if($val['column']=='item')
                  <th>TOTAL</th>
                  @else
                  <th></th>
                  @endif
                  @endif
                  @endforeach
                  <th style="white-space: nowrap;"></th>
                </tr>
              </tfoot>
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

  .sender, .recipient{
    min-height: 150px;
    border: 1px solid #ccc;
  }
  .created{
    text-align: right;
  }
</style>
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
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>    
<script>
$(document).ready(function() {
    var resp = false;
    if(window.innerWidth <= 800) resp=true;

    var table = $('.browse-table').DataTable({
        responsive: resp,
        processing: true,
        serverSide: true,
        ajax: '{!! url('spb/'.$spb->id.'/item/indexjson') !!}',
        columns: [
          { data: 'id', name: 'checkbox' },
          @foreach($cols as $val)
          @if($val['B'])
          { data: '{{ $val['column'] }}', name: '{{ $val['dbcolumn'] }}'
          @if($val['type'] == 'decimal')
          , render: $.fn.dataTable.render.number( ',', '.', 3 ) 
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
              text: '<i class="ft-plus"></i> Add New', className: 'buttons-add',
              action: function ( e, dt, node, config ) {
                  window.location = '{{ url('spb/'.$spb->id.'/item/create') }}'
              }
            },  
            { extend: 'colvis', text: 'Column' },'copy', 'csv', 'excel', 'pdf', 'print',
            {
              extend: 'csv',
              text: 'CSV All',
              className: 'buttons-csvall',
              action: function ( e, dt, node, config ) {
                  window.location = '{{ url('spb/'.$spb->id.'/item/csvall') }}'
              }
            },
            {
              text: '<i class="ft-trash"></i> Delete', className: 'buttons-deletemulti',
              action: function ( e, dt, node, config ) {

              }
            },  
            {
              text: '<i class="ft-printer"></i> Cetak SPB', className: 'buttons-cetakspb',              
              action: function ( e, dt, button, config ) {
                window.open('{{ url('spb/'.$spb->id.'/report') }}');
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
        },        
        {
            targets: ['id','created_at','updated_at','created_by','updated_by'],
            visible: false,
            searchable: false,
        } ],
        select: {
            style:    'multi',
            selector: 'td:first-child'
        },
        order: [[1, 'DESC']],        
        footerCallback: function(row, data, start, end, display) {
          var api = this.api();        
          api.columns([3,4,5], {
            page: 'current'
          }).every(function() {
            var sum = this
              .data()
              .reduce(function(a, b) {
                var x = parseFloat(a) || 0;
                var y = parseFloat(b) || 0;
                return x + y;
              }, 0);
            $(this.footer()).html(sum);
          });
          api.columns([7], {
            page: 'current'
          }).every(function() {
            var sum = this
              .data()
              .reduce(function(a, b) {
                var x = parseFloat(a) || 0;
                var y = parseFloat(b) || 0;
                return x + y;
              }, 0);
            $(this.footer()).html(parseFloat(sum).toFixed(3));
          });
        },
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
          window.location = '{{ url('spb/'.$spb->id.'/item/destroymulti?id=') }}'+deleteids_str
        } 
      }
      });
});
</script>
@endsection
