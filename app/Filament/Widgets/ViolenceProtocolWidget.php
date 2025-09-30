<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;


class ViolenceProtocolWidget extends Widget
{
    protected static string $view = 'filament.widgets.protocolo-violencia';

    protected static ?string $heading = 'Protocolo contra la Violencia Laboral';

    protected static ?int $sort = 2;

    // Variables para el formulario - Datos del quejoso
    public $quejosoNombre = '';
    public $quejosoPuesto = '';
    public $quejosoTelefono = '';
    public $quejosoArea = '';
    public $quejosoJefe = '';

    // Variables para el formulario - Datos del acusado
    public $acusadoNombre = '';
    public $acusadoPuesto = '';
    public $acusadoTelefono = '';
    public $acusadoArea = '';
    public $acusadoJefe = '';

    // Variables para el formulario - Declaración de hechos
    public $fechaOcurrencia = '';
    public $horaOcurrencia = '';
    public $lugarOcurrencia = '';
    public $frecuencia = '';
    public $manifestacionHostigamiento = '';
    public $actitudHostigador = '';
    public $reaccionInmediata = '';
    public $casoAislado = '';
    public $afectacionEmocional = '';
    public $afectacionRendimiento = '';
    public $causaParticular = '';
    public $percepcionAmbienteLaboral = '';
    public $afectacionLargoPlazo = '';
    public $necesitaApoyoPsicologico = '';



    // Widget visible para todos los usuarios autenticados
    public static function canView(): bool
    {
        return auth()->check();
    }

    // Datos del widget
    public function getViewData(): array
    {
        return [
            'user' => auth()->user(),
        ];
    }
    public function openProtocolModal(){
        $this->dispatch('open-modal', id: 'modal-protocol');
    }
    public function closeProtocolModal(){
        $this->dispatch('close-modal', id: 'modal-protocol');
    }
    public function openComplaintModal(){
        $this->closeProtocolModal();
        $this->dispatch('open-modal', id: 'modal-complaint');

    }

    public function downloadProtocol()
    {
        $storagePath = storage_path('app/documents/protocolo_violencia.pdf');

        if (file_exists($storagePath)) {
            return response()->download($storagePath, 'protocolo_violencia.pdf');
        }

        Notification::make()
            ->danger()
            ->title('Error')
            ->body('No se encontró el archivo del protocolo.')
            ->send();
    }

    public function sendComplaint()
    {
        // Validar los campos requeridos
        $this->validate([
            'quejosoNombre' => 'required|string|max:255',
            'quejosoPuesto' => 'required|string|max:255',
            'quejosoTelefono' => 'required|string|max:20',
            'quejosoArea' => 'required|string|max:255',
            'quejosoJefe' => 'required|string|max:255',
            'acusadoNombre' => 'required|string|max:255',
            'acusadoPuesto' => 'required|string|max:255',
            'acusadoArea' => 'required|string|max:255',
            'fechaOcurrencia' => 'required|date',
            'horaOcurrencia' => 'required',
            'lugarOcurrencia' => 'required|string|max:255',
            'frecuencia' => 'required|string',
            'manifestacionHostigamiento' => 'required|string',
            'actitudHostigador' => 'required|string',
            'reaccionInmediata' => 'required|string',
            'casoAislado' => 'required|string',
            'afectacionEmocional' => 'required|string',
            'afectacionRendimiento' => 'required|string',
            'causaParticular' => 'required|string',
            'percepcionAmbienteLaboral' => 'required|string',
            'afectacionLargoPlazo' => 'required|string',
            'necesitaApoyoPsicologico' => 'required|string',
        ], [
            'quejosoNombre.required' => 'El nombre del quejoso es requerido.',
            'quejosoPuesto.required' => 'El puesto del quejoso es requerido.',
            'quejosoTelefono.required' => 'El teléfono del quejoso es requerido.',
            'quejosoArea.required' => 'El área del quejoso es requerida.',
            'quejosoJefe.required' => 'El nombre del jefe inmediato es requerido.',
            'acusadoNombre.required' => 'El nombre del acusado es requerido.',
            'acusadoPuesto.required' => 'El puesto del acusado es requerido.',
            'acusadoArea.required' => 'El área del acusado es requerida.',
            'fechaOcurrencia.required' => 'La fecha de ocurrencia es requerida.',
            'horaOcurrencia.required' => 'La hora de ocurrencia es requerida.',
            'lugarOcurrencia.required' => 'El lugar de ocurrencia es requerido.',
            'frecuencia.required' => 'La frecuencia es requerida.',
            'manifestacionHostigamiento.required' => 'La manifestación del hostigamiento es requerida.',
            'actitudHostigador.required' => 'La actitud del hostigador es requerida.',
            'reaccionInmediata.required' => 'Su reacción inmediata es requerida.',
            'casoAislado.required' => 'Este campo es requerido.',
            'afectacionEmocional.required' => 'La afectación emocional es requerida.',
            'afectacionRendimiento.required' => 'La afectación en el rendimiento es requerida.',
            'causaParticular.required' => 'Este campo es requerido.',
            'percepcionAmbienteLaboral.required' => 'La percepción del ambiente laboral es requerida.',
            'afectacionLargoPlazo.required' => 'Este campo es requerido.',
            'necesitaApoyoPsicologico.required' => 'Este campo es requerido.',
        ]);

        try {
            // Preparar los datos para el correo
            $data = [
                'fecha_presentacion' => now()->format('Y-m-d'),
                'ciudad' => auth()->user()->city ?? 'N/A',
                'estado' => auth()->user()->state ?? 'N/A',
                'quejoso_nombre' => $this->quejosoNombre,
                'quejoso_puesto' => $this->quejosoPuesto,
                'quejoso_telefono' => $this->quejosoTelefono,
                'quejoso_area' => $this->quejosoArea,
                'quejoso_jefe_inmediato' => $this->quejosoJefe,
                'acusado_nombre' => $this->acusadoNombre,
                'acusado_puesto' => $this->acusadoPuesto,
                'acusado_telefono' => $this->acusadoTelefono,
                'acusado_area' => $this->acusadoArea,
                'acusado_jefe_inmediato' => $this->acusadoJefe,
                'fecha_ocurrencia' => $this->fechaOcurrencia,
                'hora_ocurrencia' => $this->horaOcurrencia,
                'lugar_ocurrencia' => $this->lugarOcurrencia,
                'frecuencia' => $this->frecuencia,
                'manifestacion_hostigamiento' => $this->manifestacionHostigamiento,
                'actitud_hostigador' => $this->actitudHostigador,
                'reaccion_inmediata' => $this->reaccionInmediata,
                'caso_aislado' => $this->casoAislado,
                'afectacion_emocional' => $this->afectacionEmocional,
                'afectacion_rendimiento' => $this->afectacionRendimiento,
                'causa_particular' => $this->causaParticular,
                'percepcion_ambiente_laboral' => $this->percepcionAmbienteLaboral,
                'afectacion_largo_plazo' => $this->afectacionLargoPlazo,
                'necesita_apoyo_psicologico' => $this->necesitaApoyoPsicologico,
            ];

            // Enviar correo
            Mail::send('emails.queja-violencia-laboral', ['data' => $data], function ($message) use ($data) {
                $message->to('contactorh@adcentrales.com')
                    ->subject('Nueva Queja de Violencia Laboral - ' . $data['quejoso_nombre']);
            });

            // Cerrar modal de formulario
            $this->dispatch('close-modal', id: 'modal-complaint');

            // Mostrar notificación de éxito
            Notification::make()
                ->success()
                ->title('Queja enviada exitosamente')
                ->body('Su queja ha sido enviada correctamente a contactorh@adcentrales.com. Nos pondremos en contacto con usted a la brevedad posible.')
                ->persistent()
                ->send();

            // Abrir modal de éxito
            $this->dispatch('open-modal', id: 'success-modal');

            // Limpiar el formulario
            $this->reset([
                'quejosoJefe',
                'acusadoNombre',
                'acusadoPuesto',
                'acusadoTelefono',
                'acusadoArea',
                'acusadoJefe',
                'fechaOcurrencia',
                'horaOcurrencia',
                'lugarOcurrencia',
                'frecuencia',
                'manifestacionHostigamiento',
                'actitudHostigador',
                'reaccionInmediata',
                'casoAislado',
                'afectacionEmocional',
                'afectacionRendimiento',
                'causaParticular',
                'percepcionAmbienteLaboral',
                'afectacionLargoPlazo',
                'necesitaApoyoPsicologico',
            ]);

        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Error al enviar la queja')
                ->body('Ocurrió un error al procesar su queja. Por favor, inténtelo de nuevo o contacte a RH directamente.')
                ->persistent()
                ->send();
        }
    }
    public function closeComplaintModal(){
        $this->dispatch('close-modal', id: 'modal-complaint');
    }


}
