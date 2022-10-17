<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail | Company Name</title>
    <?= $this->include('components/links') ?>
</head>

<body>

    <section id="customer-auth-section">
        <div class="wh-screen d-flex justify-content-center align-items-center bg-white font-nunito-sans">
            <div class="col-10" style="max-width: 800px">
                <h3 class="">Detail Pesanan</h3>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="ps-0" style="width: 140px">Nomor Pesanan</td>
                        <td style="width: 20px">:</td>
                        <td><?= $order[0]['order_no'] ?></td>
                    </tr>
                    <tr>
                        <td class="ps-0" style="width: 140px">Nama Pelanggan</td>
                        <td style="width: 20px">:</td>
                        <td><?= $order[0]['cust_name'] ?></td>
                    </tr>
                    <tr>
                        <td class="ps-0" style="width: 140px">Status Pesanan</td>
                        <td style="width: 20px">:</td>
                        <td><?= $order[0]['status'] ?></td>
                    </tr>
                    <tr>
                        <td class="ps-0" style="width: 140px">Deskripsi Pesanan</td>
                        <td style="width: 20px">:</td>
                        <td><?= $order[0]['description'] ?></td>
                    </tr>
                    <tr>
                        <td class="ps-0" style="width: 140px">Foto Diunggah</td>
                        <td style="width: 20px">:</td>
                        <td><?= $uploaded ?> dari <?= $order[0]['amount_photo'] ?></td>
                    </tr>
                </table>
                <hr>
                <section class="mb-3" id="upload-section">
                    <form action="<?= base_url('order/upload') ?>?i=<?= $order[0]['token'] ?>" id="formUploadPhoto" method="POST" enctype="multipart/form-data">
                        <label for="formFile" class="form-label">Unggah Foto</label>
                        <div class="row mx-0">
                            <span class="col-10 ps-0">
                                <input class="form-control" type="file" id="formFile" name="photo" required accept="image/*">
                            </span>
                            <button type="submit" class="btn btn-primary rounded-0 col-2"><i class="fa-solid fa-upload"></i>&nbsp; Unggah</button>
                        </div>
                    </form>
                    <hr>
                </section>
                <p class="small text-muted text-center mt-5">&copy; 2022 Company Name <br> Powered by <a href="https://www.akuonline.my.id">AkuOnline</a></p>
            </div>
        </div>
    </section>

    <?= $this->include('components/scripts') ?>
    <script>
        function checkOrder() {
            const order_no = $('#inputOrderNo')
            Notiflix.Loading.pulse()
            $.post("<?= base_url('order') ?>", {
                    order_no: order_no.val().toUpperCase()
                })
                .done(function(data) {
                    Notiflix.Loading.remove(500)
                    setTimeout(() => {
                        if (data == "notfound") {
                            Notiflix.Notify.failure("Nomor pesanan tidak ditemukan!")
                        } else {
                            const order = JSON.parse(data)
                            console.log(order[0].token)
                            const token = order[0].token
                            window.location.href = "<?= base_url('order') ?>?i=" + token
                        }
                    }, 500);
                })
        }

        <?php
        if (isset($_SESSION['error'])) {
        ?>
            Notiflix.Notify.failure('<?= $_SESSION['error'] ?>')
        <?php
        }
        ?>
    </script>
</body>

</html>