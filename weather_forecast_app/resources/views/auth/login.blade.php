<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <x-input-label>LineユーザーIDもしくはニックネームを入力してください。</x-input-label>
        @error('message')
        <p class="text-red-600">{{ $message }}</p>
        @enderror

        <!-- UserId -->
        <div class="mt-4">
            <x-input-label for="user_id" :value="__('LineユーザーID')" />
            <x-text-input id="user_id" class="block mt-1 w-full" name="user_id" :value="old('user_id')" autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
        </div>

        <!-- name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('ニックネーム')" />
            <x-text-input id="name" class="block mt-1 w-full" name="name" :value="old('name')" autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('パスワード')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                登録がまだお済みでない方はこちら
            </a>

            <x-primary-button class="ms-3">
                {{ __('ログイン') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
