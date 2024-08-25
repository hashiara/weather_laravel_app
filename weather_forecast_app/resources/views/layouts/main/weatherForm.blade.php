<div class="form-content">
    <label for="prefecture" class="form-label">都道府県</label>
    <select id="prefecture" name="prefecture" class="form-select">
        <option value="">選択されていません</option>
        @foreach ($jsons as $json)
            <option value="{{ $json['id'] }}" {{ old('prefecture', $user?->prefecture) == $json['id'] ? 'selected' : '' }}>{{ $json['name'] }}</option>
        @endforeach
    </select>
    <div id="json-data" type="hidden" data-json="{{ json_encode($jsons) }}"></div>
</div>
<div class="text-danger">{{ $errors->first('prefecture') }}</div>

<div class="form-content">
    <label for="city" class="form-label">市区町村</label>
    <select id="city" name="city" class="form-select">
    <option value="">選択しない</option>
    @foreach ($jsons as $json)
        @if ($user?->prefecture == $json['id'])
            @foreach ($json['city'] as $city)
                <option value="{{ $city['id'] }}" {{ old('city', $user?->city) == $city['id'] ? 'selected' : '' }}>{{ $city['name'] }}</option>
            @endforeach
        @endif
    @endforeach
    </select>
</div>
<div class="text-danger">{{ $errors->first('city') }}</div>