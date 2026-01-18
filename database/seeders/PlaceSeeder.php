<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $places = [
            'AMU',
            'Place Lagarde',
            'Agence PK12',
            'Agence de Nord',
            'Agence de Sud',
            'Maternité de Dar El hanan',
            'Hôpital régional d\'Arta',
            'Hôpital régional d\'Ali-Sabieh',
            'FNP',
            'Hôpital Al Rahma',
            'Hôpital général peltier',
            'Hôpital Militaire',
            'Hopital de Balbala (Cheikho)',
            'Clinique Le Héron',
            'Clinique AFFI',
            'Somclinique',
            'Centre Mutualis',
            'Polyclinique PK12',
            'Polyclinique Farah-Had',
            'Polyclinique Hayabley',
            'Labo-CS1',
            'Labo-CS2',
            'Urgence-CS1',
            'Salle-Prelevement-CS1',
            'Rdv-CS1',
            '2M DENTAL CLINIC',
            'PharmacieDétails-CS1',
            'Secretaire-Médicale-CS1',
            'DEV/DBA',
            'PF CM CNSS',
            'Retraite CNSS',
            'OQA CNSS',
            'CVR CNSS',
            'Comptabilité dépense CNSS',
            'Immatriculation CNSS',
            'Recouvrement CNSS',
            'Bureau des entrées CNSS',
            'Fichier Central CNSS',
            // Additional places from unmapped values
            'Bureau d\'entrée CS1',
            'CS1 Labo Urgence',
            'Pharmacie Urgence CS1',
            'Djibouti Medical Center',
            'Bureau des ordres',
        ];

        foreach ($places as $place) {
            // Check if place already exists before creating
            Place::firstOrCreate(
                ['name' => $place], // Search criteria
                ['created_by' => 1]  // Default values for new records
            );
        }
    }
}