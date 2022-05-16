<?php require_once 'layout/blocks/header.php'; ?>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <div class="container">
<?php if(Session::get('user')['role'] == 3){ ?>
        <div class="row">
            <div class="col-md-12">
                <!--begin::table-->
                <div class="d-flex gutter-b">
                    <div class="card-toolbar">
                            <a href="add-user.php" class="btn btn-success font-weight-bolder font-size-sm">
                            <span class="svg-icon svg-icon-md svg-icon-white">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                        <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                        <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Add User</a>
                        </div>
                </div> 
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">Admin
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <div class="datatable datatable-default datatable-bordered datatable-loaded">
                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                            <thead class="datatable-head">
                                <tr class="datatable-row" style="left: 0px;">
                                    <th class="datatable-cell" style="flex-grow:1"><span>Username</span></th>
                                    <th class="datatable-cell" style="width: 30%"><span>Email</span></th>
                                    <th class="datatable-cell" style="width: 20%"><span>Status</span></th>
                                    <th class="datatable-cell text-right" style="width: 20%"><span>Action</span></th>
                                </tr>
                            </thead>
                            <tbody id="table-admin" class="datatable-body">
                                
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end::table--> 
            </div>
        </div>
        <div class="row" style="margin-top:2rem;margin-bottom:2rem">
            <div class="col-md-12">
                <!--begin::table--> 
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">Staff
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <div class="datatable datatable-default datatable-bordered datatable-loaded">
                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                            <thead class="datatable-head">
                                <tr class="datatable-row" style="left: 0px;">
                                    <th class="datatable-cell" style="flex-grow:1"><span>Username</span></th>
                                    <th class="datatable-cell" style="width: 30%"><span>Email</span></th>
                                    <th class="datatable-cell" style="width: 20%"><span>Status</span></th>
                                    <th class="datatable-cell text-right" style="width: 20%"><span>Action</span></th>
                                </tr>
                            </thead>
                            <tbody id="table-staff" class="datatable-body">
                                
                            </tbody>
                            </table>
                        </div>
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
                            <h3 class="card-label">Customer
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <div class="datatable datatable-default datatable-bordered datatable-loaded">
                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                            <thead class="datatable-head">
                                <tr class="datatable-row" style="left: 0px;">
                                    <th class="datatable-cell" style="flex-grow:1"><span>Username</span></th>
                                    <th class="datatable-cell" style="width: 30%"><span>Email</span></th>
                                    <th class="datatable-cell" style="width: 20%"><span>Status</span></th>
                                    <th class="datatable-cell text-right" style="width: 20%"><span>Action</span></th>
                                </tr>
                            </thead>
                            <tbody id="table-customer" class="datatable-body">
                                
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
        <div class="modal fade" id="edit-user" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="update-user-modal">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="form-group modal-user-avatar">
                            <img style='width: auto;height: 100px;object-fit:cover;border:1px solid #3699ff;border-radius:5px;display:block;margin: 0 auto;'>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="modal-user-username" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="modal-user-email" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" name="modal-user-phone" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="modal-user-address" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Created At
                                <span class="text-danger"></span></label>
                                <input type="text" name="modal-user-created" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Role
                                <span class="text-danger">*</span></label>
                                <select class="form-control" name="modal-user-role">
                                    <option value="1">Customer</option>
                                    <option value="2">Staff</option>
                                    <option value="3">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status
                                <span class="text-danger">*</span></label>
                                <div class="radio-inline">
                                    <label class="radio">
                                    <input type="radio" value="1" name="modal-user-status">
                                    <span></span>Active</label>
                                    <label class="radio">
                                    <input type="radio" value="0" name="modal-user-status">
                                    <span></span>Not Active</label>
                                </div>
                            </div>
                            <input type="hidden" name="modal-user-id">
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
<?php } else { ?>
    <div class="alert alert-custom alert-danger" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">You don't have permission to access this page!</div>
    </div>
<?php } ?>
    </div>
</div>
<!--end::Entry-->
<script>
    $(document).ready(function(){
        function fetchUser(){
            $.ajax({
                url         : '../API/user.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {get: 'list-user'},
                success     : function(data){
                    admin       = ''
                    staff       = ''
                    customer    = ''
                    if(data.admin.length > 0){
                        $.each(data.admin, function(index, value){
                            admin += `<tr class="datatable-row" style="left: 0px;">
                                        <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.user_name +`</span></td>
                                        <td class="datatable-cell" style="width:30%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.user_email +`</span></td>`
                            if(value.user_status == 1){
                                admin += `<td class="datatable-cell" style="width: 20%"><span><span class="label font-weight-bold label-lg label-rounded label-primary label-inline">Active</span></span></td>`
                            } else {
                                admin += `<td class="datatable-cell" style="width: 20%"><span><span class="label font-weight-bold label-lg label-rounded label-danger label-inline">Not Active</span></span></td>`
                            }
                            admin +=  `<td class="datatable-cell text-right" style="width: 20%">
                                            <button type="button" data-user-id="`+ value.user_id +`" data-toggle="modal" data-target="#edit-user" class="btn btn-icon btn-success btn-sm mr-2 edit-user"><i class="fas fa-edit"></i></button>
                                            <button type="button" data-user-id="`+ value.user_id +`" data-toggle="tooltip" title="Delete this user" class="btn btn-icon btn-danger btn-sm mr-2 delete-user"><i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>`
                        })
                    } else {
                        admin = '<center>Not found data</center>'
                    }
                    if(data.staff.length > 0){
                        $.each(data.staff, function(index, value){
                            staff += `<tr class="datatable-row" style="left: 0px;">
                                        <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.user_name +`</span></td>
                                        <td class="datatable-cell" style="width:30%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.user_email +`</span></td>`
                            if(value.user_status == 1){
                                staff += `<td class="datatable-cell" style="width: 20%"><span><span class="label font-weight-bold label-lg label-rounded label-primary label-inline">Active</span></span></td>`
                            } else {
                                staff += `<td class="datatable-cell" style="width: 20%"><span><span class="label font-weight-bold label-lg label-rounded label-danger label-inline">Not Active</span></span></td>`
                            }
                            staff +=  `<td class="datatable-cell text-right" style="width: 20%">
                                            <button type="button" data-user-id="`+ value.user_id +`" data-toggle="modal" data-target="#edit-user" class="btn btn-icon btn-success btn-sm mr-2 edit-user"><i class="fas fa-edit"></i></button>
                                            <button type="button" data-user-id="`+ value.user_id +`" data-toggle="tooltip" title="Delete this user" class="btn btn-icon btn-danger btn-sm mr-2 delete-user"><i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>`
                        })
                    } else {
                        staff = '<center>Not found data</center>'
                    }
                    if(data.customer.length > 0){
                        $.each(data.customer, function(index, value){
                            customer += `<tr class="datatable-row" style="left: 0px;">
                                        <td class="datatable-cell" style="flex-grow:1"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.user_name +`</span></td>
                                        <td class="datatable-cell" style="width:30%"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">`+ value.user_email +`</span></td>`
                            if(value.user_status == 1){
                                customer += `<td class="datatable-cell" style="width: 20%"><span><span class="label font-weight-bold label-lg label-rounded label-primary label-inline">Active</span></span></td>`
                            } else {
                                customer += `<td class="datatable-cell" style="width: 20%"><span><span class="label font-weight-bold label-lg label-rounded label-danger label-inline">Not Active</span></span></td>`
                            }
                            customer +=  `<td class="datatable-cell text-right" style="width: 20%">
                                            <button type="button" data-user-id="`+ value.user_id +`" data-toggle="modal" data-target="#edit-user" class="btn btn-icon btn-success btn-sm mr-2 edit-user"><i class="fas fa-edit"></i></button>
                                            <button type="button" data-user-id="`+ value.user_id +`" data-toggle="tooltip" title="Delete this user" class="btn btn-icon btn-danger btn-sm mr-2 delete-user"><i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>`
                        })
                    } else {
                        customer = '<center>Not found data</center>'
                    }
                    $('#table-admin').html(admin)
                    $('#table-staff').html(staff)
                    $('#table-customer').html(customer)
                    $('[data-toggle="tooltip"]').tooltip()
                }
            })
        }
        fetchUser()
        // get user to modal
        $(document).on('click', '.edit-user', function(){
            $('.modal-footer').find('button[type="submit"]').html('Update').prop('disabled', false)
            $modal = $('#update-user-modal')
            $userID = $(this).data('user-id')
            $.ajax({
                url         : '../API/user.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {id: $userID, get: 'user'},
                success     : function(data){
                    console.log(data)
                    $('.modal-user-avatar img').attr('src', '../assets/uploads/avatar/' + data.avatar)
                    $modal.find('input[name="modal-user-username"]').val(data.username)
                    $modal.find('input[name="modal-user-email"]').val(data.email)
                    $modal.find('input[name="modal-user-phone"]').val(data.phone)
                    $modal.find('input[name="modal-user-address"]').val(data.address)
                    $modal.find('input[name="modal-user-created"]').val(data.created_at)
                    $modal.find('select[name="modal-user-role"]').val(data.role)
                    $modal.find('input[name="modal-user-id"]').val(data.user_id)
                    $modal.find('input:radio[name="modal-user-status"][value="'+ data.status +'"]').prop('checked', true)
                }
            })
        })
        // update user
        $('#update-user-modal').submit(function(e){
            e.preventDefault()
            $this = $(this)
            $data = new FormData(this)
            $data.append('action', 'update-user')
            $btnUpdate = $(this).find('button[type="submit"]')
            $.ajax({
                url         : '../api/user.php',
                type        : 'POST',
                dataType    : 'json',
                contentType : false,
                processData : false,
                data        : $data,
                beforeSend  : function(){
                    $btnUpdate.html('<i class="fas fa-circle-notch fa-spin"></i>').prop('disabled', true)
                },
                success     : function(data){
                    setTimeout(()=>{
                        if(data.status == 'success'){
                            $btnUpdate.html('<i class="fas fa-check"></i> Updated')
                            fetchUser()
                        } else {
                            $btnUpdate.html('Update').prop('disabled', false)
                            Swal.fire("Error!", "Update failed, try again", "error")
                        }
                    },500)
                }
            })
        })
        // delete user
        $(document).on('click', '.delete-user', function(){
            $userID = $(this).data('user-id')
            Swal.fire({
                title: "Are you sure?",
                text: "Are you sure delete this user?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url         : '../API/user.php',
                        type        : 'POST',
                        dataType    : 'json',
                        data        : {id: $userID, 'action': 'delete-user'},
                        success     : function(data){
                            if(data.status == 'success'){
                                Swal.fire("Success!", "Deleted user!", "success");
                                fetchUser()
                            } else {
                                Swal.fire("Error!", data.message[0], "error");
                            }
                        }
                    })
                }
            })
        })
    })
</script>
<?php require_once 'layout/blocks/footer.php'; ?>