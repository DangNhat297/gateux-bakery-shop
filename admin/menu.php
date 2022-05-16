<?php require_once 'layout/blocks/header.php';
$menu = DB::fetchAll('SELECT * FROM menu');
?>
<style>
    .delete-item{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
</style>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
<?php if(Session::get('user')['role'] == 3){ ?>
        <!--begin::row-->
        <div class="form-group row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card card-custom">
                    <div class="card-header py-3">
                        <h3 class="card-title">
                            Menu
                        </h3>
                        <button class="btn btn-primary font-weight-bolder add-new-menu-itm">Add New</button>
                    </div>
                    <!--begin::Form-->
                    <form id="update-menu">
                        <div class="card-body">
                            <div id="menu-item-wr">
                                <?php foreach ($menu as $item) : ?>
                                    <div id="<?= $item['menu_id'] ?>" class="menu-wr" ondrop="drop(event)" ondragover="allowDrop(event)">
                                        <div class="drag-wr btn form-group d-flex justify-content-start item-menu" draggable="true" ondragstart="drag(event)" id="item-<?= $item['menu_id'] ?>">
                                            <input type="number" value="<?= $item['menu_id'] ?>" hidden>
                                            <div class="menu-title pr-5">
                                                <label>Title</label>
                                                <input type="text" class="form-control title-input" placeholder="Enter Menu Title" value="<?= $item['menu_title'] ?>" name="title-<?= $item['menu_id'] ?>" required />
                                            </div>
                                            <div class="menu-url pr-5">
                                                <label>URL</label>
                                                <input type="text" class="form-control url-input" placeholder="Enter URL" value="<?= $item['menu_url'] ?>" name="name-<?= $item['menu_id'] ?>" required />
                                            </div>
                                            <div class="menu-parent pr-5">
                                                <label>Parent</label>
                                                <input type="number" class="form-control parent-input" placeholder="Enter Parent ID" value="<?= $item['menu_parent'] ?>" name="parentId-<?= $item['menu_id'] ?>" />
                                            </div>
                                            <div class="delete-item">
                                                <label>Action</label>
                                                <button type="button" href="" class="grid align-items-center btn delete-menu-item menu-link" data-menu-id="<?= $item['menu_id'] ?>">
                                                    <span class="svg-icon svg-icon-primary svg-icon-2x menu-icon">
                                                        <!--begin::Svg Icon-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
                                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="card-footer pl-0">
                                <button type="submit" class="btn btn-primary mr-2 " name="btn-update">Submit</button>
                                <!-- <button type="reset" class="btn btn-secondary">Cancel</button> -->
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>


            </div>
        </div>
        <!--end::Container-->
<?php } else { ?>
    <div class="alert alert-custom alert-danger" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">You don't have permission to access this page!</div>
    </div>
<?php } ?>
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
        var src = document.getElementById(ev.dataTransfer.getData("text"));
        var srcParent = src.parentNode;
        var tgt = ev.currentTarget.firstElementChild;

        ev.currentTarget.replaceChild(src, tgt);
        srcParent.appendChild(tgt);

    }

    function getValueIntoArray(arrayA, arrayB) {
        var arrayB = new Array;
        for (var i = 0; i < arrayA.length; i++) {
            arrayB[i] = arrayA[i].value;
        }
        return arrayB;
    }

    $('.add-new-menu-itm').on('click', function(event) {
        event.preventDefault();
        $item_count = $('.item-menu').length;
        $large = `<div id="${$item_count+1}" class="menu-wr" ondrop="drop(event)" ondragover="allowDrop(event)"> <div class="drag-wr btn form-group d-flex justify-content-start item-menu" draggable="true" ondragstart="drag(event)" id="item-${$item_count+1}"> <input type="number" value="${$item_count+1}" hidden><div class="menu-title pr-5"> <label>Title</label> <input type="text" class="form-control title-input" placeholder="Enter Menu Title" value="" name="title-${$item_count+1}" required/> </div><div class="menu-url pr-5"> <label>URL</label> <input type="text" class="form-control url-input" placeholder="Enter URL" value="" name="url-${$item_count+1}" required/> </div><div class="menu-parent pr-5"> <label>Parent</label> <input type="number" class="form-control parent-input" placeholder="Enter Parent ID" value="" name="parentId-${$item_count+1}" /> </div><div class="delete-item"> <label>Action</label> <button type="button" href="" class="grid align-items-center btn delete-menu-item" data-menu-id="${$item_count+1}"> <span class="svg-icon svg-icon-primary svg-icon-2x"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <rect x="0" y="0" width="24" height="24"/> <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/> <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/> </g> </svg> </span> </button> </div></div></div>`;

        $('#menu-item-wr').append($large);
        // console.log($item_count);
    });
    $(document).ready(function() {
        $('#update-menu').submit(function(e) {
            e.preventDefault()
            $item_count = $('.item-menu').length
            $menuTitle = getValueIntoArray($('.title-input'));
            $menuUrl = getValueIntoArray($('.url-input'));
            $menuParent = getValueIntoArray($('.parent-input'));
            // console.log($menuTitle)
            // console.log($menuUrl)
            // console.log($menuParent)
            $this = $(this)
            $thisBtn = $(this).find('button[name="btn-update"]')
            $data = new FormData(this)
            $data.append('action', 'update-menu')
            $data.append('item_count', $item_count)
            $data.append('menuTitle', $menuTitle)
            $data.append('menuUrl', $menuUrl)
            $data.append('menuParent', $menuParent)
            $.ajax({
                url: '../API/menu.php',
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
        })
    })
    // Delete Menu
    $(document).on('click', '.delete-menu-item', function() {
        $id = $(this).data('menu-id')
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure delete this menu item?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: '../API/menu.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        menu_id: $id,
                        'action': 'delete'
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            $("#" + $id).remove();
                            Swal.fire("Success!", "Deleted Menu!", "success");
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