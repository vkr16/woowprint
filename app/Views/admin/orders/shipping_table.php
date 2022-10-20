<table id="shipping_table" class="table table-hoverable mt-5">
    <thead>
        <th scope="col" class="col-md-1" style="white-space: nowrap">No</th>
        <th scope="col" class="col-md-1" style="white-space: nowrap">Order No.</th>
        <th scope="col" class="col-md-2" style="white-space: nowrap">Customer Name</th>
        <th scope="col" class="col-md-2" style="white-space: nowrap">Customer Phone</th>
        <th scope="col" class="col-md-1" style="white-space: nowrap">Order Date</th>
        <th scope="col" class="col-md-5" style="white-space: nowrap">Option</th>
    </thead>
    <tbody>
        <?php
        foreach ($orders_shipping as $key => $order) {
        ?>
            <tr>
                <td class="align-middle" style="width: 1%"></td>
                <td class="align-middle" style="white-space: nowrap"><?= $order['order_no'] ?></td>
                <td class="align-middle" style="white-space: nowrap"><?= $order['cust_name'] ?></td>
                <td class="align-middle" style="white-space: nowrap"><a target="_blank" href="https://wa.me/<?= $order['cust_phone'] ?>"><?= $order['cust_phone'] ?></a></td>
                <td class="align-middle" style="white-space: nowrap"><?= date("d M Y", $order['created_at']) ?></td>
                <td class="align-middle" style="width: 50%">
                    <button class="btn btn-sm btn-primary rounded-0 me-2 my-1" onclick="markAsCompleted(<?= $order['id'] ?>,'<?= $order['order_no'] ?>')"><i class="fa-solid fa-flag-checkered"></i>&nbsp; Mark As Completed</button>

                    <button class="btn btn-sm btn-primary rounded-0 me-2 my-1" onclick="detailModal('<?= $order['id'] ?>','<?= $order['order_no'] ?>','<?= $order['cust_name'] ?>','<?= $order['cust_phone'] ?>','<?= $order['cust_address'] ?>','<?= $order['description'] ?>','<?= $order['amount_photo'] ?>','<?= $order['status'] ?>')"><i class="fa-solid fa-circle-info"></i>&nbsp; Detail</button>

                    <a target="printdeliverynote" href="<?= base_url('admin/orders/deliverynote') ?>?i=<?= $order['order_no'] ?>" class="btn btn-primary btn-sm rounded-0  me-2 my-1"><i class="fa-solid fa-truck-fast"></i>&nbsp; Delivery Notes</a>

                    <button class="btn btn-outline-primary btn-sm rounded-0  me-2 my-1" onclick="downloadFiles(<?= $order['id'] ?>,'<?= $order['order_no'] ?>')"><i class="fa-solid fa-download"></i>&nbsp; Download Photos</button>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<script>
    var t = $('#shipping_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        ordering: false,
        sorting: false
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
</script>