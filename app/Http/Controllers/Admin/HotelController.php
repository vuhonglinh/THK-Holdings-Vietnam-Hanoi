<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelStoreRequest;
use App\Http\Requests\HotelUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Hotel;
use App\Models\Prefecture;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class HotelController extends Controller
{

    protected $prefecture;

    public function __construct(
        Prefecture $prefecture
    ) {
        $this->prefecture = $prefecture;
    }

    /** get methods */

    public function showSearch(): View
    {
        $prefectures = $this->prefecture
            ->orderBy('prefecture_id')
            ->get(['prefecture_id', 'prefecture_name']);

        return view('admin.hotel.search', ['prefectures' => $prefectures]);
    }

    public function showResult(): View
    {
        return view('admin.hotel.result');
    }

    public function showEdit($hotel_id): View
    {
        $hotel = Hotel::findOrFail($hotel_id);
        $prefectures = Prefecture::orderBy('prefecture_id')->get();
        return view('admin.hotel.edit', ['hotel' => $hotel, 'prefectures' => $prefectures]);
    }

    public function showCreate(): View
    {
        $prefectures = $this->prefecture
            ->orderBy('prefecture_id')
            ->get(['prefecture_id', 'prefecture_name']);

        return view('admin.hotel.create', ['prefectures' => $prefectures]);
    }

    /** post methods */

    public function searchResult(Request $request): View|RedirectResponse
    {

        $hotelName = trim((string) $request->input('hotel_name', ''));
        $prefectureId = $request->input('prefecture_id');

        if ($hotelName === '' && empty($prefectureId)) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['search' => '何も入力されていません']);
        }

        $var = [];
        $var['hotelList'] = Hotel::getHotelListByName($hotelName, $prefectureId);
        $var['prefectures'] = $this->prefecture->get(['prefecture_id', 'prefecture_name']);

        return view('admin.hotel.result', $var);
    }

    public function edit(HotelUpdateRequest $request)
    {
        $data = $request->validated();

        $hotel = Hotel::findOrFail($data['hotel_id']);
        $hotel->hotel_name = $data['hotel_name'];
        $hotel->prefecture_id = $data['prefecture_id'];
        $oldPath = $hotel->file_path;

        $tempImage = basename((string) $request->input('temp_image'));
        $tempFull = public_path('assets/img/hotel/tmp/' . $tempImage);
        if ($tempImage && File::exists($tempFull)) {
            $newName = uniqid('hotel_') . '.' . pathinfo($tempImage, PATHINFO_EXTENSION);
            File::copy($tempFull, public_path('assets/img/hotel/' . $newName));
            File::delete($tempFull);
            $hotel->file_path = 'hotel/' . $newName;
        }

        $hotel->save();

        if (
            $oldPath
            && $oldPath !== $hotel->file_path
            && !str_contains($oldPath, '..')
            && !Hotel::where('file_path', $oldPath)->exists()
        ) {
            File::delete(public_path('assets/img/' . $oldPath));
        }

        return redirect()->route('adminHotelEditComplete');
    }
    public function editConfirm(HotelUpdateRequest $request)
    {
        $input = $request->only(['hotel_id', 'hotel_name', 'prefecture_id']);
        $tempImage = basename((string) $request->input('temp_image'));

        if ($request->hasFile('hotel_image')) {
            $dir = public_path('assets/img/hotel/tmp');
            File::ensureDirectoryExists($dir);
            $file = $request->file('hotel_image');
            $tempImage = uniqid('tmp_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $tempImage);
        }

        $hotel = Hotel::findOrFail($input['hotel_id']);

        $tempExists = $tempImage && File::exists(public_path('assets/img/hotel/tmp/' . $tempImage));
        $imagePath = $tempExists ? 'hotel/tmp/' . $tempImage : $hotel->file_path;
        $tempImage = $tempExists ? $tempImage : '';

        $prefecture = Prefecture::findOrFail($input['prefecture_id']);
        return view('admin.hotel.edit_confirm', compact('input', 'prefecture', 'imagePath', 'tempImage'));
    }
    public function editBack(Request $request)
    {
        return redirect()
            ->route('adminHotelEditPage', ['hotel_id' => $request->input('hotel_id')])
            ->withInput($request->only(['hotel_name', 'prefecture_id', 'temp_image']));
    }

    public function editComplete()
    {
        return view('admin.hotel.edit_complete');
    }
    public function create(HotelStoreRequest $request)
    {
        $filePath = null;
        if ($request->hasFile('hotel_image')) {
            $file = $request->file('hotel_image');
            $fileName = uniqid('hotel_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/hotel'), $fileName);
            $filePath = 'hotel/' . $fileName;
        }

        Hotel::create([
            'hotel_name' => $request->hotel_name,
            'prefecture_id' => $request->prefecture_id,
            'file_path' => $filePath,
        ]);

        return redirect()->route('adminHotelCreatePage')->with('success', 'ホテルを登録しました。');
    }

    public function delete(Request $request)
    {
        $hotel = Hotel::findOrFail($request->input('hotel_id'));
        $hotelName = $hotel->hotel_name;
        $filePath = $hotel->file_path;

        $hotel->delete();

        if (
            $filePath
            && !str_contains($filePath, '..')
            && !Hotel::where('file_path', $filePath)->exists()
        ) {
            File::delete(public_path('assets/img/' . $filePath));
        }
        return redirect()
            ->route('adminHotelSearchPage')
            ->with('success', "「{$hotelName}」を削除しました。");
    }
}
