@extends('layouts.app')

@section('pagetitle')
    <title>{{ config('app.name', 'Laravel') }} | Pengguna</title>
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
          <h4 class="card-title">Pengguna</h4>
        </div>
        <div class="card-content">
          @component('components.createupdate',['cols'=>$cols,'item'=>$item ?? null])
            @slot('route')
              user
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
    $("select[name='branch_id']").addClass('selectpicker');
    $("select[name='branch_id']").attr('data-live-search','true');
    $("select[name='branch_id']").attr('data-size','5');
    $("select[name='branch_id']").selectpicker();
    // turn off autocomplete on password
    $("input[name='password']").attr('autocomplete','off');
  });
</script>
@endsection
