@extends('layouts.app')

@section('content')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/components.css')}}">
   <!-- END: Vendor CSS-->


<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
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
            <button type="button" class="btn btn-primary waves-effect waves-float waves-light waves-effect addNew" data-bs-toggle="modal" data-bs-target="#blogModal"><i data-feather="plus" class="fw-bold"></i> Add New</button>
        </div>
    </div>
</div>

{{-- <div class="input-group">
    <span class="input-group-btn">
      <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
        <i class="fa fa-picture-o"></i> Choose
      </a>
    </span>
    <input id="thumbnail" class="form-control" type="text" name="filepath">
  </div>
  <div id="holder" style="margin-top:15px;max-height:100px;"></div> --}}

{{-- <div class="input-group">
    <span class="input-group-btn">
      <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary">
        <i class="fa fa-picture-o"></i> Choose
      </a>
    </span>
    <input id="thumbnail2" class="form-control" type="text" name="filepath">
</div>

<div id="holder2" style="margin-top:15px;max-height:100px;"></div> --}}


{{-- Modal start --}}
<div class="modal fade" id="blogModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modaltitle" id="">Create new blog type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" method="POST" action="{{route('blog.store')}}" id="blogFrom">
                    @csrf
                    <input type="hidden" id="dataId" name="id">
                    <div class="row">
                        <div class="col-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Choose image
                                </a>
                                </span>
                                <input id="thumbnail" class="form-control d-none" type="text" name="photo">
                            </div>
                        </div>
                        <div class="col-7">
                            <div id="holder" style=""></div>
                        </div>
                        <span class="text-danger text-xs errors error_photo"></span>
                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-vertical">Title</label>
                                <input type="text" id="first-name-vertical " class="form-control title" name="title" placeholder="Title" >
                                <span class="text-danger text-xs errors error_title"></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="contact-info-vertical">Description</label>
                                <textarea class="form-control sortOrder" name="description" id="description" cols="30" rows="7"></textarea>
                                <span class="text-danger text-xs errors error_description"></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="contact-info-vertical">Category</label>
                                {{ Form::select('blog_category_id', $category, null, array('class'=>'form-control', 'placeholder'=>'Please select category...')) }}
                                <span class="text-danger text-xs errors error_blog_category_id"></span>
                            </div>
                        </div>



                        <div class="col-12 d-flex justify-content-end">
                            <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                            &nbsp;
                            <span class="submitButton">
                                <button type="submit" class="btn btn-primary waves-effect waves-float waves-light buttonTitle" >{{__("Submit")}}</button>
                            </span>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Modal end --}}


@endsection


@push('scripts')
{{-- <script src="{{asset('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')}}"></script> --}}
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script src="{{asset('assets/customs/customs.js')}}"></script>
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
        CKEDITOR.replace('description', options);
        (function( $ ){

            $.fn.filemanager = function(type, options) {
            type = type || 'file';

            this.on('click', function(e) {
                var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
                var target_input = $('#' + $(this).data('input'));
                var target_preview = $('#' + $(this).data('preview'));
                window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
                window.SetUrl = function (items) {
                var file_path = items.map(function (item) {
                    return item.url;
                }).join(',');

                // set the value of the desired input to image url
                target_input.val('').val(file_path).trigger('change');

                // clear previous preview
                target_preview.html('');

                // set or change the preview image src
                items.forEach(function (item) {
                    target_preview.append(
                    $('<img class="img-container img-fluid">').css('height', '10rem').attr('src', item.thumb_url)
                    );
                });

                // trigger change event
                target_preview.trigger('change');
                };
                return false;
            });
            }

        })(jQuery);

        $('#lfm').filemanager('file');

    });

$(document).ready(function () {
        // let formId = $("#blogFrom");
        // let modalId = $("#blogModal");
        let t = ()=>console.log('ddd');

        $(document).on("submit", "#blogFrom", function (e) {
            e.preventDefault();
            $(".errors").html("");
            formSubmit("blogFrom",$(this).attr("action"),"modalId",t)
        })

        $(document).on("click",".editData",function(e){
            $(".modaltitle").html("Update blog post");
            $(".buttonTitle").html("Update");
            let url = $(this).attr('data-url');
            $.ajax({
                url : url,
                type : 'POST',
                beforeSend : function(){
                    //$(".submitButton").html(lodingButton);
                },
                success : function(response){
                    const {id,title,sort_order} = response;
                    $("#dataId").val(id);
                    $(".title").val(title);
                    $(".sortOrder").val(sort_order);
                    $("#blogCategoryModal").modal("show");
                },
                complete : function(data){
                    //$( ".submitButton" ).html(submitButton);
                }
            })
        });

        // $(document).on("click",".deleteData",function(e){
        //     let url = $(this).attr('data-url');
        //     deleteData(url,t);
        // });

        // $(document).on("click",".addNew",function(){
        //     $('#blogFrom')[0].reset();
        //     $("#dataId").val('');
        //     $(".modaltitle").html("Create blog");
        //     $(".buttonTitle").html("Save");
        // });
});
</script>
@endpush
