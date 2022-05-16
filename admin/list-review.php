<?php require_once 'layout/blocks/header.php'; ?>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
		<div class="container">
        <div class="row">
            <div class="col-md-12">
                <!--begin::table--> 
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">List Review
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <div class="datatable datatable-default datatable-bordered datatable-loaded">
                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                            <thead class="datatable-head">
                                <tr class="datatable-row" style="left: 0px;">
                                    <th class="datatable-cell" style="flex-grow:1"><span>Product Name</span></th>
                                    <th class="datatable-cell" style="width: 20%"><span>Total Comment</span></th>
                                    <th class="datatable-cell" style="width: 20%"><span>New Comment At</span></th>
                                    <th class="datatable-cell" style="width: 20%"><span>Last Comment At</span></th>
                                    <th class="datatable-cell" style="width: 10%"><span>Average Rating</span></th>
                                    <th class="datatable-cell text-right" style="width: 15%"><span>Detail</span></th>
                                </tr>
                            </thead>
                            <tbody id="table-list-review" class="datatable-body">
                                
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end::table--> 
            </div>
        </div>
        <!--begin::modal--> 
        <!-- Modal-->
        <div class="modal fade" id="detail-comment" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Review Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                    <div class="timeline timeline-3">
                        <div class="timeline-items">
                            
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::modal-->
	    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
<script>
    $(document).ready(function(){
        function getListReview(){
            $.ajax({
                url         : '../API/review.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {get: 'list-review'},
                success     : function(data){
                    xhtml = ''
                    if(data.length > 0){
                        $.each(data,function(i,value){
                            xhtml += `<tr class="datatable-row" style="left: 0px;">
                                        <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.name +`</span></td>
                                        <td class="datatable-cell" style="width: 20%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.quantity +`</span></td>
                                        <td class="datatable-cell" style="width: 20%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.new +`</span></td>
                                        <td class="datatable-cell" style="width: 20%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.last +`</span></td>
                                        <td class="datatable-cell" style="width: 10%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.rating +` <i class="fas fa-star" style="color:#fad102"></i></span></td>
                                        <td class="datatable-cell text-right" style="width: 15%"><span>
                                            <button class="btn btn-success btn-sm list-review-product" data-product-id="`+ value.product_id +`" data-toggle="modal" data-target="#detail-comment">
                                                <i class="far fa-comments"></i> Detail
                                            </button>
                                        </span></td>
                                    </tr>`
                        })
                    } else {
                        xhtml = '<center>Data not found</center>'
                    }
                    $('#table-list-review').html(xhtml)
                    // $('table.table').DataTable({
                    //     responsive: true,
                    //     lengthMenu: [5, 10, 25, 50, 100],
                    //     "ordering": false
                    // })
                }
            })
        }
        getListReview()
        function getReviewProduct(id){
            $.ajax({
                url         : '../API/review.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {id: id, get: 'product-review-list'},
                success     : function(data){
                    console.log(data)
                    xhtml = ''
                    // render html review parent
                    $.each(data.product, function(i, value){
                        xhtml += `<div class="timeline-item">
                                    <div class="timeline-media">
                                        <img alt="Avatar" src="../assets/uploads/avatar/`+ value.user_avatar +`">
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="mr-2">
                                                <span class="text-dark-75 text-hover-primary font-weight-bold">`+ value.username +`</span>
                                                <span class="text-muted ml-2">`+ value.time +`</span>
                                                `
                        if(value.user_role == 3){
                            xhtml += '<span class="label label-primary font-weight-bolder label-inline ml-2">Admin</span>'
                        } else if(value.user_role == 2){
                            xhtml += '<span class="label label-success font-weight-bolder label-inline ml-2">Staff</span>'
                        } else {
                            xhtml += '<span class="label label-info font-weight-bolder label-inline ml-2">Member</span>'
                        }                        
                        xhtml +=  `<span class="font-weight-bold ml-2">`+ value.rating +`<i class="fas fa-star" style="color:#fad102"></i></span>
                                        </div>
                                            <button data-toggle="tooltip" title="Delete" class="btn btn-hover-light-primary btn-sm btn-icon delete-review" data-review-id="`+ value.review_id +`" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="flaticon2-trash"></i>
                                            </button>
                                        </div>
                                        <p class="p-0">`+ value.content +`</p>
                                    </div>
                                </div>`
                        // render html review children
                        $.each(value.children, function(i, value){
                            xhtml += `<div class="timeline-item ml-30">
                                        <div class="timeline-media">
                                            <img alt="Avatar" src="../assets/uploads/avatar/`+ value.user_avatar +`">
                                        </div>
                                        <div class="timeline-content">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="mr-2">
                                                    <span class="text-dark-75 text-hover-primary font-weight-bold">`+ value.username +`</span>
                                                    <span class="text-muted ml-2">`+ value.time +`</span>
                                                    `
                            if(value.user_role == 3){
                                xhtml += '<span class="label label-primary font-weight-bolder label-inline ml-2">Admin</span>'
                            } else if(value.user_role == 2){
                                xhtml += '<span class="label label-success font-weight-bolder label-inline ml-2">Staff</span>'
                            } else {
                                xhtml += '<span class="label label-info font-weight-bolder label-inline ml-2">Member</span>'
                            }                        
                            xhtml +=  `<span class="font-weight-bold text-muted ml-2">reply to `+ value.username +`</span>
                                            </div>
                                                <button data-toggle="tooltip" title="Delete" class="btn btn-hover-light-primary btn-sm btn-icon delete-review" data-review-id="`+ value.review_id +`" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="flaticon2-trash"></i>
                                                </button>
                                            </div>
                                            <p class="p-0">`+ value.content +`</p>
                                        </div>
                                    </div>`
                        })
                    })
                    $('.modal .modal-title').html(data.name)
                    $('.modal .modal-title').data('product-id',data.id)
                    $('.modal-body').find('.timeline-items').html(xhtml)
                    $('[data-toggle="tooltip"]').tooltip()
                }
            })
        }
        $(document).on('click', '.list-review-product', function(){
            $id = $(this).data('product-id')
            getReviewProduct($id)
        })
        $(document).on('click', '.delete-review', function(){
            $this = $(this)
            $productID = $this.closest('.modal-content').find('.modal-header .modal-title').data('product-id')
            $id = $(this).data('review-id')
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure delete this review?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url         : '../API/review.php',
                        type        : 'POST',
                        dataType    : 'json',
                        data        : {id: $id, 'action': 'delete-review'},
                        success     : function(data){
                            console.log(data)
                            if(data.status == 'success'){
                                Swal.fire("Success!", "Delete Review Success!", "success");
                                getReviewProduct($productID)
                                getListReview()
                            } else {
                                Swal.fire("Error!", "Has an error, please try again!", "error");
                            }
                        }
                    })
                }
            })
        })
    })
</script>
<?php require_once 'layout/blocks/footer.php'; ?>