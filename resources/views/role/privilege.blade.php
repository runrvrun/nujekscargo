@extends('layouts.app')

@section('pagetitle')
    <title>{{ config('app.name', 'Laravel') }} | Role</title>
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
          <h4 class="card-title">Role Privilege</h4>
        </div>
        <div class="card-content ">
        {{ Form::model('Role_privilege', ['url' => ['role/privilegesave'], 'method' => 'patch']) }}
          <div class="card-body card-dashboard table-responsive">
            <div class="form-group row">
              <label class="col-md-3 label-control" for="role_id">@lang('Role'): </label>
              <div class="col-md-9">
              {{ Form::select('role_id', App\Role::pluck('role','id'), $role_id ?? null, array('id'=>'role_id','class' => 'form-control')) }}
              </div>
            </div>    
            
            <table class="table">
              <thead>
                <tr>
                  <th>Halaman</th>
                  <th>Browse</th>
                  <th>Edit</th>
                  <th>Add</th>
                  <th>Delete</th>
                  </tr>
              </thead>
              @foreach($pages as $key=>$val)
              <tr>
                <td>{{ $val->page }}</td>
                <td>{{ Form::checkbox('priv['.$val->id.'][browse]',1, null, array('id'=>'priv'.$val->id.'browse','class'=>'privchk form-control form-control-sm')) }}
                <td>{{ Form::checkbox('priv['.$val->id.'][add]',1, null, array('id'=>'priv'.$val->id.'edit','class'=>'privchk form-control form-control-sm')) }}
                <td>{{ Form::checkbox('priv['.$val->id.'][edit]',1, null, array('id'=>'priv'.$val->id.'add','class'=>'privchk form-control form-control-sm')) }}
                <td>{{ Form::checkbox('priv['.$val->id.'][delete]',1, null, array('id'=>'priv'.$val->id.'delete','class'=>'privchk form-control form-control-sm')) }}
              </tr>
              @endforeach
            </table>

            <div class="form-actions">
                <a class="pull-right" href="{{ url('/role') }}"><button type="button" class="btn btn-raised btn-warning mr-1">
                  <i class="ft-x"></i> Cancel
                </button></a>
                <button type="submit" class="pull-left btn btn-raised btn-primary">
                  <i class="fa fa-check-square-o"></i> Save
                </button>
              </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
        </section>
          </div>
        </div>
@endsection
@section('pagecss')
@endsection
@section('pagejs')
<script>
  $(document).ready(function() {
    $( "#role_id" ).change();  
  });
  $( "#role_id" ).change(function() {
    var opt = $("option:selected", this);
    var val = this.value;
    // load privilege for that role
    $.ajax({
      url: "{{ url('/role/privilegejson') }}"+'/'+val,
      type: 'GET',
      success: function(data) {
        // uncheck all/reset
        $(".privchk").prop("checked",false);
        // check based on data
        data.forEach(function(item) {
          $("#priv"+item.page_id+"browse").prop("checked",item.browse);
          $("#priv"+item.page_id+"edit").prop("checked",item.edit);
          $("#priv"+item.page_id+"add").prop("checked",item.add);
          $("#priv"+item.page_id+"delete").prop("checked",item.delete);
        });
      }
    });
  });
</script>
@endsection
