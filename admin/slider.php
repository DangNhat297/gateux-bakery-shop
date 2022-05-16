<?php require_once 'layout/blocks/header.php';
$slider = DB::fetchAll('SELECT * FROM slider');
?>
<style>
    .slide-img {
        width: 100%;
        height: 300px;
        display: grid;
        place-items: center;
        pointer-events: none;
        user-select: none;
    }

    .img-slide {
        display: block;
        width: 100%;
        height: auto;
        max-height: 300px;
    }

    .delete-slider-item {
        top: 0;
        right: 0;
        background-color: transparent;
        outline: none;
        border: none;
    }

    .row-slider {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-row-gap: 20px;
    }
</style>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::row-->
        <div class="form-group row">
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class="card card-custom">
                    <div class="card-header py-3">
                        <h3 class="card-title">
                            Slider
                        </h3>
                    </div>
                    <!--begin::Form-->
                    <form id="update-slider">
                        <div class="card-body">
                            <div id="slider-item-wr" class="row-slider">
                                <?php foreach ($slider as $item) : ?>
                                    <div id="<?= $item['slider_id'] ?>" class="col item-slider" ondrop="drop(event)" ondragover="allowDrop(event)">
                                        <div class="slide-item position-relative w-100" draggable="true" ondragstart="drag(event)" id="slide-item-<?= $item['slider_id'] ?>">
                                            <div class="slide-img">
                                                <img class="img-slide mw-100 p-3 align-self-center user-select-none pe-none" src="data:image/jpeg;base64,<?= $item['slider_img'] ?>" alt="" id="img-<?= $item['slider_id'] ?>">
                                            </div>
                                            <div class="slide-title mb-3">
                                                <input type="text" placeholder="Slide Title" name="slide-title" id="title-<?= $item['slider_id'] ?>" class="slider-title" value="<?= $item['slider_title'] ?>">
                                            </div>
                                            <div class="slide-url">
                                                <input type="text" placeholder="Slide Url" name="slide-url" id="url-<?= $item['slider_id'] ?>" class="slider-url" value="<?= $item['slider_url'] ?>">
                                            </div>
                                            <button type="button" class="delete-slider-item position-absolute d-inline" data-slider-id="<?= $item['slider_id'] ?>">
                                                <span class=" svg-icon svg-icon-primary svg-icon-2x icon-close">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                                <rect x="0" y="7" width="16" height="2" rx="1" />
                                                                <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="card-footer pl-0 pl-3 py-3">
                            <button type="submit" class="btn btn-primary mr-2 " name="btn-update">Submit</button>
                        </div>
                    </form>
                </div>

                <!--end::Form-->
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 ">
                <div class="card card-custom">
                    <div class="card-header py-3">
                        <h3 class="card-title">
                            Add new slide
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="custom-file">
                            <input type="file" name="album[]" accept=".png, .jpg, .jpeg, .jfif" class="custom-file-input album" multiple>
                            <label class="custom-file-label" style="overflow:hidden" for="customFile">Choose file</label>
                        </div>
                        <div class="form-group preview-image" style="margin-top: 10px;display:grid"></div>
                        <button type="button" class="btn btn-primary mr-2 btn-add-slider" name="btn-add-slider">Add slide</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--end::Container-->
</div>
<!--end::Container-->
</div>
<script>
    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        var source = document.getElementById(ev.dataTransfer.getData("text"));
        var srcParent = source.parentNode;
        var tgt = ev.currentTarget.firstElementChild;

        ev.currentTarget.replaceChild(source, tgt);
        srcParent.appendChild(tgt);
    }

    function getValueIntoArray(arrayA) {
        var arrayB = new Array;
        for (var i = 0; i < arrayA.length; i++) {
            arrayB[i] = arrayA[i].value;
        }
        return arrayB;
    }

    function process(str) {
        var slash = str.lastIndexOf(",/");
        return str.substring(slash + 1, str.length)
    }

    function getSrcIntoArray(arrayA) {
        var arrayB = new Array;
        for (var i = 0; i < arrayA.length; i++) {
            arrayB[i] = process(arrayA[i].getAttribute('src'));
        }
        return arrayB;
    }

    function checkNull(array) {
        var check = true;
        for (var i = 0; i < array.length; i++) {
            if (array[i].value == null || array[i].value == "") {
                check = false;
                break;
            }
        }
        return check;
    }
    $('.btn-add-slider').on('click', function(event) {
        event.preventDefault();
        var imgSrc = $(this).prev('.preview-image').children('img').attr('src');
        if (imgSrc == null) {
            Swal.fire("Error!", "Please upload slide image", "error")
        } else {
            $item_count = $('.item-slider').length;
            $large = `<div id="${$item_count+1}" class="col item-slider" ondrop="drop(event)" ondragover="allowDrop(event)"> <div class="slide-item position-relative w-100" draggable="true" ondragstart="drag(event)" id="slide-item-${$item_count+1}"> <div class="slide-img user-select-none pe-none"> <img class="img-slide mw-100 p-3 align-self-center user-select-none pe-none" src="${imgSrc}" alt="" id="img-${$item_count+1}"> </div><div class="slide-title mb-3"> <input type="text" name="slide-title" id="title-${$item_count+1}" class="slider-title" value="" placeholder="Slide Title"> </div><div class="slide-url"> <input type="text" name="slide-url" id="url-${$item_count+1}" class="slider-url" value="" placeholder="Slide Url"> </div><button type="button" class="delete-slider-item position-absolute d-inline" data-slider-id="${$item_count+1}"> <span class=" svg-icon svg-icon-primary svg-icon-2x icon-close"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000"> <rect x="0" y="7" width="16" height="2" rx="1"/> <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/> </g> </g> </svg> </span> </button> </div></div>`;

            $('#slider-item-wr').append($large);
            $('.preview-image').children('img').remove();
        }

    });
    $(document).ready(function() {
        $('#update-slider').submit(function(e) {
            e.preventDefault()
            if (checkNull($(".slider-title")) == false) {
                Swal.fire("Error!", "Please fill all fields before update", "error")
            } else {
                $item_count = $('.item-slider').length
                $sliderTitle = getValueIntoArray($(".slider-title"))
                $sliderUrl = getValueIntoArray($(".slider-url"))
                $sliderImg = getSrcIntoArray($(".img-slide"))
                $this = $(this)
                $thisBtn = $(this).find('button[name="btn-update"]')
                $data = new FormData(this)
                $data.append('action', 'update-slider')
                $data.append('item_count', $item_count)
                $data.append('sliderTitle', $sliderTitle)
                $data.append('sliderUrl', $sliderUrl)
                $data.append('sliderImg', $sliderImg)
                $.ajax({
                    url: '../API/slider.php',
                    type: 'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    data: $data,
                    beforeSend: function() {
                        $thisBtn.html('<i class="fas fa-cog fa-spin"></i> Updating...').prop('disabled', true)
                    },
                    success: function(data) {
                        console.log(data)
                        setTimeout(() => {
                            if (data.status == 'success') {
                                $thisBtn.html('Submit').prop('disabled', false)
                                Swal.fire("Success!", "Update success!", "success")
                                // $this.find('input').prop('disabled', false)
                                // $('.web-logo').slideUp()
                            } else {
                                // $thisBtn.html('Update').prop('disabled', false)
                                Swal.fire("Error!", "Update failed, try again", "error")
                            }
                        }, 500)
                    }
                })
            }
        })
    })
    // Delete Menu
    $(document).on('click', '.delete-slider-item', function() {
        $id = $(this).data('slider-id')
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure delete this slide?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: '../API/slider.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        slider_id: $id,
                        'action': 'delete'
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            $("#" + $id).remove();
                            Swal.fire("Success!", "Deleted Slide!", "success");
                        } else {
                            Swal.fire("Error!", "Has an error, please try again!", "error");
                        }
                    }
                })
            }
        })
    })
</script>
<!--end::Entry-->
<?php require_once 'layout/blocks/footer.php'; ?>