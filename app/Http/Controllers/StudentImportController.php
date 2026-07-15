<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentImportController extends Controller
{
    public function show()
    {
        $classrooms = Classroom::all();
        return view('students.import', compact('classrooms'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        $file = $request->file('csv_file');
        $classroom = Classroom::findOrFail($request->classroom_id);

        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 0, ';');

        $imported = 0;
        $errors = [];
        $line = 1;

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            $line++;

            if (count($row) < 3) {
                $errors[] = "Ligne {$line}: données insuffisantes (minimum: prénom, nom, genre)";
                continue;
            }

            $firstName = trim($row[0]);
            $lastName = trim($row[1]);
            $gender = strtoupper(trim($row[2]));

            if (empty($firstName) || empty($lastName)) {
                $errors[] = "Ligne {$line}: prénom ou nom manquant";
                continue;
            }

            if (!in_array($gender, ['M', 'F'])) {
                $errors[] = "Ligne {$line}: genre invalide '{$gender}' (M ou F attendu)";
                continue;
            }

            Student::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'gender' => $gender,
                'classroom_id' => $classroom->id,
                'status' => 'actif',
            ]);

            $imported++;
        }

        fclose($handle);

        $message = "{$imported} élève(s) importé(s) avec succès dans {$classroom->name}.";
        if (!empty($errors)) {
            $message .= ' ' . count($errors) . ' erreur(s) rencontrée(s).';
        }

        return redirect()->route('students.import')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }
}
