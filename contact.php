<?php
require_once 'lib/layout.php';
get_header();
get_nav();
?>
<!--Begin::Contact-->  
<main>
    <div class="breadcrumb-product">
        <div class="breadcrumb-product__name">Contact</div>
        <div style="display:flex">
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/home/">Home</a></div>
            <div class="breadcrumb-link"><a href="<?=ROOT_URL?>/contact/">Contact</a></div>
        </div>
    </div>
    <div class="contact-page container">
        <div class="contact">
            <div>
                <i class="fas fa-map-marker-alt"></i>
                <p>Address</p>
                <span><?=WEB_ADDRESS?></span>
            </div>
            <div>
                <i class="fas fa-phone"></i>
                <p>Phone</p>
                <span><?=WEB_PHONE?></span>
            </div>
            <div>
                <i class="far fa-envelope"></i>
                <p>Email</p>
                <span><?=WEB_EMAIL?></span>
            </div>
        </div>
        <div class="contact-form">
            <div class="maps">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8638558813955!2d105.74459841424536!3d21.03813279283566!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454b991d80fd5%3A0x53cefc99d6b0bf6f!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1622194479357!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="form-contact">
                <form id="form-contact">
                    <input type="text" placeholder="Enter your name..." name="fullname" required="">
                    <input type="email" placeholder="Enter email..." name="email" required="">
                    <input type="text" placeholder="Enter title..." name="title" required="">
                    <textarea placeholder="Enter message..." name="content" rows="7"></textarea>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</main>
<!--End::Contact-->
<script>
    $(document).ready(function(){
        setTitle('Contact | Gateux')
        $('#form-contact').submit(function(e){
            e.preventDefault()
            var form = new FormData(this)
            form.append('action', 'add-contact')
            $.ajax({
                url         : ROOT_URL + '/API/other.php',
                type        : 'POST',
                data        : form,
                processData : false,
                contentType : false,
                dataType    : 'html',
                beforeSend  : function(){
                    $('button[type="submit"]').html('<i class="fas fa-circle-notch fa-spin"></i>').prop('disabled', true)
                },
                success     : function(data){
                    setTimeout(function(){
                        $('input,textarea').prop('disabled', true)
                        $('button[type="submit"]').html('<i class="fas fa-check"></i> Success')
                    },1000)
                }
            })
        })
    })
</script>
<?php
get_footer();
?>