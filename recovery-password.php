<?php
require_once 'lib/layout.php';
get_header();
?>
<?php
if(!empty($_GET['email']) && !empty($_GET['code'])){
    $email = $_GET['email'];
    $code  = $_GET['code'];
    $sql = "SELECT * FROM users WHERE user_email = '$email'";
    if(DB::rowCount($sql) > 0){
        $user = DB::fetch($sql);
        if(md5($user['user_verifycode']) != $code){
            header('Location: '.ROOT_URL.'/404');
        }
    } else {
        header('Location: '.ROOT_URL.'/404');
    }
} else {
    header('Location: '.ROOT_URL.'/404');
}
?>
<div id="main">
    <div class="wrapper wrapper-sign-in animated animatedFadeInUp fadeInUp">
        <div class="wr-left">
            <div class="inner-content">
                <form id="recovery-change-password">
                    <input type="hidden" name="email" value="<?=$email?>">
                    <h1 class="si-title">Recovery Password</h1>
                    <div class="si-input-wr">
                        <div class="input-block">
                            <label class="for-input" for="newpass">New Password</label>
                            <input id="newpass" type="password" name="new-password" class="cool" required />
                            <p class="error new-password"></p>
                        </div>
                        <div class="input-block">
                            <label class="for-input" for="confpass">Confirm Password</label>
                            <input id="confpass" type="password" name="confirm-password" class="cool" required />
                            <p class="error confirm-password"></p>
                        </div>
                    </div>
                    <div class="button-submit-wr">
                        <button type="submit" class="button-pink-fill">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="wr-right place-center">
            <div class="wr-inner">
                <img src="<?=ROOT_URL?>/assets/img/leaf.png" alt="">
                <h2 class="si-signup-title">Hello, friend</h2>
                <p class="si-signup-text">Recovery password an account on the store Gateux.</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.cool').on('focusin', function() {
            $(this).parent().find('label.for-input').addClass('active');
        });
        $('.cool').on('focusout', function() {
            if (!this.value) {
                $(this).parent().find('label.for-input').removeClass('active');
            }
        });
        $(window).on('load', function() {
            if ($('.cool').val().length > 0) {
                $('.cool').parent().find('label.for-input').addClass('active');
            }
        });
        $('#recovery-change-password').submit(function(e){
            e.preventDefault()
            $this = $(this)
            $('p.error').html('')
            $data = new FormData(this)
            $data.append('action','recovery-change-password')
            $.ajax({
                url         : ROOT_URL + '/API/auth.php',
                type        : 'POST',
                dataType    : 'json',
                contentType : false,
                processData : false,
                data        : $data,
                beforeSend  : function(){
                    $this.find('button[type="submit"]').html('<i class="fas fa-cog fa-spin"></i>').prop('disabled',true)
                }, 
                success     : function(data){
                    console.log(data)
                    setTimeout(()=>{
                        if(data.status == 'success'){
                            Swal.fire("Success!", "Change password success", "success")
                            $this.find('input').prop('disabled',true)
                            setTimeout(()=>{
                                window.location.href= ROOT_URL + "/auth/";
                            },1500)
                        } else {
                            Swal.fire("Error!", "Has an error, try again!", "error")
                            $.each(data.message, function(i,val){
                                $('p.error.' + i).html(val)
                            })
                            $this.find('button[type="submit"]').html('Submit').prop('disabled',false)
                        }
                    },1000)
                }
            })
        })
    })
</script>