<?php
\App\Models\Student::all()->each(function ($student) {
    $student->update(['password' => $student->nisn]);
});
echo "Done\n";
