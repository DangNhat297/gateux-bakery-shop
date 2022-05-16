<?php require_once 'layout/blocks/header.php'; ?>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
		<div class="container">
        <div class="col-md-12">
                <!--begin::table--> 
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">List Order
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <div class="table-responsive">
                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                            <thead class="datatable-head">
                                <tr class="datatable-row" style="left: 0px;">
                                    <th class="datatable-cell" style="width: 10px"><span>ID.</span></th>
                                    <th class="datatable-cell" style="flex-grow:1"><span>Information</span></th>
                                    <th class="datatable-cell" style="width: 13%"><span>Order Date</span></th>
                                    <th class="datatable-cell" style="width: 13%"><span>Total Price</span></th>
                                    <th class="datatable-cell" style="width: 15%"><span>Status</span></th>
                                    <th class="datatable-cell" style="width: 20%"><span>Note</span></th>
                                    <th class="datatable-cell text-right" style="width: 10%"><span>Action</span></th>
                                </tr>
                            </thead>
                            <tbody id="table-list-order" class="datatable-body">
                                
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end::table--> 
            </div>
	    </div>
    <!--end::Container-->
</div>
<!--begin::modal--> 
<!-- Modal-->
<div class="modal fade" id="detail-order" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::modal-->
<!--end::Entry-->
<script>
    $(document).ready(function(){
        function getListOrder(){
            $.ajax({
                url         : '../API/order.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {get: 'list-order'},
                success     : function(data){
                    xhtml = ''
                    if(data.length > 0){
                        $.each(data, function(i,v){
                            xhtml += `<tr class="datatable-row" style="left: 0px;">
                                        <td class="datatable-cell" style="width: 10px"><span class="text-dark-75 font-weight-bolder d-block font-size-lg mb-2">#`+ v.id +`</span></td>
                                        <td class="datatable-cell" style="flex-grow:1">
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg mb-2">`+ v.fullname +`</span>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg mb-2">`+ v.phone +`</span>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg mb-2">`+ v.email +`</span>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ v.address +`</span>
                                        </td>
                                        <td class="datatable-cell" style="width: 13%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ v.date +`</span></td>
                                        <td class="datatable-cell" style="width: 13%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ v.total +`</span></td>
                                        <td class="datatable-cell" style="width: 15%">
                                            <select class="form-control order-status" data-order-id="`+ v.id +`" data-status="`+ v.status +`">
                                                <option value="0">Cancel</option>
                                                <option value="1">Pending</option>
                                                <option value="2">Shipping</option>
                                                <option value="3">Success</option>
                                            </select>
                                        </td>
                                        <td class="datatable-cell" style="width: 20%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg mb-2"">`+ (v.note=='' ? 'No' : v.note) +`</span></td>
                                        <td class="datatable-cell text-right" style="width: 10%">
                                            <button class="btn btn-icon btn-success btn-sm detail-order" data-order-id="`+ v.id +`" data-toggle="modal" data-target="#detail-order">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <button class="btn btn-icon btn-danger btn-sm delete-order" data-order-id="`+ v.id +`" data-toggle="tooltip" title="Delete">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>`
                        })
                    } else {
                        xhtml = '<p style="padding:10px;text-align:center">Data not found</p>'
                    }
                    $('#table-list-order').html(xhtml)
                    $('select.order-status').each(function(index, value){
                            var status = $(value).data('status')
                            $(value).val(status)
                    })
                    $('[data-toggle="tooltip"]').tooltip()
                }
            })
        }
        getListOrder()
        $(document).on('click', '.detail-order', function(){
            $id = $(this).data('order-id')
            $.ajax({
                url         : '../API/order.php',
                type        : 'POST',
                dataType    : 'html',
                data        : {get: 'detail-order-admin', id: $id},
                success     : function(data){
                    if(data.length > 0){
                        $('#detail-order .modal-body').html(data)
                    } else {
                        $('#detail-order .modal-body').html('<p class="text-center font-weight-bolder">Data not found</p>')
                    }
                }
            })
        })
        $(document).on('change', '.order-status', function(){
            var orderID = $(this).data('order-id')
            var status  = $(this).val()
            $.ajax({
                url         : '../API/order.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {id: orderID, status: status, action: 'change-status'},
                success     : function(data){
                    if(data.status == 'success'){
                        Swal.fire("Success", "Change Order Status Success", "success")
                        getListOrder()
                    } else {
                        Swal.fire("Error", "Has an error, try again", "error")
                    }
                }
            })
        })
        $(document).on('click', '.delete-order', function(){
            $orderID = $(this).data('order-id')
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure delete this order!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url         : '../API/order.php',
                    type        : 'POST',
                    dataType    : 'json',
                    data        : {id: $orderID, action: 'delete-order'},
                    success     : function(data){
                        if(data.status == 'success'){
                            Swal.fire("Success", "Delete Order Success", "success")
                            getListOrder()
                        } else {
                            Swal.fire("Error", "Has an error, try again", "error")
                        }
                    }
                })
            }
            })
        })
    })
</script>
<?php require_once 'layout/blocks/footer.php'; ?>