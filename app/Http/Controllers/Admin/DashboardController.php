<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\{
    User,
    Datasheet,
    UserRole
};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $labels_customer = [];
        $dataChartCustomer = [];

        // Set label as today's date
        $dayDate = Carbon::now();
        $labels_customer[] = $dayDate->format('d M Y');

        // Fetch data count for today
        $dayStart = Carbon::now()->startOfDay();
        $dayEnd = Carbon::now()->endOfDay();
        $companyRole = UserRole::where('role', 'Company Admin')->first();
        $dataChartCustomer[] = User::where('user_role_id', $companyRole->id)->whereNull('deleted_at')
            ->whereBetween('created_at', [$dayStart, $dayEnd])
            ->count();

        $labels_subadmin = [];
        $dataChartSubAdmin = [];

        // Set label as today's date
        $labels_subadmin[] = $dayDate->format('d M Y');

        // Fetch data count for today
        $dayStart = Carbon::now()->startOfDay();
        $dayEnd = Carbon::now()->endOfDay();
        $subAdminRole = UserRole::where('role', 'Sub Admin')->first();
        // $dataChartSubAdmin[] = User::where('user_role_id', $subAdminRole->id)->whereBetween('created_at', [$dayStart, $dayEnd])
        //     ->count();
        $adminRole = UserRole::whereNot('role', 'Super Admin')->where('type', 'Backend')->whereNull('deleted_at')->pluck('id')->toArray();
        $dataChartSubAdmin[] = User::whereIn('user_role_id', $adminRole)->whereBetween('created_at', [$dayStart, $dayEnd])
            ->count();

        if ($request->isMethod('post')) {
            $timePeriodCustomer = $request->input('time_period_customer');
            $timePeriodSubadmin = $request->input('time_period_subadmin');
            $labels_customer = [];
            $dataChartCustomer = [];
            $labels_subadmin = [];
            $dataChartSubAdmin = [];

            if ($timePeriodCustomer == "monthly") {
                // Get labels for January to December
                $currentMonth = Carbon::now()->month; // Get the current month

                for ($i = 1; $i <= $currentMonth; $i++) {
                    $monthDate = Carbon::create(null, $i, 1);
                    $labels_customer[] = $monthDate->format('M');

                    $monthStart = Carbon::create(null, $i, 1)->startOfMonth();
                    $monthEnd = Carbon::create(null, $i, 1)->endOfMonth();
                    $dataChartCustomer[] = User::whereNull('deleted_at')
                        ->where('user_role_id', $companyRole->id)
                        ->whereBetween('created_at', [$monthStart, $monthEnd])
                        ->count();
                }
            } elseif ($timePeriodCustomer == "weekly") {
                // Get labels for the last Privous Week
                $lastMonday = Carbon::now()->subWeek()->startOfWeek();
                for ($i = 0; $i <= 6; $i++) {
                    $dayDate = $lastMonday->copy()->addDays($i);
                    $labels_customer[] = substr($dayDate->format('D'), 0, 1);
                }

                // Fetch data counts for each day in the last week
                for ($i = 0; $i <= 6; $i++) {
                    $dayStart = $lastMonday->copy()->addDays($i)->startOfDay();
                    $dayEnd = $lastMonday->copy()->addDays($i)->endOfDay();
                    $dataChartCustomer[] = User::whereNull('deleted_at')
                        ->where('user_role_id', $companyRole->id)
                        ->whereBetween('created_at', [$dayStart, $dayEnd])
                        ->count();
                }
            } elseif ($timePeriodCustomer == "daily") {
                // Set label as today's date
                $labels_customer[] = $dayDate->format('d M Y');

                // Fetch data count for today
                $dayStart = Carbon::now()->startOfDay();
                $dayEnd = Carbon::now()->endOfDay();
                $dataChartCustomer[] = User::whereNull('deleted_at')
                    ->where('user_role_id', $companyRole->id)
                    ->whereBetween('created_at', [$dayStart, $dayEnd])
                    ->count();
            }
            if ($timePeriodSubadmin == "monthly") {
                // Get labels for January to December
                $currentMonth = Carbon::now()->month; // Get the current month

                for ($i = 1; $i <= $currentMonth; $i++) {
                    $monthDate = Carbon::create(null, $i, 1);
                    $labels_subadmin[] = $monthDate->format('M');

                    $monthStart = Carbon::create(null, $i, 1)->startOfMonth();
                    $monthEnd = Carbon::create(null, $i, 1)->endOfMonth();
                    $dataChartSubAdmin[] = User::whereNull('deleted_at')
                        ->whereIn('user_role_id', $adminRole)
                        ->whereBetween('created_at', [$monthStart, $monthEnd])
                        ->count();
                }
            } elseif ($timePeriodSubadmin == "weekly") {
                // Get labels for the last 10 weeks
                $lastMonday = Carbon::now()->subWeek()->startOfWeek();
                for ($i = 0; $i <= 6; $i++) {
                    $dayDate = $lastMonday->copy()->addDays($i);
                    $labels_subadmin[] = substr($dayDate->format('D'), 0, 1);
                }

                // Fetch data counts for each day in the last week
                for ($i = 0; $i <= 6; $i++) {
                    $dayStart = $lastMonday->copy()->addDays($i)->startOfDay();
                    $dayEnd = $lastMonday->copy()->addDays($i)->endOfDay();
                    $dataChartSubAdmin[] = User::whereNull('deleted_at')
                        ->whereIn('user_role_id', $adminRole)
                        ->whereBetween('created_at', [$dayStart, $dayEnd])
                        ->count();
                }
            } elseif ($timePeriodSubadmin == "daily") {
                // Set label as today's date
                $labels_subadmin[] = $dayDate->format('d M Y');

                // Fetch data count for today
                $dayStart = Carbon::now()->startOfDay();
                $dayEnd = Carbon::now()->endOfDay();
                $dataChartSubAdmin[] = User::whereNull('deleted_at')
                    ->whereIn('user_role_id', $adminRole)
                    ->whereBetween('created_at', [$dayStart, $dayEnd])
                    ->count();
            }
            return response()->json(['success' => true, 'labels_customer' => $labels_customer, 'dataChartCustomer' => $dataChartCustomer, 'labels_subadmin' => $labels_subadmin, 'dataChartSubAdmin' => $dataChartSubAdmin]);
        }
        $totalDatasheetsCount = Datasheet::whereNull('deleted_at')->count();
        // $totalSubAdminCount = User::where('user_role_id', $subAdminRole->id)->whereNull('deleted_at')->count();
        $totalSubAdminCount = User::whereIn('user_role_id', $adminRole)->whereNull('deleted_at')->count();
        $totalCustomerCount = User::where('user_role_id', $companyRole->id)->whereNull('deleted_at')->count();
        $userDetails = Auth::guard('admin')->user();

        $doughnutData = DB::table('datasheets')
            ->selectRaw(
                "
            COUNT(CASE WHEN status = '0' AND deleted_at IS NULL THEN 1 END) AS uploadedCount,
            COUNT(CASE WHEN status = '1' AND deleted_at IS NULL THEN 1 END) AS inProgressCount,
            COUNT(CASE WHEN status = '2' AND deleted_at IS NULL THEN 1 END) AS completedCount,
            COUNT(CASE WHEN status = '3' AND deleted_at IS NULL THEN 1 END) AS publishedCount,
            COUNT(CASE WHEN status = '4' AND deleted_at IS NULL THEN 1 END) AS failedCount,
            COUNT(CASE WHEN status = '5' AND deleted_at IS NULL THEN 1 END) AS draftCount,
            COUNT(*) AS totalDatasheetsCount"
            )
            ->whereNull('deleted_at')
            ->first();

        $colorcodeObject = json_encode(colorCodeStaticArray());

        return view('admin.dashboard', compact('userDetails', 'totalDatasheetsCount', 'totalSubAdminCount', 'totalCustomerCount', 'doughnutData', 'labels_customer', 'dataChartCustomer', 'labels_subadmin', 'dataChartSubAdmin', 'colorcodeObject'));
    }


    public function changePassword(Request $request)
    {
        $userDetails = Auth::guard('admin')->user();
        $userId = $userDetails->id;
        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => 'required|string',
                'password' => 'required|string|confirmed|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[^A-Za-z0-9]/',
                'password_confirmation' => 'required'
            ],
            [
                'current_password.required' => 'The current password field is required.',
                'password.required' => 'The new password field is required.',
                'password_confirmation.required' => 'The confirm password field is required.',
            ]
        );
        if ($validator->passes()) {

            if (Hash::check($request->current_password, Auth::guard('admin')->user()->password)) {
                if ($request->password == $request->password_confirmation) {
                    if (Hash::check($request->password, Auth::guard('admin')->user()->password)) {
                        return Response()->json(['old_password_as_current' => 'You can not set old password as new password']);
                    }
                    $user = User::where('id', $userId)->update(['password' => Hash::make($request->password)]);
                    return Response()->json(['success' => 'Your password has been successfully changed!']);
                } else {
                    return Response()->json(['field_not_match' => 'Password and confirm password is incorrect']);
                }
            } else {
                return Response()->json(['current_password' => 'Current password is incorrect']);
            }
        }
        return Response()->json(['errors' => $validator->errors()]);
    }
    public function print_chart(Request $request)
    {
        $totalDatasheets = $request->input('totalDatasheets');
        $totalSubAdminMembers = $request->input('totalSubAdminMembers');
        $totalCustomereMembers = $request->input('totalCustomereMembers');

        // $doughnutImageData = $request->input('doughnutImageData');
        // $barImageData = $request->input('barImageData');
        // $lineImageData = $request->input('lineImageData');
        $allChatArr = json_decode($request->input('allchart'), true);
        $chartBarArr = [];
        foreach ($allChatArr as $key => $barArr) {
            foreach ($barArr as $key => $value) {
                $chartBarArr[$key] = $value;
            }
        }

        $pdf = PDF::loadView('admin.dashboard_pdf', compact('totalDatasheets', 'totalSubAdminMembers', 'totalCustomereMembers', 'chartBarArr'));
        $timestamp = Carbon::now()->format('His');
        $timestamp = date('d-m-Y'); // Get current date and time with AM/PM
        $pdfName = 'report-' . $timestamp . '.pdf';
        // $pdfName = 'report' . $timestamp . '.pdf';
        return $pdf->download($pdfName);
    }
}
