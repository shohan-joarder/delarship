@extends('layouts.app')

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">{{@$title}}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{@$title}}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <form action="{{route('blog-page.store')}}" class="row" id="blogPageForm" method="POST">
        @csrf
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Top banner section</h4>
                </div>
                <div class="card-body">

                    <label class="form-label" for="basic-default-password">Left banner title</label>
                    <div class="input-group form-password-toggle mb-1">
                        <input type="text" class="form-control" id="" placeholder="" value="{{@$allData->main_baner_title_1}}" aria-describedby="basic-default-password" name="main_baner_title_1" />
                    </div>
                    <span class="text-danger text-xs errors error_main_baner_title_1"></span> <br>

                    <label class="form-label" for="">Right banner title</label>
                    <div class="input-group form-password-toggle mb-1">
                        <input type="text" class="form-control" id="" placeholder="" aria-describedby="" value="{{@$allData->main_baner_title_2}}" name="main_baner_title_2" />
                    </div>
                    <span class="text-danger text-xs errors error_main_baner_title_2"></span>

                    <div class="preView text-center" id="holder">
                        @if(@$allData->main_baner)
                        <img class="img-container img-fluid" style="height: 10rem;" src="{{asset("$allData->main_baner")}}">
                        @else
                        <img class="img-container img-fluid" style="height: 10rem;" src="{{asset("common/image-placeholder.png")}}">
                        @endif
                    </div>
                    <div class="input-group d-flex justify-content-center pt-2">
                        <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose image
                        </a>
                        </span>
                        <input id="thumbnail" class="form-control d-none" type="text" value="{{@$allData->main_baner?@$allData->main_baner:''}}" name="main_baner">
                    </div>
                    <span class="text-danger text-xs errors error_main_baner"></span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Middle banner section</h4>
                </div>
                <div class="card-body">

                    <label class="form-label" for="basic-default-password">Middle banner title 1</label>
                    <div class="input-group form-password-toggle mb-1">
                        <input type="text" class="form-control" id="" placeholder="" value="{{@$allData->middle_banner_content_1}}" name="middle_banner_content_1" />

                    </div>
                    <span class="text-danger text-xs errors error_middle_banner_content_1"></span>

                    <label class="form-label" for="">Middle banner title 2</label>
                    <div class="input-group form-password-toggle mb-1">
                        <input type="text" class="form-control" id="" placeholder="" value="{{@$allData->middle_banner_content_2}}" name="middle_banner_content_2" />

                    </div>
                    <span class="text-danger text-xs errors error_middle_banner_content_2"></span>

                    <div class="preView text-center" id="holder2">
                        @if(@$allData->middle_banner)
                        <img class="img-container img-fluid" style="height: 10rem;" src="{{asset("$allData->middle_banner")}}">
                        @else
                        <img class="img-container img-fluid" style="height: 10rem;" src="{{asset("common/image-placeholder.png")}}">
                        @endif
                    </div>
                    <div class="input-group d-flex justify-content-center pt-2">
                        <span class="input-group-btn">
                        <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose image
                        </a>
                        </span>
                        <input id="thumbnail2" class="form-control d-none" type="text" value="{{@$allData->middle_banner?@$allData->middle_banner:''}}" name="middle_banner">

                    </div>
                    <span class="text-danger text-xs errors error_middle_banner"></span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Bottom banner section</h4>
                </div>
                <div class="card-body">

                    <label class="form-label" for="basic-default-password">Bottom banner title 1</label>
                    <div class="input-group form-password-toggle mb-1">
                        <input type="text" class="form-control" id="" placeholder=""  value="{{@$allData->bottom_banner_content_1}}" name="bottom_banner_content_1" />

                    </div>
                    <span class="text-danger text-xs errors error_bottom_banner_content_1"></span>

                    <label class="form-label" for="">Bottom banner title 2</label>
                    <div class="input-group form-password-toggle mb-1">
                        <input type="text" class="form-control" id="" placeholder="" aria-describedby="basic-default-password" value="{{@$allData->bottom_banner_content_2}}" name="bottom_banner_content_2" />

                    </div>
                    <span class="text-danger text-xs errors error_bottom_banner_content_2"></span>

                    <div class="preView text-center" id="holder3">
                        @if(@$allData->bottom_banner)
                        <img class="img-container img-fluid" style="height: 10rem;" src="{{asset("$allData->bottom_banner")}}">
                        @else
                        <img class="img-container img-fluid" style="height: 10rem;" src="{{asset("common/image-placeholder.png")}}">
                        @endif
                    </div>
                    <div class="input-group d-flex justify-content-center pt-2">
                        <span class="input-group-btn">
                        <a id="lfm3" data-input="thumbnail3" data-preview="holder3" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose image
                        </a>
                        </span>
                        <input id="thumbnail3" class="form-control d-none" type="text" value="{{@$allData->bottom_banner?@$allData->bottom_banner:''}}" name="bottom_banner">
                    </div>
                    <span class="text-danger text-xs errors error_bottom_banner"></span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Wedding Page Meta</h4>
                </div>
                <div class="card-body">

                    <template name="real_wedding_page_meta" id="blogPageMeta">{{@$allData->real_wedding_page_meta}}</template>

                </div>
            </div>
        </div>
        <span class="submitButton">
            <button type="submit" class="btn btn-primary waves-effect waves-float waves-light buttonTitle w-50" >{{__("Submit")}}</button>
        </span>
    </form>
</div>

@endsection

@push('scripts')
<script src="{{asset('assets/customs/customs.js')}}"></script>
<script src="{{asset('assets/customs/stand-alon.js')}}"></script>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
    var options = {
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
      filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };
</script>

<script>
    $(document).ready(function () {
        CKEDITOR.replace('blogPageMeta', options);
        $('#lfm').filemanager('image');
        $('#lfm2').filemanager('image');
        $('#lfm3').filemanager('image');
    });

    $(document).on("submit", "#blogPageForm", function (e) {
        e.preventDefault();
        $(".errors").html("");
        formSubmit("blogPageForm",$(this).attr("action"),"",'')
    });
</script>
@endpush
