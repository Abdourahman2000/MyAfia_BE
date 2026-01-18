<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Place;

class UpdateUserPlaceIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update-place-ids {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update users place_id based on existing place values';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        // Mapping between old place values and new place names
        $placeMapping = [
            'depart_amu' => 'AMU',
            'agence_lagarde' => 'Place Lagarde',
            'agence_pk12' => 'Agence PK12',
            'agence_nord' => 'Agence de Nord',
            'agence_sud' => 'Agence de Sud',
            'dar_El_hanan' => 'Maternité de Dar El hanan',
            'hopital_regional_arta' => 'Hôpital régional d\'Arta',
            'hopital_regional_ali_Sabieh' => 'Hôpital régional d\'Ali-Sabieh',
            'hopital_fnp' => 'FNP',
            'alrahma_hospital' => 'Hôpital Al Rahma',
            'hopital_general_peltier' => 'Hôpital général peltier',
            'hopital_militaire' => 'Hôpital Militaire',
            'hopital_de_balbala_cheikho' => 'Hopital de Balbala (Cheikho)',
            'clinique_le_heron' => 'Clinique Le Héron',
            'clinique_affi' => 'Clinique AFFI',
            'somclinique' => 'Somclinique',
            'centre_mutualis' => 'Centre Mutualis',
            'polyclinique_pk12' => 'Polyclinique PK12',
            'polyclinique_farah_had' => 'Polyclinique Farah-Had',
            'polyclinique_hayabley' => 'Polyclinique Hayabley',
            'labo_cs1' => 'Labo-CS1',
            'labo_cs2' => 'Labo-CS2',
            'urgence_cs1' => 'Urgence-CS1',
            'salle_prelevement_cs1' => 'Salle-Prelevement-CS1',
            'rdv_cs1' => 'Rdv-CS1',
            '2M DENTAL CLINIC' => '2M DENTAL CLINIC',
            'pharmaciedétails_cs1' => 'PharmacieDétails-CS1',
            'secretaire_médicale_cs1' => 'Secretaire-Médicale-CS1',
            'dev_dba' => 'DEV/DBA',
            'PF-CM_CNSS' => 'PF CM CNSS',
            'Retraite-CNSS' => 'Retraite CNSS',
            'OQA-CNSS' => 'OQA CNSS',
            'CVR-CNSS' => 'CVR CNSS',
            'Comptabilité-depense-CNSS' => 'Comptabilité dépense CNSS',
            'Immatriculation_CNSS' => 'Immatriculation CNSS',
            'Recouvrement_CNSS' => 'Recouvrement CNSS',
            'Bureau_des_entrées_CNSS' => 'Bureau des entrées CNSS',
            'Fichier-Central_CNSS' => 'Fichier Central CNSS',
            // Additional unmapped values
            'bureau_d_entree_cs1' => 'Bureau d\'entrée CS1',
            'cs1_labo_urgence' => 'CS1 Labo Urgence',
            'pharmacie_urgence_cs1' => 'Pharmacie Urgence CS1',
            'djibouti_medical_center' => 'Djibouti Medical Center',
            'Bureau_des_ordres' => 'Bureau des ordres',
        ];

        // Get all places indexed by name for quick lookup
        $places = Place::pluck('id', 'name')->toArray();

        // Get users with place values but no place_id
        $users = User::whereNotNull('place')->get();

        if ($users->isEmpty()) {
            $this->info('No users found with place values to update.');
            return;
        }

        $this->info("Found {$users->count()} users with place values.");
        
        if ($dryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        $updated = 0;
        $warnings = 0;

        foreach ($users as $user) {
            $oldPlaceValue = $user->place;
            
            // Find the corresponding place name from mapping
            if (isset($placeMapping[$oldPlaceValue])) {
                $placeName = $placeMapping[$oldPlaceValue];
                
                // Find the place ID from our places array
                if (isset($places[$placeName])) {
                    if (!$dryRun) {
                        $user->place_id = $places[$placeName];
                        $user->save();
                    }
                    
                    $this->line("<info>✓</info> User: {$user->name} (ID: {$user->id}) - '{$oldPlaceValue}' -> '{$placeName}' (Place ID: {$places[$placeName]})");
                    $updated++;
                } else {
                    $this->warn("⚠ Place '{$placeName}' not found in database for user {$user->name} (ID: {$user->id})");
                    $warnings++;
                }
            } else {
                $this->warn("⚠ No mapping found for place value '{$oldPlaceValue}' for user {$user->name} (ID: {$user->id})");
                $warnings++;
            }
        }

        $this->newLine();
        
        if ($dryRun) {
            $this->info("Would update {$updated} users.");
        } else {
            $this->info("Successfully updated {$updated} users.");
        }
        
        if ($warnings > 0) {
            $this->warn("Found {$warnings} warnings that need attention.");
        }
        
        if ($dryRun && $updated > 0) {
            $this->info('Run without --dry-run to perform the actual updates.');
        }
    }
}