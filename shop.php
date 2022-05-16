<?php include './lib/layout.php';
get_header();
get_nav();
?>

<?php
$categories = DB::fetchAll("SELECT * FROM category WHERE cate_status = 1 ORDER BY cate_id DESC");
$discount_products = DB::fetchAll("SELECT * FROM product WHERE product_discount > 0 AND product_status = 1 limit 0,5");
?>
<!--main-->
<style lang="">
    .filter-list_price {
        padding: 1rem;
    }

    p#price_show {
        margin: 1rem 0;
        text-align: left;
    }

    #price_range {
        background-color: #f3f3f3;
        border: none;
        height: 10px;
        background-image: none;
    }

    .ui-widget-header {
        border: none;
        background: var(--yellow);
    }

    .sort-by {
        background-color: transparent;
        font-size: 16px;
        color: #858585;
        border: none;
        border-radius: 0;
        transition: all 0.35s linear;
    }

    .sort-by:hover,
    .sort-by:focus {
        border-bottom: 1px solid var(--pink);
    }
</style>
<main>
    <div class="breadcrumb-product">
        <div class="breadcrumb-product__name">Shop</div>
        <div style="display:flex">
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/home/">Home</a></div>
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/shop/">Shop</a></div>
        </div>
    </div>
    <div class="shop-page container">
        <div class="shop-page__column">
            <div id="dynamic_content">

            </div>
        </div>
        <div class="shop-page__column">
            <div class="filter">
                <div class="filter-title">Search</div>
                <div class="filter-body">
                    <form class="filter-search">
                        <input type="text" placeholder="Enter key..." class="filter-search__input" name="search_box" id="search_box">
                        <button class="filter-search__btn"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="filter">
                <div class="filter-title">Product Categories</div>
                <div class="filter-body">
                    <div class="filter-list__category">
                        <?php foreach($categories as $value): ?>
                        <label><input type="checkbox" class="common_selector cate" value="<?=$value['cate_id'] ?>">
                            <span><?php echo $value['cate_name'] ?></span>
                        </label>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <div class="filter">
                <div class="filter-title">Price</div>
                <div class="filter-body">
                    <div class="filter-list_price">
                        <input type="hidden" id="hidden_minimum_price" value="0" />
                        <input type="hidden" id="hidden_maximum_price" value="65000" />
                        <p id="price_show">$<?=DB::fetch("SELECT MIN(product_price) as min FROM product")['min'] ?? 0?> - $<?=DB::fetch("SELECT MAX(product_price) as max FROM product")['max'] ?? 0?></p>
                        <div id="price_range"></div>
                    </div>
                </div>
            </div>
            <div class="filter">
                <div class="filter-title">Product Sale</div>
                <div class="filter-body">
                    <div class="list-product__sale">
                        <?php foreach($discount_products as $value): ?>
                        <div class="product-sale__item">
                            <a href="<?=ROOT_URL.'/product/'.slug($value['product_name']).'-'.$value['product_id']?>/">
                                <div class="product-sale__image">
                                    <img src="<?=ROOT_URL?>/assets/uploads/product/<?=$value['product_thumb'] ?>">
                                </div>
                            </a>
                            <div class="product-sale__info">
                                <a href="<?=ROOT_URL.'/product/'.slug($value['product_name']).'-'.$value['product_id']?>/">
                                    <div class="product-sale__name"><?=$value['product_name'] ?></div>
                                </a>
                                <div class="product-sale__price"><?=product_price(($value['product_discount'] > 0) ? $value['product_price'] - ($value['product_price']*$value['product_discount']/100) : $value['product_price']) ?></div>
                            </div>
                            <div class="product-sale__item--badge">Sale</div>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--main end-->
<script>
    $(document).ready(function() {
        setTitle('Gateux Product Shop')
        $('#price_range').slider({
            range: true,
            min: <?=DB::fetch("SELECT MIN(product_price) as min FROM product")['min'] ?? 0?>,
            max: <?=DB::fetch("SELECT MAX(product_price) as max FROM product")['max'] ?? 0?>,
            values: [<?=DB::fetch("SELECT MIN(product_price) as min FROM product")['min'] ?? 0?>, <?=DB::fetch("SELECT MAX(product_price) as max FROM product")['max'] ?? 0?>],
            step: 1,
            stop: function(event, ui) {
                $('#price_show').html('$' + ui.values[0] + ' - $' + ui.values[1]);
                $('#hidden_minimum_price').val(ui.values[0]);
                $('#hidden_maximum_price').val(ui.values[1]);
                load_data(1);
            }
        });

        function get_filter(class_name)
        {
            var filter = [];
             $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
            });
        return filter;
        }

        $('.common_selector').click(function(){
        load_data(1);
        });

        load_data(1);

        function load_data(page, query = '', sort = 1){
            var minimum_price = $('#hidden_minimum_price').val();
            var maximum_price = $('#hidden_maximum_price').val(); 
            var cate = get_filter('cate');
            var sort = $('.sort-by').val() ?? 1
            $.ajax({
                url: ROOT_URL + '/API/shop.php',
                method: "POST",
                data: {page:page, query:query, sort:sort, minimum_price:minimum_price, maximum_price:maximum_price, cate:cate,sort:sort},
                success:function (data){
                    $('#dynamic_content').html(data);
                    $('.sort-by').val(sort)
                    $('.rateit').rateit()
                    $items = $('.product-item__image').length
                    $arrColor = ['#D4FFC0', '#FFC0CC', '#FFEAC0', '#C0E5FF']
                    var j = 0;
                    for (i = 0; i < $items; i++) {
                        if (j == $arrColor.length) j = 0
                        $('.product-item__image').eq(i).css('background', $arrColor[j])
                        j += 1
                    }
                }
            });
        }
        $(document).on('click', '.page-link', function(e) {
            e.preventDefault()
            var page = $(this).data('page_number');
            var query = $('#search_box').val();
            load_data(page, query);
        });

        $(document).on('click', '.page-link', function(e){
            e.preventDefault();
            var page = $(this).data('page_number');
            var query = $('#search_box').val();
            load_data(page, query,);
        });

        $('#search_box').keyup(function() {
            var query = $('#search_box').val();
            load_data(1, query);
        });

        $(document).on('change','.sort-by', function(){
            var sort = $(this).val();
            var query = $('#search_box').val();
            load_data(1, query, sort);
            // $(".sort-by").val(sort).change()
            setTimeout(()=>{
                $('.sort-by option[value="'+ sort +'"]').prop('selected', true)
            },200)
        })

        if(getParam('category') != null){
            $value = getParam('category')
            setTimeout(() => {
                $('.filter-list__category').find('input[type="checkbox"][value="'+ $value +'"]').click() 
            }, 500);
        }

        if(getParam('search') != null){
            $value = getParam('search')
            console.log($value)
            setTimeout(() => {
                $('.filter-search__input').val($value).trigger('keyup')
            }, 500);
        }


    })
</script>

<?php get_footer() ?>