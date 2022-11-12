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
            <button type="button" class="btn btn-primary waves-effect waves-float waves-light waves-effect addNew" data-bs-toggle="modal" data-bs-target="#RealWeedingCategoriesModal">
                <i data-feather="plus" class="fw-bold"></i> Add New
            </button>
        </div>
    </div>
</div>

  <!-- Responsive Datatable -->
  <section id="responsive-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable">
                    <table class="dt-responsive table" id="RealWeedingCategoriesTable">
                        <thead>
                            <tr>
                                <th class="text-center">SL</th>
                                <th>Title</th>
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
<div class="modal fade" id="RealWeedingCategoriesModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modaltitle" id="">Create real weeding category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" method="POST" action="{{route('real-weeding-type.store')}}" id="RealWeedingCategoriesForm">
                    @csrf
                    <input type="hidden" id="dataId" name="id">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-vertical">Title</label>
                                <input type="text" id="first-name-vertical " class="form-control title" name="title" placeholder="Title" >
                                <span class="text-danger text-xs errors error_title"></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="contact-info-vertical">Sort order</label>
                                <input type="number" id="contact-info-vertical" class="form-control sortOrder" name="sort_order" placeholder="Sort Order" >
                                <span class="text-danger text-xs errors error_sort_order"></span>
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
<script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('assets/customs/customs.js')}}"></script>

<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var t = $('#RealWeedingCategoriesTable').DataTable({
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
                    "data": "title",
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

        $("#RealWeedingCategoriesTable").on('draw.dt', function(){
            let n = 0;
            $(".index-td").each(function(){
                n = n+1;
                if(n!=1)
                    $(this).html(n-1);
            });
        });

        $(document).on("submit", "#RealWeedingCategoriesForm", function (e) {
            e.preventDefault();
            $(".errors").html("");
            formSubmit("RealWeedingCategoriesForm",$(this).attr("action"),"RealWeedingCategoriesModal",t)

        })

        $(document).on("click",".editData",function(e){
            $(".modaltitle").html("Update real weeding category");
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
                    $("#RealWeedingCategoriesModal").modal("show");
                },
                complete : function(data){
                    //$( ".submitButton" ).html(submitButton);
                }
            })
        });

        $(document).on("click",".deleteData",function(e){
            let url = $(this).attr('data-url');
            deleteData(url,t);
        });

        $(document).on("click",".addNew",function(){
            $('#RealWeedingCategoriesForm')[0].reset();
            $("#dataId").val('');
            $(".modaltitle").html("Create real weeding category");
            $(".buttonTitle").html("Save");
        });



    });
</script>
@endpush

