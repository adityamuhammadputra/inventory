<form method="POST" action="/event" class="form form-horizontal" id="form-submit">
    @csrf
    @method('POST')
    <div class="card">
        <div class="card-header">
            Form Input
            <a class="card-header-down float-right">
                <span data-feather="chevron-down"></span>
            </a>
        </div>
        <div class="card-body card-form"
            {{-- style="display: none;" --}}
            >
            <div class="row">
                <div class="col-md-3">
                    <img src="/img/operator.jpg" class="img img-reponsive" style="width: 100%">
                </div>
                <div class="col-md-8 offset-md-1 pt-1">
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="text" id="noreg" name="noreg" class="form-control" placeholder="Noreg Rental" value="{{ $data->noReg }}" required>
                            <label id="noreg-has-value" class="error noreg-has-value" for="noreg" style="display: none;"></label>
                            <label for="noreg">Noreg Rental</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="text" id="vendor_name" name="vendor_name" class="form-control autocompleteVendor" placeholder="vendor_name" required>
                            <label for="vendor_name">Vendor Name</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="text" id="client_name" name="client_name" class="form-control autocompleteNama" placeholder="Client Name" required>
                            <label for="client_name">Client Name</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <textarea id="name" name="name" class="form-control" placeholder="Event Name" required></textarea>
                            <label for="name">Event Name</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <textarea id="location" name="location" class="form-control" placeholder="Event Location" required></textarea>
                            <label for="location">Event Location</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-3">
                            <input type="text" id="date" name="date" class="form-control datepicker" placeholder="Event Date" value="{{ $data->dateNow }}" required>
                            <label for="date">Event Date</label>
                        </div>
                        <div class="form-label-group col-md-3">
                            <input type="time" id="time" name="time" class="form-control" placeholder="Event Time" required>
                            <label for="time">Event Time</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Operator Input
            <a class="card-header-down float-right">
                <span data-feather="chevron-down"></span>
            </a>
        </div>
        <div class="card-body card-form">
            <div class="row">
                <div class="col-12 pt-2">
                    <div class="form-row row-multiple">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="1">
                                    <td>1. Camerament</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control autoCompleteOp op1" dataid="1" name="op[1][1]">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <a class="addOp" data-id="1"><span class="fa fa-plus"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control rupiah priceOp priceOp1 text-right" name="priceOp[1]" tabindex="20054"></td>
                                </tr>
                                <tr id="2">
                                    <td>2. Crew</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control autoCompleteOp op2" dataid="2" name="op[2][1]">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <a class="addOp" data-id="2"><span class="fa fa-plus"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control rupiah priceOp priceOp2 text-right" name="priceOp[2]" tabindex="20055"></td>
                                </tr>
                                <tr id="3">
                                    <td>3. SDE</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control autoCompleteOp op3" dataid="3" name="op[3][1]">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <a class="addOp" data-id="3"><span class="fa fa-plus"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control rupiah priceOp priceOp3 text-right" name="priceOp[3]" tabindex="20055"></td>
                                </tr>
                                <tr id="4">
                                    <td>4. Editor</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control autoCompleteOp op4" dataid="4" name="op[4][1]">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <a class="addOp" data-id="4"><span class="fa fa-plus"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control rupiah priceOp priceOp4 text-right" name="priceOp[4]" tabindex="20055"></td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="">
                                        <b>Sub Total Operator</b>
                                    </td>
                                    <td colspan="2">
                                        <input type="text" class="form-control rupiah subtotalOp text-right" name="sub_total_op">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Equipment Item Input
            <a class="card-header-down float-right">
                <span data-feather="chevron-down"></span>
            </a>
        </div>
        <div class="card-body card-form">
            <div class="row">
                <div class="col-12 pt-2">
                    <div class="form-row row-multiple">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Equipment Name</th>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th class="text-right text-primary" style="width: 1%;"><a id="addEquipment"><span class="fa fa-plus"></span></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="1">
                                    <td>1</td>
                                    <td>
                                        <input type="text" class="form-control autoCompleteEquipment equipment1" dataid="1" name="equpment[1]">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control autoCompleteItem item1" dataid="1" name="item[1][1]">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <a class="addItem" data-id="1"><span class="fa fa-plus"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control rupiah price price1 text-right" name="price[1]" tabindex="2000"></td>
                                    <td></td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="">
                                        <b>Sub Total Equipment Item</b>
                                    </td>
                                    <td colspan="2"><input type="text" class="form-control rupiah subtotal text-right" name="sub_total" required></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="">
                                        <b>Diskon(%)</b>
                                    </td>
                                    <td colspan="2"><input type="text" class="form-control diskon text-right" name="diskon"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="">
                                        <b>TOTAL </b>
                                    </td>
                                    <td colspan="2"><input type="text" class="form-control rupiah total text-right" name="total" readonly required></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary btn-square float-right" id="submit"><span class="fa fa-check-circle"></span> Simpan</button>
                    <a class="btn btn-secondary btn-square float-right text-white mr-2" id="btn-cancel" data-max-kode="true" data-action="/event"> Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
