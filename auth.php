<?php
require_once 'lib/layout.php';
get_header();
if (Session::get('user')) {
    echo '<script>window.location.href="' . ROOT_URL . '/home/"</script>';
}
?>
<style>
    .bth-text:hover {
        color: var(--pink);
    }
</style>
<div id="main">
    <div class="wrapper wrapper-sign-in animated animatedFadeInUp fadeInUp">
        <div class="wr-left">
            <div class="inner-content">
                <form id="sign-in">
                    <h1 class="si-title">Sign in</h1>
                    <div class="si-input-wr">
                        <div class="input-block">
                            <label class="for-input" for="fname">Username or email</label>
                            <input id="fname" type="text" value="<?= $_COOKIE['account'] ?? '' ?>" name="account" class="cool" required />
                            <p class="error account"></p>
                        </div>

                        <div class="input-block">
                            <label class="for-input" for="lpass">Password</label>
                            <input id="lpass" type="password" value="<?= $_COOKIE['password'] ?? '' ?>" name="password" class="cool" required />
                            <p class="error password"></p>
                        </div>
                    </div>
                    <div class="si-control flex-between">
                        <span class="remember">
                            <label>
                                <input type="checkbox" name="remember" class="remember-me" <?= isset($_COOKIE['remember']) ? 'checked' : '' ?>>
                                <span class="remember-text">Remember Me</span>
                            </label>
                        </span>
                        <span class="forgot-pass">Forgot password</span>
                    </div>
                    <div class="captcha-group">
                        <div class="g-recaptcha"></div>
                    </div>
                    <p class="error recaptcha"></p>
                    <div class="button-submit-wr">
                        <button type="submit" class="button-pink-fill">Sign-in</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="wr-right place-center">
            <div class="wr-inner">
                <img src="<?= ROOT_URL ?>/assets/img/leaf.png" alt="">
                <h2 class="si-signup-title">Hello, friend</h2>
                <p class="si-signup-text">Enter your personal details and start your journey with us</p>
                <button type="button" class="btn-white-outline" id="btn-switch-su">Sign up</button>
            </div>
        </div>
    </div>
    <div class="wrapper-sign-up disabled">
        <div class="su-wr-left place-center">
            <div class="wr-inner">
                <img src="<?= ROOT_URL ?>/assets/img/leaf.png" alt="">
                <h2 class="si-signup-title">Already here?</h2>
                <p class="si-signup-text">Enter and go along our journey</p>
                <button class="btn-white-outline btn-switch-si">Sign in</button>
            </div>
        </div>
        <div class="su-wr-right ">
            <div class="inner-content">
                <form id="sign-up">
                    <h1 class="si-title">Sign up</h1>
                    <div class="si-input-wr">
                        <p class="error system"></p>
                        <div class="input-block">
                            <label class="for-input" for="suusername">Username</label>
                            <input name="username" id="suusername" type="text" class="cool" name="suusername" required />
                            <p class="error username"></p>
                        </div>
                        <div class="input-block">
                            <label class="for-input" for="email">Email</label>
                            <input name="email" id="email" type="email" class="cool" required />
                            <p class="error email"></p>
                        </div>
                        <div class="input-block">
                            <label class="for-input" for="password">Password</label>
                            <input name="password" id="password" type="password" class="cool" required />
                            <p class="error password"></p>
                        </div>
                        <div class="input-block">
                            <label class="for-input" for="cpassword">Confirm password</label>
                            <input name="cpassword" id="cpassword" type="password" class="cool" required />
                            <p class="error cpassword"></p>
                        </div>
                        <div class="captcha-group">
                            <div class="g-recaptcha"></div>
                        </div>
                        <p class="error recaptcha"></p>
                    </div>
                    <div class="button-submit-wr">
                        <button type="submit" class="button-pink-fill">Sign-up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="wrapper-forgot disabled">
        <div class="su-wr-left place-center">
            <div class="wr-inner">
                <img src="<?= ROOT_URL ?>/assets/img/leaf.png" alt="">
                <h2 class="si-signup-title">Remember your identity?</h2>
                <p class="si-signup-text">Let's go and continue our journey</p>
                <button class="btn-white-outline btn-switch-si">Sign in</button>
            </div>
        </div>
        <div class="forgot-pass-wr su-wr-right">
            <h1 class="si-title">Forgot password</h1>
            <form id="forgot-password" style="width:100%">
                <div class="forgot-pass-input si-input-wr">
                    <div class="input-block">
                        <!-- <label for="facc">Enter your username or email</label> -->
                        <input id="facc" type="text" class="cool" placeholder="Email or username" required />
                        <p class="error account"></p>
                    </div>
                </div>
                <div class="captcha-group">
                    <div class="g-recaptcha"></div>
                </div>
                <p class="error recaptcha"></p>
                <div class="button-submit-wr">
                    <button type="submit" class="button-pink-fill">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div class="back" style="position: absolute; bottom: 3rem; left: 50%; transform: translateX(-50%)">
        <a href="<?= ROOT_URL ?>" class="bth-text" style="display: flex; justify-content: space-between; align-items: center; transition: all 0.35s linear;">
            <ion-icon name="home-outline" style="margin-right: 1rem"></ion-icon>
            <p class="bth">Back to home</p>
        </a>
    </div>
    <script>
        // render recaptcha
        var onloadCallback = function() {
            $('.g-recaptcha').each(function(index, el) {
                var widgetId = grecaptcha.render(el, {
                    'sitekey': '<?= SITE_KEY ?>'
                })
                $(this).attr('data-widget-id', widgetId)
            })
        }
        $(document).ready(function() {
            $('.wrapper-sign-up').hide()
            $('.wrapper-forgot').hide()
            $('.wrapper-sign-in').show()
            $('.cool').on('focusin', function() {
                $(this).parent().find('label.for-input').addClass('active');
            });
            $('.cool').on('focusout', function() {
                if (!this.value) {
                    $(this).parent().find('label.for-input').removeClass('active');
                }
            });
            $(window).on('load', function() {
                for (var i = 0; i < $('.cool').length; i++) {
                    if ($('.cool').eq(i).val() != '') {
                        $('.cool').eq(i).parent().find('label.for-input').addClass('active');
                    }
                }
            });
            $('#btn-switch-su').on('click', function() {
                $('.wrapper-sign-in').removeClass("animated animatedFadeInUp fadeInUp");
                $('.wrapper-forgot').removeClass("animated animatedFadeInUp fadeInUp");
                $('.wrapper-sign-in').addClass("animated fadeOutDown ");
                $('.wrapper-forgot').addClass("animated fadeOutDown ");
                $('.wrapper-sign-in').addClass("disabled ");
                $('.wrapper-forgot').addClass("disabled ");
                $('.wrapper-sign-up').removeClass("disabled");
                $('.wrapper-sign-up').addClass("animated animatedFadeInUp fadeInUp");
                $('.wrapper-sign-in').fadeOut()
                $('.wrapper-forgot').fadeOut()
                $('.wrapper-sign-up').fadeIn()
                // $('.wrapper-sign-up')
            });
            $('.btn-switch-si').on('click', function() {
                $('.wrapper-sign-up').removeClass("animated animatedFadeInUp fadeInUp");
                $('.wrapper-forgot').removeClass("animated animatedFadeInUp fadeInUp");
                $('.wrapper-sign-up').addClass("animated fadeOutDown ");
                $('.wrapper-forgot').addClass("animated fadeOutDown ");
                $('.wrapper-sign-up').addClass("disabled ");
                $('.wrapper-forgot').addClass("disabled ");
                $('.wrapper-sign-in').removeClass("disabled");
                $('.wrapper-sign-in').addClass("animated animatedFadeInUp fadeInUp");
                $('.wrapper-sign-in').fadeIn()
                $('.wrapper-sign-up').fadeOut()
                $('.wrapper-forgot').fadeOut()
                // $('.wrapper-sign-up')
            })
            $('.forgot-pass').on('click', function() {
                $('.wrapper-sign-in').removeClass("animated animatedFadeInUp fadeInUp");
                $('.wrapper-sign-up').removeClass("animated animatedFadeInUp fadeInUp");
                $('.wrapper-sign-in').addClass("animated fadeOutDown ");
                $('.wrapper-sign-up').addClass("animated fadeOutDown ");
                $('.wrapper-sign-in').addClass("disabled ");
                $('.wrapper-sign-up').addClass("disabled ");
                $('.wrapper-forgot').removeClass("disabled");
                $('.wrapper-forgot').addClass("animated animatedFadeInUp fadeInUp");
                $('.wrapper-sign-in').fadeOut()
                $('.wrapper-sign-up').fadeOut()
                $('.wrapper-forgot').fadeIn()
                // $('.wrapper-sign-up')
            })
            $hash = window.location.hash
            if ($hash == '#register') $('#btn-switch-su').trigger('click')
            if ($hash == '#login') $('#btn-switch-si').trigger('click')
            if ($hash == '#forgotpass') $('.forgot-pass').trigger('click')
            // sign in
            $('#sign-in').submit(function(e) {
                e.preventDefault()
                $this = $(this)
                $this.find('p.error').html('')
                $account = $this.find('input[name="account"]').val()
                $password = $this.find('input[name="password"]').val()
                $remember = $this.find('input[name="remember"]')
                $btnLogin = $this.find('button[type="submit"]')
                $rememberVal = ''
                if ($remember.is(':checked')) {
                    $rememberVal = 'yes'
                }
                $.ajax({
                    url: ROOT_URL + '/API/auth.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        remember: $rememberVal,
                        account: $account,
                        password: $password,
                        action: 'login',
                        recaptcha: grecaptcha.getResponse($this.find('.g-recaptcha').attr('data-widget-id'))
                    },
                    beforeSend: function() {
                        $btnLogin.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true)
                    },
                    success: function(data) {
                        setTimeout(() => {
                            if (data.status == 'success') {
                                Swal.fire("Success!", "Login success", "success")
                                $btnLogin.html('<i class="fas fa-check-circle"></i>')
                                setTimeout(() => {
                                    window.location.href = ROOT_URL + '/home/'
                                }, 1000)
                            } else {
                                Swal.fire("Error!", "Login failed, try again!", "error")
                                $.each(data.message, function(index, value) {
                                    $this.find('p.error.' + index).html(value)
                                    grecaptcha.reset($this.find('.g-recaptcha').attr('data-widget-id'))
                                })
                                $btnLogin.html('Sign In').prop('disabled', false)
                            }
                        }, 500)
                    }
                })
            })
            // sign up
            $('#sign-up').submit(function(e) {
                e.preventDefault()
                $this = $(this)
                $this.find('p.error').html('')
                $data = new FormData(this)
                $btnSubmit = $this.find('button[type="submit"]')
                $data.append('action', 'register')
                $data.append('recaptcha', grecaptcha.getResponse($this.find('.g-recaptcha').attr('data-widget-id')))
                $.ajax({
                    url: ROOT_URL + '/API/auth.php',
                    type: 'POST',
                    dataType: 'json',
                    data: $data,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $btnSubmit.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true)
                    },
                    success: function(data) {
                        setTimeout(() => {
                            if (data.status == 'success') {
                                Swal.fire("Success!", "Register success, please check email to active your account", "success")
                                $btnSubmit.html('<i class="fas fa-check-circle"></i>')
                                $this.find('.si-input-wr').slideUp(100, function() {
                                    $this.find('.si-input-wr').after(`<div class="box-notify box-notify__success"><i class="fas fa-check-double"></i> Please check your email to confirm account !</div>`)
                                })
                            } else {
                                Swal.fire("Error!", "Login failed, try again!", "error")
                                $.each(data.message, function(index, value) {
                                    $this.find('p.error.' + index).html(value)
                                })
                                grecaptcha.reset($this.find('.g-recaptcha').attr('data-widget-id'))
                                $btnSubmit.html('Sign Up').prop('disabled', false)
                            }
                        }, 1000)
                    }
                })
            })
            $('#forgot-password').submit(function(e) {
                e.preventDefault()
                $this = $(this)
                $this.find('p.error').html('')
                $account = $this.find('input#facc').val()
                $.ajax({
                    url: ROOT_URL + '/API/auth.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        account: $account,
                        action: 'forgot-password',
                        recaptcha: grecaptcha.getResponse($this.find('.g-recaptcha').attr('data-widget-id'))
                    },
                    beforeSend: function() {
                        $this.find('button[type="submit"]').html('<i class="fas fa-cog fa-spin"></i>').prop('disabled', true)
                    },
                    success: function(data) {
                        setTimeout(() => {
                            if (data.status == 'success') {
                                Swal.fire("Success!", "Please check email to recovery your account password", "success")
                                $this.find('button[type="submit"]').html('<i class="fas fa-check"></i>')
                                $this.find('input').prop('disabled', true)
                                $this.slideUp('fast', function() {
                                    $this.after(`<div class="box-notify box-notify__success"><i class="fas fa-check-double"></i> Please check your email to recovery account !</div>`)
                                })
                            } else {
                                Swal.fire("Error!", "Has an error, try again!", "error")
                                $.each(data.message, function(i, val) {
                                    $this.find('p.error.' + i).html(val)
                                })
                                grecaptcha.reset($this.find('.g-recaptcha').attr('data-widget-id'))
                                $this.find('button[type="submit"]').html('Submit').prop('disabled', false)
                            }
                        }, 1000)
                    }
                })
            })
        })
    </script>
</div>