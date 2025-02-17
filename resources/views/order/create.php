<?php
startSection('content');
    ?>
        <div class="d-flex alert alert-primary" role="alert">
            <div class="flex-grow-1">New Order</div>
            <div>
                <a href="<?php echo baseUrl('order/index') ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-list-ul"></i> List
                </a>
            </div>
        </div>
        <div>
            <form id="order_form" action="/order" method="POST" class="form-floating">
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body form-control" id="amount">
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
                            <div class="invalid-feedback">
                                Please provide at least one item
                            </div>
                            <div class="amount-invalid-feedback invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-1">
                                    <label for="receipt_id" class="form-label">Receipt Id</label>
                                    <input type="text" name="receipt_id" class="form-control" id="receipt_id" placeholder="Enter Receipt Id"/>
                                    <div class="invalid-feedback">
                                        Please provide a valid receipt id
                                    </div>
                                    <div class="invalid-feedback receipt_id-invalid-feedback"></div>
                                </div>
                                <div class="mb-1">
                                    <label for="name" class="form-label">Buyer Name</label>
                                    <input type="text" name="buyer_name" class="form-control" id="buyer_name" placeholder="Enter Buyer Name"/>
                                    <div class="invalid-feedback">
                                        Please provide a valid buyer name
                                    </div>
                                    <div class="invalid-feedback buyer_name-invalid-feedback"></div>
                                </div>
                                <div class="mb-1">
                                    <label for="email">Buyer Email</label>
                                    <input type="email" name="buyer_email" class="form-control" id="buyer_email" placeholder="Email"/>
                                    <div class="invalid-feedback">
                                        Please provide a valid email
                                    </div>
                                    <div class="invalid-feedback buyer_email-invalid-feedback"></div>
                                </div>
                                <div class="mb-1">
                                    <div class="row g-2">
                                        <div class="col-5">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" name="city" class="form-control" id="city" placeholder="Enter City"/>
                                            <div class="invalid-feedback">
                                                Please provide a valid city
                                            </div>
                                            <div class="invalid-feedback city-invalid-feedback"></div>
                                        </div>
                                        <div class="col-7">
                                            <label for="phone" class="form-label">Phone</label>
                                            <div class="input-group has-validation">
                                                <select name="country_code" class="form-select input-group-text" id="country_code">
                                                    <option value="880">BDT(880)</option>
                                                </select>
                                                <input name="phone" type="number" class="form-control" id="phone" placeholder="Enter Phone"/>
                                                <div class="invalid-feedback">
                                                    Please provide a valid phone
                                                </div>
                                                <div class="invalid-feedback phone-invalid-feedback"></div>  
                                            </div>
                                        </div>
                                    </div>                                
                                </div>
                                <div class="mb-1">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea name="note" class="form-control" id="note" placeholder="Enter Note" rows="3"></textarea>
                                    <div class="invalid-feedback">
                                        Please provide a valid note
                                    </div>
                                    <div class="invalid-feedback note-invalid-feedback"></div>
                                </div>
                                <div class="mb-1">
                                    <label for="entry_by" class="form-label">Entry By</label>
                                    <input name="entry_by" type="number" class="form-control" id="entry_by" placeholder="Enter Entry By"/>
                                    <div class="invalid-feedback">
                                        Please provide a valid entry by
                                    </div>
                                    <div class="invalid-feedback entry_by-invalid-feedback"></div>
                                </div>
                                <div class="mb-1">
                                    <label for="form_error" class="form-label"></label>
                                    <input  type="hidden" class="form-control" id="form_error"/>
                                    <div class="invalid-feedback form_error-invalid-feedback"></div>
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
                    let info=$(this).serializeArray();
                    info.forEach(element => {
                        if(element.value == '') {
                            $(`#${element.name}`).addClass('is-invalid');
                            isValid=false;
                        }
                        else {
                            if(['buyer_email','receipt_id','buyer_name','city'].includes(element.name)) {
                                //console.log("name=",element.name);
                                $(`#${element.name}`).addClass('is-invalid');
                                isValid=true;
                                if(!isValidAlphaNumeric(element.value) && element.name == 'buyer_name') {
                                    isValid=false;
                                }
                                else if(!isValidTextOnly(element.value) && element.name == 'receipt_id') {
                                    isValid=false;
                                }
                                else if(!isValidStringWithSpaces(element.value) && element.name == 'city') {
                                    isValid=false;
                                }
                                else if(!isValidEmail(element.value) && element.name == 'buyer_email') {
                                    isValid=false;
                                }
                                if(isValid)
                                    $(`#${element.name}`).removeClass('is-invalid');
                            }
                            else
                                $(`#${element.name}`).removeClass('is-invalid');
                        }
                    });
                    $('#amount').removeClass('is-invalid');
                    const total=$('#total').text();                
                    if(total == '0') {
                        console.log("total=",total);
                        isValid=false;
                        $('#amount').addClass('is-invalid');
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
                                const errors=response.responseJSON.errors;
                                if(errors) {
                                    Object.keys(errors).forEach(key => {
                                        $(`#${key}`).addClass('is-invalid');
                                        $(`.${key}-invalid-feedback`).addClass("is-invalid");
                                        $(`.${key}-invalid-feedback`).text(errors[key]);
                                    });
                                }
                            }
                            else{           
                                $('#btn_submit_text').text('Submit');
                                $('#btn_submit').prop('disabled', false);
                                if(response.status == 'success') {
                                    alert(response.message);
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
extendLayout('layouts/master',['title' => 'Create Order']);