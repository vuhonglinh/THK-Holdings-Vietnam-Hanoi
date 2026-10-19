
@extends('common.admin.base')


@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
    @vite('resources/scss/admin/create.scss')
@endsection


@section('main_contents')
    <div class="hotel-create">
        <h2 class="hotel-create__title">ホテル情報編集（完了）</h2>
        <p class="hotel-create__success">ホテル情報を更新しました。</p>
        <a href="{{ route('adminHotelSearchPage') }}" class="btn-submit"
            style="text-decoration:none;display:inline-block;">検索画面へ戻る</a>
    </div>
@endsection
