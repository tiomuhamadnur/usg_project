<div>
    <div class="row mb-4">
        <div class="col-12 col-md-3">
            <label class="form-label required">Provinsi</label>
            <select wire:model.live='provinsi_id' name="{{ $prefix }}provinsi_id" id="{{ $prefix }}provinsi_id" class="form-select" required>
                <option value="">- pilih provinsi -</option>
                @foreach ($provinsi as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label required">Kota/Kabupaten</label>
            <select wire:model.live="kota_id" name="{{ $prefix }}kota_id" id="{{ $prefix }}kota_id" class="form-select" {{ is_null($provinsi_id) ? 'disabled' : '' }} required>
                <option value="">- pilih kota/kabupaten -</option>
                @foreach ($kota as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label required">Kecamatan</label>
            <select wire:model.live="kecamatan_id" name="{{ $prefix }}kecamatan_id" id="{{ $prefix }}kecamatan_id" class="form-select" {{ is_null($kota_id) ? 'disabled' : '' }} required>
                <option value="">- pilih kecamatan -</option>
                @foreach ($kecamatan as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label required">Kelurahan</label>
            <select wire:model.live="kelurahan_id" name="{{ $prefix }}kelurahan_id" id="{{ $prefix }}kelurahan_id" class="form-select" {{ is_null($kecamatan_id) ? 'disabled' : '' }} required>
                <option value="">- pilih kelurahan -</option>
                @foreach ($kelurahan as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
