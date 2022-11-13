@extends('layouts.app')

@section('content')

{{-- <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}"> --}}
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/editors/quill/katex.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/editors/quill/quill.snow.css')}}">

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
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <a href="{{route('blog')}}" type="button" class="btn btn-primary waves-effect waves-float waves-light waves-effect addNew" ><i data-feather='arrow-left'></i> Back</a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Blog Edit -->
    <div class="blog-edit-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Form -->
                        <form class="mt-2" id="blogForm" action="{{route('blog.save')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="blog-edit-title">Title</label>
                                            <span class="title_remains">You have remains 150 character</span>
                                        </div>
                                        <input type="text" id="blog-edit-title" class="form-control" value="{{$model->title}}" name="title" />
                                        <span class="text-danger text-xs errors error_title"></span><br>
                                    </div>
                                    <input type="hidden" name="id" value="{{$model->id}}">
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" >Author</label>
                                        {{ Form::select('auther_id', $authors, $model->auther_id, array('class'=>' form-select', 'id'=>"", 'placeholder'=>'Please select author...')) }}
                                        <span class="text-danger text-xs errors error_auther_id"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" >Short Description</label>
                                            <span class="short_description_remains">You have remains 400 character</span>
                                        </div>
                                        <textarea class="form-control" name="short_description" id="" cols="30" rows="2">{!! $model->short_description !!}</textarea>
                                        <span class="text-danger text-xs errors error_short_description"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" >SEO keywords</label>
                                        <input type="text" class="form-control" name="seo_keywords" value="{{@$model->seo_keywords}}" title="Please use (,) comma for multiple tag" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" >Category</label>
                                        {{ Form::select('blog_category_id', $categoty, $blogCatagories, array('class'=>'select2 form-select',  'id'=>"blog_category_id", 'multiple'=>'true')) }}
                                        <span class="text-danger text-xs errors error_blog_category_id"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" >Status</label>
                                        {{ Form::select('status', $model->statuslist, $model->status, array('class'=>'form-select', "id"=>"status", 'placeholder'=>'Please select status...')) }}
                                        <span class="text-danger text-xs errors error_status"></span><br>
                                    </div>

                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" >Tags</label>
                                        <input type="text" class="form-control" name="tags" value="{{$model->tags}}" />
                                        <span class="text-danger text-xs errors error_tags"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 d-flex justify-content-between ">
                                    <div>
                                        <label class="form-label" for="">Publish date</label>
                                        <input type="date" id="fp-date" class="form-control flatpickr-date-time flatpickr-input" name="publish_date" value="{{$model->publish_date?date('Y-m-d', strtotime(@$model->publish_date)):date('Y-m-d')}}">
                                        {{-- <input type="text" id="blog-edit-title" class="form-control" value="{{$model->title}}" name="title" /> --}}
                                    </div>
                                    <div>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" id="customSwitch1" name="featured"
                                            @if($model->featured == true || $model->featured == '')
                                            checked
                                            @endif
                                            >
                                            <label class="form-check-label" for="customSwitch1">Is featured?</label>
                                        </div>
                                        &nbsp;&nbsp;
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" id="customSwitch2" name="comments"
                                            @if($model->comments == true || $model->comments == '')
                                            checked
                                            @endif
                                            >
                                            <label class="form-check-label" for="customSwitch2" >Comments</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label">Description</label>
                                        <div id="blog-editor-wrapper">
                                            <div id="blog-editor-container">
                                               <div class="editor">
                                                {!! $model->description !!}
                                                </div>
                                                <span class="text-danger text-xs errors error_description"></span><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-1">
                                    <div class="border rounded p-2">
                                        <h4 class="mb-1">Featured Image</h4>
                                        <div class="d-flex flex-column flex-md-row">

                                            <div class="preView text-center" id="holder">
                                                @if($model->photo)
                                                <img class="img-container img-fluid" style="height: 10rem;" src="{{asset("$model->photo")}}">
                                                @else
                                                <img class="img-container img-fluid" style="height: 10rem;" src="{{asset("common/image-placeholder.png")}}">
                                                @endif
                                            </div>
                                            <div class="featured-info">
                                                <div class="input-group d-flex justify-content-center pt-3">
                                                    <span class="input-group-btn"> &nbsp;
                                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                                            <i class="fa fa-picture-o"></i>
                                                            @if($model->photo)
                                                            Change image
                                                            @else
                                                            Choose image
                                                            @endif
                                                        </a>
                                                    </span>
                                                    @if($model->photo)
                                                    <input id="thumbnail" class="form-control d-none" type="text" value='{{asset("$model->photo")}}' name="photo">
                                                    @else
                                                    <input id="thumbnail" class="form-control d-none" type="text" value="" name="photo">
                                                    @endif
                                                </div>
                                                <span class="text-danger text-xs errors error_photo"></span><br>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <div class="d-flex justify-content-between" style="border-bottom: 1px solid;">
                                            <h6>SEO Section </h6>
                                            <button class="btn btn-sm" collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"> Edit SEO meta </button>
                                        </div>
                                        <div class="col-md-12 col-12 p-1" style="border-bottom: 1px solid;">
                                            <div class="mb-1">
                                                <p class="defaultMessage {{$model->id? 'd-none':''}}" style="font-size: 14px;">Setup meta title & description to make your site easy to discovered on search engines such as Google</p>
                                                <p class="showSeoTitle mb-0" style="color:#1a0dab;font-size: 17px;">
                                                    @if($model->id)
                                                    {{$model->seo_title?$model->seo_title:$model->title}}
                                                    @endif
                                                </p>
                                                <p class="showSeoPermalinks mb-0" style="color:#006621; font-size: 13px;" >
                                                    @if($model->id)
                                                    {{env("APP_URL").'/'.$model->slug }}
                                                    @endif
                                                </p>
                                                <p class="showSeoDescription mb-0" style="font-size: 13px;" >
                                                    @if($model->id)
                                                    {{$model->seo_description?$model->seo_description:$model->short_description}}
                                                    @endif
                                                </p>
                                                <p class="showSeoTags mb-0" style="font-size: 13px;" >
                                                    @if($model->id)
                                                    {{$model->seo_keywords}}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                      <div class="accordion-body">
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <div class="d-flex justify-content-between">
                                                    <label class="form-label" >SEO Title</label>
                                                    <span class="seo_title_remains">You have remains 120 character</span>
                                                </div>
                                                <input type="text" class="form-control" name="seo_title" value="{{@$model->seo_title}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <div class="d-flex justify-content-between">
                                                    <label class="form-label" >SEO Description</label>
                                                    <span class="seo_description_remains">You have remains 160 character</span>
                                                </div>
                                                <textarea class="form-control" name="seo_description" id="" cols="30" rows="1">{{@$model->seo_description}}</textarea>
                                            </div>
                                        </div>

                                      </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-50 d-flex" >
                                    <div class="submitButton">
                                        <button type="submit" class="btn btn-primary me-1">Save Changes</button>
                                    </div> &nbsp;
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>

                            </div>
                        </form>
                        <!--/ Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Blog Edit -->

</div>

<style>
  .ql-container{
    min-height: 10rem !important;
  }
</style>

@endsection

@push('scripts')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js')}}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/highlight.min.js')}}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/quill.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/page-blog-edit.js')}}"></script>
    <script src="{{asset('assets/customs/stand-alon.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.tutorialjinni.com/tagify/4.8.1/tagify.min.css" />
    <script src="https://cdn.tutorialjinni.com/tagify/4.8.1/jQuery.tagify.min.js"></script>
    <script src="{{asset('assets/customs/customs.js')}}"></script>
    <script>
        $(document).ready(function () {

            const remainsTask = (max, current) => {
                let currentLength = Number(current.length);
                let remains = max - currentLength;
                if(remains < 0 ){
                    $("#blogForm").submit();
                }
                return `You have remains ${remains} charecter`;
            }

            const seoTitleShow = () =>{
                $(".defaultMessage").hide()
                let blogTitle = $("input[name='title']").val();
                let seoTitle = $("input[name='seo_title']").val();

                if(seoTitle){
                    $(".showSeoTitle").html(`<strong>${seoTitle}</strong>`);
                }else{
                    $(".showSeoTitle").html(`<strong>${blogTitle}</strong>`);
                }
            }


            // const seoDescriptionShow =()=>{
            //     $(".showSeoDescription").html("fdfdfd");
            // }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
            const date = new Date();
            const currentMonth = month[date.getMonth()];
            const currentFullYear = date.getFullYear();
            const currentDate = date.getDate();

            const seoDescriptionShow = () =>{
                $(".defaultMessage").hide()
                let blogShortDesc = $("textarea[name='short_description']").val();
                let seoDescription = $("textarea[name='seo_description']").val();

                let dateFormate = currentMonth +' '+currentDate +', '+currentFullYear
                if(seoDescription){
                    $(".showSeoDescription").html(`<span>${dateFormate} - ${seoDescription}</span>`);
                }else{
                    $(".showSeoDescription").html(`<span>${dateFormate} - ${blogShortDesc}</span>`);
                }
            }

            $(document).on("keyup","input[name='title']",function(){
                seoTitleShow();
                 $('.title_remains').html(remainsTask(150 ,$(this).val()));
                let url = "{{route('blog.get-slug')}}";
                 $.ajax({
                    url: url,
                    type: "POST",
                    data: {title:$(this).val()},
                    success: function (response) {
                        console.log(response)
                       $(".showSeoPermalinks").html("{{env('APP_URL')}}/"+response)
                    }
                });

            });

            $(document).on("keyup","input[name='seo_title']",function(){
                seoTitleShow();
                 $('.seo_title_remains').html(remainsTask(120 ,$(this).val()))
            });

            $(document).on("keyup","textarea[name='short_description']",function(){
                seoDescriptionShow()
                $('.short_description_remains').html(remainsTask(400 ,$(this).val()))
            });

            $(document).on("keyup","textarea[name='seo_description']",function(){
                seoDescriptionShow()
                $('.seo_description_remains').html(remainsTask(160 ,$(this).val()))
            });

            $(document).on("keyup","input[name='seo_keywords']",function(){
                $('.showSeoTags').html($(this).val())
            });

            $('#lfm').filemanager('image');
            // The DOM element you wish to replace with Tagify
            var input = document.querySelector('input[name=tags]');
            // initialize Tagify on the above input node reference
            new Tagify(input)


            $(document).on('submit',"#blogForm",function (e) {
                let submitButton = $(".submitButton").html();
                $(".errors").html("");
                e.preventDefault();
                let url = $(this).attr('action');
                let title = $("input[name='title']").val();
                let auther_id = $("select[name='auther_id']").val();
                let blog_category_id = $("#blog_category_id").val();
                let status = $("select[name='status']").val();
                let tags = $("input[name='tags']").val();
                let featured = $('#customSwitch1').prop('checked');
                let comments = $('#customSwitch2').prop('checked');
                let description = $('.ql-editor').html();
                let photo = $('input[name="photo"]').val();
                let id = $('input[name="id"]').val();
                let short_description =  $('textarea[name="short_description"]').val();
                let publish_date = $('input[name="publish_date"]').val();

                let seo_title = $('input[name="seo_title"]').val();
                let seo_description = $('input[name="seo_description"]').val();
                let seo_keywords = $('input[name="seo_keywords"]').val();

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                            title,
                            auther_id,
                            blog_category_id,
                            status,
                            tags,
                            featured,
                            comments,
                            description,
                            photo,
                            id,
                            short_description,
                            publish_date,
                            seo_title,
                            seo_description,
                            seo_keywords
                        },
                    beforeSend: function () {
                        $(".submitButton").html(lodingButton);
                    },
                    success: function (response) {
                        const { status, message, errors } = response;
                        if (status == false) {
                            if (message) {
                                Swal.fire({
                                    icon: "error",
                                    title: `${message}`,
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                            }

                            if (errors) {
                                let errorsArr = Object.entries(errors);
                                for (let index = 0; index < errorsArr.length; index++) {
                                    $(".error_" + errorsArr[index][0]).html(
                                        errorsArr[index][1][0]
                                    );
                                }
                            }
                        }
                        if (status == true) {
                            Swal.fire({
                                // position: 'top-end',
                                icon: "success",
                                title: `${message}`,
                                showConfirmButton: false,
                                timer: 1500,
                            }).then(() => {
                                window.location.replace("{{route('blog')}}")
                            });
                        }
                    },
                    complete: function (data) {
                        $(".submitButton").html(submitButton);
                    },
                });

            });


        });
    </script>
@endpush
