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
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <div class="datatable datatable-default datatable-bordered datatable-loaded">
                                <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                <thead class="datatable-head">
                                    <tr class="datatable-row" style="left: 0px;">
                                        <th class="datatable-cell" style="width: 20%"><span>Image</span></th>
                                        <th class="datatable-cell" style="flex-grow:1"><span>Title</span></th>
                                        <th class="datatable-cell" style="width:10%"><span>View</span></th>
                                        <th class="datatable-cell text-right" style="width:15%"><span>Action</span></th>
                                    </tr>
                                </thead>
                                <tbody id="table-post" class="datatable-body">
                                </tbody>
                                </table>
                            </div>
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
                url         : '../API/blog.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {get: 'list-post'},
                success     : function(data){
                    console.log(data)
                    xhtml = ''
                    $.each(data, function(i, value){
                            xhtml += `<tr class="datatable-row" style="left: 0px;">
                                        <td class="datatable-cell" style="width: 20%"><img src="../assets/uploads/post/`+ value.blog_thumbnail +`" style="width: 80%;display:block;margin:0 auto;border-radius:5px;object-fit:cover"></td>
                                        <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.blog_title +`</span></td>
                                        <td class="datatable-cell" style="width:10%"><span><span class="label font-weight-bold label-lg label-rounded label-info label-inline">`+ value.blog_view +`</span></span></td>
                                        <td class="datatable-cell text-right" style="width:15%">
                                            <span>
                                                <a href="edit-post.php?id=`+ value.blog_id +`">
                                                    <button class="btn btn-icon btn-success btn-sm mr-2" data-toggle="tooltip" title="" data-original-title="Edit this post">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </a>
                                                <button class="btn btn-icon btn-danger btn-sm mr-2 delete-post" data-post-id="`+ value.blog_id +`" data-toggle="tooltip" title="" data-original-title="Delete this post">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>`
                    })
                    $('#table-post').html(xhtml)
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
        $(document).on('click', '.delete-post', function(){
            $this = $(this)
            $id = $this.data('post-id')
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure delete this post?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url         : '../API/blog.php',
                        type        : 'POST',
                        dataType    : 'json',
                        data        : {id: $id, 'action': 'delete-post'},
                        success     : function(data){
                            if(data.status == 'success'){
                                Swal.fire("Success!", "Delete Post Success!", "success");
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
    })
</script>
<?php require_once 'layout/blocks/footer.php'; ?>