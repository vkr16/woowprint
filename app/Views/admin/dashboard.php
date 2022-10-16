<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory Manager</title>
    <?= $this->include('components/links') ?>
</head>

<body>
    <div class="d-flex font-nunito-sans bg-light">
        <?= $this->include('components/sidebar') ?>
        <section class="vh-100 w-100 scrollable-y" id="topbar-section">
            <?= $this->include('components/topbar') ?>
        </section>


    </div>

    <?= $this->include('components/scripts') ?>
    <script>
        $('#sidebar_dashboard').removeClass('link-dark').addClass('active')
    </script>
</body>

</html>