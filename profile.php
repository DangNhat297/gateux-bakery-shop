<?php
require_once 'lib/layout.php';
get_header();
get_nav();
?>
<!--Begin::Profile--> 
<?php
$userID = Session::get('user')['id'];
$user = DB::fetch("SELECT * FROM users WHERE user_id = $userID");
$date = new DateTime($user['created_at']);
$time_reg = $date->format("M d, Y");
?>
<main>
    <div class="breadcrumb-product">
        <div class="breadcrumb-product__name">Profile</div>
        <div style="display:flex">
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/home/">Home</a></div>
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/profile/">Profile</a></div>
        </div>
    </div>
    <div class="profile-page container">
        <div class="profile-page__left">
            <div class="profile-user">
                <div class="profile-user__avatar">
                    <img src="<?=ROOT_URL?>/assets/uploads/avatar/<?=$user['user_avatar']?>">
                </div>
                <div class="profile-user__name">
                    <p><?=$user['user_name']?> <span style="color: var(--pink)"><i class="fas fa-check-circle"></i></span></p>
                    <p><?=($user['user_role'] == 3) ? 'Admin' : (($user['user_role'] == 2) ? 'Staff' : 'Member')?></p>
                </div>
            </div>
            <div class="profile-info">
                <div class="profile-info__item">
                    <div class="info-name">Email:</div>
                    <div class="info-detail"><?=$user['user_email']?></div>
                </div>
                <div class="profile-info__item">
                    <div class="info-name">Phone:</div>
                    <div class="info-detail"><?=$user['user_phone']?></div>
                </div>
                <div class="profile-info__item">
                    <div class="info-name">Address:</div>
                    <div class="info-detail"><?=$user['user_address']?></div>
                </div>
            </div>
            <div class="profile-tab">
                <div data-tab="information"><a href="#information"><ion-icon name="person-circle-outline"></ion-icon> Account Information</a></div>
                <div data-tab="orders"><a href="#orders"><ion-icon name="beer-outline"></ion-icon> My Orders</a></div>
                <div data-tab="change-password"><a href="#change-password"><ion-icon name="lock-closed-outline"></ion-icon> Change Password</a></div>
            </div>
        </div>
        <div class="profile-page__right">
            <div class="profile-tab__content" id="information">
                <div class="profile-tab__header">
                    <div class="profile-tab__header--title">
                        Account Information
                    <div class="text-sub">Update your personal information</div>
                    </div>
                </div>
                <div class="profile-tab__body">
                    <form id="update-profile">
                    <div class="form-information">
                        <div class="form-group" style="display:flex;align-items:center;">
                            <label><span>Avatar <sup class="text-danger">*</sup></span></label>
                            <div class="image-frame" style="background-image: url('<?=ROOT_URL?>/assets/uploads/avatar/<?=$user['user_avatar']?>')">
                                <label for="avatar_input"><div class="image-frame__btn edit"><i class="fas fa-pen"></i></div></label>
                                <div class="image-frame__btn cancel" style="display:none"><i class="fas fa-times"></i></div>
                                <input type="file" accept=".png, .jpg, .jpeg, .jfif" id="avatar_input" name="avatar" style="display:none">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <span>Username <sup class="text-danger">*</sup></span>
                                <input type="text" value="<?=$user['user_name']?>" class="form-control" disabled>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <span>Email <sup class="text-danger">*</sup></span>
                                <input type="email" value="<?=$user['user_email']?>" class="form-control" disabled>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <span>Created At <sup class="text-danger">*</sup></span>
                                <input type="text" value="<?=$time_reg?>" class="form-control" disabled>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <span>Address <sup class="text-danger">*</sup></span>
                                <input type="text" value="<?=$user['user_address']?>" class="form-control" name="address" placeholder="Enter address" required>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <span>Phone <sup class="text-danger">*</sup></span>
                                <input type="number" value="<?=$user['user_phone']?>" class="form-control" name="phone" placeholder="Enter phone" required>
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" style="float:right" class="btn-submit">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="profile-tab__content" id="orders">
                <div class="profile-tab__header">
                    <div class="profile-tab__header--title">
                        My Orders
                    <div class="text-sub">Follow my tracking orders details</div>
                    </div>
                </div>
                <div class="profile-tab__body">
                    <table class="table-order-list">
                        <thead>
                            <tr>
                                <th>Order Code</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="profile-tab__content" id="change-password">
                <div class="profile-tab__header">
                    <div class="profile-tab__header--title">
                        Change password
                    <div class="text-sub">Change your account password</div>
                    </div>
                </div>
                <div class="profile-tab__body">
                    <form id="change-form">
                    <div class="form-information">
                        <div class="form-group">
                            <label>
                                <span>Current Password <sup class="text-danger">*</sup></span>
                                <input type="password" name="current-password" class="form-control" placeholder="Enter current password" required>
                            </label>
                            <p class="error current-password"></p>
                        </div>
                        <div class="form-group">
                            <label>
                                <span>New Password <sup class="text-danger">*</sup></span>
                                <input type="password" name="new-password" class="form-control" placeholder="Enter new password" required>
                            </label>
                            <p class="error new-password"></p>
                        </div>
                        <div class="form-group">
                            <label>
                                <span>Confirm Password <sup class="text-danger">*</sup></span>
                                <input type="password" name="confirm-password" class="form-control" placeholder="Enter confirm password" required>
                            </label>
                            <p class="error confirm-password"></p>
                        </div>
                        <div class="form-group">
                            <button type="submit" style="float:right" class="btn-submit">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<!--Begin::Modal-->   
<div class="modal-window search-modal" id="order-detail">
    <div class="modal-content modal-xl">
        <div class="modal-body">
            
        </div>
    </div>
</div>
<!--End::Modal-->
<!--End::Profile-->
<script>
    $(document).ready(function(){
        setTitle('<?=$user['user_name']?> | Gateux Profile')
        function getListOrder(){
            $.ajax({
                url         : ROOT_URL + '/API/order.php',
                type        : 'POST',
                data        : {get: 'list-order-user'},
                success     : function(data){
                    if(data.length > 0){
                        $('.table-order-list tbody').html(data)
                    } else {
                        $('.table-order-list tbody').html('<p style="padding: 10px;text-align:center">Order is empty</p>')
                    }
                }
            })
        }
        getListOrder()
        $('#update-profile').submit(function(e){
            $('p.error').html('')
            $thisForm = $(this)
            e.preventDefault()
            $data = new FormData(this)
            $data.append('action', 'update-current-user')
            $.ajax({
                url         : ROOT_URL + '/API/profile.php',
                type        : 'POST',
                dataType    : 'json',
                data        : $data,
                processData : false,
                contentType : false,
                beforeSend  : function(){
                    $thisForm.find('button[type="submit"]').html('<i class="fas fa-circle-notch fa-spin"></i>').prop('disabled', true)
                },
                success     : function(data){
                    console.log(data)
                    setTimeout(()=>{
                        if(data.status == 'success'){
                            $thisForm.find('button[type="submit"]').html('<i class="far fa-check-circle"></i> Success')
                            Swal.fire("Success!", "Update success!", "success")
                            $this.find('input').prop('disabled', true)
                        } else {
                            Swal.fire("Error!", "Has an error, please try again!", "error");
                            $thisForm.find('button[type="submit"]').html('Submit').prop('disabled', false)
                            $.each(data.message, function(index, value) {
                                $('p.error.' + index).html(value)
                            })
                        }
                    },1000)
                }
            })
        })
        $(document).on('click', '.detail-order', function(){
            $this = $(this)
            $id = $this.data('order-id')
            $.ajax({
                url         : ROOT_URL + '/API/order.php',
                type        : 'POST',
                data        : {get: 'detail-order', id: $id},
                success     : function(data){
                    if(data.length > 0){
                        $('#order-detail .modal-body').html(data)
                    } else {
                        $('#order-detail .modal-body').html('<p style="padding: 20px;text-align:center">Data not found</p>')
                    }
                }
            })
        })
        $(document).on('click', '.cancel-order', function(){
            $this = $(this)
            $id = $this.data('order-id')
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure cancel this order?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url         : ROOT_URL + '/API/order.php',
                        type        : 'POST',
                        dataType    : 'json',
                        data        : {action: 'cancel-order', id: $id},
                        success     : function(data){
                            if(data.status == 'success'){
                                Swal.fire("Success!", "Cancel Order Success!", "success")
                                getListOrder()
                            } else {
                                Swal.fire("Error!", "Has an error, please try again!", "error")
                            }
                        }
                    })
                }
            })
        })
        $('#change-form').submit(function(e){
            $('p.error').html('')
            e.preventDefault()
            $thisForm = $(this)
            $data = new FormData(this)
            $data.append('action', 'change-password')
            $.ajax({
                url         : ROOT_URL + '/API/user.php',
                type        : 'POST',
                dataType    : 'json',
                processData : false,
                data        : $data,
                contentType : false,
                beforeSend  : function(){
                    $thisForm.find('button[type="submit"]').html('<i class="fas fa-circle-notch fa-spin"></i>').prop('disabled', true)
                },
                success     : function(data){
                    setTimeout(()=>{
                        if(data.status == 'success'){
                            Swal.fire("Success!", "Change Password Success!", "success")
                            $thisForm.find('button[type="submit"]').html('<i class="far fa-check-circle"></i> Success')
                            $thisForm.find('input').prop('disabled', true)
                        } else {
                            Swal.fire("Error!", "Has an error, please try again!", "error")
                            $thisForm.find('button[type="submit"]').html('Submit').prop('disabled', false)
                            $.each(data.message, function(index, value) {
                                $('p.error.' + index).html(value)
                            })
                        }
                    },1000)
                }
            })
        })
    })
</script>
<?php
get_footer();
?>