<div class="card">
    <div class="card-header">
        Form Input
        @if ($data->method == 'PATCH')
            @if ($data->rental->status == 2)
                <a class="btn btn-outline-primary float-right ml-2" href="/rental/{{ $data->rental->id }}/inv-docx"><span class="fa fa-print"></span> Cetak Invoice</a>
            @endif
            <a class="btn btn-outline-info float-right" href="/rental/{{ $data->rental->id }}/letter-docx"><span class="fa fa-print"></span> Cetak Letter</a>
        @else
        <a class="card-header-down float-right">
            <span data-feather="chevron-down"></span>
        </a>
        @endif

    </div>
    <div class="card-body card-form"
        style="{{ ($data->method == 'PATCH') ? '' : 'display: none;' }}"
        >
        <form method="POST" action="{{ $data->action }}" class="form form-horizontal" id="form-submit">
            @csrf
            @method($data->method)
            <div class="row">
                <div class="col-md-3">
                    <img src="/img/operator.jpg" class="img img-reponsive" style="width: 100%">
                </div>
                <div class="col-md-8 offset-md-1 pt-1">
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="text" id="noreg" name="noreg" class="form-control" placeholder="Rental Noreg" value="{{ $data->noReg }}" required>
                            <label id="noreg-has-value" class="error noreg-has-value" for="noreg" style="display: none;"></label>
                            <label for="noreg">Rental Noreg</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="text" id="nama" name="nama" class="form-control autocompleteNama" placeholder="Nama" required value="{{ $data->rental->nama ?? '' }}">
                            <label for="nama">Name </label>
                        </div>
                        <div class="form-label-group col-6">
                            <div class="custom-control custom-switch" style="top: 22px;">
                                <input type="checkbox" class="custom-control-input" id="checkMaster" checked>
                                <label class="custom-control-label" for="checkMaster">Take From Master</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="number" id="kontak" name="kontak" class="form-control" placeholder="kontak" required readonly value="{{ $data->rental->kontak ?? '' }}">
                            <label for="kontak">Contact</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <textarea id="alamat" name="alamat" class="form-control" placeholder="Alamat Client" required readonly>{{ $data->rental->alamat ?? '' }}</textarea>
                            <label for="alamat">Address</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-5">
                            <input type="text" id="start" name="start" class="form-control datepicker" placeholder="Rental Start" required value="{{ $data->dateNow }}">
                            <label for="start">Rental Date Start</label>
                        </div>
                        <div class="col-2 text-center">
                            <label class="">To</label>
                        </div>
                        <div class="form-label-group col-md-5">
                            <input type="text" id="end" name="end" class="form-control datepicker" placeholder="Rental End" required value="{{ $data->rental->end ?? $data->dateNow }}">
                            <label for="end">Rental Date End</label>
                        </div>
                    </div>
                </div>
                <div class="col-12 pt-2">
                    <div class="form-row row-multiple">
                        <div class="custom-control custom-switch" style="top: -10px;">
                            <input type="checkbox" class="custom-control-input" id="barcode_active" checked>
                            <label class="custom-control-label" for="barcode_active">Barcode Aktive</label>
                        </div>
                        <br>
                        <table class="table" id="table-eq">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th>Equipment Name</th>
                                    <th>Item Name</th>
                                    <th style="width: 80px">Day</th>
                                    <th>Price</th>
                                    <th class="text-right text-primary" style="width: 1%;"><a id="addEquipment"><span class="fa fa-plus"></span></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($data->rental->rentalBarangs) && count($data->rental->rentalBarangs) > 0 && $data->method == 'PATCH')
                                @foreach ($data->rental->rentalBarangs as $key => $barang)
                                @php $key = $key+1; @endphp
                                <tr id="{{ $key }}">
                                    <td class="text-center">{{ $key }}</td>
                                    <td>
                                        <input type="text" class="form-control autoCompleteEquipment equipment{{ $key }}" dataid="{{ $key }}" name="equpment[{{ $key }}]" value="{{ $barang->equpment }}">
                                    </td>
                                    <td>
                                        @foreach ($barang->rentalBarangItems as $keyItem => $item)
                                            <div class="input-group">
                                                <input type="text" class="form-control autoCompleteItem item{{ $key }}" dataid="{{ $key }}" name="item[{{ $key }}][{{ $keyItem }}]" value="{{ $item->equpment }}">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        @if ($keyItem == 0)
                                                        <a class="addItem" data-id="{{ $key }}"><span class="fa fa-plus"></span></a>
                                                        @else
                                                        <a class="removeItem" data-id="{{ $key }}"><span class="fa fa-trash"></span></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <input type="number" class="form-control day day{{ $key }} text-center" name="day[{{ $key }}]" dataid="{{ $key }}" tabindex="2000" value="{{ $barang->barang_qty }}">
                                    </td>
                                    <td><input type="text" class="form-control rupiah price price{{ $key }} text-right" name="price[{{ $key }}]" tabindex="2000"
                                        value="{{ outputRupiah($barang->barang_item_total) }}"></td>
                                    <td class="text-center"><a class="removeEquipment" data-id="{{ $key }}"><i class="fa fa-trash"></i></a></td>
                                </tr>
                                @endforeach
                                @else
                                <tr id="1">
                                    <td class="text-center">1</td>
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
                                    <td>
                                        <input type="number" class="form-control day day1 text-center" name="day[1]" dataid="1" tabindex="2000" value="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control rupiah price price1 text-right" name="price[1]" tabindex="2001">
                                    </td>
                                    <td></td>
                                </tr>
                                @endif
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right"><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="">
                                        <b>Sub Total </b>
                                    </td>
                                    <td colspan="2"><input type="text" class="form-control rupiah subtotal text-right" name="sub_total" required value="{{ $data->rental->sub_total ?? '' }}"></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="">
                                        <b>Diskon(%)</b>
                                    </td>
                                    <td colspan="2"><input type="text" class="form-control diskon text-right" name="diskon" value="{{ $data->rental->diskon ?? '' }}"></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="">
                                        <b>TOTAL </b>
                                    </td>
                                    <td colspan="2"><input type="text" class="form-control rupiah total text-right" name="total" readonly required value="{{ $data->rental->total ?? '' }}"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @if ($data->method == 'PATCH')
                        @if ($data->rental->status == 1)
                        <a class="btn btn-warning btn-square approveData"
                            data-id="{{ $data->rental->id }}" data-title="Rental #{{ $data->rental->title }}" data-url="/rental/{{ $data->rental->id }}/approve" >
                            <i class="fa fa-check"></i> Approve
                        </a>
                        <button type="submit" class="btn btn-primary btn-square float-right" id="change"><span class="fa fa-check-circle"></span> Save Changes</button>
                        @endif
                    <a class="btn btn-secondary btn-square float-right text-white mr-2" href="/rental"> Back</a>
                    @else
                    <button type="submit" class="btn btn-primary btn-square float-right" id="submit"><span class="fa fa-check-circle"></span> Save</button>
                    <a class="btn btn-secondary btn-square float-right text-white mr-2" id="btn-cancel" data-max-kode="true" data-action="/rental"> Cancel</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
