// select all
$(document).on('click', '.select-all', function(e){
    $this = $(this)
    $thisTable = $this.closest('table')
    $thisTable.find('tbody label.checkbox').each(function(index, value){
        if($this.is(':checked')){
            if($(value).find('input[type="checkbox"]').is(':not(:checked)')){
                $(value).find('input[type="checkbox"]').prop('checked', true)
            }
        } else {
            if($(value).find('input[type="checkbox"]').is(':checked')){
                $(value).find('input[type="checkbox"]').prop('checked', false)
            }
        }
    })
})
// trim input
$("input, textarea").blur(function () {
  if (!/\b/.test($(this).val())) {
    $(this).val("")
  }
})
// preview image input
$("#customFile").on("change", function () {
  $this = $(this);
  $this.parent(".custom-file").next(".preview-image").empty();
  for (let i = 0; i < this.files.length; ++i) {
    let filereader = new FileReader();
    let $img = jQuery.parseHTML(
      "<img src='' style='display:block;margin:10px 0;width: auto;height: 150px;object-fit:cover;border:1px solid #3699ff;border-radius:5px;'>"
    );
    filereader.onload = function () {
      $img[0].src = this.result;
    };
    filereader.readAsDataURL(this.files[i]);
    $this.parent(".custom-file").next(".preview-image").append($img);
  }
});
// preview product img
$(".custom-file-input.album").on("change", function () {
  $this = $(this);
  $this.parent(".custom-file").next(".preview-image").empty(); //you can remove this code if you want previous user input
  for (let i = 0; i < this.files.length; ++i) {
    let filereader = new FileReader();
    let $img = jQuery.parseHTML(
      "<img src='' style='width: 100%;height: 150px;object-fit:cover;border:1px solid #3699ff;border-radius:5px;'>"
    );
    filereader.onload = function () {
      $img[0].src = this.result;
    };
    filereader.readAsDataURL(this.files[i]);
    $this.parent(".custom-file").next(".preview-image").append($img);
  }
});
// function get session current user
function getSessionCurrentUser(){
	$result = $.ajax({
		url			: '../API/user.php',
		type		: 'POST',
		dataType	: 'json',
		data 		: {get: 'current-user'},
		async		: false
	})
	return $result.responseJSON
}
function toSlug(str)
{
    // Chuyển hết sang chữ thường
    str = str.toLowerCase();     
 
    // xóa dấu
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');
 
    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, '');
 
    // Xóa khoảng trắng thay bằng ký tự -
    str = str.replace(/(\s+)/g, '-');
 
    // xóa phần dự - ở đầu
    str = str.replace(/^-+/g, '');
 
    // xóa phần dư - ở cuối
    str = str.replace(/-+$/g, '');
 
    // return
    return str;
}
// find active menu
$(function(){
  var pathname = window.location.pathname
  var path = pathname.substr(pathname.lastIndexOf("/")+1)
  if(path.indexOf('.') == -1){
    $('.menu-nav li a[href="index.php"]').parent().addClass('menu-item-active')
  }
  $('.menu-item a[href="'+ path +'"]').parent().addClass('menu-item-active')
  $('.menu-subnav li a[href="'+ path +'"]').find('i').addClass('menu-bullet-dot').removeClass('menu-bullet-line')
                                            .closest('.menu-item').addClass('menu-item-active')
                                            .closest('.menu-submenu').attr('style','')
                                            .closest('.menu-item-submenu').addClass('menu-item-open')
})
CKEDITOR.replace("editor-product")
