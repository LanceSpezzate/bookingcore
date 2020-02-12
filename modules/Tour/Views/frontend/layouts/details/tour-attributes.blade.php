@php
    $terms_ids = $row->tour_term->pluck('term_id');
    $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
@endphp
@if(!empty($terms_ids) and !empty($attributes))
    @foreach($attributes as $attribute )
        @php $translate_attribute = $attribute['parent']->translateOrOrigin(app()->getLocale()) @endphp
        <div class="g-attributes {{$attribute['parent']->slug}} attr-{{$attribute['parent']->id}}">
            <h3>{{ $translate_attribute->name }}</h3>
            @php $terms = $attribute['child'] @endphp
            <div class="list-attributes">
                @foreach($terms as $term )
                    @php $translate_term = $term->translateOrOrigin(app()->getLocale()) @endphp
                    <div class="item {{$term->slug}} term-{{$term->id}}"><i class="icofont-check-circled"></i> {{$translate_term->name}}</div>
                @endforeach
            </div>
        </div>
    @endforeach
@endif