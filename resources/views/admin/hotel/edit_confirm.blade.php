
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
    @vite('resources/scss/admin/create.scss')
@endsection


@section('main_contents')
    <div class="hotel-create">
        <h2 class="hotel-create__title">ホテル情報編集（確認）</h2>

        <table class="hotel-confirm">
            <tr>
                <th>ホテル名</th>
                <td>{{ $input['hotel_name'] }}</td>
            </tr>
            <tr>
                <th>都道府県</th>
                <td>{{ $prefecture->prefecture_name }}</td>
            </tr>
            <tr>
                <th>ホテル画像</th>
                <td>
                    @if ($imagePath)
                        <img src="{{ asset('assets/img/' . $imagePath) }}" alt="" style="max-width:240px;">
                    @else
                        なし
                    @endif
                </td>
            </tr>
        </table>


        <form action="{{ route('adminHotelEditProcess') }}" method="POST" style="display:inline;">
            @csrf
            <input type="hidden" name="hotel_id" value="{{ $input['hotel_id'] }}">
            <input type="hidden" name="hotel_name" value="{{ $input['hotel_name'] }}">
            <input type="hidden" name="prefecture_id" value="{{ $input['prefecture_id'] }}">
            <input type="hidden" name="temp_image" value="{{ $tempImage }}">
            <button type="submit" class="btn-submit">更新する</button>
        </form>

   
        <form action="{{ route('adminHotelEditBack') }}" method="POST" style="display:inline;">
            @csrf
            <input type="hidden" name="hotel_id" value="{{ $input['hotel_id'] }}">
            <input type="hidden" name="hotel_name" value="{{ $input['hotel_name'] }}">
            <input type="hidden" name="prefecture_id" value="{{ $input['prefecture_id'] }}">
            <input type="hidden" name="temp_image" value="{{ $tempImage }}">
            <button type="submit" class="btn-submit" style="background:#757575;">戻る</button>
        </form>
    </div>
@endsection
