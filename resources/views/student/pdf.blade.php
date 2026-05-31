<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Bukti Kelulusan</title>
    <style>
        body { font-family: sans-serif; padding: 40px; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .title { font-size: 24px; font-weight: bold; margin: 0; }
        .subtitle { font-size: 16px; margin-top: 5px; }
        .content { margin-bottom: 40px; }
        .student-info { margin-bottom: 30px; }
        .student-info table { width: 100%; }
        .student-info td { padding: 8px 0; }
        .status-box { border: 2px solid #22c55e; color: #22c55e; padding: 20px; text-align: center; font-size: 28px; font-weight: bold; margin: 30px 0; letter-spacing: 2px; }
        .footer { margin-top: 60px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">SD MUHAMMADIYAH 1 LAMONGAN</h1>
        <div class="subtitle">SURAT KETERANGAN LULUS</div>
        @if(isset($academicYear) && $academicYear)
            <div class="subtitle">TAHUN AJARAN {{ $academicYear }}</div>
        @endif
    </div>

    <div class="content">
        <p>Berdasarkan hasil rapat Dewan Guru SD Muhammadiyah 1 Lamongan, dengan ini menerangkan bahwa:</p>
        
        <div class="student-info">
            <table>
                <tr>
                    <td width="30%"><strong>Nama Lengkap</strong></td>
                    <td width="5%">:</td>
                    <td>{{ $student->name }}</td>
                </tr>
                <tr>
                    <td><strong>NISN</strong></td>
                    <td>:</td>
                    <td>{{ $student->nisn }}</td>
                </tr>
            </table>
        </div>

        <p>Dinyatakan:</p>

        <div class="status-box">
            LULUS
        </div>

        @if($message)
        <div style="margin-top: 30px; border-top: 1px dashed #ccc; padding-top: 20px; font-style: italic;">
            <strong>Pesan Kepala Sekolah:</strong><br>
            "{{ $message }}"
        </div>
        @endif
    </div>

    <div class="footer">
        <p>Lamongan, {{ date('d F Y') }}</p>
        <p>Kepala Sekolah</p>
        <br><br><br>
        <p><strong>( ______________________ )</strong></p>
    </div>
</body>
</html>
