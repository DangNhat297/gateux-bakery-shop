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

    a {
        transition: color 0.15s ease-out, border 0.15s ease-out,
            opacity 0.15s ease-out, background-color 0.15s ease-out;
        text-decoration: none;
        color: #000;
        outline: none;
    }

    .widget-icon .hydrated,
    .widget-icon svg {
        color: #fff;
    }

    .single-post-hero {
        background-image: url("https://images.unsplash.com/photo-1566698629409-787a68fc5724?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80");
        background-size: cover;
        transition: opacity 1s ease-in-out;
        -webkit-animation: fadeinbg 0.5s ease-out;
        animation: fadeinbg 0.5s ease-out;
        opacity: 1;
        background-position: center;
        position: relative;
        z-index: 1;
    }

    .single-post-hero::before{
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: #2d30345e;
        z-index: -1;
    }

    .wrapper {
        position: relative;
        width: 92.5%;
        margin: 0 auto;
    }

    .cover-content {
        display: flex;
        flex-direction: column;
        text-align: left;
        -js-display: flex;
        align-content: stretch;
        align-items: flex-start;
        flex-wrap: nowrap;
        justify-content: center;
        position: relative;
        z-index: 300;
        height: 100%;
        max-width: 1045px;
        text-align: center;
    }

    .post-info {
        width: 100%;
        margin: 0 auto;
        text-align: center;
    }

    h1.post-title {
        font-size: 42px;
        font-weight: 600;
        line-height: 54px;
        width: 90%;
        margin: 50px auto 40px;
        color: #fff;
    }

    .post-categories .post-category {
        display: inline-block;
        margin: 0 auto;
        font-size: 12px;
        font-weight: 700;
        padding: 13px 42px;
        text-transform: uppercase;
        color: #f3f5f8;
        border-radius: 100px;
        background: rgb(237, 121, 2) none repeat scroll 0% 0%;
    }

    .post-meta li {
        float: left;
        margin-right: 15px;
        font-size: 13px;
        list-style: none;
        text-transform: uppercase;
    }

    .post-meta a {
        color: #f3f5f8;
        font-weight: 800;
    }

    .svg-stroke {
        transition: stroke 0.2s ease-out;
        fill: none;
        stroke: currentColor;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-width: 2;
    }

    .post-meta {
        margin: 0 auto;
        display: flex;
        width: 100%;
        justify-content: center;
    }

    .blog-page {
        position: relative;
        margin-top: 0;
    }

    .post-body {
        position: relative;
        overflow: hidden;
        margin: 3.5rem 0;
        padding: 3.648183556405354% 7.648183556405354% 0;
        border-radius: 3px;
        background: #fff;
    }
    .post-contents{
        overflow: hidden;
    }

    .post-contents img{
        width: 100%;
        display: block;
        object-fit: cover;
    }

    .post-contents>*,
    .postcontents>* {
        margin-top: 50px;
        margin-bottom: 50px;
    }

    .post-contents,
    .postcontents {
        font-size: 17px;
        line-height: 38px;
        color: #757b85;
    }

    .post-contents p,
    .post-contents ul,
    .post-contents ol,
    .postcontents p,
    .postcontents ul,
    .postcontents ol {
        font-size: 17px;
        line-height: 38px;
        margin: 40px 0;
        margin-top: 40px;
        color: #757b85;
    }

    .post-contents .wp-block-ecko-blocks-contrast {
        padding: 1rem 9%;
    }

    .post-contents .alignwide,
    .post-contents .alignfull,
    .postcontents .alignwide,
    .postcontents .alignfull {
        position: relative;
        width: 118%;
        max-width: 118%;
        margin-top: 65px;
        margin-right: -9%;
        margin-bottom: 65px;
        margin-left: -9%;
    }

    .wp-block-ecko-blocks-contrast-content p {
        color: #fff;
    }

    .post-footer {
        overflow: hidden;
        padding: 1.648183556405354% 0 3.8240917782%;
    }

    .post-footer .post-footer-shr {
        margin: auto 0;
        list-style: none;
        display: flex;
        justify-content: center;
    }

    .post-footer .post-footer-shr .post-footer-shr-title {
        font-size: 14px;
        display: inline-block;
        margin: 12px 10px 0 0;
        text-transform: uppercase;
        color: #b0b4bc;
    }

    .post-footer .post-footer-shr .post-footer-shr-item button {
        line-height: 38px;
        display: block;
        width: 42px;
        height: 42px;
        text-align: center;
        color: #7c8289;
        border: 1px solid #eff2f5;
        background: none;
        border-radius: 32px;
        transition: background-color 0.15s ease-out;
    }

    .post-author-profile {
        overflow: hidden;
        padding: 2rem 0;
        border-top: 1px solid #eff0f6;
    }

    .post-footer .post-footer-shr .post-footer-shr-item button svg {
        width: 14px;
        height: 14px;
        vertical-align: -1px;
    }

    .post-footer .post-footer-shr .post-footer-shr-item {
        display: inline-block;
        margin: 0 0 5px 5px;
    }

    .svg-fill {
        transition: fill 0.2s ease-out;
        fill: currentColor;
        stroke: none;
    }

    .post-footer .post-footer-shr .post-footer-shr-item button {
        line-height: 38px;
        text-align: center;
        color: #7c8289;
    }

    .post-footer .post-footer-shr .post-footer-shr-item button span {
        display: none;
    }

    .post-author-upper {
        display: flex;
        justify-content: center;
    }

    .post-author-info {
        text-align: center;
    }

    .post-author-profile .post-author-avatar {
        width: 75px;
        height: 75px;
        border-radius: 50%;
    }

    .post-author-profile .post-author-name span {
        font-size: 14px;
        text-transform: uppercase;
        color: #b9bec9;
    }

    .post-author-profile .post-author-name h2 {
        font-size: 20px;
        line-height: 34px;
        margin: 0;
        font-weight: 600;
        letter-spacing: -0.25px;
    }

    .post-related .post-related-post {
        position: relative;
        float: left;
        overflow: hidden;
        height: 305px;
        padding: 35px;
        border-radius: 3px;
        background: #202225;
    }

    .post-related .post-related-post .post-background {
        position: absolute;
        z-index: 100;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transition: all 0.4s ease-out;
        opacity: 0.32;
        background-position: center;
        background-size: cover;
    }

    .post-related .post-related-post .post-background-image {
        width: 100%;
        height: 100%;
        -o-object-fit: cover;
        object-fit: cover;
        -o-object-position: center;
        object-position: center;
    }

    .post-related .post-related-post .post-info {
        position: relative;
        z-index: 200;
        height: 100%;
        text-align: left;
    }

    .post-related .post-related-post span {
        font-size: 13px;
        display: block;
        text-transform: uppercase;
        color: #a0a3a8;
    }

    .post-related .post-related-post .post-bottom {
        position: absolute;
        bottom: 0;
    }

    .post-related .post-related-post .post-category {
        font-size: 11px;
        display: inline-block;
        clear: both;
        padding: 10px 25px;
        text-transform: uppercase;
        color: #5d646d;
        border-radius: 100px;
        background: #2d3034;
        transition: color 0.15s ease-out, border 0.15s ease-out,
            opacity 0.15s ease-out, background-color 0.15s ease-out;
    }

    .post-related .post-related-post .post-title {
        font-size: 15px;
        font-weight: 600;
        line-height: 24px;
        margin: 10px 0 0;
        transition: margin 0.25s ease-in-out;
        color: #fff;
    }

    .post-related .post-related-post .post-read-more {
        font-size: 13px;
        font-weight: 700;
        position: absolute;
        bottom: 0;
        margin-top: 15px;
        transition: opacity 0.25s ease-in-out;
        text-transform: uppercase;
        opacity: 0;
        color: #fff;
    }

    .post-related .post-related-post .post-read-more svg {
        width: 16px;
        height: 16px;
        margin-left: 8px;
        vertical-align: -3px;
    }

    .post-related .post-related-post span {
        font-size: 13px;
        display: block;
        text-transform: uppercase;
        color: #a0a3a8;
    }

    .post-related .post-related-post .post-read-more {
        font-size: 13px;
        font-weight: 700;
        position: absolute;
        bottom: 0;
        margin-top: 15px;
        transition: opacity 0.25s ease-in-out;
        text-transform: uppercase;
        opacity: 0;
        color: #fff;
    }

    .post-related .post-related-post:hover .post-category {
        background-color: #ed7902;
        color: #fff;
    }

    .post-related .post-related-post:hover .post-title {
        margin-bottom: 2.3rem;
    }

    .post-related .post-related-post:hover .post-read-more {
        opacity: 1;
    }

    .post-related .post-related-post .post-read-more svg {
        width: 16px;
        height: 16px;
        margin-left: 8px;
        vertical-align: -3px;
    }

    .post-related {
        overflow: hidden;
        margin-bottom: 7.648183556405354%;
    }
    .post-related .slick-slide {
        margin: 0 20px;
    }
    .post-related .slick-list {
        margin: 0 -20px;
    }
    @-webkit-keyframes fadeinbg {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeinbg {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>
<main>
<?php
if(empty($_GET['slug'])){
    echo '<script>window.location.href="'.ROOT_URL.'/404"</script>';
} else {
    $slug = $_GET['slug'];
    $sql = "SELECT * FROM blog WHERE blog_slug = '$slug'";
    if(DB::rowCount($sql) == 0){
        echo '<script>window.location.href="'.ROOT_URL.'/404"</script>';
    } else {
        $post = DB::fetch($sql);
        DB::execute("UPDATE blog SET blog_view = blog_view + 1 WHERE blog_id = ". $post['blog_id']);
        $categories = DB::fetchAll("SELECT category_blog.* FROM category_blog, cate_blog WHERE category_blog.cate_id = cate_blog.cate_id AND cate_blog.blog_id = " . $post['blog_id'] . " GROUP BY category_blog.cate_id");
        $date = new DateTime($post['blog_date']);
        $time = $date->format("jS M y");
        $title = $post['blog_title'];
    }
}
?>
    <div class="single-post-hero" style="background-image: url(<?=ROOT_URL?>/assets/uploads/post/<?=$post['blog_thumbnail']?>)">
        <div class="cover-content wrapper">
            <div class="post-info">
                <div class="post-categories">
                <?php foreach($categories as $cat): ?>
                    <a class="post-category category-fade" style="background: #ed7902" data-category-color="#ed7902" href="#"><?=$cat['cate_name']?></a>
                <?php endforeach ?>
                </div>
                <h1 class="post-title">
                    <?=$title?>
                </h1>
                <ul class="post-meta">
                    <li class="post-author">
                        <a href=""><?=$post['blog_author']?></a>
                    </li>
                    <li class="post-date">
                        <a href=""><time datetime="<?=$post['blog_date']?>"><?=$time?></time></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="blog-page container">
        <section class="page-contents">
            <article class="post-body">
                <section class="post-contents">
                    <?=$post['blog_content']?>
                </section>
                <section class="post-footer">
                    <ul class="post-footer-shr">
                        <li class="post-footer-shr-title">Share Article:</li>
                        <li class="post-footer-shr-item twitter">
                            <button aria-label="Twitter" data-location="https://twitter.com/share?text=Modern+Web+%26+JavaScript+Frontend+Framework+Essentials&amp;url=https://onyx-wp.ecko.me/javascript-essentials/" onclick="window.open(this.dataset.location, '_blank'); return false;">
                                <svg class="svg svg-fill" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.954 4.569a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.691 8.094 4.066 6.13 1.64 3.161a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.061a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548z"></path>
                                </svg>
                                <span>Twitter</span>
                            </button>
                        </li>
                        <li class="post-footer-shr-item facebook">
                            <button aria-label="Facebook" data-location="https://www.facebook.com/sharer/sharer.php?u=https://onyx-wp.ecko.me/javascript-essentials/" onclick="window.open(this.dataset.location, '_blank'); return false;">
                                <svg class="svg svg-fill" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.676 0H1.324C.593 0 0 .593 0 1.324v21.352C0 23.408.593 24 1.324 24h11.494v-9.294H9.689v-3.621h3.129V8.41c0-3.099 1.894-4.785 4.659-4.785 1.325 0 2.464.097 2.796.141v3.24h-1.921c-1.5 0-1.792.721-1.792 1.771v2.311h3.584l-.465 3.63H16.56V24h6.115c.733 0 1.325-.592 1.325-1.324V1.324C24 .593 23.408 0 22.676 0"></path>
                                </svg>
                                <span>Facebook</span>
                            </button>
                        </li>
                        <li class="post-footer-shr-item pinterest">
                            <button aria-label="Pinterest" data-location="https://pinterest.com/pin/create/button/?url=https://onyx-wp.ecko.me/javascript-essentials/&amp;description=Modern+Web+%26+JavaScript+Frontend+Framework+Essentials" onclick="window.open(this.dataset.location, '_blank'); return false;">
                                <svg class="svg svg-fill" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026z"></path>
                                </svg>
                                <span>Pinterest</span>
                            </button>
                        </li>
                        <li class="post-footer-shr-item linkedin">
                            <button aria-label="LinkedIn" data-location="https://www.linkedin.com/shareArticle?mini=true&amp;url=https://onyx-wp.ecko.me/javascript-essentials/&amp;title=Modern+Web+%26+JavaScript+Frontend+Framework+Essentials" onclick="window.open(this.dataset.location, '_blank'); return false;">
                                <svg class="svg svg-fill" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0z"></path>
                                </svg>
                                <span>LinkedIn</span>
                            </button>
                        </li>
                        <li class="post-footer-shr-item reddit">
                            <button aria-label="Reddit" data-location="https://www.reddit.com/submit?url=https://onyx-wp.ecko.me/javascript-essentials/&amp;title=Modern+Web+%26+JavaScript+Frontend+Framework+Essentials" onclick="window.open(this.dataset.location, '_blank'); return false;">
                                <svg class="svg svg-fill" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.204 14.049c-.06.276-.091.56-.091.847 0 3.443 4.402 6.249 9.814 6.249 5.41 0 9.812-2.804 9.812-6.249 0-.274-.029-.546-.082-.809l-.015-.032a.456.456 0 01-.029-.165c-.302-1.175-1.117-2.241-2.296-3.103a.422.422 0 01-.126-.07c-.026-.02-.045-.042-.067-.064-1.792-1.234-4.356-2.008-7.196-2.008-2.815 0-5.354.759-7.146 1.971a.397.397 0 01-.179.124c-1.206.862-2.042 1.937-2.354 3.123a.454.454 0 01-.037.171l-.008.015zm9.773 5.441c-1.794 0-3.057-.389-3.863-1.197a.45.45 0 010-.632.47.47 0 01.635 0c.63.629 1.685.943 3.228.943 1.542 0 2.591-.3 3.219-.929a.463.463 0 01.629 0 .482.482 0 010 .645c-.809.808-2.065 1.198-3.862 1.198zm-3.606-7.573c-.914 0-1.677.765-1.677 1.677 0 .91.763 1.65 1.677 1.65s1.651-.74 1.651-1.65c0-.912-.739-1.677-1.651-1.677zm7.233 0c-.914 0-1.678.765-1.678 1.677 0 .91.764 1.65 1.678 1.65s1.651-.74 1.651-1.65c0-.912-.739-1.677-1.651-1.677zm4.548-1.595c1.037.833 1.8 1.821 2.189 2.904a1.818 1.818 0 00-2.189-2.902zM2.711 9.963a1.82 1.82 0 00-1.173 3.207c.401-1.079 1.172-2.053 2.213-2.876a1.82 1.82 0 00-1.039-.329v-.002zm9.217 12.079c-5.906 0-10.709-3.205-10.709-7.142 0-.275.023-.544.068-.809A2.723 2.723 0 010 11.777a2.725 2.725 0 012.725-2.713 2.7 2.7 0 011.797.682c1.856-1.191 4.357-1.941 7.112-1.992l1.812-5.524.404.095s.016 0 .016.002l4.223.993a2.237 2.237 0 014.296.874c0 1.232-1.003 2.234-2.231 2.234s-2.23-1.004-2.23-2.23l-3.851-.912-1.467 4.477c2.65.105 5.047.854 6.844 2.021a2.663 2.663 0 011.833-.719 2.716 2.716 0 012.718 2.711c0 .987-.54 1.886-1.378 2.365.029.255.059.494.059.749-.015 3.938-4.806 7.143-10.72 7.143zm8.179-19.187a1.339 1.339 0 100 2.678c.732 0 1.33-.6 1.33-1.334 0-.733-.598-1.332-1.347-1.332z"></path>
                                </svg>
                                <span>Reddit</span>
                            </button>
                        </li>
                    </ul>
                </section>
<?php
$author = $post['blog_author'];
$user = DB::fetch("SELECT * FROM users WHERE user_name = '$author'");
?>
                <section class="post-author-profile">
                    <div class="post-author-upper">
                        <div class="post-author-info">
                            <img class="post-author-avatar" src="<?=ROOT_URL?>/assets/uploads/avatar/<?=$user['user_avatar']?>" alt="<?=$post['blog_author']?>" loading="lazy" />
                            <div class="post-author-name">
                                <span>Author</span>
                                <h2>
                                    <a href=""><?=$post['blog_author']?></a>
                                </h2>
                            </div>
                        </div>
                    </div>
                </section>
            </article>
<?php
$arrCat = [];
$postID = $post['blog_id'];
$categories = DB::fetchAll("SELECT * FROM cate_blog WHERE blog_id = $postID");
foreach($categories as $cat){
    $arrCat[] = $cat['cate_id'];
}
$arrCat = implode(",", $arrCat);
$sql = "SELECT blog.* FROM blog, cate_blog WHERE blog.blog_id = cate_blog.blog_id AND blog.blog_id <> $postID AND cate_blog.cate_id IN ($arrCat) GROUP BY blog.blog_id LIMIT 0,12";
if(DB::rowCount($sql) > 0){
    $relatedPost = DB::fetchAll($sql);
} else {
    $relatedPost = DB::fetchAll("SELECT blog.* FROM blog WHERE blog.blog_id <> $postID LIMIT 0,12");
}
?>            
            <section class="post-related post-related-count-3">
                <?php foreach($relatedPost as $post): ?>
                <a href="<?=ROOT_URL?>/<?='post/'.$post['blog_slug']?>/" class="post-related-post">
                    <picture class="post-background">
                        <img src="<?=ROOT_URL?>/assets/uploads/post/<?=$post['blog_thumbnail']?>" class="post-background-image" alt="<?=$post['blog_title']?>" loading="lazy" />
                    </picture>
                    <div class="post-info">
                        <span>Related Article</span>
                        <div class="post-bottom">
                            <span class="post-category" style="" data-category-color="#6e2585"><?=DB::fetch("SELECT cate_name FROM cate_blog, category_blog WHERE cate_blog.cate_id = category_blog.cate_id")['cate_name']?></span>
                            <h3 class="post-title"><?=$post['blog_title']?></h3>
                            <span class="post-read-more">
                                Read Article
                                <svg class="svg svg-stroke" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 18l6-6-6-6"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
                <?php endforeach ?>
            </section>
        </section>
    </div>
</main>
<!--End::Contact-->
<script>
    $(document).ready(function() {
        setTitle('<?=$title?> | Gateux')
        $('.post-related').slick({
            slidesToShow: 3,
            arrows: true,
            prevArrow: `<button type='button' class='slick-prev slick-arrow' aria-hidden='true'><i class="fas fa-angle-left"></i></button>`,
            nextArrow: `<button type='button' class='slick-next slick-arrow'><i class="fas fa-angle-right"></i></button>`,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                    slidesToShow: 2,
                    dots: true,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                    slidesToShow: 1,
                    dots: true
                    }
                }
            ]
        })
    });
</script>
<?php
get_footer();
?>