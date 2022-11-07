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
            <button type="button" class="btn btn-primary waves-effect waves-float waves-light waves-effect addNew" data-bs-toggle="modal" data-bs-target="#weedingCategoryModal"><i data-feather="plus" class="fw-bold"></i> Add New</button>
        </div>
    </div>
</div>

  <!-- Responsive Datatable -->
  <section id="responsive-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable">
                    <table class="dt-responsive table" id="weedingCategoryTable">
                        <thead>
                            <tr>
                                <th class="text-center">SL</th>
                                <th class=>Image</th>
                                <th>Title</th>
                                <th>Sub title</th>
                                <th>Sort Order</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Responsive Datatable -->

{{-- Modal start --}}
<div class="modal fade" id="weedingCategoryModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modaltitle" id=""> New weeding category </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" method="POST" action="{{route('weeding-category.store')}}" id="popularVanueForm">
                    @csrf
                    <input type="hidden" id="dataId" name="id">
                    <div class="row">

                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-vertical">Title</label>
                                <input type="text"  class="form-control title" name="title" placeholder="Title" >
                                <span class="text-danger text-xs errors error_title"></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-vertical">Sub title</label>
                                <input type="text"  class="form-control sub_title" name="sub_title" placeholder="Sub Title" >
                                <span class="text-danger text-xs errors error_sub_title"></span>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-vertical">Sort Order</label>
                                <input type="number" class="form-control sort_order" name="sort_order" placeholder="Sort Order" >
                                <span class="text-danger text-xs errors error_sort_order"></span>
                            </div>
                        </div>

                        <div class="preView text-center" id="holder">
                            <img class="img-container img-fluid" style="height: 10rem;" src="{{asset("common/image-placeholder.png")}}">
                        </div>
                        <div class="input-group d-flex justify-content-center pt-2">
                            <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose image
                            </a>
                            </span>
                            <input id="thumbnail" class="form-control d-none" type="text" value="" name="photo">
                        </div>

                        <span class="text-danger text-xs errors error_photo"></span><br>

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

@push("scripts")
<script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('assets/customs/customs.js')}}"></script>
<script src="{{asset('assets/customs/stand-alon.js')}}"></script>

<script>
    $(document).ready(function () {

        $('#lfm').filemanager('image');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var t = $('#weedingCategoryTable').DataTable(
                {
                    "scrollX":false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": "",
                    "order": [[ 2, "desc" ]],
                    "columns": [
                {
                    "className": 'index-td text-center',
                    "data": null,
                    "defaultContent": '#',
                },
                {
                    "width":"20%",
                    "className": 'image-td',
                    "data": "image",
                },
                {
                    "data": "title",
                },
                {
                    "data": "sub_title",
                },
                {
                    "data": "sort_order",
                },
                {
                    "data":"id",
                    "orderable": false,
                    "searchable": false,
                    "className": 'action text-center',
                    render: function(data, type, row) {
                            return `<button type="button" title="Edit" class="btn btn-primary btn-sm editData" data-url="${row.edit}"><i data-feather='edit-3'></i></button>
                            <button type="button" title="Delete" class="btn btn-danger btn-sm deleteData" data-url="${row.delete}"><i data-feather='trash' ></i></button>
                            `;
                    }
                },
                {
                    "data": "updated_at",
                    "visible": false,
                },
            ],
        });

        t.draw();

        $("#weedingCategoryTable").on('draw.dt', function(){
            let n = 0;
            $(".index-td").each(function(){
                n = n+1;
                if(n!=1)
                    $(this).html(n-1);
            });
        });


        $(document).on("submit", "#popularVanueForm", function (e) {
            e.preventDefault();
            $(".errors").html("");
            formSubmit("popularVanueForm",$(this).attr("action"),"weedingCategoryModal",t)
        });

        $(document).on("click",".addNew",function(){
            $("#dataId").val('');
            $(".modaltitle").html("New weeding category");
            $(".buttonTitle").html("Save");
            $("#holder").html('<img class="img-container img-fluid" style="height: 10rem;" src="{{asset("common/image-placeholder.png")}}">')
        });

        $(document).on("click",".deleteData",function(e){
            let url = $(this).attr('data-url');
            deleteData(url,t);
        });

        $(document).on("click",".editData",function(e){
        $(".modaltitle").html("Update weeding category");
        $(".buttonTitle").html("Update");
        let url = $(this).attr('data-url');
        $.ajax({
            url : url,
            type : 'POST',
            beforeSend : function(){
            },
            success : function(response){
                const {data,photo} = response;
                const{id,title,sub_title,sort_order} = data;
                $("#dataId").val(id);
                $(".title").val(title);
                $(".sub_title").val(sub_title);
                $(".sort_order").val(sort_order);
                $("#holder").html(`<img class="img-container img-fluid" style="height: 10rem;" src="${photo}">`)
                $("#thumbnail").val(photo);

                $("#weedingCategoryModal").modal("show");

            },
            complete : function(data){
                //$( ".submitButton" ).html(submitButton);
            }
        })
    });

    })

</script>
@endpush
