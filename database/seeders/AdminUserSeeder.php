<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur admin si aucun n'existe
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'Administrateur',
                'email' => 'admin@haccp.local',
                'password' => Hash::make('Admin123!'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('Utilisateur admin créé : admin@haccp.local / Admin123!');
        } else {
            $this->command->info('Un administrateur existe déjà.');
        }

        // Mettre à jour les utilisateurs existants sans rôle
        User::whereNull('role')->update(['role' => 'employe']);
        $this->command->info('Rôles attribués aux utilisateurs existants.');
    }
}
