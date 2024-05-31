<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            天気予報地域
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            天気予報を送ってほしい地域を選択してください。
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="prefecture" :value="__('Prefecture')" />
            <div class="cp_ipselect cp_sl01">
                <select name="prefecture">
                    <option value="">選択されていません</option>
                    @foreach ($jsons as $json)
                        <option value="{{ $json['id'] }}" {{ old('prefecture', $user?->prefecture) == $json['id'] ? 'selected' : '' }}>{{ $json['name'] }}</option>
                    @endforeach
                </select>
                <div id="json-data" type="hidden" data-json="{{ json_encode($jsons) }}"></div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('prefecture')" />
        </div>

        <div>
            <x-input-label for="city" :value="__('City')" />
            <div class="cp_ipselect cp_sl01">
                <select name="city">
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
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Confirm') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
