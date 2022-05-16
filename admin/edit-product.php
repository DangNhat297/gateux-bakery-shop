<?php require_once 'layout/blocks/header.php'; ?>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
		<div class="container">
<?php
$id = (!empty($_GET['product'])) ? (int)$_GET['product'] : 0;
$query = "SELECT * FROM product WHERE product_id = $id";
if(DB::rowCount($query) > 0){
?>            
			<!--begin::row-->
            <form id="update-product">
			<div class="row">
                <div class="col-md-8">
                    <div class="card card-custom">
                        <div class="card-header">
                            <h3 class="card-title">Add Product</h3>
                        </div>
                        <!--begin::Form-->
                            <div class="card-body">
                                <input type="hidden" name="id">
                                <div class="form-group">
                                    <label>Product Name
                                    <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter product name" required="">
                                    <span class="form-text text-muted error name"></span>
                                </div>
                                <div class="form-group">
                                    <label>Product Price
                                    <span class="text-danger">*</span></label>
                                    <input type="number" min="0" class="form-control" name="price" placeholder="Enter product price" required="">
                                    <span class="form-text text-muted error price"></span>
                                </div>
                                <div class="form-group">
                                    <label>Product Discount
                                    <span class="text-danger">*</span></label>
                                    <input type="number" value="0" min="0" max="100" name="discount" class="form-control" placeholder="Enter product discount" required="">
                                    <span class="form-text text-muted error discount"></span>
                                </div>
                                <div class="form-group">
                                    <label>Product Status</label>
                                    <div class="radio-inline">
                                        <label class="radio">
                                        <input type="radio" value="1" name="status">
                                        <span></span>Active</label>
                                        <label class="radio">
                                        <input type="radio" value="0" name="status">
                                        <span></span>Not Active</label>
                                    </div>
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
                            <button type="submit" class="btn btn-primary mr-2">Update</button>
                            <a href="list-product.php"><button type="button" class="btn btn-secondary mr-2">Back</button></a>
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
                                <?php foreach(DB::fetchAll("SELECT * FROM category WHERE cate_status = 1") as $category): ?>
                                    <label class="checkbox">
                                    <input type="checkbox" value="<?=$category['cate_id']?>" name="categories[]">
                                    <span></span><?=$category['cate_name']?></label>
                                <?php endforeach ?>
                                </div>
                            <div class="ps__rail-x" style="left: 0px; bottom: -50px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 50px; height: 200px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 22px; height: 89px;"></div></div></div>
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
                            <div class="form-group preview-image album" style="margin-top: 10px;display:grid;grid-template-columns: 1fr 1fr;grid-gap:10px"></div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
		<!--end::Container-->
<?php } else { ?>
    <div class="alert alert-custom alert-danger" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">Product doesn't exists!</div>
    </div>
<?php } ?>        
	    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
<script>
    $(document).ready(function(){
        function getProduct(){
            $.ajax({
                url         : '../api/product.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {get: 'product', id: <?=$id?>},
                success     : function(data){
                    $form = $('#update-product')
                    $form.find('input[name="id"]').val(data.id)
                    $form.find('input[name="name"]').val(data.name)
                    $form.find('input[name="price"]').val(data.price)
                    $form.find('input[name="discount"]').val(data.discount)
                    $form.find('input:radio[name="status"][value="'+ data.status +'"]').prop('checked', true)
                    setTimeout(()=>{
                        CKEDITOR.instances['editor-product'].setData(data.description)
                    },500)
                    $.each(data.categories, function(index, value){
                        $form.find('input:checkbox[name="categories[]"][value="'+ value +'"]').prop('checked', true)
                    })
                    //$form.find('.preview-image.thumbnail').append(`<img src='../assets/uploads/product/`+ data.thumb +`' style='width: auto;height: 150px;object-fit:cover;border:1px solid #3699ff;border-radius:5px;'>`)
                    $form.find('#kt_user_edit_avatar').css('background-image', 'url("../assets/uploads/product/'+ data.thumb +'")')
                    getAlbum()
                }
            })
        }
        getProduct()
        function getAlbum(){
            $.ajax({
                url         : '../api/product.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {get: 'product', id: <?=$id?>},
                success     : function(data){
                    $form = $('#update-product')
                    xhtml = ''
                    $.each(data.album, function(index, value){
                        xhtml += `<div class="card card-custom overlay">
											<div class="card-body p-0">
												<div class="overlay-wrapper">
													<img src="../assets/uploads/product/`+ value +`" alt="" class="w-100 rounded">
												</div>
												<div class="overlay-layer">
													<button type="button" data-position-album="`+ index +`" class="btn btn-icon font-weight-bold btn-danger btn-shadow remove-album"><i class="far fa-trash-alt"></i></button>
												</div>
											</div>
										</div>`
                    })
                    $form.find('.preview-image.album').html(xhtml)
                }
            })
        }
        getAlbum()
        $(document).on('click', '.remove-album', function(){
            $pos = $(this).data('position-album')
            $.ajax({
                url         : '../API/product.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {action: 'remove-album', pos: $pos, id: <?=$id?>},
                success     : function(data){
                    console.log(data)
                    getAlbum()
                }
            })
        })
        $('#update-product').submit(function(e){
            $('span.error').html('')
            $thisForm = $(this)
            e.preventDefault()
            $error = []
            $checkBox = $('input[name="categories[]"]:checked')
            // check empty checkbox
            if($checkBox.length == 0){
                $('input[name="categories[]"]').closest('.card-body').next('.card-footer').remove()
                $('input[name="categories[]"]').closest('.card-body').after(`<div class="card-footer">
                            <span class="form-text text-muted error">Please choose category</span>
                        </div>`)
                $('input[name="categories[]"]').click(function(){
                    if($(this).is(':checked')){
                        $(this).closest('.card-body').next('.card-footer').hide()
                    }
                })
                $error.push('categories')
            }
            // check empty description
            if(CKEDITOR.instances['editor-product'].getData().length === 0){
                $('span.error.description').html('Please add description')
                CKEDITOR.instances['editor-product'].on('change', function(){
                    $('span.error.description').html('')
                })
                $error.push('description')
            }
            if($error.length == 0){
                $data = new FormData(this)
                $data.append('action', 'update-product')
                $data.set('description', CKEDITOR.instances['editor-product'].getData());
                $.ajax({
                    url         : '../API/product.php',
                    type        : 'POST',
                    dataType    : 'json',
                    contentType : false,
                    processData : false,
                    data        : $data,
                    beforeSend  : function(){
                        $thisForm.find('button[type="submit"]').addClass('spinner spinner-white spinner-right').prop('disabled', true)
                    },
                    success     : function(data){
                        console.log(data)
                        setTimeout(()=>{
                            if(data.status == 'success'){
                                $thisForm.find('input').prop('disabled', true)
                                CKEDITOR.instances['editor-product'].setReadOnly(true)
                                Swal.fire("Success!", "Add Product Success!", "success");
                                $thisForm.find('button[type="submit"]').removeClass('spinner spinner-white spinner-right').html('<i class="far fa-check-circle"></i> Success')
                                $thisForm.find('.preview-image.album').prev('.preview-image').slideUp()
                                getAlbum()
                            } else {
                                Swal.fire("Error!", "Has an error, please try again!", "error");
                                $thisForm.find('button[type="submit"]').removeClass('spinner spinner-white spinner-right').prop('disabled', false)
                                $.each(data.message, function(index, value){
                                    $('span.error.' + index).html(value)
                                })
                            }
                        },1000)
                    }
                })
            }
        })
    })
</script>
<?php require_once 'layout/blocks/footer.php'; ?>