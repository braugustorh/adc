<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            // Agregar los nuevos campos después de 'carta_no_antecedentes_url'
            $table->string('recomendacion_url', 250)->nullable()->after('carta_no_antecedentes_url');
            $table->string('cert_medico_url', 250)->nullable()->after('recomendacion_url');
            $table->string('nss_url', 250)->nullable()->after('cert_medico_url');
            $table->string('sol_empleo_url', 250)->nullable()->after('nss_url');
            $table->string('retencion_url', 250)->nullable()->after('sol_empleo_url');
            $table->string('alta_imss_url', 250)->nullable()->after('retencion_url');
            $table->string('modificacion_imss_url', 250)->nullable()->after('alt_imss_url');
            $table->string('baja_imss_url', 250)->nullable()->after('modificacion_imss_url');
            $table->string('renuncia_url', 250)->nullable()->after('baja_imss_url');
            $table->string('finiquito_url', 250)->nullable()->after('renuncia_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            // Eliminar los campos agregados
            $table->dropColumn([
                'recomendacion_url',
                'cert_medico_url',
                'nss_url',
                'sol_empleo_url',
                'retencion_url',
                'alt_imss_url',
                'modificacion_imss_url',
                'baja_imss_url',
                'renuncia_url',
                'finiquito_url',
            ]);
        });
    }
};
