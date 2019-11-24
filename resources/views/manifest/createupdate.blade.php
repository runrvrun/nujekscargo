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
          @component('components.createupdate',compact('cols','item'))
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
@endsection
@section('pagejs')
<script>
$(document).ready(function(){
  @if(isset($no_manifest))
  $("input[name='no_manifest']").val('{{ $no_manifest }}'); // fill next manifest no
  @endif
});
</script>
@endsection
