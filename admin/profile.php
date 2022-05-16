<?php require_once 'layout/blocks/header.php'; ?>
<!--begin::Entry-->
<?php
$userID = Session::get('user')['id'];
$user = DB::fetch("SELECT * FROM users WHERE user_id = $userID");
$date = new DateTime($user['created_at']);
$time_reg = $date->format("d-m-Y");
?>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
        <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="card-body">
                <!--begin::Top-->
                <div class="d-flex">
                    <!--begin::Pic-->
                    <div class="flex-shrink-0 mr-7">
                        <div class="symbol symbol-50 symbol-lg-120">
                            <img alt="Pic" src="../assets/uploads/avatar/<?=Session::get('user')['avatar']?>">
                        </div>
                    </div>
                    <!--end::Pic-->
                    <!--begin: Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex align-items-center justify-content-between flex-wrap mt-2">
                            <!--begin::User-->
                            <div class="mr-3">
                                <!--begin::Name-->
                                <a href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3"><?=Session::get('user')['username']?>
                                <i class="flaticon2-correct text-success icon-md ml-2"></i></a>
                                <!--end::Name-->
                                <!--begin::Contacts-->
                                <div class="d-flex flex-wrap my-2">
                                    <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"></path>
                                                <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"></circle>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span><?=Session::get('user')['email']?></a>
                                    <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Lock.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"/>
                                            <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3"/>
                                            <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3"/>
                                        </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span><?=(Session::get('user')['role']==3) ? 'Admin' : 'Staff'?></a>
                                </div>
                                <!--end::Contacts-->
                            </div>
                            <!--begin::User-->
                        </div>
                        <!--end::Title-->
                        <!--begin::Content-->
                        <div class="d-flex align-items-center flex-wrap justify-content-between">
                            <!--begin::Description-->
                            <div class="flex-grow-1 font-weight-bold text-dark-50 py-2 py-lg-2 mr-5">Live as if you were to die tomorrow. Learn as if you were to live forever. Nothing is impossible !</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Top-->
                <!--begin::Separator-->
                <div class="separator separator-solid my-7"></div>
                <!--end::Separator-->
            </div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="card card-custom">
            <!--begin::Card header-->
            <div class="card-header card-header-tabs-line nav-tabs-line-3x">
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                        <!--begin::Item-->
                        <li class="nav-item mr-3">
                            <a class="nav-link active" data-toggle="tab" href="#kt_user_edit_tab_1">
                                <span class="nav-icon">
                                    <span class="svg-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"></path>
                                                <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"></path>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                <span class="nav-text font-size-lg">Profile</span>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_2">
                                <span class="nav-icon">
                                    <span class="svg-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"></path>
                                                <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3"></path>
                                                <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3"></path>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                <span class="nav-text font-size-lg">Change Password</span>
                            </a>
                        </li>
                        <!--end::Item-->
                    </ul>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                    <div class="tab-content">
                        <!--begin::Tab-->
                        <div class="tab-pane show px-7 active" id="kt_user_edit_tab_1" role="tabpanel">
                            <form class="form" id="update-profile">
                            <div class="card-body">
                                <!--begin::Row-->
                                <div class="row">
                                    <div class="col-xl-2"></div>
                                    <div class="col-xl-7 my-2">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <label class="col-3"></label>
                                            <div class="col-9">
                                                <h6 class="text-dark font-weight-bold mb-10">Profile Info:</h6>
                                            </div>
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Group-->
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-lg-right text-left">Avatar</label>
                                            <div class="col-9">
                                                <div class="image-input image-input-empty image-input-outline" id="kt_user_edit_avatar" style="background-image: url('../assets/uploads/avatar/<?=$user['user_avatar']?>')">
                                                    <div class="image-input-wrapper"></div>
                                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                                        <input type="file" name="avatar" accept=".png, .jpg, .jpeg, .jfif" />
                                                        <input type="hidden" name="profile_avatar_remove" />
                                                    </label>
                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    </span>
                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    </span>
                                                </div>
                                                <span class="form-text text-muted error avatar"></span>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-lg-right text-left">Username</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-lg form-control-solid" value="<?=$user['user_name']?>" type="text" disabled>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-lg-right text-left">Email</label>
                                            <div class="col-9">
                                                <div class="input-group input-group-lg input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-at"></i>
                                                        </span>
                                                    </div>
                                                    <input type="email" class="form-control form-control-lg form-control-solid" value="<?=$user['user_email']?>" placeholder="Email" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-lg-right text-left">Role</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-lg form-control-solid" value="<?=($user['user_role'] == 3) ? 'Admin' : 'Staff'?>" type="text" disabled>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-lg-right text-left">Created At</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-lg form-control-solid" value="<?=$time_reg?>" type="text" disabled>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-lg-right text-left">Address</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-lg form-control-solid" value="<?=$user['user_address']?>" placeholder="Enter address" name="address" type="text" required>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-lg-right text-left">Phone</label>
                                            <div class="col-9">
                                                <div class="input-group input-group-lg input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-phone"></i>
                                                        </span>
                                                    </div>
                                                    <input type="number" class="form-control form-control-lg form-control-solid" value="<?=$user['user_phone']?>" placeholder="Enter phone" name="phone" placeholder="Phone" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--begin::Footer-->
                            <div class="card-footer pb-0">
                                <div class="row">
                                    <div class="col-xl-2"></div>
                                    <div class="col-xl-7">
                                        <div class="row">
                                            <div class="col-3"></div>
                                            <div class="col-9">
                                                <button type="submit" class="btn btn-primary mr-3" name="btn-update-profile">Save Change</button>
                                                <a href="#" class="btn btn-clean font-weight-bold">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Footer-->
                            </form>
                        </div>
                        <!--end::Tab-->
                        <!--begin::Tab-->
                        <div class="tab-pane px-7" id="kt_user_edit_tab_2" role="tabpanel">
                        <form class="form" id="change-password">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Row-->
                                <div class="row">
                                    <div class="col-xl-2"></div>
                                    <div class="col-xl-7">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <label class="col-3"></label>
                                            <div class="col-9">
                                                <h6 class="text-dark font-weight-bold mb-10">Change Your Password:</h6>
                                            </div>
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Group-->
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-lg-right text-left">Current Password</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-lg form-control-solid mb-1" name="current-password" type="password" placeholder="Current password">
                                                <span class="form-text text-muted error current-password"></span>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-lg-right text-left">New Password</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-lg form-control-solid" type="password" name="new-password" placeholder="New password">
                                                <span class="form-text text-muted error new-password"></span>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-lg-right text-left">Verify Password</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-lg form-control-solid" type="password" name="confirm-password" placeholder="Verify password">
                                                <span class="form-text text-muted error confirm-password"></span>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Body-->
                            <!--begin::Footer-->
                            <div class="card-footer pb-0">
                                <div class="row">
                                    <div class="col-xl-2"></div>
                                    <div class="col-xl-7">
                                        <div class="row">
                                            <div class="col-3"></div>
                                            <div class="col-9">
                                                <button type="submit" class="btn btn-primary mr-3" name="btn-change-password">Save Change</button>
                                                <a href="#" class="btn btn-clean font-weight-bold">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Footer-->
                        </form>
                        </div>
                        <!--end::Tab-->
                    </div>
            </div>
            <!--begin::Card body-->
        </div>
        </div>
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
<script>
    $(document).ready(function(){
        $('#update-profile').submit(function(e){
            $('span.error').html('')
            $this = $(this)
            e.preventDefault()
            $data = new FormData(this)
            $data.append('action', 'update-current-user')
            $.ajax({
                url         : '../API/profile.php',
                type        : 'POST',
                dataType    : 'json',
                data        : $data,
                processData : false,
                contentType : false,
                beforeSend  : function(){
                    $this.find('button[name="btn-update-profile"]').addClass('spinner spinner-white spinner-right').prop('disabled', true)
                },
                success     : function(data){
                    setTimeout(()=>{
                        if(data.status == 'success'){
                            $this.find('button[name="btn-update-profile"]').removeClass('spinner spinner-white spinner-right').html('<i class="far fa-check-circle"></i> Updated')
                            Swal.fire("Success!", "Update success!", "success")
                            $this.find('input').prop('disabled', true)
                        } else {
                            $this.find('button[name="btn-update-profile"]').removeClass('spinner spinner-white spinner-right').prop('disabled', false)
                            Swal.fire("Error!", "Update failed, try again", "error")
                            $.each(data.message, function(index, value){
                                $('span.error.' + index).html(value)
                            })
                        }
                    },1000)
                }
            })
        })
        $('#change-password').submit(function(e){
            $('span.error').html('')
            e.preventDefault()
            $thisForm = $(this)
            $data = new FormData(this)
            $data.append('action', 'change-password')
            $.ajax({
                url         : '../API/user.php',
                type        : 'POST',
                dataType    : 'json',
                processData : false,
                data        : $data,
                contentType : false,
                beforeSend  : function(){
                    $thisForm.find('button[name="btn-change-password"]').addClass('spinner spinner-white spinner-right').prop('disabled', true)
                },
                success     : function(data){
                    setTimeout(()=>{
                        if(data.status == 'success'){
                            Swal.fire("Success!", "Change Password Success!", "success");
                            $thisForm.find('button[name="btn-change-password"]').removeClass('spinner spinner-white spinner-right').html('<i class="far fa-check-circle"></i> Success')
                            $thisForm.find('input').prop('disabled', true)
                        } else {
                            Swal.fire("Error!", "Has an error, please try again!", "error");
                            $thisForm.find('button[name="btn-change-password"]').removeClass('spinner spinner-white spinner-right').prop('disabled', false)
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