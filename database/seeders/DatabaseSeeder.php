<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Payment;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        // Super Admin (pas lié à une école)
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@schoolmanager.com',
        ]);
        $superAdmin->assignRole('super_admin');

        // École de démo
        $school = School::create([
            'name' => 'Institut Excellence',
            'slug' => 'institut-excellence',
            'email' => 'contact@excellence.sn',
            'phone' => '77 123 45 67',
            'address' => 'Dakar, Sénégal',
            'subscription_plan' => 'standard',
            'trial_ends_at' => now()->addDays(14),
        ]);

        // Admin de l'école
        $adminEcole = User::factory()->create([
            'name' => 'Directeur Diallo',
            'email' => 'directeur@excellence.sn',
            'school_id' => $school->id,
        ]);
        $adminEcole->assignRole('admin_ecole');

        // Classes
        $classes = [
            ['name' => '6ème A', 'level' => '6ème', 'section' => 'A', 'capacity' => 40],
            ['name' => '5ème A', 'level' => '5ème', 'section' => 'A', 'capacity' => 35],
            ['name' => '4ème A', 'level' => '4ème', 'section' => 'A', 'capacity' => 35],
        ];

        foreach ($classes as $class) {
            $class['school_id'] = $school->id;
            Classroom::create($class);
        }

        // Étudiants
        $students = [
            ['first_name' => 'Amadou', 'last_name' => 'Ba', 'gender' => 'M', 'classroom_id' => 1],
            ['first_name' => 'Fatou', 'last_name' => 'Diop', 'gender' => 'F', 'classroom_id' => 1],
            ['first_name' => 'Moussa', 'last_name' => 'Ndiaye', 'gender' => 'M', 'classroom_id' => 2],
            ['first_name' => 'Aïssatou', 'last_name' => 'Sow', 'gender' => 'F', 'classroom_id' => 2],
            ['first_name' => 'Ibrahima', 'last_name' => 'Fall', 'gender' => 'M', 'classroom_id' => 3],
        ];

        foreach ($students as $student) {
            $student['school_id'] = $school->id;
            $student['status'] = 'actif';
            Student::create($student);
        }

        // Paiements de démo
        $payments = [
            ['student_id' => 1, 'amount' => 25000, 'type' => 'inscription', 'payment_method' => 'especes', 'status' => 'paye', 'paid_at' => now()->subDays(30)],
            ['student_id' => 1, 'amount' => 15000, 'type' => 'mensualite', 'payment_method' => 'orange_money', 'status' => 'paye', 'paid_at' => now()->subDays(15)],
            ['student_id' => 2, 'amount' => 25000, 'type' => 'inscription', 'payment_method' => 'wave', 'status' => 'paye', 'paid_at' => now()->subDays(28)],
            ['student_id' => 2, 'amount' => 15000, 'type' => 'mensualite', 'payment_method' => 'especes', 'status' => 'en_attente', 'due_date' => now()->addDays(5)],
            ['student_id' => 3, 'amount' => 25000, 'type' => 'inscription', 'payment_method' => 'especes', 'status' => 'paye', 'paid_at' => now()->subDays(25)],
            ['student_id' => 4, 'amount' => 15000, 'type' => 'mensualite', 'payment_method' => 'especes', 'status' => 'en_retard', 'due_date' => now()->subDays(10)],
            ['student_id' => 5, 'amount' => 25000, 'type' => 'inscription', 'payment_method' => 'virement', 'status' => 'paye', 'paid_at' => now()->subDays(20)],
        ];

        foreach ($payments as $payment) {
            $payment['school_id'] = $school->id;
            Payment::create($payment);
        }

        // Matières pour la 6ème A (classroom_id = 1)
        $subjects = [
            ['name' => 'Mathématiques', 'coefficient' => 4, 'classroom_id' => 1],
            ['name' => 'Français', 'coefficient' => 4, 'classroom_id' => 1],
            ['name' => 'Anglais', 'coefficient' => 2, 'classroom_id' => 1],
            ['name' => 'Histoire-Géo', 'coefficient' => 2, 'classroom_id' => 1],
            ['name' => 'SVT', 'coefficient' => 2, 'classroom_id' => 1],
        ];

        foreach ($subjects as $subject) {
            $subject['school_id'] = $school->id;
            Subject::create($subject);
        }

        // Notes pour les 2 élèves de 6ème A (student_id 1 et 2)
        $notes = [
            ['student_id' => 1, 'subject_id' => 1, 'value' => 14, 'type' => 'devoir'],
            ['student_id' => 1, 'subject_id' => 1, 'value' => 12, 'type' => 'composition'],
            ['student_id' => 1, 'subject_id' => 2, 'value' => 11, 'type' => 'devoir'],
            ['student_id' => 1, 'subject_id' => 2, 'value' => 13, 'type' => 'composition'],
            ['student_id' => 1, 'subject_id' => 3, 'value' => 15, 'type' => 'devoir'],
            ['student_id' => 1, 'subject_id' => 4, 'value' => 12, 'type' => 'devoir'],
            ['student_id' => 1, 'subject_id' => 5, 'value' => 16, 'type' => 'devoir'],
            ['student_id' => 2, 'subject_id' => 1, 'value' => 9, 'type' => 'devoir'],
            ['student_id' => 2, 'subject_id' => 1, 'value' => 11, 'type' => 'composition'],
            ['student_id' => 2, 'subject_id' => 2, 'value' => 15, 'type' => 'devoir'],
            ['student_id' => 2, 'subject_id' => 2, 'value' => 14, 'type' => 'composition'],
            ['student_id' => 2, 'subject_id' => 3, 'value' => 8, 'type' => 'devoir'],
            ['student_id' => 2, 'subject_id' => 4, 'value' => 13, 'type' => 'devoir'],
            ['student_id' => 2, 'subject_id' => 5, 'value' => 10, 'type' => 'devoir'],
        ];

        foreach ($notes as $note) {
            $note['school_id'] = $school->id;
            $note['period'] = 'Trimestre 1';
            $note['max_value'] = 20;
            Grade::create($note);
        }

        // Présences de démo (5 derniers jours pour la 6ème A)
        $statuses = ['present', 'absent', 'retard', 'justifie'];
        $classroomId = 1;
        $studentIds = [1, 2];

        for ($i = 1; $i <= 5; $i++) {
            $date = now()->subDays($i);
            foreach ($studentIds as $studentId) {
                Attendance::create([
                    'school_id' => $school->id,
                    'student_id' => $studentId,
                    'classroom_id' => $classroomId,
                    'date' => $date,
                    'status' => $i === 3 && $studentId === 2 ? 'absent' : ($i === 4 && $studentId === 1 ? 'retard' : 'present'),
                ]);
            }
        }

        // Deuxième école (pour tester le multi-tenant)
        $school2 = School::create([
            'name' => 'École Avenir',
            'slug' => 'ecole-avenir',
            'email' => 'contact@avenir.sn',
            'phone' => '78 999 88 77',
            'address' => 'Saint-Louis, Sénégal',
            'subscription_plan' => 'basic',
            'trial_ends_at' => null,
        ]);

        $admin2 = User::factory()->create([
            'name' => 'Directrice Sy',
            'email' => 'directrice@avenir.sn',
            'school_id' => $school2->id,
        ]);
        $admin2->assignRole('admin_ecole');
    }
}
