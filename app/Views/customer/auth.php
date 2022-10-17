<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang | Company Name</title>
    <?= $this->include('components/links') ?>
</head>

<body>

    <section id="customer-auth-section">
        <div class="wh-screen d-flex justify-content-center align-items-center bg-white font-nunito-sans">
            <div class="col-10" style="max-width: 480px">
                <h1>Selamat Datang!</h1>
                <h5>Silahkan masukkan nomor pesanan anda.</h5>
                <hr class="col-5">
                <div class="mb-3">
                    <input type="text" id="inputOrderNo" class="form-control uppercase" placeholder="Nomor Pesanan" maxlength="6">
                </div>
                <button class="btn btn-primary rounded-0 mb-5" onclick="checkOrder()">Cek Pesanan</button>

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
    </script>
</body>

</html>