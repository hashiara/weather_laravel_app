<div class="form-content">
    <label for="birth" class="form-label">生年月日</label>
    <input type="date" id="birth" name="birth" class="form-control" value="{{ old('birth', $user->birth) }}">
</div>
<div class="text-danger">{{ $errors->first('birth') }}</div>