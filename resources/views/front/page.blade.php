@extends('front.layout.app')

@section('content')

<div class="page-title mb-0">
  <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumbs">
                <div class="col">
                <a href="{{route('front.home')}}">{{__('Home')}}</a>\{{$page->title}}
                </div>
               
              </ul>
        </div>
    </div>
  </div>
</div>

<div class="pt-5 pb-5 ">
    <div class="container ">
        <!-- Categories-->
        <div class="col-lg-12 mb-4 mt-4">
                <div class="">
                    <div class="body px-4 py-5" style="border: 1px solid gainsboro;border-radius: 5px; ">
                        <div class="d-page-content">
                            <h4 class="d-block text-center"><b>{{$page->title}}</b></h4>
                            {!! $page->details !!}
                        </div>
                    </div>
                </div>
            </div>
      </div>
</div>

@endsection