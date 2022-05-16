<?php require_once 'layout/blocks/header.php'; ?>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <div class="container">
        <!--Begin::form-->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Add Category Post</h3>
                    </div>
                    <!--begin::Form-->
                    <form id="add-category">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Category Name
                                    <span class="text-danger">*</span></label>
                                <input type="text" id="category" class="form-control" placeholder="Enter category" required>
                                <span class="form-text text-muted error category"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="btn-add-category" class="btn btn-primary mr-2">Add</button>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <!--End::form-->
        <div class="row">
            <div class="col-md-12">
                <!--begin::table-->
                <div class="card card-custom gutter-b">
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
                                        <th class="datatable-cell" style="width: 20px"><span>ID.</span></th>
                                        <th class="datatable-cell" style="flex-grow:1"><span>Category name</span></th>
                                        <th class="datatable-cell text-right" style="width: 20%"><span>Action</span></th>
                                    </tr>
                                </thead>
                                <tbody id="table-categories" class="datatable-body">

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
        <div class="modal fade" id="edit-category" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="update-category-modal">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Category Name
                                    <span class="text-danger">*</span></label>
                                <input type="text" id="modal-cate-name" class="form-control" placeholder="Enter category" required>
                                <span class="form-text text-muted error category"></span>
                            </div>
                            <div class="form-group">
                                <label>Created At
                                    <span class="text-danger"></span></label>
                                <input type="text" id="modal-cate-created" class="form-control" placeholder="Created At" disabled>
                            </div>
                            <input type="hidden" id="modal-cate-id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary font-weight-bold">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::modal-->
    </div>
</div>
<!--end::Entry-->
<script>
    $(document).ready(function() {
        // get data categories to table
        function fetchCategory() {
            $.ajax({
                url: '../API/category_blog.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    get: 'list-category'
                },
                success: function(data) {
                    xhtml = ''
                    if (data.length > 0) {
                        $.each(data, function(i, value) {
                            xhtml += `<tr class="datatable-row">
                                        <th class="datatable-cell" style="width: 20px"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">#`+ value.cate_id +`</span></th>
                                        <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">` + value.cate_name + `</span></td>`
                            xhtml += `<td class="datatable-cell text-right" style="width: 20%">
                                            <button type="button" data-cate-id="` + value.cate_id + `" data-toggle="modal" data-target="#edit-category" class="btn btn-icon btn-success btn-sm mr-2 edit-category"><i class="fas fa-edit"></i></button>`
                            xhtml += `<button type="button" data-cate-id="` + value.cate_id + `" data-toggle="tooltip" title="Delete" class="btn btn-icon btn-danger btn-sm mr-2 delete-category"><i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>`
                        })
                    } else {
                        xhtml = `<center>data not found</center>`
                    }
                    $('#table-categories').html(xhtml)
                    $('[data-toggle="tooltip"]').tooltip()
                }
            })
        }
        fetchCategory()
        // add category
        $('#add-category').submit(function(e) {
            e.preventDefault()
            $('span.error').html('')
            $catName = $(this).find('#category').val()
            $catName = $catName.trim()
            var arr = $catName.split(" ")
            for (var i = 0; i < arr.length; i++) {
                arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
            }
            $catName = arr.join(" ")
            $.ajax({
                url: '../API/category_blog.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    category: $catName,
                    'action': 'add-category'
                },
                beforeSend: function() {
                    $('button[name="btn-add-category"]').addClass('spinner spinner-white spinner-right').prop('disabled', true)
                },
                success: function(data) {
                    setTimeout(() => {
                        if (data.status == 'success') {
                            Swal.fire("Success!", "Add category success!", "success");
                            $('#category').val('')
                            fetchCategory()
                        } else {
                            $.each(data.message, function(index, value) {
                                $('span.error.' + index).html(value)
                            })
                            Swal.fire("Error!", "Add category failed, please try again!", "error");
                        }
                        $('button[name="btn-add-category"]').removeClass('spinner spinner-white spinner-right').html('Add').prop('disabled', false)
                    }, 1000)
                }
            })
        })
        // edit category -> get data to modal
        $(document).on('click', '.edit-category', function() {
            $('.modal').find('#modal-cate-name,button').prop('disabled', false)
            $('.modal-footer').find('button[type="submit"]').html('Update')
            var $id = $(this).data('cate-id')
            $.ajax({
                url: '../API/category_blog.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    category: $id,
                    'get': 'category'
                },
                success: function(data) {
                    $('#modal-cate-name').val(data.cate_name)
                    $('#modal-cate-created').val(data.created_at)
                    $('#modal-cate-id').val(data.cate_id)
                }
            })
        })
        // update category
        $('#update-category-modal').submit(function(e) {
            e.preventDefault()
            $this = $(this)
            $('.modal-body').find('span.error').html('')
            $catName = $this.find('#modal-cate-name').val()
            $catID = $this.find('#modal-cate-id').val()
            $catName = $catName.trim()
            var arr = $catName.split(" ")
            for (var i = 0; i < arr.length; i++) {
                arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
            }
            $catName = arr.join(" ")
            $.ajax({
                url: '../API/category_blog.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    category_name: $catName,
                    id: $catID,
                    action: 'update'
                },
                beforeSend: function() {
                    $this.find('button[type="submit"]').html('<i class="fas fa-circle-notch fa-spin"></i>').prop('disabled', true)
                },
                success: function(data) {
                    setTimeout(() => {
                        if (data.status == 'success') {
                            $this.find('button[type="submit"]').html('<i class="fas fa-check"></i> Updated')
                            fetchCategory()
                            getStats()
                            $this.find('input').prop('disabled', true)
                        } else {
                            $this.find('button[type="submit"]').html('Update').prop('disabled', false)
                            $.each(data.message, function(index, value) {
                                $('.modal-body').find('span.error.' + index).html(value)
                            })
                        }
                    }, 500)
                }
            })
        })
        // delete category
        $(document).on('click', '.delete-category', function() {
            $id = $(this).data('cate-id')
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure delete this category?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: '../API/category_blog.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            category: $id,
                            'action': 'delete'
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire("Success!", "Deleted Category!", "success");
                                fetchCategory()
                                getStats()
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