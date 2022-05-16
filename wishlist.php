<?php
require_once 'lib/layout.php';
get_header();
get_nav();
?>
<!--Begin::Profile-->
<style>
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }

    .table-content table {
        background: #ffffff none repeat scroll 0 0;
        border-color: #ebebeb;
        border-radius: 0;
        border-style: solid;
        border-width: 1px 0 0 1px;
        margin-bottom: 0;
        width: 100%;
        text-align: center;
    }

    .table-content th,
    .table-content td {
        border-bottom: 1px solid #ebebeb;
        border-right: 1px solid #ebebeb;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
        padding: 1rem 0;
    }

    .table-content table td {
        border-top: medium none;
        font-size: 16px;
        padding: 20px 10px;
        vertical-align: middle;
        max-width: 60px;
    }
    .plantmore-product-thumbnail img{
        display: block;
        object-fit: cover;
        width: 100%;
    }
    .in-stock {
        color: #30b878;
    }

    .out-stock {
        color: #A80135;
    }

    .plantmore-product-remove>a:hover {
        color: #ff5951;
    }
</style>
<main>
    <div class="breadcrumb-product">
        <div class="breadcrumb-product__name">Wishlist</div>
        <div style="display:flex">
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/home/">Home</a></div>
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/wishlist/">Wishlist</a></div>
        </div>
    </div>
    <div class="profile-page container">
        <div class="wishlist-main-content section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="#" class="cart-table">
                            <div class=" table-content table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="plantmore-product-thumbnail">Images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="plantmore-product-price">Unit Price</th>
                                            <th class="plantmore-product-remove">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-wishlist">
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--End::Profile-->
<script>
    $(document).ready(function() {
        setTitle('Wishlist | Gateux')
        function getWishList(){
            $.ajax({
                url         : ROOT_URL + '/API/wishlist.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {get: 'wishlist'},
                success     : function(data){
                    xhtml = '';
                    if(data.length > 0){
                        $.each(data, function(i,v){
                        xhtml += `<tr>
                                            <td class="plantmore-product-thumbnail"><a href="#"><img src="`+ ROOT_URL +`/assets/uploads/product/`+ v.thumb +`" alt=""></a></td>
                                            <td class="plantmore-product-name"><a href="#">`+ v.name +`</a></td>
                                            <td class="plantmore-product-price"><span class="amount">`+ v.price +`</span></td>
                                            <td class="plantmore-product-remove">
                                                <a data-product-id="`+ v.id +`" data-type-btn="wishlist-to-cart" data-toggle="tooltip" title="Add to Cart" data-placement="top">
                                                    <ion-icon name="bag-add-outline"></ion-icon>
                                                </a>
                                                <a data-product-id="`+ v.id +`" data-type-btn="remove-wishlist" data-toggle="tooltip" title="Remove from Wishlist" data-placement="top">
                                                    <ion-icon name="trash-outline"></ion-icon>
                                                </a>
                                            </td>
                                        </tr>`
                        })
                    } else {
                        xhtml = '<p style="text-align:center;padding:10px">Wishlist is empty</p>'
                    }
                    $('#table-wishlist').html(xhtml)
                }
            })
        }
        getWishList()
        $(document).on('click', '[data-type-btn="wishlist-to-cart"]', function(e){
            e.preventDefault()
            $id = $(this).data('product-id')
            $.ajax({
                url         : ROOT_URL + '/API/wishlist.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {action: 'wishlist-to-cart', id: $id},
                success     : function(data){
                    if(data.status == 'success'){
                        getWishList()
                        getCartSide()
                        toastr["success"]("Add to Cart Success!", "Success")
                    } else {
                        toastr["error"]("Has an error, please try again", "Error")
                    }
                }
            })
        })
        $(document).on('click', '[data-type-btn="remove-wishlist"]', function(e){
            e.preventDefault()
            $id = $(this).data('product-id')
            $.ajax({
                url         : ROOT_URL + '/API/wishlist.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {action: 'remove-wishlist', id: $id},
                success     : function(data){
                    if(data.status == 'success'){
                        getWishList()
                        toastr["success"]("Remove Product Success!", "Success")
                    } else {
                        toastr["error"]("Has an error, please try again", "Error")
                    }
                }
            })
        })
    })
</script>
<?php
get_footer();
?>