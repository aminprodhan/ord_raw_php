<?php
$title = "Order List";
startSection('content');
    ?>
        <style>
            .vtop{
                vertical-align: middle;
            }
        </style>
        <div class="d-flex alert alert-primary" role="alert">
            <div class="flex-grow-1">Order List</div>
            <div>
                <a href="<?php echo baseUrl('/') ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle-dotted"></i> Create
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <form action="<?php echo baseUrl('/order/index') ?>" method="get">
                            <th class="vtop" scope="col">Start Date</th>
                            <th><input name="start_date" class="form-control" type="date" /></th>
                            <th class="vtop" scope="col">End Date</th>
                            <th><input name="end_date" class="form-control" type="date" /></th>
                            <th class="vtop" scope="col">Entry By</th>
                            <th><input name="entry_by" class="form-control" /></th>
                            <th><button class="btn btn-primary">Filter</button></th>
                        </form>
                    </tr>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Receipt Id</th>
                        <th scope="col">Items</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Buyer</th>
                        <th scope="col">Buyer Email</th>
                        <th scope="col">Buyer IP</th>
                        <th scope="col">City</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Entry At</th>
                        <th scope="col">Entry By</th>
                        <th scope="col">Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order): ?>
                        <tr>
                            <th scope="row"><?php echo $order->id; ?></th>
                            <td><?php echo $order->receipt_id; ?></td>
                            <td>
                                <ul>
                                    <?php foreach(explode(',', $order->items) as $item): ?>
                                        <li><?php echo $item; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td><?php echo $order->amount; ?></td>
                            <td><?php echo $order->buyer; ?></td>
                            <td><?php echo $order->buyer_email; ?></td>
                            <td><?php echo $order->buyer_ip; ?></td>
                            <td><?php echo $order->city; ?></td>
                            <td><?php echo $order->phone; ?></td>
                            <td><?php echo $order->entry_at; ?></td>
                            <td><?php echo $order->entry_by; ?></td>
                            <td><?php echo htmlspecialchars($order->note); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php                
endSection();
extendLayout('layouts/master');