<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use Carbon\Carbon;

class StudentAuthController extends Controller
{
    public function showLoginForm()
    {
        $announcementDate = Setting::where('key', 'announcement_datetime')->value('value');
        $schoolLogo = Setting::where('key', 'school_logo')->value('value');
        $academicYear = Setting::where('key', 'academic_year')->value('value');
        $frontendTheme = Setting::where('key', 'frontend_theme')->value('value') ?? 'dark';
        $isTime = false;
        if ($announcementDate && Carbon::now()->gte(Carbon::parse($announcementDate))) {
            $isTime = true;
        }

        return view('student.login', compact('announcementDate', 'isTime', 'schoolLogo', 'academicYear', 'frontendTheme'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'nisn' => 'required',
            'password' => 'required',
        ]);

        $announcementDate = Setting::where('key', 'announcement_datetime')->value('value');
        if (!$announcementDate || Carbon::now()->lt(Carbon::parse($announcementDate))) {
            return back()->withErrors(['message' => 'Waktu pengumuman belum tiba.']);
        }

        if (Auth::guard('student')->attempt(['nisn' => $request->nisn, 'password' => $request->password])) {
            $student = Auth::guard('student')->user();
            $student->update(['has_logged_in' => true]);
            return redirect()->route('announcement.index');
        }

        return back()->withErrors(['message' => 'NISN atau Password salah.']);
    }

    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect()->route('student.login');
    }
}
