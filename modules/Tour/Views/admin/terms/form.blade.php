@if(!empty($attr))
    <input type="hidden" name="attr_id" value="{{$attr->id}}">
@endif
<div class="form-group">
    <label>{{__("Name")}}</label>
    <input type="text" value="{{$translation->name}}" placeholder="{{__("Term name")}}" name="name" class="form-control">
</div>
{{--<div class="form-group">--}}
    {{--<label class="control-label">{{__("Description")}}</label>--}}
    {{--<div class="">--}}
        {{--<textarea name="content" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->content}}</textarea>--}}
    {{--</div>--}}
{{--</div>--}}