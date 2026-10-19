
@extends('common.admin.base')


@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
    @vite('resources/scss/admin/create.scss')
@endsection


@section('main_contents')
    <div class="hotel-create">
        <h2 class="hotel-create__title">ホテル情報編集（入力）</h2>

        <form action="{{ route('adminHotelEditConfirm') }}" method="POST" enctype="multipart/form-data"
            class="hotel-create__form" novalidate>
            @csrf
            <input type="hidden" name="hotel_id" value="{{ $hotel->hotel_id }}">
        
            <input type="hidden" name="temp_image" value="{{ old('temp_image') }}">

            <div class="form-group">
                <label for="hotel_name">ホテル名 <span class="required">*</span></label>
                <input type="text" id="hotel_name" name="hotel_name" maxlength="255"
                    value="{{ old('hotel_name', $hotel->hotel_name) }}">
                @error('hotel_name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="prefecture_id">都道府県 <span class="required">*</span></label>
                <select id="prefecture_id" name="prefecture_id">
                    <option value="">選択してください</option>
                    @foreach ($prefectures as $prefecture)
                        <option value="{{ $prefecture->prefecture_id }}"
                            {{ old('prefecture_id', $hotel->prefecture_id) == $prefecture->prefecture_id ? 'selected' : '' }}>
                            {{ $prefecture->prefecture_name }}
                        </option>
                    @endforeach
                </select>
                @error('prefecture_id')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="hotel_image">ホテル画像（任意）</label>

                @php
                    $preview = old('temp_image')
                        ? 'assets/img/hotel/tmp/' . old('temp_image')
                        : 'assets/img/' . $hotel->file_path;
                @endphp
                @if ($preview)
                    <img src="{{ asset($preview) }}" alt="{{ $hotel->hotel_name }}"
                        style="max-width:240px;margin-bottom:8px;">
                @endif

                <input type="file" id="hotel_image" name="hotel_image" accept="image/jpeg,image/png,image/webp">
                @error('hotel_image')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-submit">確認画面へ</button>
        </form>
    </div>
@endsection
