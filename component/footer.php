<!--footer-->
<footer>
    <button class="scroll-to-top"><ion-icon name="caret-up-outline"></ion-icon></button>
    <div class="custom-shape-divider-bottom-1636523607">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
        </svg>
    </div>
    <div class="footer container">
        <div class="column-footer">
            <div class="logo-footer">
                <img src="<?=ROOT_URL?>/assets/img/Gateux-white.png" />
            </div>
            <div class="footer-social">
                <a href=""><i class="fab fa-facebook-f"></i></a>
                <a href=""><i class="fab fa-twitter"></i></a>
                <a href=""><i class="fab fa-pinterest-p"></i></a>
                <a href=""><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="column-footer">
            <div class="column-footer__title">Page</div>
            <ul class="list-url">
                <li><a href="<?=ROOT_URL?>/blog/">Blog</a></li>
                <li><a href="<?=ROOT_URL?>/contact/">Contact</a></li>
                <li><a href="<?=ROOT_URL?>/about-us/">About Us</a></li>
                <li><a href="<?=ROOT_URL?>/shop/">Shop</a></li>
            </ul>
        </div>
        <div class="column-footer">
            <div class="column-footer__title">Quick Menu</div>
            <ul class="list-url">
                <li><a href="<?=ROOT_URL?>/home/">Home</a></li>
                <li><a href="<?=ROOT_URL?>/shop/">Product</a></li>
                <li><a href="<?=ROOT_URL?>/cart/">Cart</a></li>
                <li><a href="<?=ROOT_URL?>/wishlist/">Wishlist</a></li>
            </ul>
        </div>
        <div class="column-footer">
            <div class="column-footer__title">Newsletter</div>
            <div class="column-footer__body">
                <p>Follow us to get latest promotion</p>
                <form id="footer-subcribe" class="footer-subscribe">
                    <input type="email" class="sub-footer__input" placeholder="Enter your email..." required/>
                    <button type="submit" class="sub-footer__btn">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
    <div class="copyright">
        <p>© 2021 All Rights Reserved</p>
    </div>
</footer>
<!--footer end-->
<script>
    $(document).ready(function(){
        $('#footer-subcribe').submit(function(e){
            e.preventDefault()
            $this = $(this)
            $email = $this.find('.sub-footer__input').val()
            $.ajax({
                url         : ROOT_URL + '/API/other.php',
                type        : 'POST',
                dataType    : 'json',
                data        : {email: $email, action: 'sub-footer'},
                beforeSend  : function(){
                    $this.find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true)
                },
                success     : function(data){
                    console.log(data)
                    setTimeout(()=>{
                        if(data.status == 'success'){
                            $this.find('input').prop('disabled', true)
                            $this.find('button[type="submit"]').html('<i class="fas fa-check"></i>').prop('disabled', true)
                        } else {
                            $this.find('button[type="submit"]').html('Subscribe').prop('disabled', false)
                        }
                    },1000)
                }
            })
        })
    })
</script>
<script src="<?=ROOT_URL?>/assets/js/jquery.rateit.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?=ROOT_URL?>/assets/js/toastr.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="<?=ROOT_URL?>/assets/js/custom.js?t=<?=randomStr()?>"></script>
</body>
</html>