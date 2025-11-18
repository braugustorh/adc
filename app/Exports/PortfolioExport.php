<?php

namespace App\Exports;

use App\Models\Portfolio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PortfolioExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    public function collection()
    {
        $portfolios = Portfolio::with('user')
            ->get()
            ->map(function ($portfolio) {
                return [
                    'Nombre' => $portfolio->user?->name . ' ' . $portfolio->user?->first_name . ' ' . $portfolio->user?->last_name,
                    'Acta de nacimiento' => $portfolio->acta_url ? '✓' : '✗',
                    'CURP' => $portfolio->curp_url ? '✓' : '✗',
                    'RFC' => $portfolio->rfc_url ? '✓' : '✗',
                    'Identificación Oficial' => $portfolio->ine_url ? '✓' : '✗',
                    'Comprobante de domicilio' => $portfolio->comprobante_domicilio_url ? '✓' : '✗',
                    'Comprobante de estudios' => $portfolio->comprobante_estudios_url ? '✓' : '✗',
                    'Antecedentes Penales' => $portfolio->carta_no_antecedentes_url ? '✓' : '✗',
                    'Solicitud de Empleo' => $portfolio->sol_empleo_url ? '✓' : '✗',
                    'Carta de recomendación' => $portfolio->recomendacion_url ? '✓' : '✗',
                    'Certificado médico' => $portfolio->cert_medico_url ? '✓' : '✗',
                    'NSS' => $portfolio->nss_url ? '✓' : '✗',
                    'Alta IMSS' => $portfolio->alta_imss_url ? '✓' : '✗',
                    'Retención Infonavit' => $portfolio->retencion_url ? '✓' : '✗',
                ];
            });

        return $portfolios;
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Acta de nacimiento',
            'CURP',
            'RFC',
            'Identificación Oficial',
            'Comprobante de domicilio',
            'Comprobante de estudios',
            'Antecedentes Penales',
            'Solicitud de Empleo',
            'Carta de recomendación',
            'Certificado médico',
            'NSS',
            'Alta IMSS',
            'Retención Infonavit',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => '@', // Texto para nombre
        ];
    }
}
