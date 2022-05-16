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
                                <h3 class="card-label">List Category
                            </div>
                            <div class="card-toolbar">
                                <a href="add-product.php" class="btn btn-success font-weight-bolder font-size-sm">
                                <span class="svg-icon svg-icon-md svg-icon-white">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M13,11 L17,11 C19.0758626,11 20.7823939,12.5812954 20.980747,14.6050394 L20.2928932,15.2928932 C19.1327768,16.4530096 18.0387961,17 17,17 C16.5220296,17 16.1880664,16.8518214 15.5648598,16.401988 C15.504386,16.3583378 15.425236,16.3005045 15.2756717,16.1912639 C14.1361881,15.3625486 13.3053476,15 12,15 C10.7177731,15 9.87894492,15.3373247 8.58005831,16.1531954 C8.42732855,16.2493619 8.35077622,16.2975179 8.28137728,16.3407226 C7.49918122,16.8276828 7.06530257,17 6.5,17 C5.8272085,17 5.18146841,16.7171497 4.58539107,16.2273674 C4.21125802,15.9199514 3.94722374,15.6135435 3.82536894,15.4354062 C3.58523105,15.132389 3.4977165,15.0219591 3.03793571,14.4468552 C3.3073102,12.4994956 4.97854212,11 7,11 L11,11 L11,9 L13,9 L13,11 Z" fill="#000000"/>
                                            <path d="M12,7 C13.1045695,7 14,6.1045695 14,5 C14,4.26362033 13.3333333,3.26362033 12,2 C10.6666667,3.26362033 10,4.26362033 10,5 C10,6.1045695 10.8954305,7 12,7 Z" fill="#000000" opacity="0.3"/>
                                            <path d="M21,17.3570374 L21,21 C21,21.5522847 20.5522847,22 20,22 L4,22 C3.44771525,22 3,21.5522847 3,21 L3,17.4976746 C3.098145,17.5882704 3.2035241,17.6804734 3.31568417,17.7726326 C4.24088818,18.5328503 5.30737928,19 6.5,19 C7.52608715,19 8.26628185,18.7060277 9.33838848,18.0385822 C9.41243034,17.9924871 9.49377318,17.9413176 9.64386645,17.8468046 C10.6511414,17.2141042 11.1835561,17 12,17 C12.7988191,17 13.2700619,17.2056332 14.0993283,17.8087361 C14.2431314,17.9137812 14.3282387,17.9759674 14.3943239,18.0236679 C15.3273176,18.697107 16.0099741,19 17,19 C18.3748985,19 19.7104312,18.4390637 21,17.3570374 Z" fill="#000000" opacity="0.3"/>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>Add Product</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <div class="datatable datatable-default datatable-bordered datatable-loaded">
                                <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                <thead class="datatable-head">
                                    <tr class="datatable-row" style="left: 0px;">
                                        <th class="datatable-cell" style="width: 5%">
                                            <label class="checkbox">
                                                <input type="checkbox" class="select-all">
                                                <span></span></label>
                                        </th>
                                        <th class="datatable-cell" style="width:20%"><span>Image</span></th>
                                        <th class="datatable-cell" style="width:15%"><span>Name</span></th>
                                        <th class="datatable-cell" style="width:13%"><span>Price</span></th>
                                        <th class="datatable-cell" style="width:10%"><span>Discount</span></th>
                                        <th class="datatable-cell" style="width:10%"><span>View</span></th>
                                        <th class="datatable-cell" style="width: 14%"><span>Status</span></th>
                                        <th class="datatable-cell text-right" style="flex-grow:1"><span>Action</span></th>
                                    </tr>
                                </thead>
                                <tbody id="table-product" class="datatable-body">
                                </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-success mr-2 enable-all-product">Active Select Product</button>
                            <button type="button" class="btn btn-warning mr-2 disable-all-product">Non-Active Select Product</button>
                        </div>
                    </div>
                    <!--end::table--> 
                </div>
            </div>
	    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
<script>
    $(document).ready(function(){
        function getListProduct(){
            $.ajax({
                url         : '../API/product.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {get: 'list-product'},
                success     : function(data){
                    xhtml = ''
                    if(data.length > 0){
                        $.each(data, function(i, value){
                            xhtml += `<tr class="datatable-row" style="left: 0px;">
                                        <td class="datatable-cell" style="width: 5%">
                                            <label class="checkbox">
                                                <input type="checkbox" name="products" value="`+ value.product_id +`">
                                                <span></span></label>
                                        </td>
                                        <td class="datatable-cell" style="width:20%"><img src="../assets/uploads/product/`+ value.product_thumb +`" style="width: 80%;display:block;margin:0 auto;border-radius:5px;object-fit:cover"></td>
                                        <td class="datatable-cell" style="width:15%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.product_name +`</span></td>
                                        <td class="datatable-cell" style="width:13%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.product_price +`</span></td>
                                        <td class="datatable-cell" style="width:10%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.product_discount +`</span></td>
                                        <td class="datatable-cell" style="width:10%"><span><span class="label font-weight-bold label-lg label-rounded label-info label-inline">`+ value.product_view +`</span></span></td>`
                            if(value.product_status == 0){
                                xhtml += `<td class="datatable-cell" style="width:14%"><span><span class="label font-weight-bold label-lg label-rounded label-danger label-inline">Not Active</span></span></td>`
                            } else {
                                xhtml += `<td class="datatable-cell" style="width:14%"><span><span class="label font-weight-bold label-lg label-rounded label-primary label-inline">Active</span></span></td>`
                            }
                            xhtml += `<td class="datatable-cell text-right" style="flex-grow:1"><span>
                                            <a href="edit-product.php?product=`+ value.product_id +`">
                                                <button class="btn btn-icon btn-success btn-sm mr-2" data-toggle="tooltip" title="Edit this product">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </a>
                                            <button class="btn btn-icon btn-danger btn-sm mr-2 delete-product" data-product-id="`+ value.product_id +`" data-toggle="tooltip" title="Delete this product">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </span></td>
                                    </tr>`
                        })

                    } else {
                        $('#table-product').closest('.card-body').next('.card-footer').hide()
                        xhtml = '<center>Data not found</center>'
                    }
                    $('#table-product').html(xhtml)
                    $('[data-toggle="tooltip"]').tooltip()
                    $('table.table').DataTable({
                        responsive: true,
                        lengthMenu: [5, 10, 25, 50, 100],
                        "ordering": false
                    })
                }
            })
        }
        getListProduct()
        $(document).on('click', '.delete-product', function(){
            $this = $(this)
            $id = $this.data('product-id')
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure delete this product?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url         : '../API/product.php',
                        type        : 'POST',
                        dataType    : 'json',
                        data        : {product: $id, 'action': 'delete-product'},
                        success     : function(data){
                            if(data.status == 'success'){
                                Swal.fire("Success!", "Delete Product Success!", "success");
                                setTimeout(()=>{
                                    window.location.reload()
                                },1000)
                            } else {
                                Swal.fire("Error!", "Has an error, please try again!", "error");
                            }
                        }
                    })
                }
            })
        })
        // enable all product
        $('.enable-all-product').click(function(){
            $thisBtn = $(this)
            Swal.fire({
                title: "Are you sure?",
                text: "Active All Product?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, active them!"
            }).then(function(result) {
                if (result.value) {
                    var arr = []
                    $thisBtn.closest('.card-footer').prev('.card-body').find('tbody label.checkbox').each(function(index, value){
                        if($(value).find('input[type="checkbox"]').is(':checked')){
                            arr.push($(value).find('input[type="checkbox"]').val());
                        }
                    })
                    if(arr.length == 0){
                        Swal.fire("Error !", "Please choose product to enable!", "warning");
                    } else {
                        $.ajax({
                            url         : '../API/product.php',
                            type        : 'POST',
                            dataType    : 'json',
                            data        : {products: arr, 'action': 'enable-all'},
                            beforeSend  : function(){
                                $thisBtn.html('<i class="fas fa-spinner fa-spin"></i>')
                            },
                            success     : function(data){
                                setTimeout(()=>{
                                    if(data.status == 'success'){
                                        Swal.fire("Success!", "Enabled All Product!", "success");
                                        setTimeout(()=>{
                                            window.location.reload()
                                        },1000)
                                    } else {
                                        Swal.fire("Error!", "Has an error, please try again!", "error");
                                    }
                                    $thisBtn.html('Active Select Product')
                                },500)
                            }
                        })
                    }
                }
            })
        })
        // disable all product
        $('.disable-all-product').click(function(){
            $thisBtn = $(this)
            Swal.fire({
                title: "Are you sure?",
                text: "Disable All Product?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, disabled them!"
            }).then(function(result) {
                if (result.value) {
                    var arr = []
                    $thisBtn.closest('.card-footer').prev('.card-body').find('tbody label.checkbox').each(function(index, value){
                        if($(value).find('input[type="checkbox"]').is(':checked')){
                            arr.push($(value).find('input[type="checkbox"]').val());
                        }
                    })
                    if(arr.length == 0){
                        Swal.fire("Error !", "Please choose product to disabled!", "warning");
                    } else {
                        $.ajax({
                            url         : '../API/product.php',
                            type        : 'POST',
                            dataType    : 'json',
                            data        : {products: arr, 'action': 'disable-all'},
                            beforeSend  : function(){
                                $thisBtn.html('<i class="fas fa-spinner fa-spin"></i>')
                            },
                            success     : function(data){
                                setTimeout(()=>{
                                    if(data.status == 'success'){
                                        Swal.fire("Success!", "Disabled All Product!", "success");
                                        setTimeout(()=>{
                                            window.location.reload()
                                        },1000)
                                    } else {
                                        Swal.fire("Error!", "Has an error, please try again!", "error");
                                    }
                                    $thisBtn.html('Non-Active Select Product')
                                },500)
                            }
                        })
                    }
                }
            })
        })
    })
</script>
<?php require_once 'layout/blocks/footer.php'; ?>