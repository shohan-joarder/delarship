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

</div>

  <!-- Responsive Datatable -->
  <section id="responsive-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable">
                    <table class="dt-responsive table" id="vendorTable">
                        <thead>
                            <tr>
                                <th class="text-center">SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Verified</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Responsive Datatable -->


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
        var t = $('#vendorTable').DataTable({
                    "scrollX":false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{route('all-vendors')}}",
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
                    "data": "email",
                },
                {
                    "data": "phone",
                },
                {
                    "data": "status",
                    render:(data,type,row)=>{
                        console.log(data);
                        if(data == 1){
                            `<span class="btn btn-success btn-sm waves-effect waves-float waves-light">Active</span>`
                        }else{
                            `<span class="btn btn-danger btn-sm waves-effect waves-float waves-light">Inactive</span>`
                        }
                        // if(row === 1){
                        //     return  `<span class="btn btn-danger btn-sm waves-effect waves-float waves-light">Inactive</span>`
                        // }else{
                        //     return  `<span class="btn btn-success btn-sm waves-effect waves-float waves-light">Active</span>`
                        // }
                    }
                },
                {
                    "data": "verified",
                    render:(data,type,row)=>{
                        if (row == 1) {
                            return `<span class="btn btn-success btn-sm waves-effect waves-float waves-light">Yes</span>`
                        }else{
                            return `<span class="btn btn-danger btn-sm waves-effect waves-float waves-light">No</span>`
                        }
                    }
                },
                {
                    "data":"id",
                    "orderable": false,
                    "searchable": false,
                    "className": 'action text-center',
                    render: function(data, type, row) {
                         return `
                         <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input changeStatus" ${row.status == 1?'checked':''} id="customSwitch1" name="featured" data-id=${row.id} />
                            </div>`;
                    }
                },
                {
                    "data": "updated_at",
                    "visible": false,
                },
            ],
        });

        t.draw();

        $("#vendorTable").on('draw.dt', function(){
            let n = 0;
            $(".index-td").each(function(){
                n = n+1;
                if(n!=1)
                    $(this).html(n-1);
            });
        });

        $(document).on("click",".changeStatus",function(){
            let id = $(this).attr("data-id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "If Deleted, You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{route('change-user-status')}}",
                            type: "POST",
                            data:{id},
                            beforeSend: function () {
                                //$(".submitButton").html(lodingButton);
                            },
                            success: function (response) {

                            },
                            complete: function (data) {
                                t.draw();
                            }
                        })
                    }
                });

        });


    });
</script>
@endpush

