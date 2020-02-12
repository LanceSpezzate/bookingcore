@extends('layouts.user')
@section('content')
    <h2 class="title-bar">
        {{__("Update verification data")}}
    </h2>
    @include('admin.message')
    <div class="booking-history-manager">
        <form action="{{route("user.verification.store")}}" method="post">
            @csrf
            @foreach($fields as $field)
                @switch($field['type'])
                    @case("email")
                    @include('User::frontend.verification.fields.email')
                    @break
                    @case("phone")
                    @include('User::frontend.verification.fields.phone')
                    @break
                    @case("file")
                    @include('User::frontend.verification.fields.file')
                    @break
                    @case("multi_files")
                    @include('User::frontend.verification.fields.multi_files')
                    @break
                    @case('text')
                    @default
                    @include('User::frontend.verification.fields.text')
                    @break
                @endswitch
            @endforeach
            <hr>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-4">
                    <button class="btn btn-success"> <i class="fa fa-save"></i> {{__("Save changes")}} </button>
                </div>
            </div>
        </form>
    </div>
@endsection
