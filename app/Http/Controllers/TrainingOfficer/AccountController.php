<?php

namespace App\Http\Controllers\TrainingOfficer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingOfficerRequest;
use App\Http\Requests\TrainingOfficerUpdateRequest;
use App\Models\TrainingOfficer\TrainingOfficerAccount;
use App\Models\Office;
use App\Models\Faculty;
use App\Models\Division;
use App\Exports\TrainingOfficerAccountsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
{
    public function index()
    {
        $getAllTrainingOfficerAccount = TrainingOfficerAccount::withTrashed()
            ->with(['office', 'faculty', 'division'])
            ->orderBy('training_officer_accounts.created_at', 'DESC')
            ->paginate(10);

        $template = 'training_officer.account.account.pages.index';

        return view('training_officer.dashboard.layout', compact(
            'template',
            'getAllTrainingOfficerAccount',
        ));
    }

    public function create()
    {
        $offices = Office::where('status', true)->get();
        $faculties = Faculty::where('status', true)->get();
        $divisions = Division::where('status', true)->get();
        $template = "training_officer.account.account.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/training_officer.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/admin/plugins/ckeditor/ckeditor.js',
                '/admin/plugins/ckfinder_2/ckfinder.js',
                '/admin/lib/finder.js',
                '/admin/lib/library.js',
            ]
        ];

        $config['method'] = 'create';

        return view('training_officer.dashboard.layout', compact('template', 'config', 'offices', 'faculties', 'divisions'));
    }

    public function store(TrainingOfficerRequest $request)
    {
        $validatedData = $request->validated();

        // Create a new training officer account
        TrainingOfficerAccount::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'hometown' => $validatedData['hometown'],
            'office_id' => $validatedData['office_id'] ?? null,
            'faculty_id' => $validatedData['faculty_id'] ?? null,
            'division_id' => $validatedData['division_id'] ?? null,
            'created_by' => auth()->id(), // Assuming you have authentication set up
            'created_at' => now(),
        ]);

        // Redirect to the index page with a success message
        toastr()->success('Thêm mới cán bộ quản lí thành công');
            return redirect()->route('training_officer_account.index');
    }

    public function edit(Request $request, $id)
    {
        $getEdit = TrainingOfficerAccount::findOrFail($id);
        $offices = Office::where('status', true)->get();
        $faculties = Faculty::where('status', true)->get();
        $divisions = Division::where('status', true)->get();
        
        $request->session()->put('TrainingId', $id);

        // Store the current email in session

        $template = "training_officer.account.account.pages.store";

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                '/admin/css/training_officer.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/admin/plugins/ckeditor/ckeditor.js',
                '/admin/plugins/ckfinder_2/ckfinder.js',
                '/admin/lib/finder.js',
                '/admin/lib/library.js',
            ]
        ];

        $config['method'] = 'edit';

        return view('training_officer.dashboard.layout', compact('template', 'config', 'getEdit', 'offices', 'faculties', 'divisions'));
    }


    public function update(TrainingOfficerUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
    
        $trainingOfficerAccount = TrainingOfficerAccount::findOrFail($id);
    
        $trainingOfficerAccount->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'hometown' => $validatedData['hometown'],
            'office_id' => $validatedData['office_id'] ?? null,
            'faculty_id' => $validatedData['faculty_id'] ?? null,
            'division_id' => $validatedData['division_id'] ?? null,
            'updated_by' => auth()->id(),
            'updated_at' => now(),
        ]);
    
        toastr()->success('Tài khoản cán bộ đào tạo đã được cập nhật thành công.');
        return redirect()->route('training_officer_account.index');
    }


    public function destroy($id)
    {
        $trainingOfficerAccount = TrainingOfficerAccount::findOrFail($id);
        $trainingOfficerAccount->deleted_by = auth()->id();
        $trainingOfficerAccount->save();
        $trainingOfficerAccount->delete();
    
        toastr()->success('Tài khoản cán bộ đào tạo đã được ẩn');
        return redirect()->route('training_officer_account.index');
    }

    public function restore($id)
    {
        $trainingOfficerAccount = TrainingOfficerAccount::onlyTrashed()->findOrFail($id);
        $trainingOfficerAccount->restore();
    
        toastr()->success('Tài khoản cán bộ đào tạo đã được phục hồi thành công.');
        return redirect()->route('training_officer_account.index');
    }

    public function forceDelete($id)
    {
        $trainingOfficerAccount = TrainingOfficerAccount::onlyTrashed()->findOrFail($id);
        $trainingOfficerAccount->forceDelete();
    
        toastr()->success('Tài khoản cán bộ đào tạo đã bị xóa vĩnh viễn.');
        return redirect()->route('training_officer_account.index');
    }

    /**
     * Export training officer accounts to Excel
     */
    public function export(Request $request)
    {
        $keyword = $request->get('keyword');
        
        return Excel::download(new TrainingOfficerAccountsExport($keyword), 'danh_sach_can_bo_dao_tao_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}
