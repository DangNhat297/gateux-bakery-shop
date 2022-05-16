// config toarst
toastr.options = {
	"closeButton": true,
	"debug": false,
	"newestOnTop": false,
	"progressBar": true,
	"positionClass": "toast-top-right",
	"preventDuplicates": true,
	"onclick": null,
	"showDuration": "300",
	"hideDuration": "1000",
	"timeOut": "1500",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
}
// aos init
AOS.init();
// set title page
function setTitle(text) {
	document.title = text
}
// set background to header
$(window).scroll(function(){ 
    if ($(this).scrollTop() > 10) { 
        $('header').css('background', 'var(--pink)')
        $('.widget-icon li a').css('color', '#fff')
    } else { 
        $('header').css('background', 'none')
        $('.widget-icon li a').css('color', '#fff')
    } 
})
/*==============================================================*/
		// Hero slider
		/*==============================================================*/
		var $bannerSlider = jQuery('.banner-slider');
		var $bannerFirstSlide = $('div.banner-slide:first-child');

		$bannerSlider.on('init', function(e, slick) {
			var $firstAnimatingElements = $bannerFirstSlide.find('[data-animation]');
			slideanimate($firstAnimatingElements);
		});
		$bannerSlider.on('beforeChange', function(e, slick, currentSlide, nextSlide) {
			var $animatingElements = $('div.slick-slide[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
			slideanimate($animatingElements);
		});
		$bannerSlider.slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			fade: true,
			pauseOnHover:false,
			dots: false,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 3000,
			cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
			touchThreshold: 100,
			swipe: true,
			adaptiveHeight: true,
			responsive: [
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					autoplay: false,
					autoplaySpeed: 4000,
					swipe: true,
				}
			}
			]
		});
		function slideanimate(elements) {
			var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
			elements.each(function() {
				var $this = $(this);
				var $animationDelay = $this.data('delay');
				var $animationType = 'animated ' + $this.data('animation');
				$this.css({
					'animation-delay': $animationDelay,
					'-webkit-animation-delay': $animationDelay
				});
				$this.addClass($animationType).one(animationEndEvents, function() {
					$this.removeClass($animationType);
				});
			});
		}

// data color
$("[data-color]").each(function () {
		$(this).css('color', $(this).attr('data-color'));
});
// data background color
$("[data-bgcolor]").each(function () {
	$(this).css('background-color', $(this).attr('data-bgcolor'));
});
$('.list-product-horizontal').slick({
	slidesToShow: 4,
	arrows: true,
	prevArrow: `<button type='button' class='slick-prev slick-arrow' aria-hidden='true'><i class="fas fa-angle-left"></i></button>`,
	nextArrow: `<button type='button' class='slick-next slick-arrow'><i class="fas fa-angle-right"></i></button>`,
	responsive: [
		{
		  breakpoint: 1080,
		  settings: {
			slidesToShow: 3,
		  }
		},
		{
			breakpoint: 768,
			settings: {
			  slidesToShow: 2
			}
		},
	  ]
})
$('.list-product-vertical, .list-author, .list-blog').slick({
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
$(document).on('mouseenter','[data-toggle="tooltip"]',function(){
	$position = $(this).data('placement')
	$(this).addClass('tooltip tooltip--' + $position)
}).on('mouseleave','[data-toggle="tooltip"]', function(){
	$(this).removeClass('tooltip tooltip--' + $position)
})
$(document).on('click', '[data-modal="modal"]', function(e){
	e.preventDefault()
	$target = $(this).data('target')
	$delay = $(this).data('modal-delay') ?? 0
	if($($target).length > 0){
		if($(this).data('type-btn') == 'quickview'){
			$icon = $(this).html()
			$(this).html('<i class="fas fa-circle-notch fa-spin"></i>')
			setTimeout(()=>{
				$(this).html($icon)
			},$delay)
		}
		setTimeout(()=>{
			$('body').css('overflow-y','hidden')
			$($target).css({
				"visibility": "visible",
				"opacity": 1
			})
			$($target).find('.modal-content').css({"top": 0,"opacity": 1})
		},$delay)
	}
})
$('[data-type="close-modal"],[data-type="close-quickview"]').click(function(){
	$(this).closest('.modal-window').css({
		"visibility": "hidden",
		"opacity": 0
	})
	$('.modal-content').css({"top": "-150px","opacity": 0})
	$('body').css('overflow-y','auto')
})
$('[data-type="close-cart"]').click(function(){
	$(this).closest('.cart-right-side').css({
		"opacity": 0,
		"visibility": "hidden",
		"transform": "translateX(100%)"
	})
})
$('.modal-window').on('click', function(e) {
	if (e.target !== this)
	  return;
	$(this).closest('.modal-window').css({
		"visibility": "hidden",
		"opacity": 0
	})
	$('.modal-content').css({"top": "-150px","opacity": 0})
	$('body').css('overflow-y','auto')
})
$(document).mouseup(function(e){
    var container = $('.cart-right-side')
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.css({
			"opacity": 0,
			"visibility": "hidden",
			"transform": "translateX(100%)"
		})
    }
})
$('.show-cart-side').click(function(e){
	e.preventDefault()
	$('.cart-right-side').css({
		"opacity": 1,
		"visibility": "visible",
		"transform": "translateX(0)"
	})
})
$('.product-single .product-info__image--thumb').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: false,
	fade: true,
	draggable: false,
	asNavFor: '.product-single .product-info__image--album'
})
$('.product-single .product-info__image--album').slick({
	slidesToShow: 4,
	slidesToScroll: 1,
	asNavFor: '.product-single .product-info__image--thumb',
	dots: false,
	focusOnSelect: true,
	arrows: true,
	prevArrow: `<button type='button' class='slick-prev slick-arrow' aria-hidden='true'><i class="fas fa-angle-left"></i></button>`,
	nextArrow: `<button type='button' class='slick-next slick-arrow'><i class="fas fa-angle-right"></i></button>`
})
$(function(){
	$(document).on('click', '.quantity__button.sub', function(){
		var input = parseInt($(this).next().val())
		$valTmp = input
		if($valTmp === 1) return false
		$(this).next().val($valTmp-1).change()
	})
	$(document).on('click', '.quantity__button.add', function(){
		var input = parseInt($(this).prev().val())
		$(this).prev().val(input+1).change()
	})
})
function activeTab(tab){
	$('.product-detail__tab>span').removeClass("active")
	$(tab).addClass("active")
	var id = $(tab).data("tab")
	$('.tab-content').slideUp(200)
	$('#' + id).slideDown(50)
	const tabActive = $('.product-detail__tab>span.active')
	const line = $('.product-detail__tab .tabline')
	line.css("left", $(tabActive).position().left + 'px')
	line.css("width", $(tabActive).outerWidth() + 'px')
}
$('.product-detail__tab>span').click(function(){
	activeTab(this)
	return false
})
$productTab = $('.product-detail__tab')[0]
if($productTab){
	activeTab('.product-detail__tab>span:first-child')
}
$(document).on('click', '.review-item__btn--reply',function(){
	$this = $(this)
	$parent = $this.closest('.review-item')
	$replyName = $this.closest('.review-item__user').find('.review-item__name').text()
	$replyReview = $this.closest('.review-item__user').data('review-id')
	if($parent.has('.form-reply').length == 0){
		$parent.append(`<div class="form-reply">
						<div class="reply-to-title">Reply to <div class="reply-to-user">`+ $replyName +`</div></div>
						<form class="reply-form" action="" id="reply-review">
							<textarea class="review-textarea" rows="2" required></textarea>
							<button type="submit" class="review-btn" data-reply-review="`+ $replyReview +`">Submit</button>
						</form>
					</div>`)
		$parent.find('.form-reply').hide().slideDown()
		$([document.documentElement, document.body]).animate({
			scrollTop: $parent.find('.form-reply').offset().top-300
		}, 100)
	} else {
		$parent.find('.form-reply').slideUp("slow", function(){
			$(this).remove()
		})
	}
})
// share social
$(function (){
	var currentLocation = window.location;
	$('a[data-share="facebook"]').attr("href", "https://www.facebook.com/sharer/sharer.php?u=" + currentLocation);
	$('a[data-share="twitter"]').attr("href", "https://twitter.com/share?url=" + currentLocation);
	$('a[data-share="pinterest"]').attr("href", "https://pinterest.com/pin/create/link/?url=" + currentLocation);
	$('a[data-share="copyurl"]').on('click', function(){
		var dummy = document.createElement('input'),
		text = window.location.href;
		document.body.appendChild(dummy);
		dummy.value = text;
		dummy.select();
		document.execCommand('copy');
		document.body.removeChild(dummy);
		$(this).after('<small>Copied Url</small>');
		setTimeout(()=>{
			$('.info__detail--sharing').find('a[data-share="copyurl"]').next().fadeOut(300, function(){
				$(this).remove();
			});
		},2000);
		return false;
	})
})
// function add to cart
function addToCart(productID, thisBtn, quantity = 1){
	$currentText = $(thisBtn).html()
	$.ajax({
		url         : ROOT_URL + '/API/cart.php',
		type        : 'POST',
		data        : {id: productID, quantity: quantity, action: 'add-to-cart'},
		dataType    : 'json',
		beforeSend  : function(){
			$(thisBtn).html('<i class="fas fa-circle-notch fa-spin"></i>').prop('disabled', true)
		},
		success     : function(data){
			console.log(data)
			setTimeout(function(){
				if(data.status == 'success'){
					toastr["success"]("Add Product To Cart Success!", "Success")
					getCartSide()
				} else {
					toastr["error"]("Has an error, try again!", "Error")
				}
				$(thisBtn).html($currentText).prop('disabled', false)
			},1000)
		}
	})
}
// function add to wishlist
function addToWishlist(productID, thisBtn){
	$.ajax({
		url         : ROOT_URL + '/API/wishlist.php',
		type        : 'POST',
		data        : {id: productID, action: 'add-to-wishlist'},
		dataType    : 'json',
		success     : function(data){
			console.log(data)
			if(data.status == 'success'){
				toastr["success"]("Add Product To Wishlist Success!", "Success")
				$(thisBtn).addClass('added')
			} else {
				toastr["error"]("Has an error, try again!", "Error")
			}
		}
	})
}
// get cart
function getCartSide(){
	$.ajax({
		url			: ROOT_URL + '/API/cart.php',
		type		: 'POST',
		dataType	: 'json',
		data 		: {get: 'list-cart'},
		success		: function(data){
			xhtml = ''
			if(data.product.length > 0){
				$.each(data.product, function(i,value){
					xhtml += `<div class="cart-right-side__list--item">
								<a href="">
									<div class="cart-side-item__img">
										<img src="`+ ROOT_URL +`/assets/uploads/product/`+ value.image +`" />
									</div>
								</a>
								<div class="cart-side-item__info">
									<a href="">
										<div class="cart-side-item__name">`+ value.name +`</div>
									</a>
									<div class="cart-side-item__price">`+ value.quantity +` x `+ value.price +`</div>
								</div>
								<div class="cart-side-item__remove">
									<button class="cart-remove__btn" data-cart-id="`+ value.id +`"><i class="far fa-trash-alt"></i></button>
								</div>
							</div>`
				})
				$('.cart-right-side__btn button[data-type="checkout"]').show()
				$('.cart-right-side__btn button[data-type="cart"]').show()
			} else {
				xhtml = '<p style="text-align:center;padding:10px;">Cart is empty</p>'
				$('.cart-right-side__btn button[data-type="checkout"]').hide()
				$('.cart-right-side__btn button[data-type="cart"]').hide()
			}
			$('.cart-right-side__list').html(xhtml)
			$('.cart-total-money').find('strong').text(data.sum)
		}
	})
}
getCartSide()
$(document).on('click', '.cart-remove__btn, .remove-cart__btn', function(){
	$id = $(this).data('cart-id')
	$.ajax({
		url			: ROOT_URL + '/API/cart.php',
		type		: 'POST',
		dataType	: 'json',
		data 		: {id: $id, action: 'delete-cart-product'},
		success		: function(data){
			if(data.status == 'success'){
				toastr["success"]("Delete Product Success!", "Success")
				getCartSide()
				if(typeof getCartPage == 'function') getCartPage()
			} else {
				toastr["error"]("Has an error, try again!", "Error")
			}
		}
	})
})
// scroll to top
$(window).scroll(function(){ 
	if ($(this).scrollTop() > 1000) { 
		$('button.scroll-to-top').css({
			"opacity": 1,
			"bottom": "20px"
		})
	} else { 
		$('button.scroll-to-top').css({
			"opacity": 0,
			"bottom": "0"
		})
	} 
}); 
$('button.scroll-to-top').click(function(){ 
	$("html, body").animate({ scrollTop: 0 }, 300)
	return false
})
$(document).on('click','[data-type-btn="add-to-cart"]',function(e){
	e.preventDefault()
	$thisBtn = $(this)
	$id = $thisBtn.data('product-id')
	addToCart($id, $thisBtn)
})
$(document).on('click','[data-type-btn="add-to-wishlist"]',function(e){
	e.preventDefault()
	$thisBtn = $(this)
	if(!$thisBtn.hasClass('added')){
		$id = $thisBtn.data('product-id')
		addToWishlist($id, $thisBtn)
	}
	return false
})
// find element in array
function valInArray(value, array) {
	return array.indexOf(value) > -1;
  }
//get wishlist arr
function arrWishList(){
	$result =  $.ajax({
		url			: ROOT_URL + '/API/wishlist.php',
		type		: 'POST',
		dataType	: 'json',
		async		: false,
		data 		: {get: 'get-array-wishlist'}
	})
	return $result.responseJSON
}
// create slide album quickview
function sliderQuickView(){
	$('#quickview .product-info__image--thumb').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: false,
		arrows: true,
		prevArrow: `<button type='button' class='slick-prev slick-arrow' aria-hidden='true'><i class="fas fa-angle-left"></i></button>`,
		nextArrow: `<button type='button' class='slick-next slick-arrow'><i class="fas fa-angle-right"></i></button>`
	})
}
// quicview
// $('[data-type-btn="quickview"]').click(function(){
// 	$('#quickview .product-info__image--thumb').empty().removeClass('slick-initialized slick-slider')
// 	$('#quickview .product-info__detail--name').empty()
// 	$('#quickview .product-info__detail--price').empty()
// 	$('#quickview input.input-quantity').val(1)
// 	$('#quickview .product-info__detail--rating .rateit').data('rateit-value',0)
// 	$('#quickview .product-info__detail--short-description').empty()
// 	$('#quickview .product-info__detail--categories a').remove()
// 	$('#quickview .product-info__detail--categories').html($('#quickview .product-info__detail--categories').html().replace(',',''))
// 	$this = $(this)
// 	$quickViewIcon = $this.html()
// 	$productID = $this.data('product-id')
// 	$.ajax({
// 		url			: 'API/product.php',
// 		type		: 'POST',
// 		dataType	: 'json',
// 		data		: {id: $productID, get: 'product-quickview'},
// 		beforeSend	: function(){
// 			$('#quickview .modal-content').append(`<div class="modal-loading">
// 					<img src="https://i.gifer.com/origin/b4/b4d657e7ef262b88eb5f7ac021edda87.gif">
// 				</div>`)
// 		},
// 		success		: function(data){
// 			$('#quickview .modal-content .modal-loading').fadeOut(1000, function(){
// 				$('#quickview .modal-content .modal-loading').remove()
// 			})
// 			$('#quickview .product-info__image--thumb').append(`<img src="./assets/uploads/product/`+ data.thumb +`">`)
// 			$.each(data.album,function(i,value){
// 				$('#quickview .product-info__image--thumb').append(`<img src="./assets/uploads/product/`+ value +`">`)
// 			})
// 			$('#quickview .product-info__detail--name').text(data.name)
// 			$('#quickview .product-info__detail--price').text(data.price)
// 			$('#quickview .product-info__detail--rating .rateit').find('.rateit-preset').attr('style', 'width:' + (data.rating*100)/5 + '%')
// 			$('#quickview .product-info__detail--short-description').html(data.description)
// 			$('#quickview .add-to-cart').data('product-id', data.id)
// 			$('#quickview .add-to-wishlist').data('product-id', data.id)
// 			if(valInArray(parseInt(data.id),arrWishList())){
// 				$('#quickview .add-to-wishlist').addClass('added')
// 			} else {
// 				$('#quickview .add-to-wishlist').removeClass('added')
// 			}
// 			$.each(data.categories,function(index,value){
// 				if(index < data.categories.length - 1){
// 					$('#quickview .product-info__detail--categories').append(`<a href="`+ value.id +`">`+ value.name +`</a>, `)
// 				} else {
// 					$('#quickview .product-info__detail--categories').append(`<a href="`+ value.id +`">`+ value.name +`</a>`)
// 				}
// 			})
// 			sliderQuickView()
// 		}
// 	})
// })
$(document).on('click','[data-type-btn="quickview"]',function(){
	$this = $(this)
	$productID = $this.data('product-id')
	$.ajax({
		url			: ROOT_URL + '/API/product.php',
		type		: 'POST',
		dataType	: 'html',
		data		: {id: $productID, get: 'product-quickview'},
		success		: function(data){
			$('#quickview .modal-body').html(data)
			$arrColor 	= ['#D4FFC0', '#FFC0CC', '#FFEAC0', '#C0E5FF']
			// set background to product single thumb png
			$('#quickview .product-info__image--thumb').css('background', $arrColor[randomInteger(0, $arrColor.length-1)])
			$('.rateit').rateit()
			sliderQuickView()
		}
	})
})
// add to cart quickview
$(document).on('click', '#quickview .add-to-cart',function(){
	$thisBtn = $(this)
	$id = $thisBtn.data('product-id')
	$quantity = $('#quickview input.input-quantity').val()
	addToCart($id, $thisBtn, $quantity)
})
// load country to select form checkout
// $(function(){
// 	$.getJSON('assets/js/country.json', function(data){
// 		$.each(data, function(i, v){
// 			$('#select-country').append('<option value="'+i+'">'+v+'</option>')
// 		})
// 		$('#select-country option:nth-child(1)').prop('hidden', true)
// 	})
// 	$(document).on('change', '#select-country', function(){
// 		$text = $(this).find(':selected').text()
// 		$(this).next('input').val($text)
// 	})
// })
// get input form value 
$(function(){
	$form = $('.form-information-checkout')
	$detail = $('.delivery-address')
	$form.find('input[name="fullname"]').keyup(function(){
		$detail.find('[data-as="fullname"]').html('<i class="fas fa-user"></i> ' + $(this).val()).fadeIn()
		if($(this).val() == '') $detail.find('[data-as="fullname"]').fadeOut()
	})
	$form.find('input[name="phone"]').keyup(function(){
		$detail.find('[data-as="phone"]').html('<i class="fas fa-phone"></i> ' + $(this).val()).fadeIn()
		if($(this).val() == '') $detail.find('[data-as="phone"]').fadeOut()
	})
	$form.find('input[name="email"]').keyup(function(){
		$detail.find('[data-as="email"]').html('<i class="fas fa-envelope"></i> ' + $(this).val()).fadeIn()
		if($(this).val() == '') $detail.find('[data-as="email"]').fadeOut()
	})
	$form.find('input[name="address"]').keyup(function(){
		$detail.find('[data-as="address"]').html('<i class="fas fa-map-marker-alt"></i> ' + $(this).val()).fadeIn()
		if($(this).val() == '') $detail.find('[data-as="address"]').fadeOut()
	})
	$form.find('textarea[name="note"]').keyup(function(){
		$detail.find('[data-as="note"]').html('<i class="fas fa-sticky-note"></i> ' + $(this).val()).fadeIn()
		if($(this).val() == '') $detail.find('[data-as="note"]').fadeOut()
	})
})
// file input image
// preview image input
$("#avatar_input").on("change", function () {
	$this = $(this)
	$this.closest(".image-frame").find('img').remove()
	for (let i = 0; i < this.files.length; ++i) {
		let filereader = new FileReader()
		let $img = jQuery.parseHTML(
		"<img>"
		)
		filereader.onload = function () {
		$img[0].src = this.result
		}
		filereader.readAsDataURL(this.files[i])
		$this.closest(".image-frame").append($img)
		$this.closest(".image-frame").find('.image-frame__btn.cancel').show()
	}
})
$('.image-frame__btn.cancel').click(function(e){
	e.preventDefault()
	$(this).closest('.image-frame').find('img').remove()
	$(this).closest('.image-frame').find('input').val(null)
	$(this).hide()
})
// tab profile
function showTab(tab){
	$('.profile-tab>div').removeClass("active")
	$(tab).addClass("active")
	var id = $(tab).data("tab")
	$('.profile-tab__content').hide()
	$('#' + id).show().find('.rateit').rateit()
}
$('.profile-tab>div').click(function(){
	showTab(this)
	var hash = $(this).find('a').attr('href')
	history.pushState({}, "", hash)
	return false
})
$productTab = $('.profile-tab')[0]
if($productTab){
	$hash = window.location.hash
    if($hash !== ''){
        $productTab = $('.profile-tab')[0]
        if($productTab){
			if($('.profile-tab>div').find('a[href="'+$hash+'"]').length > 0){
				$('.profile-tab>div').find('a[href="'+$hash+'"]').parent().click()
			} else {
				showTab('.profile-tab>div:first-child')
			}
        }
    } else {
		showTab('.profile-tab>div:first-child')
	}
}
// live search
function liveSearchResult($key){
	$.ajax({
		url			: ROOT_URL + '/API/product.php',
		type		: 'POST',
		dataType	: 'html',
		data 		: {key: $key, action: 'live-search'},
		success		: function(data){
			if(data.length > 0){
				$('#search-modal .search-result').html(data)
				$('.rateit').rateit()
			} else {
				$('#search-modal .search-result').html('<p style="text-align:center;padding:10px;background:#fff;font-size:1rem">Data not found</p>')
			}
		}
	})
}
$('#search-modal .modal-body__input').keyup(function(){
	$key = $(this).val()
	liveSearchResult($key)
})
function randomInteger(min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
}
// random background for product horizontal
$(function(){
	$arrColor 	= ['#D4FFC0', '#FFC0CC', '#FFEAC0', '#C0E5FF']
	// set background to product single thumb png
	$('.product-info__image--thumb').css('background', $arrColor[randomInteger(0, $arrColor.length-1)])
	$product 	= $('.product-horizontal').length
	$productCol = ('.product-column__item--image').length
	var j = 0;
	for(i = 0;i < $productCol;i++){
		if(j == $arrColor.length) j = 0
		$('.product-horizontal').eq(i).css('background', $arrColor[j])
		j += 1
	}
	for(i = 0;i < $product;i++){
		if(j == $arrColor.length) j = 0
		$('.product-column__item--image').eq(i).css('background', $arrColor[j])
		j += 1
	}
})
// function get param
function getParam(key){
	var paramString = window.location.search
	let queryString = new URLSearchParams(paramString)
	return queryString.get(key)
}