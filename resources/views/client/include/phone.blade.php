<div class="form-group">
    <label for="company" class="col-sm-2 control-label">DDD</label>

    <div class="col-sm-1">
        <input class="form-control" name="mobile_ddd" placeholder="DDD"
               value="{{ old('mobile_ddd') }}">
    </div>
    <label for="company" class="col-sm-1 control-label">Celular</label>

    <div class="col-sm-2">
        <input class="form-control" name="mobile_number" placeholder="Celular"
               value="{{ old('mobile_number') }}">
    </div>
    <label for="company" class="col-sm-1 control-label">Operadora</label>

    <div class="col-sm-2">
        <select class="form-control" name="carrier_id">
            @foreach($carriers as $carrier)
                <option value="{{ $carrier->id }}"{{ $carrier->id == old('carrier_id') ? ' selected' : '' }}>
                    {{ $carrier->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<hr class="line-dashed line-full"/>