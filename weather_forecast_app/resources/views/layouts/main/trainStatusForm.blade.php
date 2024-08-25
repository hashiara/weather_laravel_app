
<div class="form-content">
    <label for="area_code" class="form-label">地域</label>
    <select id="area_code" name="area_code" class="form-select">
        <option value="">選択されていません</option>
        @foreach ($posts['areaList'] as $key => $areaList)
            <option value="{{ $key }}" {{ old('area_code', $user?->area_code) == $key ? 'selected' : '' }}>{{ $areaList }}</option>
        @endforeach
    </select>
    <div id="json-data" type="hidden" data-json="{{ json_encode($posts) }}"></div>
</div>
<div class="text-danger">{{ $errors->first('area_code') }}</div>

<div class="form-content">
    <label for="rail_order" class="form-label">路線</label>
    <select id="rail_order" name="rail_order" class="form-select">
    <option value="">選択しない</option>
    @foreach ($posts['data'] as $key => $data)
        @if ($user?->area_code == $key)
            @foreach ($data as $key => $railList)
                <option value="{{ $key }}" {{ old('rail_order', $user?->rail_order) == $key ? 'selected' : '' }}>{{ $railList['railName'] }}</option>
            @endforeach
        @endif
    @endforeach
    </select>
</div>
<div class="text-danger">{{ $errors->first('rail_order') }}</div>