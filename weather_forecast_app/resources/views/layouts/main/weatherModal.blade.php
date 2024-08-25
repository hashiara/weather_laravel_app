<div class="text-center bg-white">
    <div class="collapse hamburger-content">
        <h1 class="hamburger" id="hamburger1">
            <a href="{{ route('main.index', ['title' => 'horoscope']) }}">
                星占い
            </a>
        </h1>
    </div>
    <div class="collapse hamburger-content">
        <h1 class="hamburger" id="hamburger2">
            <a href="{{ route('main.index', ['title' => 'trainStatus']) }}">
                路線情報
            </a>
        </h1>
    </div>
    <form id="logout_form" action="{{ route('logout') }}" method="POST" class="collapse hamburger-content">
        @csrf
        <h1 class="hamburger" id="hamburger3">
            <div>
                ログアウト
            </div>
        </h1>
    </form>
    <form id="delete_account_form" action="{{ route('account.delete') }}" method="POST" class="collapse hamburger-content" data-toggle="modal" data-target="#deleteAcountModal">
        @csrf
        @method('DELETE')
        <h1 class="hamburger" id="hamburger4">
            <div>
                アカウント削除
            </div>
        </h1>
    </form>
</div>