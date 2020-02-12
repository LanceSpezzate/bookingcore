@extends('layouts.app')
@section('head')
	<link href="{{ asset('css/contact.css?_ver='.config('app.version')) }}" rel="stylesheet">
@endsection
@section('content')
<div id="bravo_content-wrapper">
	<div class="bravo_content">
		<div class="container">
			<div class="row section">
				<div class="col-md-12 col-lg-5">
					<div role="form" class="form_wrapper" lang="en-US" dir="ltr">
						<form method="post" action="{{url(app_get_locale().'/contact/store')}}"  class="bookcore-form">
							{{csrf_field()}}
							<div style="display: none;">
								<input type="hidden" name="g-recaptcha-response" value="">
							</div>
							<div class="contact-form">
								<div class="contact-header">
									<h3>{{ setting_item_with_lang("page_contact_title") }}</h3>
									<p>{{ setting_item_with_lang("page_contact_sub_title") }}</p>
                                </div>
								@include('admin.message')
								<div class="contact-form">
									<div class="form-group">
										<input type="text" value="" placeholder=" {{ __('Name') }} " name="name" class="form-control">
									</div>
									<div class="form-group">
										<input type="text" value="" placeholder="{{ __('Email') }}" name="email" class="form-control">
									</div>

									<div class="form-group">
										 <textarea name="message" cols="40" rows="10" class="form-control textarea" placeholder="{{ __('Message') }}"></textarea>
									</div>
									<div class="form-group">
										{{recaptcha_field('contact')}}
									</div>
									<p><input type="submit" value="{{ __('SEND MESSAGE') }}" class="form-control submit btn btn-primary"></p></div></div>
							</form>
					</div>
				</div>
				<div class="offset-lg-2 col-md-12 col-lg-5">
					<div class="contact-info">
						<div class="info-bg">
							@if($bg = get_file_url(setting_item("page_contact_image"),"full"))
								<img src="{{$bg}}" class="img-responsive" alt="{{ setting_item_with_lang("page_contact_title") }}">
							@endif
						</div>
						<div class="info-content">
							<div class="sub">
								<p>{!! setting_item_with_lang("page_contact_desc") !!}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer')

@endsection
