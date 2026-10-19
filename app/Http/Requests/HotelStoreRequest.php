<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hotel_name' => ['required', 'string', 'max:255', 'unique:hotels,hotel_name'],
            'prefecture_id' => ['required', 'integer', 'exists:prefectures,prefecture_id'],
            'hotel_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'hotel_name.required' => 'ホテル名を入力してください。',
            'hotel_name.max' => 'ホテル名は255文字以内で入力してください。',
            'hotel_name.unique' => 'このホテル名は既に登録されています。',
            'prefecture_id.required' => '都道府県を選択してください。',
            'prefecture_id.exists' => '正しい都道府県を選択してください。',
            'hotel_image.image' => '画像ファイルを選択してください。',
            'hotel_image.mimes' => '画像は jpeg, png, webp のいずれかにしてください。',
            'hotel_image.max' => '画像サイズは2MB以内にしてください。',
        ];
    }
}
