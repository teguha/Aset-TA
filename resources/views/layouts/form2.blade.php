@extends('layouts.app')

@section('content')
@section('content-header')
    @include('layouts.base.subheadernobuttons')
@show
@php
$colors = [
1 => 'primary',
2 => 'info',
];
@endphp
<div class="{{ $container ?? 'container-fluid' }}">
	<form action="@yield('action', '#')" method="POST" autocomplete="@yield('autocomplete', 'off')">
		<div class="card card-custom mb-4">
			@section('card-header')
		    	<div class="card-header">
		    		<h3 class="card-title">@yield('card-title', $title)</h3>
					<div class="card-toolbar">
						@section('card-toolbar')
							@include('layouts.forms.btnBackTop')
						@show
					</div>
		        </div>
			@show

			<div class="card-body">
				@csrf
				@yield('card-body')
			</div>
			
			@section('buttons')
				<div class="card-footer">
					@section('card-footer')
						<div class="d-flex justify-content-between">
							@include('layouts.forms.btnBack')
							@include('layouts.forms.btnSubmitPage')
						</div>
					@show
				</div>
			@show
		</div>
        <div class="card card-custom">
            <div class="row">
                <div class="col-md-6">     
                    <div class="col-xs-12">
                        <div class="card card-custom">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex flex-column mr-5">
                                            <div class="card-header" style="padding-left:0.5rem!important;">
                                                <h5>
                                                    Alur Persetujuan
                                                </h5>
                                            </div> 
                                            <br>
                                            <div class="d-flex align-items-center justify-content-center">
                                                @php
                                                $menu =\App\Models\Globals\Menu::where('module', $module)->first();
                                                @endphp
                                                @if ($menu->flows()->get()->groupBy('order')->count() == 0)
                                                <span class="label label-light-info font-weight-bold label-inline" data-toggle="tooltip">Data tidak tersedia.</span>
                                                @else
                                                @foreach ($orders = $menu->flows()->get()->groupBy('order') as $i => $flows)
                                                @foreach ($flows as $j => $flow)
                                                <span class="label label-light-{{ $colors[$flow->type] }} font-weight-bold label-inline"
                                                    data-toggle="tooltip" title="{{ $flow->show_type }}">{{ $flow->role->name }}</span>
                                                @if (!($i === $orders->keys()->last() && $j === $flows->keys()->last()))
                                                <i class="mx-2 fas fa-angle-double-right text-muted"></i>
                                                @endif
                                                @endforeach
                                                @endforeach
                                                @endif
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="background:#e9eaf3;">
                    <div class="col-xs-12">
                        <div class="card card-custom" style="min-height:165px;">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                    <div class="d-flex flex-column mr-5">
                                        <a href="#" class="h4 text-dark text-hover-primary mb-5">
                                            Informasi
                                        </a>
                                        <p class="text-dark-50">
                                            Sebelum submit pastikan data {!! $title !!} tersebut sudah sesuai.
                                        </p>
                                    </div>
                                    <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                        @php
                                            $menu =\App\Models\Globals\Menu::where('module', $module)->first();
                                            $count = $menu->flows()->count();
                                            $submit = $count == 0 ? 'disabled' : 'enabled';
                                        @endphp
                                        <div style="display: none">
                                        @include('layouts.forms.btnBack')
                                        </div>
                                        @yield('submit-dropdown-content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</form>
</div>
@endsection