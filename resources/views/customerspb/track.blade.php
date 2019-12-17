@extends('layouts.app')

@section('pagetitle')
    <title>@lang('SPB Tracking')</title>
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
        <div style="position:absolute">
          <a href="{{ url('customerspb') }}" class="btn btn-primary pull-left"><i class="ft-arrow-left"></i> Kembali ke SPB</a>
        </div>
        <div>
          <a href="{{ url('customerspb/'.$spb->id.'/reporttrack') }}" class="btn btn-info pull-right"><i class="ft-printer"></i> Cetak Tracking</a>
        </div>
        <div class="card-header">
            <h4 class="card-title">{{ $spb->no_spb }}</h4>
        </div>
        <div class="card-header">
        <h5>{{ $spb->customer }} <i class="ft-arrow-right"></i> {{ $spb->recipient }}</h5>
        <br/><p>Tanggal pengiriman: {{ $spb->created_at->format('j F Y') }}</p>
        </div>
        <div class="card-content ">
          <div class="card-body card-dashboard table-responsive">
            <div id="tracking">
              <div class="text-center tracking-status-{{ $spb->status_code}}">
                <p class="tracking-status text-tight">{{ $spb->status }}</p>
              </div>
              <div class="tracking-list">
                @foreach($track as $key=>$val)
                <div class="tracking-item">
                    <div class="tracking-icon status-{{ $val->status_code }}">
                      {{ $val->status_code }}
                    </div>
                    <div class="tracking-date">{{ $val->created_at->format('d M Y') }}<span>{{ $val->created_at->format('H:i') }}</span></div>
                    <div class="tracking-content">{{ $val->process }} {{ $val->city }} <div>{{ $val->track }}</div><span>{{ $val->status }}</span></div>
                </div>
                @endforeach
              </div>
          </div>
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
<style>
  .tracking-status-WHS{background-color: #ff8040;}
  .tracking-status-OTW{background-color: #0080ff;}
  .tracking-status-DLY{background-color: #ffff00;color:#000;}
  .tracking-status-RCV{background-color: #408080;}
  .tracking-status-BTO,.tracking-status-ORD{background-color: #FF586B;}
  .tracking-status-PAI,.tracking-status-CLR{background-color: #008000;}
.tracking-detail {
 padding:3rem 0
}
#tracking {
 margin-bottom:1rem
}
[class*=tracking-status-] p {
 margin:0;
 font-size:1.1rem;
 color:#fff;
 text-transform:uppercase;
 text-align:center
}
[class*=tracking-status-] {
 padding:1.6rem 0
}
.tracking-list {
 border:1px solid #e5e5e5
}
.tracking-item {
 border-left:1px solid #e5e5e5;
 position:relative;
 padding:2rem 1.5rem .5rem 2.5rem;
 font-size:.9rem;
 margin-left:3rem;
 min-height:5rem
}
.tracking-item:last-child {
 padding-bottom:4rem
}
.tracking-item .tracking-date {
 margin-bottom:.5rem
}
.tracking-item .tracking-date span {
 color:#888;
 font-size:85%;
 padding-left:.4rem
}
.tracking-item .tracking-content {
 padding:.5rem .8rem;
 background-color:#f4f4f4;
 border-radius:.5rem
}
.tracking-item .tracking-content span {
 display:block;
 color:#888;
 font-size:85%
}
.tracking-item .tracking-icon {
 line-height:2.6rem;
 position:absolute;
 left:-1.3rem;
 width:2.6rem;
 height:2.6rem;
 text-align:center;
 border-radius:50%;
 font-size:1.1rem;
 background-color:#fff;
 color:#fff
}

.tracking-item .tracking-icon.status-WHS{background-color: #ff8040;}
.tracking-item .tracking-icon.status-OTW{background-color: #0080ff;}
.tracking-item .tracking-icon.status-DLY{background-color: #ffff00;color:#000;}
.tracking-item .tracking-icon.status-RCV{background-color: #408080;}
.tracking-item .tracking-icon.status-BTO,.tracking-item .tracking-icon.status-ORD{background-color: #FF586B;}
.tracking-item .tracking-icon.status-PAI,.tracking-item .tracking-icon.status-CLR{background-color: #008000;}

@media(min-width:992px) {
 .tracking-item {
  margin-left:10rem
 }
 .tracking-item .tracking-date {
  position:absolute;
  left:-10rem;
  width:7.5rem;
  text-align:right
 }
 .tracking-item .tracking-date span {
  display:block
 }
 .tracking-item .tracking-content {
  padding:0;
  background-color:transparent
 }
}
</style>
@endsection
@section('pagejs')
@endsection
