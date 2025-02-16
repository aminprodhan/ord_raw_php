<?php
$title = "Home Page";
startSection('content');
    ?>
        <div class="alert alert-primary" role="alert">
            New Order
        </div>
        <div>
            <form id="order_form" action="/order" method="POST" class="form-floating">
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body form-control" id="items_table">
                                <h5 class="card-title">Items</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 50%">Name</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Rate</th>
                                            <th scope="col">                                     
                                                <button id="add_item" type="button" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-plus-circle-dotted"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="items"></tbody>
                                    <tfoot>
                                        <tr>
                                            <th scope="col" colspan="2">
                                                <b>Total</b>
                                            </th>
                                            <th scope="col">
                                                <b id="total">0</b>
                                            </th>
                                        </tr>                                    
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-1">
                                    <label for="receipt_id" class="form-label">Receipt Id</label>
                                    <input type="text" name="receipt_id" class="form-control" id="receipt_id" placeholder="Enter Receipt Id">
                                </div>
                                <div class="mb-1">
                                    <label for="name" class="form-label">Buyer Name</label>
                                    <input type="text" name="buyer_name" class="form-control" id="buyer_name" placeholder="Enter Buyer Name">
                                </div>
                                <div class="mb-1">
                                    <label for="email">Buyer Email</label>
                                    <input type="email" name="buyer_email" class="form-control" id="buyer_email" placeholder="Email">
                                </div>
                                <div class="mb-1">
                                    <div class="row g-2">
                                        <div class="col-5">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" name="city" class="form-control" id="city" placeholder="Enter City">
                                        </div>
                                        <div class="col-7">
                                            <label for="phone" class="form-label">Phone</label>
                                            <div class="input-group flex-nowrap">
                                                <select name="country_code" class="form-select input-group-text" id="country_code">
                                                    <option value="880">BDT(880)</option>
                                                </select>
                                                <input name="phone" type="number" class="form-control" id="phone" placeholder="Enter Phone">
                                            </div>
                                        </div>
                                    </div>                                
                                </div>
                                <div class="mb-1">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea name="note" class="form-control" id="note" placeholder="Enter Note" rows="3"></textarea>
                                </div>
                                <div class="mb-1">
                                    <label for="entry_by" class="form-label">Entry By</label>
                                    <input name="entry_by" type="number" class="form-control" id="entry_by" placeholder="Enter Entry By">
                                </div>
                                <div class="mb-1">
                                    <button id="btn_submit" type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i>
                                        <span id="btn_submit_text">Submit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php
endSection();
startSection('scripts');
    ?>
        <script>
            //base URL
            const baseUrl = "<?php echo baseUrl('order/store'); ?>";
            console.log(baseUrl);
            $(document).ready(function() {
                console.log(document.cookie);
                
                $('#add_item').on('click', function() {
                    addItem();
                });
                $('#items').on('click', '#remove_item', function() {
                    let id = $(this).data('id');
                    $(`#item-${id}`).remove();
                    calculateTotal();
                });
                $(document).on('keyup','.td-item', function() {
                    calculateTotal();
                });
                $(document).on("input", ".td-item", function () {
                    calculateTotal();
                });
                //ajax form submit
                $('#order_form').on('submit', function(e) {
                    e.preventDefault();
                    let isValid=true;
                    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    let info=$(this).serializeArray();
                    info.forEach(element => {
                        if(element.value == '') {
                            $(`#${element.name}`).addClass('is-invalid');
                            isValid=false;
                        }
                        else {
                            if(element.name == 'buyer_email') {
                                if(!emailPattern.test(element.value)) {
                                    $(`#${element.name}`).addClass('is-invalid');
                                    isValid=false;
                                }
                                else
                                    $(`#${element.name}`).removeClass('is-invalid');
                            }else
                                $(`#${element.name}`).removeClass('is-invalid');
                        }
                    });
                    $('#items_table').removeClass('is-invalid');
                    const total=$('#total').text();                
                    if(total == '0') {
                        console.log("total=",total);
                        isValid=false;
                        $('#items_table').addClass('is-invalid');
                    }
                    if(isValid) {
                        
                        info = info.filter(item => item.name != 'country_code' && item.name != 'phone');
                        info.push({ name: 'phone', value: `${$('#country_code').val()}${$('#phone').val()}` });
                        info.push({ name: 'amount', value: total });
                        $('#btn_submit_text').text('Saving...');
                        $('#btn_submit').prop('disabled', true);
                        
                        ajaxCall('POST', baseUrl, info, function(response, error) {
                            if(error) {
                                $('#btn_submit_text').text('Submit');
                                $('#btn_submit').prop('disabled', false);
                            }
                            else{           
                                $('#btn_submit_text').text('Submit');
                                $('#btn_submit').prop('disabled', false);
                                if(response.status == 'success') {
                                    $('#order_form').trigger('reset');
                                    $('#items').empty();
                                    $('#total').text(0); 
                                }
                            }
                        });

                    }
                });
            });
            const addItem = () => {
                //count total items
                let count = $('#items tr').length;
                if(count >= 0) {
                    count = count + 1;
                }
                let tr=`<tr data-id="${count}" class="tr-items" id="item-${count}">
                            <td><input type="text" class="form-control td-item item-name-${count}" placeholder="Item Name" name="items[${count}]" /></td>
                            <td><input type="number"  class="form-control td-item item-qty-${count}" placeholder="Qty" name="qty[${count}]" /></td>
                            <td><input type="number"  class="form-control td-item item-rate-${count}" placeholder="Rate" name="rate[${count}]" /></td>
                            <td>
                                <button data-id="${count}" id="remove_item" type="button" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>`;
                $('#items').append(tr);
            }
            const calculateTotal = () => {
            //calculate total based on rate and Qty
            let total = 0;
            $('.tr-items').each(function() {
                let id = $(this).attr("data-id");
                let qty = $(`.item-qty-${id}`).val();
                let rate = $(`.item-rate-${id}`).val();
                let name = $(`.item-name-${id}`).val();
                if(name == '') {
                    $(`.item-name-${id}`).addClass('is-invalid');
                    return false;
                }
                else {
                    $(`.item-name-${id}`).removeClass('is-invalid');
                }
                total = total + (qty * rate);
            });
            $('#total').text(total);
        }
        </script>
    <?php
endSection();
extendLayout('layouts/master');