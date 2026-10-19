
@extends('common.admin.base')


@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
    @vite('resources/scss/admin/create.scss')
@endsection

@section('main_contents')
    <div class="hotel-create">
        <h2 class="hotel-create__title">ホテル新規登録</h2>

        @if (session('success'))
            <p class="hotel-create__success">{{ session('success') }}</p>
        @endif

        <form action="{{ route('adminHotelCreateProcess') }}" method="POST" enctype="multipart/form-data" class="hotel-create__form"
            novalidate>
            @csrf

            <div class="form-group">
                <label for="hotel_name">ホテル名 <span class="required">*</span></label>
                <input type="text" id="hotel_name" name="hotel_name" value="{{ old('hotel_name') }}" maxlength="255">
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
                            {{ old('prefecture_id') == $prefecture->prefecture_id ? 'selected' : '' }}>
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
                <input type="file" id="hotel_image" name="hotel_image" accept="image/jpeg,image/png,image/webp">
                @error('hotel_image')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-submit">登録する</button>
        </form>
    </div>
@endsection
