<?php require_once './lib/layout.php';
get_header();
get_nav();
?>
<?php
$id = (!empty($_GET['id'])) ? (int)$_GET['id'] : 0;
$query = "SELECT * FROM product WHERE product_id = $id AND product_status = 1";
if(DB::rowCount($query) > 0){
    $product = DB::fetch($query);
    extract($product);
    DB::execute("UPDATE product SET product_view = product_view + 1 WHERE product_id = $product_id");
    $review = DB::fetch("SELECT AVG(review_rating) as avg, COUNT(*) as total FROM review WHERE (review_rating <> null OR review_parent_id is null) AND product_id = $id");
    $categories = DB::fetchAll("SELECT category.cate_id, category.cate_name FROM category, cate_product WHERE category.cate_id = cate_product.cate_id AND cate_product.product_id = $id");
?>
<!--main-->
<main>
    <div class="breadcrumb-product">
        <div class="breadcrumb-product__name"><?=$product_name?></div>
        <div style="display:flex">
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/home/">Home</a></div>
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/shop/">Product</a></div>
            <div class="breadcrumb-link"><a><?=$product_name?></a></div>
        </div>
    </div>
    <div class="product-single container">
        <div class="product-info">
            <div class="product-info__image">
                <div class="product-info__image--thumb">
                    <img src="<?=ROOT_URL?>/assets/uploads/product/<?=$product_thumb?>">
                    <?php foreach(json_decode($product_album) as $img): ?>
                    <img src="<?=ROOT_URL?>/assets/uploads/product/<?=$img?>">
                    <?php endforeach ?>
                </div>
                <div class="product-info__image--album">
                    <img src="<?=ROOT_URL?>/assets/uploads/product/<?=$product_thumb?>">
                    <?php foreach(json_decode($product_album) as $img): ?>
                    <img src="<?=ROOT_URL?>/assets/uploads/product/<?=$img?>">
                    <?php endforeach ?>
                </div>
            </div>
            <div class="product-info__detail">
                <div class="product-info__detail--name"><?=$product_name?></div>
                <div class="product-info__detail--price">
                <?=($product_discount > 0) ? product_price($product_price-(($product_discount*$product_price)/100))." <del>".product_price($product_price)."</del>" : product_price($product_price)?>
                </div>
                <div class="product-info__detail--rating">
                    <div class="rating-avg rateit" data-rateit-value="<?=$review['avg']?>" data-rateit-readonly="true" data-rateit-mode="font" style="font-size:40px" data-rateit-resetable="false" data-rateit-ispreset="true"></div> (<?=$review['total']?> reviews)
                </div>
                <div class="product-info__detail--short-description">
                    <?=strip_tags($product['product_description'])?>
                </div>
                <div class="product-info__detail--btn">
                    <div class="quantity__btn">
                        <button class="quantity__button sub"><i class="fas fa-minus"></i></button>
                        <input type="number" name="quantity" step="1" value="1" class="input-quantity" min="1">
                        <button class="quantity__button add"><i class="fas fa-plus"></i></button>
                    </div>
                    <button class="add-to-cart" data-product-id="<?=$product_id?>"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                    <button class="add-to-wishlist <?=issetWishlist($product_id) ? 'added' : ''?>" data-product-id="<?=$product_id?>" data-toggle="tooltip" title="Add to Wishlist" data-placement="top">
                        <i class="fas fa-heart added"></i>
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info__detail--categories">Categories:
                    <?php for($i = 0;$i < count($categories);$i++){
                        if($i == count($categories)-1){
                            echo ' <a href="'.ROOT_URL.'/shop/?category='.$categories[$i]["cate_id"].'">'.$categories[$i]["cate_name"].'</a>';
                        } else {
                            echo ' <a href="'.ROOT_URL.'/shop/?category='.$categories[$i]["cate_id"].'">'.$categories[$i]["cate_name"].'</a>,';
                        }
                    }?>
                </div>
                <div class="info__detail--sharing">
                    <a href="" data-share="facebook" target="_blank" data-toggle="tooltip" title="Share Facebook" data-placement="top"><i class="fab fa-facebook-f"></i></a>
                    <a href="" data-share="pinterest" target="_blank" data-toggle="tooltip" title="Share Pinterest" data-placement="top"><i class="fab fa-pinterest-p"></i></a>
                    <a href="" data-share="twitter" target="_blank" data-toggle="tooltip" title="Share Twitter" data-placement="top"><i class="fab fa-twitter"></i></a>
                    <a href="" data-share="copyurl" data-toggle="tooltip" title="Copy Url" data-placement="top"><i class="fas fa-link"></i></a>
                </div>
            </div>
        </div>
        <div class="product-detail">
            <div class="product-detail__tab">
                <span data-tab="description" class="active">Description</span>
                <span data-tab="review">Review</span>
                <div class="tabline"></div>
            </div>
            <div class="tab-content" id="description">
               <?=$product['product_description']?>
            </div>
            <div class="tab-content" id="review">
                <div class="list-review">
                </div>
                <?php if(Session::issetSession('user')) { ?>
                    <?php if(DB::rowCount("SELECT * FROM review WHERE product_id = $id AND review_rating is not null AND user_id = ". Session::get('user')['id']) == 0){ ?>
                <form action="" id="rating-submit">
                    <div class="form-review">
                        <label>Rating: </label>
                        <input type="range" min="0" max="5" value="5" step="0.5" data-rateit-ispreset="true" data-rateit-resetable="false" id="rating">
                        <div class="rateit" data-rateit-mode="font" data-rateit-resetable="false" data-rateit-ispreset="true" style="font-size: 35px;" data-rateit-backingfld="#rating"></div>
                        <label>Comment:</label>
                        <textarea class="review-textarea" rows="5" required></textarea>
                        <button type="submit" class="review-btn">Submit</button>
                    </div>
                </form>
                <?php } else { ?>
                    <div class="box-notify box-notify__success"><i class="far fa-grin-hearts"></i> Thank you for your support and review of the product. Thank you !</div>
                <?php } ?>
                <?php } else { ?>
                    <div class="box-notify box-notify__warning">Please login to review this product !</div>
                <?php } ?>
            </div>
        </div>
        <h2 class="title">related products</h2>
<?php
$arrCat = [];
foreach($categories as $cat){
    $arrCat[] = $cat['cate_id'];
}
$arrCat = implode(",", $arrCat);
$sql = "SELECT product.* FROM product, cate_product WHERE product.product_id = cate_product.product_id AND product.product_status = 1 AND product.product_id <> $product_id AND cate_product.cate_id IN ($arrCat) GROUP BY product.product_id LIMIT 0,12";
if(DB::rowCount($sql) > 0){
    $relatedProduct = DB::fetchAll($sql);
} else {
    $relatedProduct = DB::fetchAll("SELECT product.* FROM product WHERE product.product_id <> $product_id AND product.product_status = 1 LIMIT 0,12");
}
?>
        <!--product horizontal-->
        <div class="list-product-horizontal container" style="margin:2rem auto">
        <?php foreach($relatedProduct as $value): ?>
            <a href="<?=ROOT_URL.'/product/'.slug($value['product_name']).'-'.$value['product_id']?>/">
                    <div class="product-horizontal">
                        <?=($value['product_discount']>0) ? '<div class="product-horizontal__ribbon">-'.$value['product_discount'].'%</div>' : ''?>
                        <div class="product-horizontal__image">
                            <img src="<?=ROOT_URL?>/assets/uploads/product/<?=$value['product_thumb'] ?>"/>
                        </div>
                        <div class="product-horizontal__btn">
                            <button data-toggle="tooltip" title="Quickview" data-type-btn="quickview" data-modal-delay="1000" data-product-id="<?=$value['product_id']?>" data-modal="modal" data-target="#quickview" data-placement="top"><i class="fab fa-searchengin"></i></button>
                            <button data-toggle="tooltip" data-type-btn="add-to-wishlist" data-product-id="<?=$value['product_id']?>" class="<?=issetWishlist($value['product_id']) ? 'added' : ''?>" title="Add to Wishlist" data-placement="top">
                              <i class="far fa-heart"></i>
                              <i class="fas fa-heart added"></i>
                            </button>
                        </div>
                        <div class="product-horizontal__info">
                            <div class="product-horizontal__info--text">
                                <div class="product-horizontal__name"><?=$value['product_name'] ?></div>
                                <div class="product-horizontal__price"><?=product_price(($value['product_discount']>0) ? $value['product_price']-($value['product_price']*$value['product_discount']/100) : $value['product_price']) ?></div>
                            </div>
                            <div class="product-horizontal__info--btn">
                            <button type="button" data-toggle="tooltip" data-type-btn="add-to-cart" data-product-id="<?=$value['product_id']?>" title="Add to Cart" data-placement="left"><i class="fas fa-shopping-basket"></i></button>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach ?>
        </div>
        <!--product horizontal end-->
    </div>
</main>
<?php } else {
 require_once 'component/404.php';
} ?>
<!--main end-->
<script>
    $(document).ready(function(){
        setTitle('<?=$product_name?> | Gateux')
        $('.product-single .add-to-cart').click(function(){
            $thisBtn = $(this)
            $id = $thisBtn.data('product-id')
            $quantity = $thisBtn.closest('.product-info__detail--btn').find('input.input-quantity').val()
            addToCart($id, $thisBtn, $quantity)
        })
        $('.add-to-wishlist').click(function(e){
            e.preventDefault()
            $thisBtn = $(this)
            if(!$thisBtn.hasClass('added')){
                $id = $thisBtn.data('product-id')
                addToWishlist($id, $thisBtn)
            } else {
                return false
            }
        })
        function getReviewProduct(id){
            $.ajax({
                url         : ROOT_URL + '/API/review.php',
                type        : 'POST',
                dataType    : 'html',
                data        : {id: id, get: 'product-review-list-html'},
                success     : function(data){
                    if(data.length > 0){
                        $('.list-review').html(data)
                    } else {
                        $('.list-review').html(`<p style="font-weight: 700;text-align: center;font-size: 1.3rem;margin:2rem 0;">This product has no reviews yet</p>`)
                    }
                    $('.user-rating').rateit({
                        readonly: true,
                        mode: 'bg',
                        resetable:false,
                        ispreset:true
                    })
                }
            })
        }
        getReviewProduct(<?=$id?>)
        $('#rating-submit').submit(function(e){
            e.preventDefault()
            $thisForm = $(this)
            $rating = $thisForm.find('#rating').val()
            $content = $thisForm.find('.review-textarea').val()
            $productID = <?=$id?>

            $.ajax({
                url         : ROOT_URL + '/API/review.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {rating: $rating, content: $content, action: 'add-review', id: $productID},
                beforeSend  : function(){
                    $thisForm.find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true)
                },
                success     : function(data){
                    setTimeout(()=>{
                        if(data.status == 'success'){
                            toastr["success"]("Send Review Success!", "Success")
                            $thisForm.find('button[type="submit"]').html('<i class="fas fa-check-double"></i>')
                            $thisForm.slideUp(50, function(){
                                $thisForm.after('<div class="box-notify box-notify__success"><i class="far fa-grin-hearts"></i> Thank you for your support and review of the product. Thank you !</div>')   
                            })
                            getReviewProduct($productID)
                        } else {
                            $thisForm.find('button[type="submit"]').html('Submit').prop('disabled', false)
                            toastr["error"]("Has an error, try again!", "Error")
                        }
                    },1000)
                }
            })
        })
        $(document).on('submit', '#reply-review', function(e){
            e.preventDefault()
            $thisForm = $(this)
            $content = $thisForm.find('.review-textarea').val()
            $reviewID = $thisForm.find('button[type="submit"]').data('reply-review')
            $productID = <?=$id?>
            
            $.ajax({
                url         : ROOT_URL + '/API/review.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {action: 'reply-review', product: $productID, id: $reviewID, content: $content},
                beforeSend  : function(){
                    $reviewID = $thisForm.find('button[type="submit"]').html('<i class="fas fa-circle-notch fa-spin"></i>').prop('disabled',true)
                },
                success     : function(data){
                    console.log(data)
                    setTimeout(()=>{
                        if(data.status == 'success'){
                            toastr["success"]("Reply Review Success!", "Success")
                            getReviewProduct($productID)
                        } else {
                            $thisForm.find('button[type="submit"]').html('Submit').prop('disabled', false)
                            toastr["error"]("Has an error, try again!", "Error")
                        }
                    },1000)
                }
            })
        })
        $(document).on('click', '.review-item__btn--delete', function(){
            $id = $(this).data('review-id')
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url         : ROOT_URL + '/API/review.php',
                    type        : 'POST',
                    dataType    : 'json',
                    data        : {id: $id, 'action': 'delete-review'},
                    success     : function(data){
                        if(data.status == 'success'){
                            Swal.fire("Success!", "Delete Review Success!", "success")
                            getReviewProduct(<?=$id?>)
                        } else {
                            Swal.fire("Error!", "Has an error, please try again!", "error")
                        }
                    }
                })
            }
            })
        })
    })
</script>
<?php get_footer() ?>