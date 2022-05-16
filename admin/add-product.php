<?php require_once 'layout/blocks/header.php'; ?>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::row-->
        <form id="add-product">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-custom">
                        <div class="card-header">
                            <h3 class="card-title">Add Product</h3>
                        </div>
                        <!--begin::Form-->
                        <div class="card-body">
                            <div class="form-group">
                                <label>Product Name
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Enter product name" required="">
                                <span class="form-text text-muted error name"></span>
                            </div>
                            <div class="form-group">
                                <label>Product Price
                                    <span class="text-danger">*</span></label>
                                <input type="number" min="0" step="0.01" class="form-control" name="price" placeholder="Enter product price" required="">
                                <span class="form-text text-muted error price"></span>
                            </div>
                            <div class="form-group">
                                <label>Product Discount
                                    <span class="text-danger">*</span></label>
                                <input type="number" value="0" min="0" max="100" name="discount" class="form-control" placeholder="Enter product discount" required="">
                                <span class="form-text text-muted error discount"></span>
                            </div>
                            <div class="form-group">
                                <label>Product Description
                                    <span class="text-danger">*</span></label>
                                <textarea name="description" id="editor-product"></textarea>
                                <span class="form-text text-muted error description"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card card-custom gutter-b">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary mr-2">Add</button>
                            <a href="list-product.php"><button type="button" class="btn btn-success mr-2">List Product</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="card-icon">
                                    <i class="fas fa-birthday-cake text-primary"></i>
                                </span>
                                <h3 class="card-label">Category</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div data-scroll="true" data-height="auto" class="scroll ps ps--active-y" style="max-height: 200px; overflow: hidden;">
                                <div class="checkbox-list">
                                    <?php foreach (DB::fetchAll("SELECT * FROM category WHERE cate_status = 1") as $category) : ?>
                                        <label class="checkbox">
                                            <input type="checkbox" value="<?= $category['cate_id'] ?>" name="categories[]">
                                            <span></span><?= $category['cate_name'] ?></label>
                                    <?php endforeach ?>
                                </div>
                                <div class="ps__rail-x" style="left: 0px; bottom: -50px;">
                                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__rail-y" style="top: 50px; height: 200px; right: 0px;">
                                    <div class="ps__thumb-y" tabindex="0" style="top: 22px; height: 89px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="card-icon">
                                    <i class="far fa-image text-primary"></i>
                                </span>
                                <h3 class="card-label">Thumbnail</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="custom-file">
                                <input type="file" id="customFile" name="thumbnail" accept=".png, .jpg, .jpeg, .jfif" class="custom-file-input">
                                <label class="custom-file-label" style="overflow:hidden" for="customFile">Choose file</label>
                            </div>
                            <div class="form-group preview-image" style="margin-top: 10px;"></div>
                        </div>
                    </div>
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="card-icon">
                                    <i class="fas fa-file-image text-primary"></i>
                                </span>
                                <h3 class="card-label">Album</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="custom-file">
                                <input type="file" name="album[]" accept=".png, .jpg, .jpeg, .jfif" class="custom-file-input album" multiple>
                                <label class="custom-file-label" style="overflow:hidden" for="customFile">Choose file</label>
                            </div>
                            <div class="form-group preview-image" style="margin-top: 10px;display:grid;grid-template-columns: 1fr 1fr;grid-gap:10px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Container-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
<script>
    $(document).ready(function() {
        $('#add-product').submit(function(e) {
            $('span.error').html('')
            $thisForm = $(this)
            e.preventDefault()
            $error = []
            $checkBox = $('input[name="categories[]"]:checked')
            // check empty checkbox
            if ($checkBox.length == 0) {
                $('input[name="categories[]"]').closest('.card-body').next('.card-footer').remove()
                $('input[name="categories[]"]').closest('.card-body').after(`<div class="card-footer">
                            <span class="form-text text-muted error">Please choose category</span>
                        </div>`)
                $('input[name="categories[]"]').click(function() {
                    if ($(this).is(':checked')) {
                        $(this).closest('.card-body').next('.card-footer').hide()
                    }
                })
                $error.push('categories')
            }
            // check empty thumbnail
            if ($('input[name="thumbnail"]').get(0).files.length == 0) {
                $('input[name="thumbnail"]').closest('.card-body').next('.card-footer').remove()
                $('input[name="thumbnail"]').closest('.card-body').after(`<div class="card-footer">
                            <span class="form-text text-muted error">Please choose thumbnail</span>
                        </div>`)
                $('input[name="thumbnail"]').on('change', function() {
                    $(this).closest('.card-body').next('.card-footer').hide()
                })
                $error.push('thumbnail')
            }
            // check empty description
            if (CKEDITOR.instances['editor-product'].getData().length === 0) {
                $('span.error.description').html('Please add description')
                CKEDITOR.instances['editor-product'].on('change', function() {
                    $('span.error.description').html('')
                })
                $error.push('description')
            }
            if ($error.length == 0) {
                $data = new FormData(this)
                $data.append('action', 'add-product')
                $data.set('description', CKEDITOR.instances['editor-product'].getData());
                $.ajax({
                    url: '../API/product.php',
                    type: 'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    data: $data,
                    beforeSend: function() {
                        $thisForm.find('button[type="submit"]').addClass('spinner spinner-white spinner-right').prop('disabled', true)
                    },
                    success: function(data) {
                        console.log(data)
                        setTimeout(() => {
                            if (data.status == 'success') {
                                $thisForm.find('input').prop('disabled', true)
                                CKEDITOR.instances['editor-product'].setReadOnly(true)
                                Swal.fire("Success!", "Add Product Success!", "success");
                                $thisForm.find('button[type="submit"]').removeClass('spinner spinner-white spinner-right').html('<i class="far fa-check-circle"></i> Success')
                            } else {
                                Swal.fire("Error!", "Has an error, please try again!", "error");
                                $thisForm.find('button[type="submit"]').removeClass('spinner spinner-white spinner-right').prop('disabled', false)
                                $.each(data.message, function(index, value) {
                                    $('span.error.' + index).html(value)
                                })
                            }
                        }, 1000)
                    }
                })
            }
        })
    })
</script>
<?php require_once 'layout/blocks/footer.php'; ?>