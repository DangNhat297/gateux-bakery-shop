<?php include './lib/layout.php';
include 'config.php';
include 'lib/functions.php';

get_header();
get_nav();

$categories = DB::fetchAll("SELECT category.*, COUNT(cate_product.product_id) as soluongsanpham FROM category LEFT JOIN cate_product ON category.cate_id = cate_product.cate_id WHERE category.cate_status = 1 GROUP BY category.cate_id ORDER BY soluongsanpham DESC LIMIT 0,4");
$productsMostViewd = DB::fetchAll("SELECT * FROM product WHERE product_status = 1 ORDER BY product_id DESC LIMIT 12");
$menuToDay = DB::fetchAll("SELECT product.product_id, product.product_name, product.product_price, product.product_discount, product.product_thumb, product.product_description, product.product_view, AVG(review_rating) as avg FROM product
                                LEFT JOIN review ON review.product_id = product.product_id WHERE product.product_status = 1 GROUP BY product.product_id LIMIT 3");
$mostViewed = DB::fetchAll("SELECT product.product_id, product.product_name, product.product_price, product.product_discount, product.product_thumb, product.product_description, product.product_view, AVG(review_rating) as avg FROM product
                                LEFT JOIN review ON review.product_id = product.product_id WHERE product.product_status = 1 GROUP BY product.product_id ORDER BY product_view ASC LIMIT 3");
$bestSeller = DB::fetchAll("SELECT order_detail.product_id, product.product_name, product.product_thumb, product.product_price, product.product_discount, product.product_description, AVG(review.review_rating) as rating, tb1.sum FROM order_detail INNER JOIN product ON product.product_id = order_detail.product_id LEFT JOIN review ON review.product_id = order_detail.product_id INNER JOIN (SELECT product_id,SUM(product_quantity) as sum FROM order_detail GROUP BY product_id) as tb1 ON tb1.product_id = order_detail.product_id GROUP BY order_detail.product_id, review.product_id ORDER BY sum DESC LIMIT 0,3;");
$slides = DB::fetchAll("SELECT * FROM slider");
?>
    <main>
        <!--main-->
        <!-- hero slider Start -->
        <div class="banner-wrap hero-slider">
            <div class="banner-slider">
                <?php foreach($slides as $slide): ?>
                <!-- hero slide start -->
                <div class="banner-slide">
                    <div class="hero-image" style="background-image: url(data:image/jpeg;base64,<?=$slide['slider_img']?>)"></div>
                    <div class="container">
                        <div class="hero-content">
                            <h1 data-animation="rollIn" data-delay="0.8s">
                                <?=$slide['slider_title']?>
                            </h1>
                        </div>
                    </div>
                    <!-- <div class="hero-content__image" data-animation="fadeInDown" data-delay="0.8s">
                        <img src="assets/img/slide/m4-s-1-1.png"/>
                    </div> -->
                    <?php if($slide['slider_url'] != ''){ ?>
                        <a href="<?=ROOT_URL.'/'.$slide['slider_url']?>"><button class="hero-btn">Learn more</button></a>
                    <?php } ?>
                    <!--Waves Container-->
                    <div>
                        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                            <defs>
                                <path id="gentle-wave"
                                      d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"/>
                            </defs>
                            <g class="parallax">
                                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7"/>
                                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)"/>
                                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)"/>
                                <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff"/>
                            </g>
                        </svg>
                    </div>
                    <!--Waves end-->
                </div>
                <?php endforeach ?>
                <!-- hero slide end -->
                <!-- hero slide start -->
                <!-- <div class="banner-slide">
                    <div class="hero-image" style="background-image: url('assets/img/slide/m4-s-2.jpg')"></div>
                    <div class="container">
                        <div class="hero-content">
                            <h1 data-animation="slideInDown" data-delay="0.8s">
                                Best Quality Products
                            </h1>
                        </div>
                    </div>
                    <div class="hero-content__image" data-animation="fadeInDown" data-delay="0.8s">
                        <img src="assets/img/slide/m4-s-2-1.png"/>
                    </div>
                    <button class="hero-btn">Learn more</button> -->
                    <!--Waves Container-->
                    <!-- <div>
                        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                            <defs>
                                <path id="gentle-wave"
                                      d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"/>
                            </defs>
                            <g class="parallax">
                                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7"/>
                                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)"/>
                                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)"/>
                                <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff"/>
                            </g>
                        </svg>
                    </div> -->
                    <!--Waves end-->
                <!-- </div> -->
                <!-- hero slide end -->
            </div>
        </div>
        <!-- hero slider end -->
        <!--category populated-->
        <div class="category-populated container">
            <?php foreach($categories as $cate): ?>
            <a href="<?=ROOT_URL.'/shop/?category='.$cate['cate_id']?>">
                <div class="cat-populated__item">
                    <img src="<?=ROOT_URL?>/assets/uploads/category/<?=$cate['cate_thumb']?>">
                    <div class="cat-populated__title"><?=$cate['cate_name']?></div>        
                </div>
            </a>
            <?php endforeach ?>
        </div>
        <!--category populated end-->
        <h2 class="title">new product</h2>
        <!--product horizontal-->
        <div class="list-product-horizontal container">
            <?php foreach ($productsMostViewd as $value): ?>
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
            <?php endforeach; ?>
        </div>
        <!-- <a href="<?=ROOT_URL?>/shop/"><button class="see-more-product">See more...</button></a> -->
        <!--product horizontal end-->
        <h2 class="title">best service</h2>
        <!--service-->
        <div class="service container">
            <div class="service-item">
                <img src="<?=ROOT_URL?>/assets/img/m4-bg-1.jpg"/>
            </div>
            <div class="service-item">
                <h6 class="service-item__number">01.</h6>
                <h3 class="service-item__title">custom shape</h3>
                <p class="service-item__description">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry.
                </p>
            </div>
            <div class="service-item">
                <h6 class="service-item__number">02.</h6>
                <h3 class="service-item__title">free shipping</h3>
                <p class="service-item__description">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry.
                </p>
            </div>
            <div class="service-item">
                <h6 class="service-item__number">03.</h6>
                <h3 class="service-item__title">new design</h3>
                <p class="service-item__description">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry.
                </p>
            </div>
            <div class="service-item">
                <h6 class="service-item__number">04.</h6>
                <h3 class="service-item__title">hight-quality service</h3>
                <p class="service-item__description">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry.
                </p>
            </div>
        </div>
        <!--service end-->
        <!--product column-->
        <div class="list-product-vertical container">
            <!--column 1-->
            <div class="product-column">
                <div class="product-column__title">Menu Today</div>
                <div class="product-column__list">
                    <?php foreach ($menuToDay as $value): ?>
                        <div class="product-column__item">
                            <a href="<?=ROOT_URL.'/product/'.slug($value['product_name']).'-'.$value['product_id']?>/">
                                <div class="product-column__item--image">
                                    <img src="<?=ROOT_URL?>/assets/uploads/product/<?php echo $value['product_thumb'] ?>"/>
                                    <button data-toggle="tooltip" data-modal="modal" data-target="#quickview" data-type-btn="quickview" data-modal-delay="1000" data-product-id="<?=$value['product_id']?>" title="Quickview" data-placement="top">
                                        <i class="fab fa-searchengin"></i>
                                    </button>
                                </div>
                            </a>
                            <div class="product-column__item--info">
                                <a href="">
                                    <div class="product-column__item--name"><?php echo $value['product_name'] ?></div>
                                </a>
                                <div class="rateit" data-rateit-value="<?php echo $value['avg']?>" data-rateit-resetable="false"
                                     data-rateit-ispreset="true" data-rateit-mode="font" style="font-size:20px" data-rateit-readonly = "true"></div>
                                <div class="product-column__item--price"><?=product_price(($value['product_discount'] > 0) ? $value['product_price'] - ($value['product_price']*$value['product_discount']/100) : $value['product_price']) ?></div>
                                <div class="product-column__item--description">
                                    <?=handleField($value['product_description'])?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!--column 2-->
            <div class="product-column">
                <div class="product-column__title">best sellers</div>
                <div class="product-column__list">
                    <?php foreach ($bestSeller as $value): ?>
                        <div class="product-column__item">
                            <a href="<?=ROOT_URL.'/product/'.slug($value['product_name']).'-'.$value['product_id']?>/">
                                <div class="product-column__item--image">
                                    <img src="<?=ROOT_URL?>/assets/uploads/product/<?php echo $value['product_thumb'] ?>"/>
                                    <button data-toggle="tooltip" data-modal="modal" data-target="#quickview" data-type-btn="quickview" data-modal-delay="1000" data-product-id="<?=$value['product_id']?>" title="Quickview" data-placement="top">
                                        <i class="fab fa-searchengin"></i>
                                    </button>
                                </div>
                            </a>
                            <div class="product-column__item--info">
                                <a href="">
                                    <div class="product-column__item--name"><?php echo $value['product_name'] ?></div>
                                </a>
                                <div class="rateit" data-rateit-value="<?php echo $value['rating']?>" data-rateit-resetable="false"
                                     data-rateit-ispreset="true" data-rateit-mode="font" style="font-size:20px" data-rateit-readonly = "true"></div>
                                <div class="product-column__item--price"><?=product_price(($value['product_discount'] > 0) ? $value['product_price'] - ($value['product_price']*$value['product_discount']/100) : $value['product_price']) ?></div>
                                <div class="product-column__item--description">
                                    <?=handleField($value['product_description'])?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!--column 3-->
            <div class="product-column">
                <div class="product-column__title">Most View</div>
                <div class="product-column__list">
                    <?php foreach ($mostViewed as $value): ?>
                        <div class="product-column__item">
                            <a href="<?=ROOT_URL.'/product/'.slug($value['product_name']).'-'.$value['product_id']?>/">
                                <div class="product-column__item--image">
                                    <img src="<?=ROOT_URL?>/assets/uploads/product/<?php echo $value['product_thumb'] ?>"/>
                                    <button data-toggle="tooltip" data-modal="modal" data-target="#quickview" data-type-btn="quickview" data-modal-delay="1000" data-product-id="<?=$value['product_id']?>" title="Quickview" data-placement="top">
                                        <i class="fab fa-searchengin"></i>
                                    </button>
                                </div>
                            </a>
                            <div class="product-column__item--info">
                                <a href="">
                                    <div class="product-column__item--name"><?php echo $value['product_name'] ?></div>
                                </a>
                                <div class="rateit" data-rateit-value="<?php echo $value['avg']?>" data-rateit-resetable="false"
                                     data-rateit-ispreset="true" data-rateit-mode="font" style="font-size:20px" data-rateit-readonly = "true"></div>
                                <div class="product-column__item--price"><?=product_price(($value['product_discount'] > 0) ? $value['product_price'] - ($value['product_price']*$value['product_discount']/100) : $value['product_price']) ?></div>
                                <div class="product-column__item--description">
                                    <?=handleField($value['product_description'])?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!--product column end-->
        <!--product discount-->
<?php
$sql = "SELECT * FROM product WHERE product_discount > 0 AND product.product_id = (SELECT MAX(product_id) FROM product WHERE product_discount > 0);";
if(DB::rowCount($sql) > 0){ 
    $product = DB::fetch($sql);
?>
        <div class="product-discount container">
            <div class="product-discount__image">
                <img src="<?=ROOT_URL?>/assets/uploads/product/<?=$product['product_thumb']?>"/>
            </div>
            <div class="product-discount__info">
                <div class="product-discount__event">New Event</div>
                <div class="product-discount__quantity-customer">100+ client</div>
                <div class="product-discount__sale">sale up to <?=$product['product_discount']?>%</div>
                <div class="product-discount__description">
                    <?=handleField($product['product_description'])?>
                </div>
                <a href="<?=ROOT_URL.'/product/'.slug($product['product_name']).'-'.$product['product_id']?>/"><button style="width:100%" class="product-discount__btn">buy now</button></a>
            </div>
        </div>
<?php } ?>
        <!--product discount end-->
                <!--blog-->
<?php
$listPost = DB::fetchAll("SELECT * FROM blog");
$dataPost = [];
foreach($listPost as $post){
    $date = new DateTime($post['blog_date']);
    $time = $date->format("M d, Y");
    $dataPost[] = [
        'slug'      => $post['blog_slug'],
        'thumb'     => $post['blog_thumbnail'],
        'author'    => $post['blog_author'],
        'title'     => $post['blog_title'],
        'time'      => $time
    ];
}
?>
        <h2 class="title">Blog</h2>
        <div class="list-blog container">
            <?php foreach($dataPost as $post): ?>
            <div class="blog">
                <div class="blog-thumb">
                    <img src="<?=ROOT_URL?>/assets/uploads/post/<?=$post['thumb']?>">
                </div>
                <div class="blog-date">
                    <span>
                        <i class="fas fa-user-edit"></i> <?=$post['author']?>
                    </span>
                    <span><i class="far fa-calendar-alt"></i> <?=$post['time']?></span>
                </div>
                <a href="<?=ROOT_URL.'/post/'.$post['slug']?>/"><div class="blog-title"><?=$post['title']?></div></a>
                <a href="<?=ROOT_URL.'/post/'.$post['slug']?>/"><button class="blog-read">Read More</button></a>
            </div>
            <?php endforeach ?>
        </div>
        <!--blog end-->
        <!--author-->
        <h2 class="title">Our chef</h2>
        <div class="list-author container">
            <div class="author-item">
                <div class="author-avatar">
                    <img src="<?=ROOT_URL?>/assets/img/default.jpg"/>
                    <div class="author-contact">
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-facebook-f"></i>
                            </div>
                        </a>
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-instagram"></i>
                            </div>
                        </a>
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-pinterest-p"></i>
                            </div>
                        </a>
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-twitter"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="author-info">
                    <div class="author-info__name">Adam Smile</div>
                    <div class="author-info__position">Director</div>
                </div>
            </div>
            <div class="author-item">
                <div class="author-avatar">
                    <img src="<?=ROOT_URL?>/assets/img/default.jpg"/>
                    <div class="author-contact">
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-facebook-f"></i>
                            </div>
                        </a>
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-instagram"></i>
                            </div>
                        </a>
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-pinterest-p"></i>
                            </div>
                        </a>
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-twitter"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="author-info">
                    <div class="author-info__name">Adam Smile</div>
                    <div class="author-info__position">Director</div>
                </div>
            </div>
            <div class="author-item">
                <div class="author-avatar">
                    <img src="<?=ROOT_URL?>/assets/img/default.jpg"/>
                    <div class="author-contact">
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-facebook-f"></i>
                            </div>
                        </a>
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-instagram"></i>
                            </div>
                        </a>
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-pinterest-p"></i>
                            </div>
                        </a>
                        <a href="">
                            <div class="author-contact__social">
                                <i class="fab fa-twitter"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="author-info">
                    <div class="author-info__name">Adam Smile</div>
                    <div class="author-info__position">Director</div>
                </div>
            </div>
        </div>
        <!--author end-->
        <!--instagram gallery-->
        <div class="instagram-gallery container">
            <div class="instagram-gallery__item">
                <p class="ins">@Instagram</p>
                <p class="follower">10k Follower</p>
                <p class="text-fl">
                Follow our store on instagram to see product photos.
                </p>
                <button class="follow-us">Follow</button>
            </div>
            <div class="instagram-gallery__item">
                <img src="<?=ROOT_URL?>/assets/img/photo-1588195540875-63c2be0f60ae.jfif"/>
            </div>
            <div class="instagram-gallery__item">
                <img src="<?=ROOT_URL?>/assets/img/photo-1588227071345-751a485e2f79.jfif"/>
            </div>
            <div class="instagram-gallery__item">
                <img src="<?=ROOT_URL?>/assets/img/photo-1589119908995-c6837fa14848.jfif"/>
            </div>
            <div class="instagram-gallery__item">
                <img src="<?=ROOT_URL?>/assets/img/photo-1600326145552-327f74b9c189.jfif"/>
            </div>
            <div class="instagram-gallery__item">
                <img src="<?=ROOT_URL?>/assets/img/photo-1516054575922-f0b8eeadec1a.jfif"/>
            </div>
        </div>
        <!--instagram gallery end-->
        <!--our partner-->
        <h2 class="title">our partner</h2>
        <div class="partners container">
            <div class="partner-item">
                <img src="<?=ROOT_URL?>/assets/img/partner-1.png"/>
            </div>
            <div class="partner-item">
                <img src="<?=ROOT_URL?>/assets/img/partner-2.png"/>
            </div>
            <div class="partner-item">
                <img src="<?=ROOT_URL?>/assets/img/partner-3.png"/>
            </div>
            <div class="partner-item">
                <img src="<?=ROOT_URL?>/assets/img/partner-4.png"/>
            </div>
            <div class="partner-item">
                <img src="<?=ROOT_URL?>/assets/img/partner-5.png"/>
            </div>
            <div class="partner-item">
                <img src="<?=ROOT_URL?>/assets/img/partner-6.png"/>
            </div>
            <div class="partner-item">
                <img src="<?=ROOT_URL?>/assets/img/partner-7.png"/>
            </div>
            <div class="partner-item">
                <img src="<?=ROOT_URL?>/assets/img/partner-8.png"/>
            </div>
            <div class="partner-item">
                <img src="<?=ROOT_URL?>/assets/img/partner-9.png"/>
            </div>
            <div class="partner-item">
                <img src="<?=ROOT_URL?>/assets/img/partner-10.png"/>
            </div>
        </div>
        <!--out partner end-->   
    </main>
    <!--main end-->
<?php get_footer() ?>