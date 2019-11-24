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
      @if ($errors->any())
      <p class="alert alert-danger">
        {!! ucfirst(implode('<br/>', $errors->all(':message'))) !!}
      </p>
      @endif
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">@lang('Item')</h4>
        </div>
        <div class="card-content">
        <div class="px-3">
          @if(isset($item))
              {{ Form::model($item, ['route' => ['item.update', $item->id], 'method' => 'patch']) }}
          @else
              {{ Form::open(['route' => 'item.store']) }}
          @endif
              {{ Form::hidden('spb_id',$spb->id) }}
              <div class="form-body">
                <div class="form-group row">
                  <label class="col-md-2 label-control" for="no_po">@lang('Item'): </label>
                  <div class="col-md-10">
                  {{ Form::text('item', old('item',$item->item ?? null), array('class' => 'form-control','required')) }}
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 label-control" for="no_po">@lang('Bale'): </label>
                  <div class="col-md-4">
                  {{ Form::number('bale', old('bale',$item->bale ?? null), array('class' => 'form-control')) }}
                  </div>
                  <label class="col-md-2 label-control" for="no_po">@lang('Weight'): </label>
                  <div class="col-md-4">
                  {{ Form::number('weight', old('weight',$item->weight ?? null), array('class' => 'form-control','placeholder'=>'KG')) }}
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 label-control" for="no_po">@lang('Dimension'): </label>
                  <div class="col-md-3">
                  {{ Form::number('length', old('length',$item->length ?? null), array('class' => 'form-control','placeholder' => __('Length'))) }}
                  </div>
                  <div class="col-md-3">
                  {{ Form::number('width', old('width',$item->width ?? null), array('class' => 'form-control','placeholder' => __('Width'))) }}
                  </div>
                  <div class="col-md-3">
                  {{ Form::number('height', old('height',$item->height ?? null), array('class' => 'form-control','placeholder' => __('Height'))) }}
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 label-control" for="no_po">@lang('Packaging'): </label>
                  <div class="col-md-10">
                  {{ Form::text('packaging', old('packaging',$item->packaging ?? null), array('class' => 'form-control')) }}
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 label-control" for="no_po">@lang('No PO'): </label>
                  <div class="col-md-10">
                  {{ Form::text('no_po', old('no_po',$item->no_po ?? null), array('class' => 'form-control')) }}
                  </div>
                </div>
              </div>
              <div class="form-actions">
                <a class="pull-right" href="{{ url('/spb/'.$spb->id.'/item') }}"><button type="button" class="btn btn-raised btn-warning mr-1">
                  <i class="ft-x"></i> Cancel
                </button></a>
                <button type="submit" class="pull-left btn btn-raised btn-primary mr-3">
                  <i class="fa fa-check-square-o"></i> Save
                </button>                
                <button type="submit" name="saveadd" value=1 class="pull-left btn btn-raised btn-primary">
                  <i class="fa fa-check-square-o"></i><i class="fa fa-plus"></i> Save and Add More
                </button>
              </div>
            </form>
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
@endsection
@section('pagejs')
@endsection
