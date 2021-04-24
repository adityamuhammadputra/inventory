<form method="POST" action="{{ $data->action }}" class="form form-horizontal" id="form-submit">
    @csrf
    @method($data->method)
    <div class="card">
        <div class="card-header">
            Form Input
            @if ($data->method == 'PATCH')
                @if ($data->event->status == 2)
                    <a class="btn btn-outline-primary float-right ml-2" href="/event/{{ $data->event->id }}/inv-docx"><span class="fa fa-print"></span> Cetak Invoice</a>
                @endif
            <a class="btn btn-outline-info float-right ml-2" href="/event/{{ $data->event->id }}/letter-docx"><span class="fa fa-print"></span> Letter</a>
            @else
            <a class="card-header-down float-right">
                <span data-feather="chevron-down"></span>
            </a>
            @endif
        </div>
        <div class="card-body card-form"
            style="{{ ($data->method == 'PATCH') ? '' : 'display: none;' }}"
            >
            <div class="row">
                <div class="col-md-3">
                    <img src="/img/operator.jpg" class="img img-reponsive" style="width: 100%">
                </div>
                <div class="col-md-8 offset-md-1 pt-1">
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="text" id="noreg" name="noreg" class="form-control" placeholder="Noreg Event" value="{{ $data->noReg }}" required>
                            <label id="noreg-has-value" class="error noreg-has-value" for="noreg" style="display: none;"></label>
                            <label for="noreg">Noreg Event</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="text" id="vendor_name" name="vendor_name" class="form-control autocompleteVendor" placeholder="vendor_name" required value="{{ $data->event->vendor_name ?? '' }}">
                            <label for="vendor_name">Vendor Name</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <input type="text" id="client_name" name="client_name" class="form-control autocompleteNama" placeholder="Client Name" required value="{{ $data->event->client_name ?? '' }}">
                            <label for="client_name">Client Name</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <textarea id="name" name="name" class="form-control" placeholder="Event Name" required>{{ $data->event->name ?? '' }}</textarea>
                            <label for="name">Event Name</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-6">
                            <textarea id="location" name="location" class="form-control" placeholder="Event Location" required>{{ $data->event->location ?? '' }}</textarea>
                            <label for="location">Event Location</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-3">
                            <input type="text" id="date_start" name="date_start" class="form-control datepicker" placeholder="Event Date" value="{{ $data->dateNow }}" required>
                            <label for="date_start">Event Date Start</label>
                        </div>
                        <div class="form-label-group col-md-3">
                            <input type="time" id="time_start" name="time_start" class="form-control" placeholder="Event Time" required value="{{ $data->event->time_start ?? '' }}">
                            <label for="time_start">Event Time Start</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-3">
                            <input type="text" id="date_end" name="date_end" class="form-control datepicker" placeholder="Event Date" value="{{ $data->dateTom }}" required>
                            <label for="date_end">Event Date End</label>
                        </div>
                        <div class="form-label-group col-md-3">
                            <input type="time" id="time_end" name="time_end" class="form-control" placeholder="Event Time" required value="{{ $data->event->time_end ?? '' }}">
                            <label for="time_end">Event Time End</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card"
        style="{{ ($data->method == 'PATCH') ? '' : 'display: none;' }}"
        >
        <div class="card-header">
            Operator Input
            @if ($data->method == 'PATCH')
            <a class="btn btn-outline-info float-right" href="/event/{{ $data->event->id }}/operator-docx"><span class="fa fa-print"></span> Payment Operator</a>
            @endif
        </div>
        <div class="card-body card-form">
            <div class="row">
                <div class="col-12 pt-2">
                    <div class="form-row row-multiple">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 5px;">#</th>
                                    <th>Operator Name</th>
                                    <th style="width: 100px;">Day</th>
                                    <th style="width: 190px">
                                        Price
                                        <a class="addOp float-right text-primary"><span class="fa fa-plus"></span></a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($data->event->eventOperator) && count($data->event->eventOperator) > 0 && $data->method == 'PATCH')
                                    @foreach ($data->event->eventOperator as $key => $item)
                                     <tr id="{{ $item->ids }}">
                                        <td class="text-center">{{ $item->ids }}</td>
                                        <td>
                                            <input type="text" class="form-control autoCompleteOp op{{ $item->ids }}" dataid="{{ $item->ids }}" name="op[{{ $item->ids }}]" tabindex="{{ $item->ids }}"
                                                value="{{ $item->op_name }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control dayOp dayOp{{ $item->ids }} text-ceneter" name="dayOp[{{ $item->ids }}]" dataid="{{ $item->ids }}" tabindex="100"
                                                value="{{ $item->operator_qty }}">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control rupiah priceOp priceOp{{ $item->ids }} text-right" name="priceOp[{{ $item->ids }}]" dataid="{{ $item->ids }}"
                                                    tabindex="101"
                                                    value="{{ $item->operator_total }}">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text" style="background: transparent; border: none;">
                                                        <a class="removeOp" data-id="{{ $item->ids }}"><span class="fa fa-trash"></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr id="1">
                                    <td class="text-center">1</td>
                                    <td>
                                        <input type="text" class="form-control autoCompleteOp op1" dataid="1" name="op[1]" tabindex="1">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control dayOp dayOp1 text-ceneter" name="dayOp[1]" dataid="1" tabindex="100" value="1">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control rupiah priceOp priceOp1 text-right" name="priceOp[1]" dataid="1" tabindex="101">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" style="color: transparent; background: transparent; border: none;">
                                                    <a class="removeOp" data-id="1"><span class="fa fa-trash"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
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
                                        <input type="text" class="form-control rupiah subtotalOp text-right" name="sub_total_op" value="{{ $data->event->sub_total_op ?? '' }}">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card"
        style="{{ ($data->method == 'PATCH') ? '' : 'display: none;' }}"
        >
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
                                    <th style="width: 5px;">#</th>
                                    <th>Equipment Name</th>
                                    <th>Item Name</th>
                                    <th style="width: 80px">Day</th>
                                    <th style="width: 190px">Price</th>
                                    <th class="text-right text-primary" style="width: 1%;"><a id="addEquipment"><span class="fa fa-plus"></span></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($data->event->eventBarangs) && count($data->event->eventBarangs) > 0 && $data->method == 'PATCH')
                                @foreach ($data->event->eventBarangs as $key => $barang)
                                @php $key = $key+1; @endphp
                                <tr id="{{ $key }}">
                                    <td class="text-center">{{ $key }}</td>
                                    <td>
                                        <input type="text" class="form-control autoCompleteEquipment equipment{{ $key }}" dataid="{{ $key }}" name="equpment[{{ $key }}]" value="{{ $barang->equpment }}">
                                    </td>
                                    <td>
                                        @foreach ($barang->eventBarangItems as $keyItem => $item)
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
                                    <td><input type="text" class="form-control rupiah price price{{ $key }} text-right" name="price[{{ $key }}]" tabindex="2000" value="{{ outputRupiah($barang->barang_item_total) }}"></td>
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
                                        <b>Sub Total Equipment Item</b>
                                    </td>
                                    <td colspan="2"><input type="text" class="form-control rupiah subtotal text-right" name="sub_total" required value="{{ $data->event->sub_total ?? '' }}"></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="">
                                        <b>Diskon(%)</b>
                                    </td>
                                    <td colspan="2"><input type="text" class="form-control diskon text-right" name="diskon" value="{{ $data->event->diskon ?? '' }}"></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="">
                                        <b>TOTAL </b>
                                    </td>
                                    <td colspan="2"><input type="text" class="form-control rupiah total text-right" name="total" readonly required value="{{ $data->event->total ?? '' }}"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @if ($data->method == 'PATCH')
                        @if ($data->event->status == 1)
                            <a class="btn btn-warning btn-square approveData"
                                data-id="{{ $data->event->id }}" data-title="Event #{{ $data->event->title }}" data-url="/event/{{ $data->event->id }}/approve" >
                                <i class="fa fa-check"></i> Approve
                            </a>
                            <button type="submit" class="btn btn-primary btn-square float-right" id="change"><span class="fa fa-check-circle"></span> Simpan Perubahan</button>
                        @endif
                        <a class="btn btn-secondary btn-square float-right text-white mr-2" href="/event"> Kembali</a>
                    @else
                        <button type="submit" class="btn btn-primary btn-square float-right" id="submit"><span class="fa fa-check-circle"></span> Simpan</button>
                        <a class="btn btn-secondary btn-square float-right text-white mr-2" id="btn-cancel" data-max-kode="true" data-action="/event"> Batal</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
