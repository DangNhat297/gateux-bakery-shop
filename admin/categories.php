<?php require_once 'layout/blocks/header.php'; ?>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <div class="container">
        <!--Begin::form-->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Add Category Product</h3>
                    </div>
                    <!--begin::Form-->
                    <form id="add-category">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Category Name
                                    <span class="text-danger">*</span></label>
                                <input type="text" name="cat-name" class="form-control" placeholder="Enter category" required>
                                <span class="form-text text-muted error category"></span>
                            </div>
                            <div class="form-group">
                                <label>Category Thumbnail</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="thumbnail" accept=".png, .jpg, .jpeg, .jfif" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <div class="form-group preview-image" style="margin-top: 10px;"></div>
                                <span class="form-text text-muted error thumbnail"></span>
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
                                        <th class="datatable-cell" style="width: 5%">
                                            <label class="checkbox">
                                                <input type="checkbox" class="select-all">
                                                <span></span></label>
                                        </th>
                                        <th class="datatable-cell" style="flex-grow:1"><span>Product name</span></th>
                                        <th class="datatable-cell" style="width: 20%"><span>Status</span></th>
                                        <th class="datatable-cell text-right" style="width: 20%"><span>Action</span></th>
                                    </tr>
                                </thead>
                                <tbody id="table-categories" class="datatable-body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-success mr-2 enable-all-category">Enable All Category</button>
                        <button type="button" class="btn btn-warning mr-2 disable-all-category">Disable All Category</button>
                    </div>
                </div>
                <!--end::table-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!--begin::table-->
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">Stats Category
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <div class="datatable datatable-default datatable-bordered datatable-loaded">
                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                <thead class="datatable-head">
                                    <tr class="datatable-row" style="left: 0px;">
                                        <th class="datatable-cell" style="flex-grow:1"><span>Category Name</span></th>
                                        <th class="datatable-cell" style="width: 20%"><span>Product of Category</span></th>
                                        <th class="datatable-cell" style="width: 20%"><span>Max Price</span></th>
                                        <th class="datatable-cell" style="width: 20%"><span>Min Price</span></th>
                                        <th class="datatable-cell" style="width: 20%"><span>Average Price</span></th>
                                    </tr>
                                </thead>
                                <tbody id="table-stats" class="datatable-body">

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
                                <input type="text" name="cate-name" class="form-control" placeholder="Enter category" required>
                                <span class="form-text text-muted error category"></span>
                            </div>
                            <div class="form-group">
                                <label style="display:block">Category Thumbnail</label>
                                <div class="image-input image-input-empty image-input-outline" id="kt_user_edit_avatar">
                                    <div class="image-input-wrapper"></div>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="thumbnail" accept=".png, .jpg, .jpeg, .jfif" />
                                        <input type="hidden" name="profile_avatar_remove" />
                                    </label>
                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>
                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>
                                </div>
                                <span class="form-text text-muted error thumbnail"></span>
                            </div>
                            <div class="form-group">
                                <label>Created At
                                    <span class="text-danger"></span></label>
                                <input type="text" id="modal-cate-created" class="form-control" placeholder="Created At" disabled>
                            </div>
                            <input type="hidden" name="id">
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
        // get stats
        function getStats() {
            $.ajax({
                url: '../API/category.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    get: 'stats-category'
                },
                success: function(data) {
                    xhtml = ''
                    if (data.length > 0) {
                        $.each(data, function(i, value) {
                            xhtml += `<tr class="datatable-row" style="left: 0px;">
                                    <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">` + value.name + `</span></td>
                                    <td class="datatable-cell" style="width: 20%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">` + value.quantity + `</span></td>
                                    <td class="datatable-cell" style="width: 20%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">` + value.max + `</span></td>
                                    <td class="datatable-cell" style="width: 20%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">` + value.min + `</span></td>
                                    <td class="datatable-cell" style="width: 20%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">` + value.avg + `</span></td>
                                </tr>`
                        })
                    } else {
                        xhtml = '<center>Data not found</center>'
                    }
                    $('#table-stats').html(xhtml)
                }
            })
        }
        getStats()
        // get data categories to table
        function fetchCategory() {
            $.ajax({
                url: '../API/category.php',
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
                                        <td class="datatable-cell" style="width: 5%">
                                            <label class="checkbox">
                                            <input type="checkbox" value="` + value.cate_id + `">
                                            <span></span></label>
                                        </td>
                                        <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">` + value.cate_name + `</span></td>`
                            if (value.cate_status == 1) {
                                xhtml += `<td class="datatable-cell" style="width: 20%"><span><span class="label font-weight-bold label-lg label-rounded label-primary label-inline">Active</span></span></td>`
                            } else {
                                xhtml += `<td class="datatable-cell" style="width: 20%"><span><span class="label font-weight-bold label-lg label-rounded label-warning label-inline">Not Active</span></span></td>`
                            }
                            xhtml += `<td class="datatable-cell text-right" style="width: 20%">
                                            <button type="button" data-cate-id="` + value.cate_id + `" data-toggle="modal" data-target="#edit-category" class="btn btn-icon btn-success btn-sm mr-2 edit-category"><i class="fas fa-edit"></i></button>`
                            if (value.cate_status == 1) {
                                xhtml += `<button type="button" data-cate-id="` + value.cate_id + `" data-toggle="tooltip" title="Disable" class="btn btn-icon btn-warning btn-sm mr-2 disable-category"><i class="far fa-window-close"></i></button>`
                            } else {
                                xhtml += `<button type="button" data-cate-id="` + value.cate_id + `" data-toggle="tooltip" title="Enable" class="btn btn-icon btn-primary btn-sm mr-2 enable-category"><i class="far fa-check-square"></i></button>`
                            }

                            xhtml += `<button type="button" data-cate-id="` + value.cate_id + `" data-toggle="tooltip" title="Delete" class="btn btn-icon btn-danger btn-sm mr-2 delete-category"><i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>`
                        })
                    } else {
                        xhtml = `<center>data not found</center>`
                        $('#table-categories').closest('.card-body').next('.cart-footer').hide()
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
            $data = new FormData(this)
            $data.append('action','add-category')
            $catName = $data.get('cat-name')
            $catName = $catName.trim()
            var arr = $catName.split(" ")
            for (var i = 0; i < arr.length; i++) {
                arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
            }
            $catName = arr.join(" ")
            $data.set('cat-name', $catName)
            $.ajax({
                url: '../API/category.php',
                type: 'POST',
                dataType: 'json',
                data: $data,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('button[name="btn-add-category"]').addClass('spinner spinner-white spinner-right').prop('disabled', true)
                },
                success: function(data) {
                    console.log(data)
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
            $('.modal').find('#kt_user_edit_avatar').css('background-image', "none")
            $('.modal').find('.image-input-wrapper').css('background-image', "none")
            $('.modal').find('input[type="file"]').val(null)
            $('.modal').find('input[name="cate-name"],input[name="id"],input[type="file"],button').prop('disabled', false)
            $('.modal-footer').find('button[type="submit"]').html('Update')
            var $id = $(this).data('cate-id')
            $.ajax({
                url: '../API/category.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    category: $id,
                    'get': 'category'
                },
                success: function(data) {
                    $('.modal').find('input[name="cate-name"]').val(data.cate_name)
                    $('#modal-cate-created').val(data.created_at)
                    $('.modal').find('input[name="id"]').val(data.cate_id)
                    $('.modal').find('#kt_user_edit_avatar').css('background-image', 'url(../assets/uploads/category/'+ data.cate_thumb +')')
                }
            })
        })
        // update category
        $('#update-category-modal').submit(function(e) {
            e.preventDefault()
            $this = $(this)
            $data = new FormData(this)
            $data.append('action', 'update')
            $('.modal-body').find('span.error').html('')
            $catName = $data.get('cate-name')
            $catName = $catName.trim()
            var arr = $catName.split(" ")
            for (var i = 0; i < arr.length; i++) {
                arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
            }
            $catName = arr.join(" ")
            $data.set('cate-name', $catName)
            $.ajax({
                url: '../API/category.php',
                type: 'POST',
                dataType: 'html',
                contentType: false,
                processData: false,
                data: $data,
                beforeSend: function() {
                    $this.find('button[type="submit"]').html('<i class="fas fa-circle-notch fa-spin"></i>').prop('disabled', true)
                },
                success: function(data) {
                    console.log(data)
                    data = JSON.parse(data)
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
        // enable category
        $(document).on('click', '.enable-category', function() {
            $id = $(this).data('cate-id')
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure enable this category?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, enable it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: '../API/category.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            category: $id,
                            'action': 'enable'
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire("Success!", "Enabled Category!", "success");
                                fetchCategory()
                            } else {
                                Swal.fire("Error!", "Has an error, please try again!", "error");
                            }
                        }
                    })
                }
            })
        })
        // disable category
        $(document).on('click', '.disable-category', function() {
            $id = $(this).data('cate-id')
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure disable this category?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, disable it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: '../API/category.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            category: $id,
                            'action': 'disable'
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire("Success!", "Disabled Category!", "success");
                                fetchCategory()
                            } else {
                                Swal.fire("Error!", "Has an error, please try again!", "error");
                            }
                        }
                    })
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
                        url: '../API/category.php',
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
        // enable all category
        $('.enable-all-category').click(function() {
            $thisBtn = $(this)
            Swal.fire({
                title: "Are you sure?",
                text: "Enable All Category?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, enable them!"
            }).then(function(result) {
                if (result.value) {
                    var arr = []
                    $('label.checkbox').each(function(index, value) {
                        if ($(value).find('input[type="checkbox"]').is(':checked')) {
                            arr.push($(value).find('input[type="checkbox"]').val());
                        }
                    })
                    if (arr.length == 0) {
                        Swal.fire("Error !", "Please choose category to enable!", "warning");
                    } else {
                        $.ajax({
                            url: '../API/category.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                categories: arr,
                                'action': 'enable-all'
                            },
                            beforeSend: function() {
                                $thisBtn.html('<i class="fas fa-spinner fa-spin"></i>')
                            },
                            success: function(data) {
                                setTimeout(() => {
                                    if (data.status == 'success') {
                                        Swal.fire("Success!", "Enabled All Category!", "success");
                                        fetchCategory()
                                    } else {
                                        Swal.fire("Error!", "Has an error, please try again!", "error");
                                    }
                                    $thisBtn.html('Enable All Category')
                                }, 500)
                            }
                        })
                    }
                }
            })
        })
        // disabled all category
        $('.disable-all-category').click(function() {
            $thisBtn = $(this)
            Swal.fire({
                title: "Are you sure?",
                text: "Disable All Category?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, disable them!"
            }).then(function(result) {
                if (result.value) {
                    var arr = []
                    $('label.checkbox').each(function(index, value) {
                        if ($(value).find('input[type="checkbox"]').is(':checked')) {
                            arr.push($(value).find('input[type="checkbox"]').val());
                        }
                    })
                    if (arr.length == 0) {
                        Swal.fire("Error !", "Please choose category to disable!", "warning");
                    } else {
                        $.ajax({
                            url: '../API/category.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                categories: arr,
                                'action': 'disable-all'
                            },
                            beforeSend: function() {
                                $thisBtn.html('<i class="fas fa-spinner fa-spin"></i>')
                            },
                            success: function(data) {
                                setTimeout(() => {
                                    if (data.status == 'success') {
                                        Swal.fire("Success!", "Disabled All Category!", "success");
                                        fetchCategory()
                                    } else {
                                        Swal.fire("Error!", "Has an error, please try again!", "error");
                                    }
                                    $thisBtn.html('Disable All Category')
                                }, 500)
                            }
                        })
                    }
                }
            })
        })
    })
</script>
<?php require_once 'layout/blocks/footer.php'; ?>