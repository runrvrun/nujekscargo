@extends('layouts.app')

@section('pagetitle')
    <title>{{ config('app.name', 'Laravel') }} | Manifest</title>
@endsection

@section('content')
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- DOM - jQuery events table -->
<section id="browse-table">
  <div class="row">
    <div class="col-12">
      @if ($errors->any())
      <p class="alert alert-danger">
        {!! ucfirst(implode('<br/>', $errors->all(':message'))) !!}
      </p>
      @endif
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Manifest</h4>
        </div>
        <div class="card-content">
          @component('components.createupdate',['cols'=>$cols,'item'=>$item ?? null])
            @slot('route')
              manifest
            @endslot
          @endcomponent          
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
<link rel="stylesheet" href="{{ asset('app-assets') }}/css/bootstrap-select.min.css">
@endsection
@section('pagejs')
<script src="{{ asset('app-assets') }}/js/bootstrap-select.min.js"></script>
<script>
$(document).ready(function(){
  $("select[name='vehicle_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='vehicle_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='vehicle_id']").attr('data-size','4'); // dropdown search with bootstrap select
  $("select[name='vehicle_id']").selectpicker();
  $("select[name='driver_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='driver_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='driver_id']").attr('data-size','4'); // dropdown search with bootstrap select
  $("select[name='driver_id']").selectpicker();
  $("select[name='origin_province_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='origin_province_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='origin_province_id']").attr('data-size','4'); // dropdown search with bootstrap select
  $("select[name='origin_province_id']").selectpicker();
  $("select[name='destination_province_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='destination_province_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='destination_province_id']").attr('data-size','4'); // dropdown search with bootstrap select
  $("select[name='destination_province_id']").selectpicker();
  $("select[name='destination2_province_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='destination2_province_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='destination2_province_id']").attr('data-size','4'); // dropdown search with bootstrap select
  $("select[name='destination2_province_id']").selectpicker();
  $("select[name='destination3_province_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='destination3_province_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='destination3_province_id']").attr('data-size','4'); // dropdown search with bootstrap select
  $("select[name='destination3_province_id']").selectpicker();
  $("select[name='destination4_province_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='destination4_province_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='destination4_province_id']").attr('data-size','4'); // dropdown search with bootstrap select
  $("select[name='destination4_province_id']").selectpicker();
});
</script>
<script>
$(document).ready(function(){
  @if(isset($no_manifest))
  $("input[name='no_manifest']").val('{{ $no_manifest }}'); // fill next manifest no
  $("input[name='no_manifest']").attr('readonly','readonly');
  @endif 
});
</script>
@endsection
