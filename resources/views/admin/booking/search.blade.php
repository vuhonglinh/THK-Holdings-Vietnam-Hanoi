
@extends('common.admin.base')


@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
    @vite('resources/scss/admin/booking.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper booking-page-wrapper">
        <h2>予約情報検索</h2>

        <form action="{{ route('adminBookingSearchResult') }}" method="get" class="booking-search-form">
            <div class="form-row">
                <label for="customer_name">顧客名</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ request('customer_name') }}">
            </div>
            <div class="form-row">
                <label for="customer_contact">顧客連絡先</label>
                <input type="text" id="customer_contact" name="customer_contact"
                    value="{{ request('customer_contact') }}">
            </div>
            <div class="form-row">
                <label for="chekin_time">チェックイン日時</label>
                <input type="datetime-local" id="chekin_time" name="chekin_time" value="{{ request('chekin_time') }}">
                <span class="hint">以降</span>
            </div>
            <div class="form-row">
                <label for="chekout_time">チェックアウト日時</label>
                <input type="datetime-local" id="chekout_time" name="chekout_time" value="{{ request('chekout_time') }}">
                <span class="hint">以前</span>
            </div>

            <button type="submit">検索</button>

            @if (session('empty_error'))
                <p class="error-text">{{ session('empty_error') }}</p>
            @endif
            @foreach ($errors->all() as $error)
                <p class="error-text">{{ $error }}</p>
            @endforeach
        </form>

        @yield('booking_results')
    </div>
@endsection
