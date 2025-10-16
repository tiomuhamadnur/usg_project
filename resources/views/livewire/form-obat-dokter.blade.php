<div>
    <div class="mb-3">
        <label class="form-label required" for="obat_id">Obat</label>
        <select class="form-select" wire:model.live='obat_id' name="obat_id" id="obat_id" required>
            <option value="" selected>- pilih obat -</option>
            @foreach ($obats as $item)
                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->sediaan->name ?? '-' }})</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label required" for="jumlah">Jumlah @if($obat) <span class="text-success">(Stock {{ $obat->name }}: {{ $obat->stock }} {{ $obat->unit->code ?? '' }})</span>@endif</label>
        <input type="number" class="form-control" name="jumlah" min="1" max="@if($obat){{ $obat->stock }}@endif" id="jumlah" required
            placeholder="input jumlah obat">
    </div>
</div>
