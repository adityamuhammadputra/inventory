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

            <div class="col-md-9 pt-4">
                <form method="POST" action="/api/v1/jasa?model={{ $data->model }}" class="form form-horizontal" id="form-submit">
                    @csrf
                    @method('POST')
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <select name="vendor_id" id="vendor_id" class="form-control select2" required>
                                <option value="" selected disabled></option>
                                @foreach ($data->vendor as $key => $val)
                                    <option value="{{ $val->id }}">{{ $val->kode }} - {{ $val->nama }} </option>
                                @endforeach
                            </select>
                            <label for="vendor_id">--Pilih Vendor--</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="text" id="kode" name="kode" class="form-control" placeholder="KodeOperator" value="" required>
                            <label id="kode-has-value" class="error kode-has-value" for="kode" style="display: none;"></label>
                            <label for="kode">Kode Petugas</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Operator" required>
                            <label for="nama">Nama Petugas</label>
                        </div>
                        <div class="form-label-group col-md-6">
                            <input type="text" id="harga" name="harga" class="form-control rupiah" placeholder="Harga Operator" required>
                            <label for="harga">Harga Petugas</label>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <select name="tugas" id="tugas" class="form-control select2" required>
                                <option value="" selected disabled></option>
                                <option value="Fotografer">Fotografer</option>
                                <option value="Videografer">Videografer</option>
                                <option value="SDE">SDE</option>
                                <option value="Crew">Crew</option>
                                <option value="EditorVideo">Editor Video</option>
                            </select>
                            <label for="tugas">--Pilih Tugas--</label>
                        </div>
                        <div class="form-label-group col-md-6 mt-4">
                            <button type="submit" class="btn btn-primary btn-square float-right" id="submit"><span class="fa fa-check-circle"></span> Simpan</button>
                            <a class="btn btn-secondary btn-square float-right text-white mr-2" id="btn-cancel" data-action="/api/v1/jasa?model={{ $data->model }}"  data-action="/api/v1/barang"> Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
