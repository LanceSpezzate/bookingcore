<div class="container">
    <div class="bravo_gallery">
        <div class="btn-group">
            @if($youtube)
                <a href="#" class="btn-transparent has-icon bravo-video-popup" data-toggle="modal" data-src="{{ str_ireplace("watch?v=","embed/",$youtube) }}" data-target="#video-{{$id}}">
                    @if($bg_image)
                        <img src="{{get_file_url($bg_image,'full')}}" class="img-fluid" alt="">
                    @endif
                    <div class="play-icon">
                        <img src="{{asset('module/vendor/img/ico-play.svg')}}" alt="Play background" class="img-fluid play-image">
                    </div>
                </a>
            @endif
        </div>
        <div class="modal fade" id="video-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content p-0">
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item bravo_embed_video" src="{{ str_ireplace("watch?v=","embed/",$youtube) }}" allowscriptaccess="always" allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>