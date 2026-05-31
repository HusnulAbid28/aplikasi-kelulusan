<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;

class AnnouncementController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $message = Setting::where('key', 'principal_message')->value('value');
        $academicYear = Setting::where('key', 'academic_year')->value('value');
        $frontendTheme = Setting::where('key', 'frontend_theme')->value('value') ?? 'dark';

        return view('student.announcement', compact('student', 'message', 'academicYear', 'frontendTheme'));
    }

    public function downloadPdf()
    {
        $student = Auth::guard('student')->user();
        $message = Setting::where('key', 'principal_message')->value('value');
        $academicYear = Setting::where('key', 'academic_year')->value('value');
        
        $pdf = Pdf::loadView('student.pdf', compact('student', 'message', 'academicYear'));
        return $pdf->download('Surat_Kelulusan_'.$student->nisn.'.pdf');
    }
}
