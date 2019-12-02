@extends('layouts.app')

@section('pagetitle')
    <title>{{ config('app.name', 'Laravel') }} | Armada</title>
@endsection

@section('content')
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!-- DOM - jQuery events table -->
<section id="browse-table">
  <div class="row">
    <div class="col-12">
      <div class="card">
      @if ($errors->any())
              <p class="alert alert-danger">
              {!! ucfirst(implode('<br/>', $errors->all(':message'))) !!}
              </p>
      @endif
        <div class="card-header">
          <h4 class="card-title">Armada</h4>
        </div>
        <div class="card-content">
          @component('components.createupdate',['cols'=>$cols,'item'=>$items ?? null])
            @slot('route')
              vehicle
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
@endsection
