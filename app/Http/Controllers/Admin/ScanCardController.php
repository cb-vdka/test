<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ScanCardController extends Controller
{
    public function index()
    {
        $userInfos = UserInfo::all()->map(function ($userInfo) {
            $userInfo->date_of_birth = $userInfo->date_of_birth ? Carbon::parse($userInfo->date_of_birth) : null;
            $userInfo->doe = $userInfo->doe ? Carbon::parse($userInfo->doe) : null;
            return $userInfo;
        });

        $template = "admin.teacher.teacherscan.pages.index";
        return view('admin.dashboard.layout', compact('template', 'userInfos'));
    }
    public function show($id)
    {
        // Find the user information by ID
        $userInfo = UserInfo::findOrFail($id);

        // Convert date_of_birth and doe to Carbon instances
        $userInfo->date_of_birth = $userInfo->date_of_birth ? Carbon::parse($userInfo->date_of_birth) : null;
        $userInfo->doe = $userInfo->doe ? Carbon::parse($userInfo->doe) : null;

        // Pass the user info to the view
        $template = "admin.teacher.teacherscan.pages.show"; // Adjust the template path as necessary
        return view('admin.dashboard.layout', compact('template', 'userInfo'));
    }




    public function create()
    {
        $template = "admin.teacher.teacherscan.pages.store";
        return view('admin.dashboard.layout', compact('template'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'cccd_front' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cccd_back' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Store the images and get the paths
        $frontImagePath = $request->file('cccd_front')->store('cccd_images');
        $backImagePath = $request->file('cccd_back')->store('cccd_images');
    
        // Process both images
        $frontData = $this->processImage($frontImagePath);
        $backData = $this->processImage($backImagePath);
    
        // Merge front and back data, prioritize front data
        $data = array_merge($backData, $frontData);
    
        // Add the image paths to the data array
        $data['cccd_front_image'] = $frontImagePath;
        $data['cccd_back_image'] = $backImagePath;
    
        // Return the view with extracted data
        if (!empty($data)) {
            return view('admin.dashboard.layout', [
                'template' => "admin.teacher.teacherscan.pages.store",
                'data' => $data
            ]);
        } else {
            return redirect()->back()->with('error', 'Không thể trích xuất thông tin từ ảnh.');
        }
    }
    
    public function save(Request $request)
    {
        // Validate and save the information to the database
        $userInfo = new UserInfo();
    
        $userInfo->name = $request->input('name');
        $dob = $request->input('dob');
        $doe = $request->input('doe');
    
        $userInfo->date_of_birth = $dob ? Carbon::createFromFormat('d/m/Y', $dob)->format('Y-m-d') : null;
        $userInfo->age = $dob ? $this->calculateAge($userInfo->date_of_birth) : 0;
    
        $userInfo->gender = $request->input('sex') ?? 'N/A';
        $userInfo->id_number = $request->input('id_number');
        $userInfo->nationality = $request->input('nationality') ?? 'N/A';
        $userInfo->home = $request->input('home') ?? 'N/A';
        $userInfo->address = $request->input('address') ?? 'N/A';
        $userInfo->province = $request->input('province') ?? 'N/A';
        $userInfo->district = $request->input('district') ?? 'N/A';
        $userInfo->ward = $request->input('ward') ?? 'N/A';
        $userInfo->street = $request->input('street') ?? 'N/A';
        $userInfo->doe = $doe ? Carbon::createFromFormat('d/m/Y', $doe)->format('Y-m-d') : null;
    
        // Ensure the images are saved correctly
        $userInfo->cccd_front_image = $request->input('cccd_front') ?? $request->input('cccd_front_image');
        $userInfo->cccd_back_image = $request->input('cccd_back') ?? $request->input('cccd_back_image');
    
        // Save the information
        $userInfo->save();
    
        // Redirect back with success message
        toastr()->success('Thông tin đã được lưu thành công');
        return redirect()->route('teacher.scan');
    }
    


    private function processImage($imagePath)
    {
        // Get the full path to the image
        $fullImagePath = storage_path('app/' . $imagePath);

        // Send the POST request to the API
        $response = Http::withHeaders([
            'api-key' => 'D8cx3dWR8PbCnTHT3ICeUMImCPMFfHqI',
        ])->attach(
            'image',
            file_get_contents($fullImagePath),
            'image.jpg'
        )->post('https://api.fpt.ai/reader/predict/66b845c915ed2bc92fbc4dd5?direct=true');

        // Process the response
        $ocrData = $response->json();
        return $ocrData['data'][0] ?? [];
    }

    private function calculateAge($date_of_birth)
    {
        return Carbon::parse($date_of_birth)->age;
    }
    public function destroy($id)
    {
        // Tìm thông tin người dùng theo ID
        $userInfo = UserInfo::findOrFail($id);

        // Xóa thông tin người dùng
        $userInfo->delete();

        // Redirect back with success message
        toastr()->success('Thông tin đã được xóa thành công');
        return redirect()->route('teacher.scan');
    }
}
