@extends('Email::layout')
@section('content')
<div class="b-container">
    <div class="b-panel">
        <h1>{{__("Hello Administrator")}}</h1>

        <p>{{__('An user has been registered as Vendor. Please check the information bellow:')}}</p>
        <ul>
            <li>{{__('First name: :name',['name'=>$user->first_name])}}</li>
            <li>{{__('Last name: :name',['name'=>$user->last_name])}}</li>
            <li>{{__('Email: :email',['email'=>$user->email])}}</li>
            <li>{{__('Registration date: :date',['date'=>display_date($user->created_at)])}}</li>
        </ul>
        <p>{{__('You can approved the request here:')}} <a href="{{url('admin/module/user/userUpgradeRequest')}}">{{__('View request')}}</a></p>

        <br>
        <p>{{__('Regards')}},<br>{{setting_item('site_title')}}</p>
    </div>
</div>
@endsection