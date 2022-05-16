<?php require_once 'layout/blocks/header.php'; ?>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
		<div class="container">
			<!--Begin::form--> 
<?php if(Session::get('user')['role'] == 3){ ?>  
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Add User</h3>
                        </div>
                        <!--begin::Form-->
                        <form id="add-user">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Username
                                    <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter username" name="username" required>
                                    <span class="form-text text-muted error username"></span>
                                </div>
                                <div class="form-group">
                                    <label>Password
                                    <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Enter password" name="password" required>
                                    <span class="form-text text-muted error password"></span>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password
                                    <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Enter confirm password" name="cpassword" required>
                                    <span class="form-text text-muted error cpassword"></span>
                                </div>
                                <div class="form-group">
                                    <label>Email
                                    <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" placeholder="Enter email" name="email" required>
                                    <span class="form-text text-muted error email"></span>
                                </div>
                                <div class="form-group">
                                    <label>Role
                                    <span class="text-danger">*</span></label>
                                    <select class="form-control" name="role">
                                        <option value="1">Member</option>
                                        <option value="2">Staff</option>
                                        <option value="3">Admin</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="btn-add-user" class="btn btn-primary mr-2">Add</button>
                                    <a href="list-user.php"><button type="button" class="btn btn-success mr-2">List User</button></a>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
            <!--End::form-->
<?php } else { ?>
    <div class="alert alert-custom alert-danger" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">You don't have permission to access this page!</div>
    </div>
<?php } ?>
	    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
<script>
    $(document).ready(function(){
        $('#add-user').submit(function(e){
            $('span.error').html('')
            e.preventDefault()
            $thisForm = $(this)
            $data = new FormData(this)
            $data.append('action', 'add-user')
            $.ajax({
                url         : '../API/user.php',
                type        : 'POST',
                dataType    : 'json',
                processData : false,
                data        : $data,
                contentType : false,
                beforeSend  : function(){
                    $thisForm.find('button[name="btn-add-user"]').addClass('spinner spinner-white spinner-right').prop('disabled', true)
                },
                success     : function(data){
                    console.log(data)
                    setTimeout(()=>{
                        if(data.status == 'success'){
                            Swal.fire("Success!", "Add User Success!", "success");
                            $thisForm.find('button[type="submit"]').removeClass('spinner spinner-white spinner-right').html('<i class="far fa-check-circle"></i> Success')
                            $thisForm.find('input').prop('disabled', true)
                        } else {
                            Swal.fire("Error!", "Has an error, please try again!", "error");
                            $thisForm.find('button[name="btn-add-user"]').removeClass('spinner spinner-white spinner-right').prop('disabled', false)
                            $.each(data.message, function(index, value) {
                                $('span.error.' + index).html(value)
                            })
                        }
                    },1000)
                }
            })
        })
    })
</script>
<?php require_once 'layout/blocks/footer.php'; ?>