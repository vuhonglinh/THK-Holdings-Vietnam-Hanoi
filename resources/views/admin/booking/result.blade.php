@extends('admin.booking.search')

@section('booking_results')
    <div class="search-result">
        <h3 class="search-result-title">検索結果</h3>
        @if ($bookingList->isNotEmpty())
            <div class="table-scroll">
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>顧客名</th>
                            <th>顧客連絡先</th>
                            <th>チェックイン日時</th>
                            <th>チェックアウト日時</th>
                            <th>予約日時</th>
                            <th>情報更新日時</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookingList as $booking)
                            <tr>
                                <td data-label="顧客名">{{ $booking->customer_name }}</td>
                                <td data-label="顧客連絡先">{{ $booking->customer_contact }}</td>
                                <td data-label="チェックイン日時">{{ $booking->chekin_time?->format('Y-m-d H:i') }}</td>
                                <td data-label="チェックアウト日時">{{ $booking->chekout_time?->format('Y-m-d H:i') }}</td>
                                <td data-label="予約日時">{{ $booking->created_at?->format('Y-m-d H:i') }}</td>
                                <td data-label="情報更新日時">{{ $booking->updated_at?->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>検索結果がありません</p>
        @endif
    </div>
@endsection
