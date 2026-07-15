<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\FeeStructure;
use App\Models\Grade;
use App\Models\Payment;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Rôles
        foreach (['super_admin', 'admin_ecole', 'enseignant', 'parent', 'secretaire'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // École
        $school = School::firstOrCreate(['name' => 'Institut Excellence de Dakar'], [
            'slug' => 'institut-excellence-dakar',
            'email' => 'contact@institut-excellence.sn',
            'phone' => '77 123 45 67',
            'address' => 'Rue 12, Médina, Dakar',
            'subscription_plan' => 'standard',
            'trial_ends_at' => now()->addYear(),
            'is_active' => true,
        ]);

        // Admin
        $admin = User::firstOrCreate(['email' => 'directeur@institut-excellence.sn'], [
            'name' => 'Directeur Diallo',
            'password' => bcrypt('password'),
            'school_id' => $school->id,
        ]);
        $admin->assignRole('admin_ecole');

        // Secrétaire
        $secretaire = User::firstOrCreate(['email' => 'secretaire@institut-excellence.sn'], [
            'name' => 'Awa Ndiaye',
            'password' => bcrypt('password'),
            'school_id' => $school->id,
        ]);
        $secretaire->assignRole('secretaire');

        // Classes
        $classesData = [
            ['name' => '6ème A', 'level' => '6ème'],
            ['name' => '6ème B', 'level' => '6ème'],
            ['name' => '5ème A', 'level' => '5ème'],
            ['name' => '5ème B', 'level' => '5ème'],
            ['name' => '4ème A', 'level' => '4ème'],
            ['name' => '3ème A', 'level' => '3ème'],
        ];

        $classrooms = [];
        foreach ($classesData as $c) {
            $classrooms[] = Classroom::firstOrCreate(
                ['name' => $c['name'], 'school_id' => $school->id],
                ['level' => $c['level'], 'school_id' => $school->id]
            );
        }

        // Matières par classe
        $subjectsData = [
            'Mathématiques' => 4,
            'Français' => 4,
            'Anglais' => 2,
            'SVT' => 2,
            'Physique-Chimie' => 2,
            'Histoire-Géo' => 2,
            'Éducation Physique' => 1,
            'Arabe' => 2,
        ];

        foreach ($classrooms as $classroom) {
            foreach ($subjectsData as $name => $coef) {
                Subject::firstOrCreate([
                    'name' => $name,
                    'classroom_id' => $classroom->id,
                    'school_id' => $school->id,
                ], [
                    'coefficient' => $coef,
                ]);
            }
        }

        // Enseignants
        $teachersData = [
            ['name' => 'M. Ibrahima Fall', 'email' => 'fall@institut-excellence.sn'],
            ['name' => 'Mme Coumba Diop', 'email' => 'diop@institut-excellence.sn'],
            ['name' => 'M. Ousmane Sarr', 'email' => 'sarr@institut-excellence.sn'],
        ];

        foreach ($teachersData as $t) {
            $teacher = User::firstOrCreate(['email' => $t['email']], [
                'name' => $t['name'],
                'password' => bcrypt('password'),
                'school_id' => $school->id,
            ]);
            $teacher->assignRole('enseignant');
            $teacher->classrooms()->syncWithoutDetaching([$classrooms[array_rand($classrooms)]->id]);
        }

        // Élèves (noms sénégalais réalistes)
        $prenomsMasculins = ['Amadou', 'Moussa', 'Ibrahima', 'Ousmane', 'Cheikh', 'Mamadou', 'Abdoulaye', 'Modou', 'Papa', 'Saliou', 'Alioune', 'Babacar', 'Malick', 'Seydou', 'Thierno'];
        $prenomsFeminins = ['Fatou', 'Aïssatou', 'Mariama', 'Aminata', 'Khady', 'Ndèye', 'Sokhna', 'Awa', 'Coumba', 'Daba', 'Mame', 'Rama', 'Yacine', 'Astou', 'Nabou'];
        $noms = ['Ba', 'Diallo', 'Diop', 'Fall', 'Gueye', 'Kane', 'Mbaye', 'Ndiaye', 'Sarr', 'Sow', 'Sy', 'Thiam', 'Wade', 'Cissé', 'Diouf', 'Faye', 'Seck', 'Tall', 'Touré', 'Niang'];

        $students = [];
        foreach ($classrooms as $classroom) {
            $count = rand(8, 12);
            for ($i = 0; $i < $count; $i++) {
                $gender = rand(0, 1) ? 'M' : 'F';
                $prenom = $gender === 'M'
                    ? $prenomsMasculins[array_rand($prenomsMasculins)]
                    : $prenomsFeminins[array_rand($prenomsFeminins)];
                $nom = $noms[array_rand($noms)];

                $student = Student::create([
                    'first_name' => $prenom,
                    'last_name' => $nom,
                    'gender' => $gender,
                    'birth_date' => Carbon::now()->subYears(rand(11, 17))->subDays(rand(1, 365))->toDateString(),
                    'classroom_id' => $classroom->id,
                    'school_id' => $school->id,
                    'status' => 'actif',
                    'parent_name' => ($gender === 'M' ? 'M.' : 'Mme') . ' ' . $noms[array_rand($noms)],
                    'parent_phone' => '77' . rand(100, 999) . rand(10, 99) . rand(10, 99),
                ]);
                $students[] = $student;
            }
        }

        // Frais scolaires
        foreach ($classrooms as $classroom) {
            FeeStructure::firstOrCreate([
                'classroom_id' => $classroom->id,
                'label' => 'Inscription',
                'school_id' => $school->id,
            ], [
                'type' => 'inscription',
                'amount' => 25000,
                'occurrences' => 1,
            ]);
            FeeStructure::firstOrCreate([
                'classroom_id' => $classroom->id,
                'label' => 'Mensualité',
                'school_id' => $school->id,
            ], [
                'type' => 'mensualite',
                'amount' => 15000,
                'occurrences' => 9,
            ]);
        }

        // Paiements
        foreach ($students as $student) {
            // Inscription payée pour tout le monde
            Payment::create([
                'student_id' => $student->id,
                'school_id' => $school->id,
                'amount' => 25000,
                'type' => 'inscription',
                'payment_method' => ['especes', 'orange_money', 'wave'][rand(0, 2)],
                'status' => 'paye',
                'paid_at' => Carbon::now()->subMonths(rand(2, 4)),
            ]);

            // Mensualités (certains à jour, certains en retard)
            $monthsPaid = rand(3, 9);
            for ($m = 1; $m <= $monthsPaid; $m++) {
                Payment::create([
                    'student_id' => $student->id,
                    'school_id' => $school->id,
                    'amount' => 15000,
                    'type' => 'mensualite',
                    'payment_method' => ['especes', 'orange_money', 'wave'][rand(0, 2)],
                    'status' => 'paye',
                    'paid_at' => Carbon::now()->subMonths($monthsPaid - $m + 1),
                ]);
            }

            // Ajouter des retards pour certains
            if (rand(1, 4) === 1) {
                Payment::create([
                    'student_id' => $student->id,
                    'school_id' => $school->id,
                    'amount' => 15000,
                    'type' => 'mensualite',
                    'payment_method' => 'especes',
                    'status' => 'en_retard',
                    'due_date' => Carbon::now()->subWeeks(rand(1, 4)),
                ]);
            }
        }

        // Notes (Trimestre 1)
        $subjects = Subject::where('school_id', $school->id)->get();
        foreach ($students as $student) {
            $studentSubjects = $subjects->where('classroom_id', $student->classroom_id);
            foreach ($studentSubjects as $subject) {
                // 2-3 notes par matière
                $notesCount = rand(2, 3);
                for ($n = 0; $n < $notesCount; $n++) {
                    Grade::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'school_id' => $school->id,
                        'period' => 'Trimestre 1',
                        'type' => $n === 0 ? 'composition' : 'devoir',
                        'value' => round(rand(4, 19) + rand(0, 1) * 0.5, 2),
                        'max_value' => 20,
                    ]);
                }
            }
        }

        // Présences (30 derniers jours)
        foreach ($students as $student) {
            for ($d = 1; $d <= 20; $d++) {
                $date = Carbon::now()->subDays($d);
                if ($date->isWeekend()) continue;

                Attendance::create([
                    'student_id' => $student->id,
                    'classroom_id' => $student->classroom_id,
                    'school_id' => $school->id,
                    'date' => $date->toDateString(),
                    'status' => rand(1, 10) <= 8 ? 'present' : (rand(0, 1) ? 'absent' : 'retard'),
                ]);
            }
        }

        $this->command->info("Données de démo créées :");
        $this->command->info("- 1 école : Institut Excellence de Dakar");
        $this->command->info("- Admin : directeur@institut-excellence.sn / password");
        $this->command->info("- Secrétaire : secretaire@institut-excellence.sn / password");
        $this->command->info("- " . count($classrooms) . " classes, " . count($students) . " élèves");
        $this->command->info("- Notes, paiements et présences générés");
    }
}
