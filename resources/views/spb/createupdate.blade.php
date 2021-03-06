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
      @if ($errors->any())
      <p class="alert alert-danger">
        {!! ucfirst(implode('<br/>', $errors->all(':message'))) !!}
      </p>
      @endif
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">SPB</h4>
        </div>
        <div class="card-content">
          @component('components.createupdate',['cols'=>$cols,'item'=>$item ?? null])
            @slot('route')
              spb
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
  @if(isset($no_spb))
  $("input[name='no_spb']").val('{{ $no_spb }}'); // fill next spb no
  $("input[name='no_spb']").attr('readonly','readonly');
  @endif
  $("select[name='customer_id']").addClass('selectpicker'); // dropdown search with bootstrap select
  $("select[name='customer_id']").attr('data-live-search','true'); // dropdown search with bootstrap select
  $("select[name='customer_id']").selectpicker();
});
</script>
<script>
  // make city dropdown conditional to province
  $("select[name='province_id']").change(function () {
    var opt = $("option:selected", this);
    var val = this.value;
    $("select[name='city_id'] option").hide();
    $("select[name='city_id'] option[value^='"+ val +"']").show();
    $("select[name='city_id'] option[value^='"+ val +"']:first").attr('selected','selected');
    $("select[name='city_id']").attr('data-live-search','true');
    $("select[name='city_id']").attr('data-size','4');
    $("select[name='city_id']").selectpicker('refresh');
  });  
</script>
<script>
  $(document).ready(function(){
    $("select[name='province_id']").change();
    // dropdown search with bootstrap select
    $("select[name='province_id']").attr('data-live-search','true');
    $("select[name='province_id']").attr('data-size','4');
    $("select[name='province_id']").selectpicker();
    $("select[name='city_id']").attr('data-live-search','true');
    $("select[name='city_id']").attr('data-size','4');
    $("select[name='city_id']").selectpicker();
  });
</script>
@endsection
