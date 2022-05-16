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
                        <h3 class="card-title">Setting My Website</h3>
                    </div>
                    <!--begin::Form-->
                    <form id="update-setting">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Website Name
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="<?= WEB_TITLE ?>" name="website-name" placeholder="Enter name" required>
                            </div>
                            <div class="form-group">
                                <label>Website Address
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="<?= WEB_ADDRESS ?>" name="website-address" placeholder="Enter address" required>
                            </div>
                            <div class="form-group">
                                <label>Website Email
                                    <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" value="<?= WEB_EMAIL ?>" name="website-email" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label>Website Phone
                                    <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" value="<?= WEB_PHONE ?>" name="website-phone" placeholder="Enter number phone" required>
                            </div>
                            <div class="form-group web-logo">
                                <img src='../assets/uploads/logo/<?= WEB_LOGO ?>' style='width: auto;height: 150px;object-fit:cover;border:1px solid #3699ff;border-radius:5px'>
                            </div>
                            <div class="form-group">
                                <label>File Logo</label>
                                <div class="custom-file">
                                    <input type="file" accept=".png, .jpg, .jpeg, .jfif" name="weblogo" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose new file</label>
                                </div>
                                <div class="form-group preview-image">

                                </div>

                            </div>
                            <div class="form-group">
                                <button type="submit" name="btn-update" class="btn btn-primary mr-2">Update</button>
                            </div>
                        </div>
                </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
<?php } else { ?>
    <div class="alert alert-custom alert-danger" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">You don't have permission to access this page!</div>
    </div>
<?php } ?>
    </div>
    <!--End::form-->
    <!--end::Container-->
</div>
<!--end::Container-->
</div>
<!--end::Entry-->
<script>
    $(document).ready(function() {
        $('#update-setting').submit(function(e) {
            e.preventDefault()
            $this = $(this)
            $thisBtn = $(this).find('button[name="btn-update"]')
            $data = new FormData(this)
            $data.append('action', 'update-information')
            $.ajax({
                url: '../API/setting.php',
                type: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                data: $data,
                beforeSend: function() {
                    $thisBtn.addClass('spinner spinner-white spinner-right').prop('disabled', true)
                },
                success: function(data) {
                    setTimeout(() => {
                        if (data.status == 'success') {
                            $thisBtn.removeClass('spinner spinner-white spinner-right').html('<i class="far fa-check-circle"></i> Updated')
                            Swal.fire("Success!", "Update success!", "success")
                            $this.find('input').prop('disabled', true)
                            // $('.web-logo').slideUp()
                        } else {
                            $thisBtn.removeClass('spinner spinner-white spinner-right').html('Update').prop('disabled', false)
                            Swal.fire("Error!", "Update failed, try again", "error")
                        }
                    }, 500)
                }

            })
        })
    })
</script>
<?php require_once 'layout/blocks/footer.php'; ?>