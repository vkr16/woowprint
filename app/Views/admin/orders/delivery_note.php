<?php
// var_dump($sender[0]['sender_name'] . ' - ' . $sender[0]['sender_phone'] . ' - ' . $sender[0]['sender_address']);
// echo "<br><br><br>";
// var_dump($order[0]['cust_name'] . ' - ' . $order[0]['cust_phone'] . ' - ' . $order[0]['cust_address']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Note</title>
    <?= $this->include('components/links') ?>
</head>

<body>

    <div class="container font-nunito-sans">
        <h5>Nomor Pesanan : <?= $order[0]['order_no'] ?></h5>
        <hr>
        <h5>Pengirim</h5>
        <p class="mb-0 small"><?= $sender[0]['sender_name']  ?></p>
        <p class="mb-0 small"><?= $sender[0]['sender_phone'] ?></p>
        <p class="mb-0 small"><?= $sender[0]['sender_address'] ?></p>
        <hr>
        <h5>Penerima</h5>
        <p class="mb-0 small"><?= $order[0]['cust_name']  ?></p>
        <p class="mb-0 small"><?= $order[0]['cust_phone']  ?></p>
        <p class="mb-0 small"><?= $order[0]['cust_address']  ?></p>

    </div>

    <script>
        window.print()
        window.onfocus = function() {
            setTimeout(window.close, 0)
        }

        function closeme() {
            window.close, 0
        }
    </script>

</body>

</html>