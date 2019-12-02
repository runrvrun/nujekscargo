<div class="px-3">
          @if(isset($item))
              {{ Form::model($item, ['route' => [$route.'.update', $item->id], 'method' => 'patch']) }}
          @else
              {{ Form::open(['route' => $route.'.store']) }}
          @endif
              <div class="form-body">
                @foreach($cols as $key=>$val)
                  @if(!in_array($val['column'],['id','created_at','updated_at']))
                    @if($val['E']=='1' OR $val['A']=='1')
                      @switch($val['type'])
                        @case('dropdown')
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="{{ $val['column'] }}">@lang($val['caption']){!! isset($val['required'])? '<span class="required">*</span>':'' !!}: </label>
                          <div class="col-md-9">
                          {{ Form::select($val['column'], 
                            $val['dropdown_model']::pluck($val['dropdown_caption'],$val['dropdown_value']), 
                            old($val['column'],$item->{$val['column']} ?? null), 
                            array('class' => 'form-control',isset($val['required'])? 'required':'',isset($val['readonly'])? 'readonly':'')) }}
                          </div>
                        </div>    
                        @break
                        @case('enum')
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="{{ $val['column'] }}">@lang($val['caption']){!! isset($val['required'])? '<span class="required">*</span>':'' !!}: </label>
                          <div class="col-md-9">
                          {{ Form::select($val['column'], 
                            $val['enum_values'], 
                            old($val['column'],$item->{$val['column']} ?? null), 
                            array('class' => 'form-control',isset($val['required'])? 'required':'',isset($val['readonly'])? 'readonly':'')) }}
                          </div>
                        </div>    
                        @break
                        @case('textarea')
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="{{ $val['column'] }}">@lang($val['caption']){!! isset($val['required'])? '<span class="required">*</span>':'' !!}: </label>
                          <div class="col-md-9">
                          {{ Form::textarea($val['column'], old($val['column'],$item->{$val['column']} ?? null), array('class' => 'form-control',isset($val['required'])? 'required':'',isset($val['readonly'])? 'readonly':'','rows'=>4)) }}
                          </div>
                        </div>
                        @break
                        @case('email')
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="{{ $val['column'] }}">@lang($val['caption']){!! isset($val['required'])? '<span class="required">*</span>':'' !!}: </label>
                          <div class="col-md-9">
                          {{ Form::email($val['column'], old($val['column'],$item->{$val['column']} ?? null), array('class' => 'form-control',isset($val['required'])? 'required':'',isset($val['readonly'])? 'readonly':'')) }}
                          </div>
                        </div>
                        @break
                        @case('number')
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="{{ $val['column'] }}">@lang($val['caption']){!! isset($val['required'])? '<span class="required">*</span>':'' !!}: </label>
                          <div class="col-md-9">
                          {{ Form::number($val['column'], old($val['column'],$item->{$val['column']} ?? null), array('class' => 'form-control',isset($val['required'])? 'required':'',isset($val['readonly'])? 'readonly':'')) }}
                          </div>
                        </div>
                        @break
                        @case('decimal')
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="{{ $val['column'] }}">@lang($val['caption']){!! isset($val['required'])? '<span class="required">*</span>':'' !!}: </label>
                          <div class="col-md-9">
                          {{ Form::number($val['column'], old($val['column'],$item->{$val['column']} ?? null), array('class' => 'form-control',isset($val['required'])? 'required':'',isset($val['readonly'])? 'readonly':'')) }}
                          </div>
                        </div>
                        @break
                        @case('password')
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="{{ $val['column'] }}">@lang($val['caption']){!! isset($val['required'])? '<span class="required">*</span>':'' !!}: </label>
                          <div class="col-md-9">
                          {{ Form::password($val['column'], array('class' => 'form-control',isset($val['required'])? 'required':'',isset($val['readonly'])? 'readonly':'')) }}
                          </div>
                        </div>
                        @break
                        @default
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="{{ $val['column'] }}">@lang($val['caption']){!! isset($val['required'])? '<span class="required">*</span>':'' !!}: </label>
                          <div class="col-md-9">
                          {{ Form::text($val['column'], old($val['column'],$item->{$val['column']} ?? null), array('class' => 'form-control',isset($val['required'])? 'required':'',isset($val['readonly'])? 'readonly':'')) }}
                          </div>
                        </div>
                      @endswitch
                    @endif
                  @endif
                @endforeach      
              </div>
              <div class="form-actions">
                <a class="pull-right" href="{{ url($route) }}"><button type="button" class="btn btn-raised btn-warning mr-1">
                  <i class="ft-x"></i> Cancel
                </button></a>
                <button type="submit" class="pull-left btn btn-raised btn-primary mr-3">
                  <i class="fa fa-check-square-o"></i> Save
                </button>                
                @if($saveadd ?? 0)
                <button type="submit" name="saveadd" class="pull-left btn btn-raised btn-primary">
                  <i class="fa fa-check-square-o"></i><i class="fa fa-plus"></i> Save and Add More
                </button>
                @endif
              </div>
            </form>
          </div>