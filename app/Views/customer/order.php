<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan | Woowprint</title>
    <?= $this->include('components/links') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/custom.css') ?>">
</head>

<body>

    <section id="order-detail-section">
        <div class="mt-5 d-flex justify-content-center align-items-center bg-white font-nunito-sans">
            <div class="col-10" style="max-width: 800px">
                <a href="<?= base_url('') ?>"><i class="fa-solid fa-left-long"></i>&nbsp; Kembali</a>
                <h3 class="mt-2">Detail Pesanan</h3>
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
                        <td>
                            <?php
                            if ($order[0]['status'] == 'uploading') {
                                echo "Mengunggah Foto";
                            } else if ($order[0]['status'] == 'queued') {
                                echo "Dalam Antrian";
                            } else if ($order[0]['status'] == 'processing') {
                                echo "Sedang Diproses";
                            } else if ($order[0]['status'] == 'shipping') {
                                echo "Dalam Proses Pengiriman";
                            } else if ($order[0]['status'] == 'completed') {
                                echo "Selesai";
                            }
                            ?>
                        </td>
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

                <?php
                if ($uploaded < $order[0]['amount_photo']) {
                ?>
                    <section class="mb-3" id="upload-section">
                        <form action="<?= base_url('order/upload') ?>?i=<?= $order[0]['token'] ?>" id="formUploadPhoto" method="POST" enctype="multipart/form-data">
                            <label for="formFile" class="form-label">Unggah Foto</label>
                            <div class="row mx-0">
                                <span class="col-md-10 px-0 mb-2">
                                    <input class="form-control" type="file" id="formFile" name="photo" required accept="image/*">
                                </span>
                                <button type="submit" class="btn btn-primary rounded-0 col-md-2 mb-2"><i class="fa-solid fa-upload"></i>&nbsp; Unggah</button>
                            </div>
                        </form>
                        <hr>
                    </section>
                <?php
                }
                ?>


                <?php
                if ($order[0]['status'] == 'uploading' && $uploaded == $order[0]['amount_photo']) {
                ?>
                    <section class="mb-3" id="submit-section">
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success rounded-0 mx-auto" onclick="finishUploading()">Selesai Mengunggah</button>
                        </div>
                        <hr>
                    </section>
                <?php
                }
                ?>

                <section id="thumbnail-section">
                    <div class="d-flex flex-wrap justify-content-center mx-0">
                        <?php
                        foreach ($photos as $key => $photo) {
                        ?>
                            <div class="col-6 col-md-3 mb-3 p-2">
                                <img src="<?= base_url('public/uploads') ?>/<?= $photo['file_name'] ?>" role="button" onclick="preview('<?= base_url('public/uploads') ?>/<?= $photo['file_name'] ?>','<?= $photo['id'] ?>','<?= $photo['file_name'] ?>')" width="100%" class="thumb-img">
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </section>
                <p class="small text-muted text-center mt-5">&copy; 2022 Woowprint <br> Powered by <a href="https://www.akuonline.my.id">AkuOnline</a></p>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="previewModalLabel">Preview</h1>
                    <button type="button" class="btn-close noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <img src="" id="previewImg" class="previewImg mx-auto">
                </div>
                <div class="modal-footer <?= $order[0]['status'] == 'uploading' ? 'd-flex justify-content-between' : '' ?>">
                    <?php
                    if ($order[0]['status'] == 'uploading') {
                    ?>
                        <button type="button" class="btn btn-danger rounded-0" id="deleteButton"><i class="fa-solid fa-trash-can"></i>&nbsp; Delete</button>
                    <?php
                    }
                    ?>
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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
            Notiflix.Notify.failure('<?= $_SESSION['error'] ?>', {
                plainText: false
            })
        <?php
        }

        if (isset($_SESSION['success'])) {
        ?>
            Notiflix.Notify.success('<?= $_SESSION['success'] ?>', {
                plainText: false
            })
        <?php
        }
        ?>

        function preview(url, id, file_name) {
            console.log(id + ' - ' + file_name)
            $('#previewImg').attr('src', url)
            $('#deleteButton').attr('onclick', 'deletePhoto(' + id + ',"' + file_name + '")')
            $('#previewModal').modal('show')
        }

        function deletePhoto(id, file_name) {
            Notiflix.Loading.pulse()
            $.post("<?= base_url('order/deletephoto') ?>", {
                    id: id,
                    file_name: file_name
                })
                .done(function(data) {
                    if (data == "deleted") {
                        Notiflix.Notify.success("Berhasil dihapus!")
                        $('#previewModal').modal('hide')
                        setTimeout(() => {
                            window.location.reload()
                        }, 1000);
                    } else {
                        Notiflix.Notify.failure("Gagal menghapus foto")
                        setTimeout(() => {
                            window.location.reload()
                        }, 1000);
                    }
                });
        }

        function finishUploading() {
            const order_id = '<?= $order[0]['id'] ?>'

            Notiflix.Report.info(
                'Perhatian',
                'Setelah anda mengkonfirmasi pesanan anda akan masuk kedalam antrian pesanan dan anda tidak lagi dapat mengubah foto yang sudah diunggah',
                'Saya Mengerti',
                () => {
                    Notiflix.Confirm.show(
                        'Konfirmasi',
                        'Kirim foto dan proses pesanan?',
                        'Ya',
                        'Batal',
                        () => {
                            $.post("<?= base_url('order/confirm') ?>", {
                                    id: '<?= $order[0]['id'] ?>'
                                })
                                .done(function(data) {
                                    console.log(data)
                                });
                        },
                        () => {}, {},
                    );
                },
            );
        }
    </script>
</body>

</html>