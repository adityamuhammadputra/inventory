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
        <form method="POST" action="/rental" class="form form-horizontal" id="form-submit">
            <div class="row">
                <div class="col-md-3">
                    <img src="/img/operator.jpg" class="img img-reponsive" style="width: 100%">
                </div>
                <div class="col-md-8 offset-md-1 pt-1">
                    @csrf
                    @method('POST')
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="text" id="noreg" name="noreg" class="form-control" placeholder="Noreg Rental" value="{{ $data->noReg }}" required>
                            <label id="noreg-has-value" class="error noreg-has-value" for="noreg" style="display: none;"></label>
                            <label for="noreg">Noreg Rental</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="text" id="nama" name="nama" class="form-control autocompleteNama" placeholder="Nama" required>
                            <label for="nama">Nama </label>
                        </div>
                        <div class="form-label-group col-6">
                            <div class="custom-control custom-switch" style="top: 22px;">
                                <input type="checkbox" class="custom-control-input" id="checkMaster" checked>
                                <label class="custom-control-label" for="checkMaster">Ambil Dari Master</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="number" id="kontak" name="kontak" class="form-control" placeholder="kontak" required readonly>
                            <label for="kontak">Kontak</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <textarea id="alamat" name="alamat" class="form-control" placeholder="Alamat Client" required readonly></textarea>
                            <label for="alamat">Alamat</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-5">
                            <input type="text" id="start" name="start" class="form-control datepicker" placeholder="Rental Start" value="{{ $data->dateNow }}" required>
                            <label for="start">Rental Date Start</label>
                        </div>
                        <div class="col-2 text-center">
                            <label class="">s/d</label>
                        </div>
                        <div class="form-label-group col-md-5">
                            <input type="text" id="end" name="end" class="form-control datepicker" placeholder="Rental End" required>
                            <label for="end">Rental Date End</label>
                        </div>
                    </div>
                </div>
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
                                        <b>Sub Total </b>
                                    </td>
                                    <td colspan="2"><input type="text" class="form-control rupiah subtotal text-right" name="sub_total" required></td>
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
                    <a class="btn btn-secondary btn-square float-right text-white mr-2" id="btn-cancel" data-max-kode="true" data-action="/rental"> Batal</a>
                </div>
            </div>
        </form>

    </div>
</div>
