<form class="form" id="wrap-filter">
    <div class="card-body card-filter px-0 pb-0" style="display: none;">
        <div class="form-group col-md-3 mb-4">
            <div class="form-label-group input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">total >=</div>
                </div>
                <input type="text" id="total-filter" name="total" class="form-control rupiahFilter" placeholder="harga Barang" required>
            </div>
        </div>
        <div class="form-row form-group col-md-6">
            <div class="form-label-group col-5">
                <input type="text" id="date_start" name="date_start" class="form-control datepicker" placeholder="Rental Start" required value="{{ $data->dateNow }}">
                <label for="start">Event Date Start</label>
            </div>
            <div class="col-2 text-center">
                <label class="">To</label>
            </div>
            <div class="form-label-group col-md-5">
                <input type="text" id="end" name="end" class="form-control datepicker" placeholder="Rental End" required value="">
                <label for="end">Event Date End</label>
            </div>
        </div>
    </div>
    <label class="custom-control custom-checkbox label-approved">
        <input type="checkbox" class="custom-control-input" name="aproved" id="aproved-filter" value="1">
        <span class="custom-control-label">See Approved</span>
    </label>

    <a class="filter-export-transaksi text-secondary"><span class="mdi mdi-file-excel"></span>Export</a>
    <a class="filter-icon-transaksi"><span class="fa fa-filter"></span></a>
</form>
