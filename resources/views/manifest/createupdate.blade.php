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
          @component('components.createupdate',['cols'=>$cols,'item'=>$items ?? null])
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection
@section('pagejs')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script>
$(document).ready(function(){
  $("select[name='vehicle_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='vehicle_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='vehicle_id']").attr('data-size','4'); // dropdown search with bootstrap select
  $("select[name='driver_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='driver_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='driver_id']").attr('data-size','3'); // dropdown search with bootstrap select
});
</script>
<script>
$(document).ready(function(){
  @if(isset($no_manifest))
  $("input[name='no_manifest']").val('{{ $no_manifest }}'); // fill next manifest no
  @endif
});
</script>
@endsection
