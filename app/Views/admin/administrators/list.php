<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Administrators - Woowprint</title>
    <?= $this->include('components/links') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/library/bootstrap-select-1.14.0/css/bootstrap-select.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/custom.css') ?>">
</head>

<body>
    <div class="d-flex font-nunito-sans bg-light">
        <?= $this->include('components/sidebar') ?>
        <section class="vh-100 w-100 scrollable-y" id="topbar-section">
            <?= $this->include('components/topbar') ?>

            <div class="mx-2 mx-lg-5 my-4 px-3 py-2">
                <h2 class="fw-semibold">List of Administrators</h2>
                <hr class="mt-05" style="max-width: 200px;border: 2px solid; opacity: 1 ">
                <div class="d-flex mb-5">
                    <button class="btn btn-primary rounded-0" data-bs-toggle="modal" data-bs-target="#modalAddAdministrator">
                        <i class="fa-solid fa-user-plus"></i>&nbsp; Add Administrator
                    </button>
                </div>
                <div class="table-responsive" id="administrators_table_container">
                    <table class="table table-hover mt-5" id="administrators_table">
                        <thead>
                            <th>No</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Option</th>
                        </thead>
                        <tbody id="administrators_table_body">
                            <?php
                            foreach ($administrators as $index => $administrator) {
                            ?>
                                <tr>
                                    <td class="align-middle"></td>
                                    <td class="align-middle"><?= $administrator['name'] ?></td>
                                    <td class="align-middle"><?= $administrator['username'] ?></td>
                                    <td class="align-middle">
                                        <button class="btn btn-danger btn-sm rounded-0 me-2 my-1" onclick="deleteAdministrator(<?= $administrator['id'] ?>,'<?= $administrator['name'] ?>')" <?= $administrator['id'] == $_SESSION['oms_cetakfoto_user_session'] ? 'disabled' : '' ?>><i class="fa-solid fa-trash-alt"></i>&nbsp; Delete</button>

                                        <button class="btn btn-primary btn-sm rounded-0 me-2 my-1" onclick="resetPasswordModal(<?= $administrator['id'] ?>,'<?= $administrator['name'] ?>')"><i class="fa-solid fa-user-edit"></i>&nbsp; Edit</button>

                                        <button class="btn btn-primary btn-sm rounded-0 me-2 my-1" onclick="resetPasswordModal(<?= $administrator['id'] ?>,'<?= $administrator['name'] ?>')"><i class="fa-solid fa-unlock-keyhole"></i>&nbsp; Reset Password</button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Add Admin -->
    <div class="modal fade" id="modalAddAdministrator" tabindex="-1" aria-labelledby="modalAddAdministratorLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddAdministratorLabel">
                        <i class="fa-solid fa-user-plus"></i>&nbsp; Add Administrator
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/administrators/add') ?>" method="POST">
                        <div class="mb-3">
                            <label for="inputName">Name</label>
                            <input type="text" autocomplete="name" class="form-control my-2" name="inputName" id="inputName">
                        </div>
                        <div class="mb-3">
                            <label for="inputUsername">Username</label>
                            <input type="text" autocomplete="username" class="form-control my-2" name="inputUsername" id="inputUsername">
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword">Password</label>
                            <input type="password" autocomplete="new-password" class="form-control my-2" name="inputPassword" id="inputPassword">
                        </div>
                        <div class="mb-3 d-flex align-items-center me-auto">
                            <input type="checkbox" class="form-check-input rounded-0 mt-0" id="checkShowPassword" onchange="inputPasswordVisible()">
                            <label for="checkShowPassword" class="form-label mb-0 ms-2">Show password</label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-0"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Administrator Reset Password -->
    <div class="modal fade" id="modalResetPasswordAdministrator" tabindex="-1" aria-labelledby="modalResetPasswordAdministratorLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalResetPasswordAdministratorLabel">
                        <i class="fa-solid fa-unlock-keyhole"></i>&nbsp; Reset Password
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/administrators/reset') ?>" method="POST">
                        <div class="mb-3">
                            <label for="showAdministrator">Administrator</label>
                            <input type="text" autocomplete="off" class="form-control mt-2" name="showAdministrator" id="showAdministrator" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword2">New Password</label>
                            <input required type="password" autocomplete="new-password" class="form-control my-2" name="inputPassword2" id="inputPassword2">
                        </div>
                        <div class="mb-3 d-flex align-items-center me-auto">
                            <input type="checkbox" class="form-check-input rounded-0 mt-0" id="checkShowPassword2" onchange="inputPasswordVisible2()">
                            <label for="checkShowPassword2" class="form-label mb-0 ms-2">Show password</label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-0" id="resetPasswordButton" name="adminId"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Set Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('components/scripts') ?>
    <script src="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/library/bootstrap-select-1.14.0/js/bootstrap-select.min.js') ?>"></script>
    <script>
        $('#sidebar_administrators').removeClass('link-dark').addClass('active')

        var t = $('#administrators_table').DataTable({
            columnDefs: [{
                orderable: false,
                targets: 0
            }],
            order: [
                [1, 'asc']
            ]
        });

        t.on('order.dt search.dt', function() {
            let i = 1;
            t.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();

        function inputPasswordVisible() {
            if ($('#inputPassword').attr('type') == 'password') {
                $('#inputPassword').attr('type', 'text')
            } else {
                $('#inputPassword').attr('type', 'password')
            }
        }

        function inputPasswordVisible2() {
            if ($('#inputPassword2').attr('type') == 'password') {
                $('#inputPassword2').attr('type', 'text')
            } else {
                $('#inputPassword2').attr('type', 'password')
            }
        }

        <?php
        if (isset($_SESSION['adminAddSuccess'])) {
        ?>
            Notiflix.Notify.success("<?= $_SESSION['adminAddSuccess'] ?>")
        <?php
        }
        ?>
        <?php
        if (isset($_SESSION['passResetSuccess'])) {
        ?>
            Notiflix.Notify.success("<?= $_SESSION['passResetSuccess'] ?>")
        <?php
        }
        ?>
        <?php
        if (isset($_SESSION['adminAddFailed'])) {
        ?>
            Notiflix.Notify.failure("<?= $_SESSION['adminAddFailed'] ?>")
        <?php
        }
        ?>

        <?php
        if (isset($_SESSION['passResetFailed'])) {
        ?>
            Notiflix.Notify.failure("<?= $_SESSION['passResetFailed'] ?>")
        <?php
        }
        ?>

        function resetPasswordModal(id, name, employee_number) {
            $('#modalResetPasswordAdministrator').modal('show')
            $('#showAdministrator').val(name)

            $('#resetPasswordButton').attr('value', id)
        }
    </script>
</body>

</html>