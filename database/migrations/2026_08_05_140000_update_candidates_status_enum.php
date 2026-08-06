<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Amplía el enum de estatus de candidatos al pipeline de selección:
     * en_proceso, contratado, banco_talento, archivado.
     * Mapea los valores previos: active/inactive -> en_proceso, hired -> contratado, rejected -> archivado.
     */
    public function up(): void
    {
        // 1. Ampliar el enum permitiendo tanto los valores viejos como los nuevos temporalmente.
        DB::statement("ALTER TABLE candidates MODIFY status ENUM('active','inactive','hired','rejected','en_proceso','contratado','banco_talento','archivado') DEFAULT 'en_proceso'");

        // 2. Migrar los datos existentes al nuevo vocabulario.
        DB::table('candidates')->where('status', 'active')->update(['status' => 'en_proceso']);
        DB::table('candidates')->where('status', 'inactive')->update(['status' => 'en_proceso']);
        DB::table('candidates')->where('status', 'hired')->update(['status' => 'contratado']);
        DB::table('candidates')->where('status', 'rejected')->update(['status' => 'archivado']);

        // 3. Dejar el enum únicamente con los valores nuevos.
        DB::statement("ALTER TABLE candidates MODIFY status ENUM('en_proceso','contratado','banco_talento','archivado') DEFAULT 'en_proceso'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE candidates MODIFY status ENUM('active','inactive','hired','rejected','en_proceso','contratado','banco_talento','archivado') DEFAULT 'active'");

        DB::table('candidates')->where('status', 'en_proceso')->update(['status' => 'active']);
        DB::table('candidates')->where('status', 'contratado')->update(['status' => 'hired']);
        DB::table('candidates')->where('status', 'banco_talento')->update(['status' => 'active']);
        DB::table('candidates')->where('status', 'archivado')->update(['status' => 'rejected']);

        DB::statement("ALTER TABLE candidates MODIFY status ENUM('active','inactive','hired','rejected') DEFAULT 'active'");
    }
};
