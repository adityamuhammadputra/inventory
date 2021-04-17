<div class="card-body card-filter px-0 pb-0" style="display: none;">
    <form class="form" id="wrap-filter">
        <div class="form-group col-md-3">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="aproved" id="aproved-filter" value="1">
                <span class="custom-control-label">Lihat Approved</span>
            </label>
        </div>
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
                <input type="text" id="start" name="start" class="form-control datepicker" placeholder="Rental Start" required value="{{ $data->dateNow }}">
                <label for="start">Rental Date Start</label>
            </div>
            <div class="col-2 text-center">
                <label class="">s/d</label>
            </div>
            <div class="form-label-group col-md-5">
                <input type="text" id="end" name="end" class="form-control datepicker" placeholder="Rental End" required value="{{ $data->rental->end ?? '' }}">
                <label for="end">Rental Date End</label>
            </div>
        </div>
    </form>
</div>
