@extends('admin.hotel.search')

@section('search_results')
    <div class="page-wrapper search-page-wrapper">
        <div class="search-result">
            <h3 class="search-result-title">検索結果</h3>
            @if (!empty($hotelList))
                <div class="table-scroll">
                    <table class="shopsearchlist_table">
                        <thead>
                            <tr>
                                <th>ホテル名</th>
                                <th>都道府県</th>
                                <th>登録日</th>
                                <th>更新日</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hotelList as $hotel)
                                <tr>
                                    <td data-label="ホテル名">
                                        <a href="" target="_blank">{{ $hotel['hotel_name'] }}</a>
                                    </td>
                                    <td data-label="都道府県">{{ $hotel['prefecture']['prefecture_name'] }}</td>
                                    <td data-label="登録日">{{ (string) $hotel['created_at'] }}</td>
                                    <td data-label="更新日">{{ (string) $hotel['updated_at'] }}</td>
                                    <td class="actions">
                                        <a href="{{ route('adminHotelEditPage', ['hotel_id' => $hotel['hotel_id']]) }}"
                                            class="btn-action">編集</a>
                                        <form action="{{ route('adminHotelDeleteProcess') }}" method="post"
                                            class="js-delete-form" data-hotel-name="{{ $hotel['hotel_name'] }}">
                                            @csrf
                                            <input type="hidden" name="hotel_id" value="{{ $hotel['hotel_id'] }}">
                                            <button type="submit" class="btn-action">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>検索結果がありません</p>
            @endif
        </div>
    </div>

    <script> 
        document.querySelectorAll('.js-delete-form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                var name = form.dataset.hotelName;
                var ok = window.confirm('「' + name + '」を削除してもよろしいですか？\nこの操作は元に戻せません。');
                if (!ok) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
