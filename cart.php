<?php require_once './lib/layout.php';
get_header();
get_nav();
?>
<!--main-->
<main>
    <div class="breadcrumb-product">
        <div class="breadcrumb-product__name">Cart</div>
        <div style="display:flex">
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/home/">Home</a></div>
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/cart/">Cart</a></div>
        </div>
    </div>
    <div class="cart-page container">
        <div class="table-cart__header">
            <div>Product Image</div>
            <div>Product Name</div>
            <div>Price</div>
            <div>Quantity</div>
            <div>Total</div>
            <div>Action</div>
        </div>
        <div class="table-cart__body">
        </div>
        <div class="total-money">
            <span>Sum money: </span>
            <span class="sum-cart">$0</span>
        </div>
        <div class="cart-footer__btn">
            <div style="display: flex;flex-direction: column;row-gap:10px">
                <!-- <form action="" class="apple-code">
                    <input type="text" class="form-control" placeholder="Apple code...">
                    <button class="apply-code__btn"><i class="fas fa-angle-right"></i></button>
                </form> -->
                <a href="<?=ROOT_URL?>/shop/"><button class="continue-shopping"><i class="fas fa-shopping-bag"></i> Continue Shopping</button></a>
            </div>
            <a href="<?=ROOT_URL?>/checkout/"><button class="cart-checkout"><i class="fas fa-money-check-alt"></i> Checkout</button></a>
        </div>
    </div>
</main>
<!--main end-->
<script>
    function getCartPage(){
            $.ajax({
                url         : ROOT_URL + '/API/cart.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {get: 'list-cart'},
                success     : function(data){
                    xhtml = ''
                    if(data.product.length > 0){
                        $.each(data.product, function(i,value){
                            xhtml += `<div class="cart-item">
                                        <div class="cart-item__image">
                                            <img src="`+ ROOT_URL +`/assets/uploads/product/`+ value.image +`">
                                        </div>
                                        <div class="cart-item__name">`+ value.name +`</div>
                                        <div class="cart-item__price">`+ value.price +`</div>
                                        <div class="cart-item__quantity">
                                            <div class="quantity__btn">
                                                <button class="quantity__button sub"><i class="fas fa-minus"></i></button>
                                                <input type="number" name="quantity" data-cart-id="`+ value.id +`" step="1" value="`+ value.quantity +`" class="input-quantity" min="1">
                                                <button class="quantity__button add"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="cart-item__total">`+ value.total +`</div>
                                        <div class="cart-item__action">
                                            <button class="remove-cart__btn" data-cart-id="`+ value.id +`" data-toggle="tooltip" data-placement="top" title="Delete"><i class="far fa-trash-alt"></i></button>
                                        </div>
                                    </div>`
                        })
                        $('.cart-checkout').show()
                    } else {
                        xhtml += '<p style="text-align:center;padding:10px;">Cart is empty</p>'
                        $('.cart-checkout').hide()
                    }
                    $('.table-cart__body').html(xhtml)
                    $('.sum-cart').html(data.sum)
                }
            })
        }
    $(document).ready(function(){
        setTitle('Cart | Gateux')
        getCartPage()
        $(document).on('change', '.input-quantity', function(){
            $this = $(this)
            $cartID = $this.data('cart-id')
            $quantity = parseInt($this.val())
            $.ajax({
                url         : ROOT_URL + '/API/cart.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {id: $cartID,quantity: $quantity, action: 'update-cart'},
                success     : function(data){
                    if(data.status == 'success'){
                        toastr["success"]("Update Cart Success!", "Success")
                        getCartPage()
                        getCartSide()
                    } else {
                        toastr["error"]("Has an error, try again!", "Error")
                    }
                }
            })
        })
    })
</script>
<?php get_footer() ?>