<div class="px-3">
              <div class="form-body">
                @foreach($cols as $key=>$val)
                  @if(!in_array($val['column'],['id','created_at','updated_at']))
                    @if($val['R']=='1')
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="{{ $val['column'] }}">@lang($val['caption']): </label>
                          <div class="col-md-9">
                          {!! $item->{$val['column']} ?? null !!}
                          </div>
                        </div>
                    @endif
                  @endif
                @endforeach      
              </div>
          </div>