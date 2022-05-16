<!--header-->
<?php
$menuParent = DB::fetchAll("SELECT * FROM menu WHERE menu_parent = 0");
$dataMenu = [];
foreach ($menuParent as $parent) {
    $dataMenu[] = [
        'menu_id'       => $parent['menu_id'],
        'menu_title'    => $parent['menu_title'],
        'menu_url'      => $parent['menu_url'],
        'child'         => DB::fetchAll("SELECT * FROM menu WHERE menu_parent = " . $parent['menu_id'])
    ];
}
?>
<header>
    <div class="container header">
        <a class="logo" href="<?=ROOT_URL?>/home/">
            <img src="<?=ROOT_URL?>/assets/uploads/logo/<?=WEB_LOGO?>" />
        </a>
        <nav>
            <label for="reponsive-menu"><i class="fas fa-align-justify"></i></label>
            <input type="checkbox" id="reponsive-menu" />
            <ul class="navigation">
                <?php foreach ($dataMenu as $menu) : ?>
                    <li class="<?= count($menu['child']) > 0 ? 'dropdown-menu' : '' ?>">
                        <a href="<?=ROOT_URL?>/<?= $menu['menu_url'] ?>"><?= $menu['menu_title'] ?></a>
                        <?php if (count($menu['child']) > 0) { ?>
                            <ul class="dropdown-list">
                                <?php foreach ($menu['child'] as $child) : ?>
                                    <li><a href="<?=ROOT_URL?>/<?= $child['menu_url'] ?>"><?= $child['menu_title'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php endforeach ?>

                <label class="close-reponsive-menu" for="reponsive-menu"><i class="fas fa-times"></i></label>
            </ul>
        </nav>
        <ul class="widget-icon">
            <li data-modal="modal" data-target="#search-modal">
                <a href="">
                    <!-- <i class="fas fa-search"></i> -->
                    <ion-icon name="search-outline"></ion-icon>
                </a>
            </li>
            <li class="show-cart-side">
                <a href="">
                    <!-- <i class="fas fa-shopping-basket"></i> -->
                    <ion-icon name="cart-outline"></ion-icon>
                </a>
            </li>
            <li>
                <a href="<?=ROOT_URL?>/<?= (Session::issetSession('user')) ? 'profile/' : 'auth/' ?>">
                    <!-- <i class="far fa-user"></i> -->
                    <ion-icon name="person-outline"></ion-icon>
                </a>
            </li>
        </ul>
    </div>
    <div class="cart-right-side">
        <button class="close-cart" data-type="close-cart">
            <i class="fas fa-times"></i>
        </button>
        <p class="cart-right-side__title">
            <i class="fas fa-shopping-bag"></i> Cart
        </p>
        <div class="cart-right-side__list">
        </div>
        <div class="cart-total-money">
            Total: <strong></strong>
        </div>
        <div class="cart-right-side__btn">
            <a style="display:grid" href="<?=ROOT_URL?>/cart"><button data-type="cart">Cart</button></a>
            <a style="display:grid" href="<?=ROOT_URL?>/checkout"><button data-type="checkout">Checkout</button></a>
        </div>
    </div>
    <div class="modal-window search-modal" id="search-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span><i class="fas fa-search"></i> Seach Product</span>
            </div>
            <div class="modal-body">
                <form id="form-seach-modal" action="<?=ROOT_URL?>/shop">
                    <input class="modal-body__input" name="search" placeholder="Enter key search..." required />
                </form>
            </div>
            <div class="search-result" id="scroll-custom">

            </div>
        </div>
    </div>
    <div class="modal-window" id="quickview">
        <div class="modal-content modal-xl">
            <button class="close-quickview" data-type="close-quickview">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-body">
            </div>
        </div>
    </div>
    <div class="sticky-toolbar">
        <?php if (Session::issetSession('user') && (Session::get('user')['role'] == 2 || Session::get('user')['role'] == 3)) { ?>
            <a href="<?=ROOT_URL?>/admin"><button class="sticky-toolbar__btn btn--black" data-toggle="tooltip" title="Admin Panel" data-placement="left"><i class="fas fa-cogs"></i></button></a>
        <?php } ?>
        <a href="<?=ROOT_URL?>/cart/"><button class="sticky-toolbar__btn btn--red" data-toggle="tooltip" title="Cart" data-placement="left"><i class="fas fa-shopping-basket"></i></button></a>
        <a href="<?=ROOT_URL?>/wishlist/"><button class="sticky-toolbar__btn btn--pink" data-toggle="tooltip" title="Wishlist" data-placement="left"><i class="fas fa-heart"></i></button></a>
        <?php if (Session::issetSession('user')) { ?>
            <a href="<?=ROOT_URL?>/logout/"><button class="sticky-toolbar__btn btn--green" data-toggle="tooltip" title="Sign out" data-placement="left"><i class="fas fa-sign-out-alt"></i></button></a>
        <?php } ?>
    </div>
</header>
<!--header end-->