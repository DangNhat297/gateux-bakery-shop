<?php
require_once 'lib/layout.php';
get_header();
get_nav();
?>
<!--Begin::Contact-->
<style>
    main {
        background-color: #f3f5f8;
        margin-bottom: -5rem;
        padding: 0 0 3rem;
    }

    .post {
        margin: 3rem 0;
        position: relative;
        overflow: hidden;
        width: 100%;
        margin-bottom: 60px;
        text-align: left;
        border-radius: 3px;
        background: #fff;
    }

    a {
        transition: color 0.15s ease-out, border 0.15s ease-out, opacity 0.15s ease-out, background-color 0.15s ease-out;
        text-decoration: none;
        color: #000;
        outline: none;
    }

    .post .post-header-image img {
        display: block;
        width: 100%;
        min-height: 50px;
        margin-top: -2px;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
    }

    .post .post-info {
        position: relative;
        z-index: 400;
        top: -20px;
        padding: 0 7.177033492822966%;
    }

    h1.post-title {
        font-size: 36px;
        font-weight: 600;
        line-height: 54px;
        width: 90%;
        margin: 50px 0 40px;
    }

    .post .post-contents {
        font-size: 16px;
        line-height: 34px;
        margin: 40px 0;
        color: #757a83;
    }

    .post .post-date {
        position: relative;
        display: block;
        float: left;
        width: 15%;
        margin: 100px 0 0 -20px;
        text-align: center;
        text-transform: uppercase;
    }

    .post .post-date {
        position: relative;
        display: block;
        float: left;
        width: 15%;
        margin: 100px 0 0 -20px;
        text-align: center;
        text-transform: uppercase;
    }

    .post .post-date .post-date-day {
        font-size: 24px;
        display: block;
        margin: 0 auto 15px;
        color: #51555b;
    }

    .post .post-date .post-date-month {
        font-size: 17px;
        display: block;
        margin-bottom: 15px;
        color: #abb0b7;
    }

    .post .post-date .post-date-year {
        font-size: 14px;
        display: block;
        margin-bottom: 15px;
        color: #d4d8df;
    }

    .post .post-date .post-date-year {
        font-size: 14px;
        display: block;
        margin-bottom: 15px;
        color: #d4d8df;
        background: #ed7902;
    }

    .post .post-date hr {
        width: 60px;
        height: 1px;
        margin: 35px auto;
        border: 0;
        background: #e2e7ed;
        box-sizing: border-box;
    }

    .post .post-right-align {
        float: right;
        width: 78%;
    }

    .post .post-categories {
        margin-bottom: -10px;
    }

    .post .post-category {
        font-size: 12px;
        display: inline-block;
        padding: 13px 30px;
        text-transform: uppercase;
        color: #fff;
        border-radius: 100px;
        background: #7ac143;
    }

    .post .post-meta {
        font-size: 13px;
        overflow: hidden;
        margin: 9.177033492822966% 0 1%;
        list-style: none;
        text-transform: uppercase;
        color: #b4bcca;
    }

    .post .post-meta .post-read-more a ion-icon {
        width: 16px;
        height: 16px;
        margin-left: 10px;
        vertical-align: -3px;
        color: #111112;
    }

    .post .post-meta .post-read-more a:hover ion-icon {
        -webkit-animation: pan-right-with-fade 0.8s ease-in-out infinite;
        animation: pan-right-with-fade 0.8s ease-in-out infinite;
    }


    @-webkit-keyframes pan-right-with-fade {
        0% {
            transform: translateX(0px)
        }

        50% {
            transform: translateX(5px)
        }

        100% {
            transform: translateX(0px)
        }
    }

    @keyframes pan-right-with-fade {
        0% {
            transform: translateX(0px)
        }

        50% {
            transform: translateX(5px)
        }

        100% {
            transform: translateX(0px)
        }
    }
</style>
<main>
    <div class="breadcrumb-product">
        <div class="breadcrumb-product__name">Blog</div>
        <div style="display:flex">
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/home/">Home</a></div>
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/blog/">Blog</a></div>
        </div>
    </div>
<?php
$listPost = DB::fetchAll("SELECT * FROM blog");
$dataPost = [];
foreach($listPost as $post){
    $id = $post['blog_id'];
    $date = new DateTime($post['blog_date']);
    $time = $date->format("j,S,F,Y");
    $dataPost[] = [
        'id'        => $id,
        'title'     => $post['blog_title'],
        'thumb'     => $post['blog_thumbnail'],
        'shortdesc' => $post['blog_excerpt'],
        'time'      => explode(",", $time),
        'slug'      => $post['blog_slug'],
        'cate'      => DB::fetchAll("SELECT category_blog.* FROM category_blog, cate_blog WHERE cate_blog.blog_id = $id AND cate_blog.cate_id = category_blog.cate_id GROUP BY category_blog.cate_id")
    ];
}
?>
    <div class="blog-page container">
        <?php foreach($dataPost as $post): ?>
        <article id="" class="post type-post status-publish format-standard has-post-thumbnail">
            <div class="post-header-image">
                <a href="<?=ROOT_URL?>/post/<?=$post['slug']?>/"><img src="<?=ROOT_URL?>/assets/uploads/post/<?=$post['thumb']?>" alt="<?=$post['title']?>" loading="lazy"></a>
            </div>
            <div class="post-info">
                <a href="<?=ROOT_URL?>/post/<?=$post['slug']?>/" class="post-date">
                    <span class="post-date-day"><?=$post['time'][0]?><small><?=$post['time'][1]?></small></span>
                    <span class="post-date-month"><?=$post['time'][2]?></span>
                    <span class="post-date-year"><?=$post['time'][3]?></span>
                    <span class="post-date-category" style="background: #ed7902;"></span>
                    <hr>
                </a>
                <div class="post-right-align">
                    <div class="post-categories">
                        <?php foreach($post['cate'] as $cat): ?>
                        <a class="post-category category-fade" style="background: rgb(237, 121, 2) none repeat scroll 0% 0%;" data-category-color="#ed7902" href="https://onyx-wp.ecko.me/category/javascript/"><?=$cat['cate_name']?></a>
                        <?php endforeach ?>
                    </div>
                    <h1 class="post-title"><a href="<?=ROOT_URL?>/post/<?=$post['slug']?>/"><?=$post['title']?></a></h1>
                    <section class="post-contents">
                        <p><?=$post['shortdesc']?></p>
                    </section>
                    <ul class="post-meta">
                        <li class="post-read-more post-meta-align-left">
                            <a href="<?=ROOT_URL?>/post/<?=$post['slug']?>/">
                                Continue Reading <ion-icon name="arrow-forward-circle-outline"></ion-icon>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
        </article>
        <?php endforeach ?>
    </div>
</main>
<!--End::Contact-->
<script>
    $(document).ready(function() {
        setTitle('Blog | Gateux')
    })
</script>
<?php
get_footer();
?>