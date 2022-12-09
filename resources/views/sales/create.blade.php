@extends('layouts.app')

@section('content')

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
                <div class="selsInfoSection text-center p-2 text-center  row">
                    <div class="w-50 col">
                        <div class="form-group">
                            <label for="date" style="float: left">Date</label>
                            <input type="date" class="form-control" id="date" aria-describedby="emailHelp" placeholder="Enter Date">
                        </div>
                    </div>
                    <div class="w-50 col">
                        <div class="form-group">
                            <label for="date" style="float: left">DSR</label>
                            <select class="form-control" id="date" aria-describedby="emailHelp" placeholder="Enter DSR">
                                <option value="">Select DSR</option>
                                @foreach ($dsr as $k=>$item)
                                <option value="{{$k}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="w-50 col">
                        <div class="form-group">
                            <label for="date" style="float: left">Market</label>
                            <select class="form-control" id="date" aria-describedby="emailHelp" placeholder="Enter Market">
                                <option value="">Select Market</option>
                                @foreach ($market as $k=>$item)
                                <option value="{{$k}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="w-50 col">
                        <div class="form-group">
                            <label for="date" style="float: left">Product</label>
                            <select class="form-control" id="selectProduct"  placeholder="Enter Product">
                                <option value="">Select Product</option>
                                @foreach ($product as $k=>$item)
                                <option value="{{$item->id}}" data-price="{{$item->sales_price}}" data-product = "{{$item->product_name}}">{{$item->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-datatable">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Sales Price</th>
                                <th>Take</th>
                                <th>Return</th>
                                <th>Sales</th>
                                <th>Damage</th>
                                <th>Commition</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="bodyItem">

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" ></th>
                                <th colspan="2"><h6>Net Amount</h6></th>
                                <th class="netTotal">0</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var salesNumber = [];

        $(document).on("change","#selectProduct",function(){
            let productName = $(this).find(':selected').attr('data-product');
            let productId = $(this).val();
            let productPrice = $(this).find(':selected').attr("data-price");

            salesNumber[productId] = {
                id:productId,
                name:productName,
                price:productPrice
            }
            createProductList(salesNumber[productId]);
        });

        function createProductList ({name, id,price}){
            var items = '';
            // salesNumber.map((product,i)=>{
            //     const {name, id,price} = product
                items  = `
                <tr>
                    <td>${id}</td>
                    <td>${name}</td>
                    <td>${price}</td>
                    <td class="p-1"><input type="text" class="form-contorl takes takes_${id} w-100" data-price="${price}" data-id="${id}"/></td>
                    <td class="p-1"><input type="text" class="form-contorl return takes_${id} w-100" data-price="${price}" data-id="${id}"/></td>
                    <td class="sales_${id}">0</td>
                    <td></td>
                    <td></td>
                    <td class="total_${id} grandTotal">0</td>
                    <td></td>
                </tr>
                `
                // <a class='delItem' title="Remove Item"><i class="fa fa-trash"><i></a>
            $("#bodyItem").append(items)
        }

        $(document).on("keyup",".takes",function(){
            let price = $(this).data("price");
            let qty = $(this).val();
            let id = $(this).data("id");
            $(".total_"+id).html(price * qty);
            $(".sales_"+id).html(qty);
            getGrandTotal()
        });
        $(document).on("keyup",".return",function(){
            let price = $(this).data("price");
            let id = $(this).data("id");
            let takenitem = $(".takes_"+id).val();
            let qty =takenitem - $(this).val();
            $(".sales_"+id).html(qty);
            $(".total_"+id).html(price * qty);
            getGrandTotal()
        });

        function getGrandTotal (){
            let gt = 0;
            $('.grandTotal').each(function(i, obj) {
                gt += parseInt($(this).html());
            });
            $(".netTotal").html(gt.toFixed(2))
            //console.log(gt);

        }

    });
</script>
@endpush
