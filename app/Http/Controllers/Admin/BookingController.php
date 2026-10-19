<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $booking;

    public function __construct(
        Booking $booking
    ) {
        $this->booking = $booking;
    }

    public function showSearch()
    {
        return view('admin.booking.search');
    }

    public function searchResult(Request $request)
    {
        $input = $request->validate([
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_contact' => ['nullable', 'string', 'max:255'],
            'chekin_time' => ['nullable', 'date'],
            'chekout_time' => ['nullable', 'date', 'after_or_equal:chekin_time'],
        ], [
            'customer_name.max' => '顧客名は255文字以内で入力してください。',
            'customer_contact.max' => '顧客連絡先は255文字以内で入力してください。',
            'chekin_time.date' => 'チェックイン日時の形式が正しくありません。',
            'chekout_time.date' => 'チェックアウト日時の形式が正しくありません。',
            'chekout_time.after_or_equal' => 'チェックアウト日時はチェックイン日時以降を指定してください。',
        ]);

        $input = array_filter($input, fn($v) => $v !== null && $v !== '');

        if (empty($input)) {
            return back()->withInput()->with('empty_error', '何も入力されていません');
        }

        $query = $this->booking->with('hotel')->orderByDesc('created_at');

        if (isset($input['customer_name'])) {
            $query->where('customer_name', 'like', '%' . $this->escapeLike($input['customer_name']) . '%');
        }
        if (isset($input['customer_contact'])) {
            $query->where('customer_contact', 'like', '%' . $this->escapeLike($input['customer_contact']) . '%');
        }
        if (isset($input['chekin_time'])) {
            $query->where('chekin_time', '>=', $input['chekin_time']);
        }
        if (isset($input['chekout_time'])) {
            $query->where('chekout_time', '<=', $input['chekout_time']);
        }

        return view('admin.booking.result', [
            'bookingList' => $query->get(),
        ]);
    }

    private function escapeLike(string $value): string
    {
        return addcslashes($value, '%_\\');
    }
}
