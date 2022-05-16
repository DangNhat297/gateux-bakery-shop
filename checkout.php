<?php 
require_once 'lib/layout.php';
get_header();
get_nav();
?>
<style>
    li.show-cart-side{
        display: none;
    }
</style>
<!--Begin::Main-Checkout--> 
<main>
    <div class="breadcrumb-product">
        <div class="breadcrumb-product__name">Checkout</div>
        <div style="display:flex">
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/home/">Home</a></div>
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/cart/">Cart</a></div>
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/checkout/">Checkout</a></div>
        </div>
    </div>
<?php if(Session::issetSession('user')){
$userID = Session::get('user')['id']; 
if(DB::rowCount("SELECT * FROM cart WHERE user_id = $userID") > 0){    
?>
    <form id="checkout">
    <div class="check-out container">
        <div class="check-out__left">
            <p class="title-checkout"><span>Billing Details</span></p>
            <div class="form-information-checkout">
                <div class="form-group">
                    <label>
                        <span>Fullname <sup class="text-danger">*</sup></span>
                        <input class="form-control" type="text" name="fullname" placeholder="Enter fullname" required>
                    </label>
                </div>
                <div class="form-group row">
                    <div class="form-group">
                        <label>
                            <span>Phone <sup class="text-danger">*</sup></span>
                            <input class="form-control" type="number" name="phone" placeholder="Enter number phone" required>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <span>Email <sup class="text-danger">*</sup></span>
                            <input class="form-control" type="email" name="email" placeholder="Enter email" required>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        <span>Address<sup class="text-danger">*</sup></span>
                        <input class="form-control" name="address" type="text" placeholder="Enter address" required>
                    </label>
                </div>
                <div class="form-group">
                    <label><span>Note</span>
                        <textarea class="form-control" name="note" rows="5" placeholder="Addition information"></textarea>
                    </label>
                </div>
            </div>
        </div>
        <div class="check-out__right">
<?php 
$sql = "SELECT product.product_name, product.product_price, product.product_discount, cart.* FROM product, cart WHERE product.product_id = cart.product_id AND user_id = $userID";
$listCart = DB::fetchAll($sql);
$data = [];
$sum = 0;
foreach($listCart as $product){
    $data[] = [
        'product'   => $product['product_name'],
        'quantity'  => $product['product_quantity'],
        'total'     => ($product['product_discount'] > 0) ? ($product['product_price'] - ($product['product_price']*$product['product_discount']/100))*$product['product_quantity'] : $product['product_price']*$product['product_quantity']
    ];
}
$sum = array_reduce($data, function($sum, $i){
    $sum += $i['total'];
    return $sum;
},0);
?>
            <p class="title-checkout"><span>Your Order <i class="fas fa-cookie-bite"></i></span></p>
            <h5>Delivery Address:</h5>
            <div class="delivery-address">
                <p data-as="fullname"></p>
                <p data-as="phone"></p>
                <p data-as="email"></p>
                <p data-as="address"></p>
                <p data-as="note"></p>
            </div>
            <h5>Order Details:</h5>
            <table class="check-out-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="list-cart-checkout">
                <?php foreach($data as $value): ?>
                    <tr>
                        <td><?=$value['product']?> <span style="color:var(--pink)">x  <?=$value['quantity']?></span></td>
                        <td><?=product_price($value['total'])?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Grand Total</th>
                        <th><?=product_price($sum)?></th>
                    </tr>
                </tfoot>
            </table>
            <div class="form-group">
                <p>
                    <input type="radio" id="test1" name="radio-group" checked>
                    <label for="test1">Payment on delivery</label>
                </p>
            </div>
            <button type="submit" class="cart-checkout">Checkout</button>
        </div>
    </div>
    </form>
<?php 
} else { ?>
<div class="active-page">
    <p>Cart is empty !</p>
    <a href="<?=ROOT_URL?>/shop/"><button class="detail-order" style="margin-top:20px">Continue shopping</button></a>
</div>
<?php }
} else { ?>
    <div class="active-page">Please <a href="<?=ROOT_URL?>/auth/#login" style="color:var(--pink)">login</a> or <a href="<?=ROOT_URL?>/auth/#register" style="color:var(--pink)">register</a> to proceed with the order payment</div>
<?php } ?>
</main>
<!--End::Main-Checkout-->
<script>
    $(document).ready(function(){
        setTitle('Checkout | Gateux')
        $('#checkout').submit(function(e){
            e.preventDefault()
            $thisForm = $(this)
            $data = new FormData(this)
            $data.append('action','checkout')
            $.ajax({
                url         : ROOT_URL + '/API/order.php',
                type        : 'POST',
                dataType    : 'json',
                contentType : false,
                processData : false,
                data        : $data,
                beforeSend  : function(){
                    $thisForm.find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true)
                },
                success     : function(data){
                    setTimeout(()=>{
                        if(data.status == 'success'){
                            Swal.fire("Success!", "Checkout success", "success")
                            $thisForm.find('button[type="submit"]').html('<i class="fas fa-check"></i> Success')
                            $thisForm.find('.check-out__left').fadeOut()
                            $('.check-out.container').css({
                                "grid-template-columns" : "95%",
                                "justify-content" : "center"
                            })
                            $thisForm.find('.check-out__right').append(`<div class="box-notify box-notify__success"><i class="far fa-grin-hearts"></i> Checkout success, thanks ! <i class="far fa-grin-hearts"></i></div>`)
                            $thisForm.find('.check-out__right').append(`<a href="index.php"><button type="button" class="detail-order" style="margin-top:20px">Continue shopping</button></a>`)
                        } else {
                            $thisForm.find('button[type="submit"]').html('Checkout').prop('disabled', false)
                            Swal.fire("Error!", "Checkout failed, try again!", "error")
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