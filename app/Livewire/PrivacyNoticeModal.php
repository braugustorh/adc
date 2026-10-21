<?php

namespace App\Livewire;

use App\Models\PrivacyNotice;
use App\Services\PrivacyNoticeService;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class PrivacyNoticeModal extends Component
{
    public bool $showModal = false;
    public bool $isPreview = false;
    public bool $canSkipAsAdmin = false;
    public string $step = 'initial'; // 'initial' | 'simplified' | 'extended'
    public bool $hasInitialNotice = true;
    public bool $hasExtendedNotice = false;
    public bool $acceptedCheckbox = false;
    public ?int $noticeId = null;

    public string $headerTitle = 'Aviso de Privacidad';
    public ?string $version = null;
    public string $scopeType = 'razon_social';
    public string $initialHtml = '';
    public string $simplifiedHtml = '';
    public string $extendedHtml = '';
    public string $checkboxLabel = '';
    public array $resolvedData = [];

    public function mount(PrivacyNoticeService $service): void
    {
        if (!Auth::check()) {
            return;
        }

        if (request()->routeIs('filament.pages.exit-survey-page')) {
            return;
        }

        $user = Auth::user();

        // No mostrar si el usuario está inactivo (flujo de encuesta de salida)
        if (!$user || !$user->status) {
            return;
        }

        // Verificar si ya aceptó el aviso activo (consulta optimizada con caché + sesión + índice único)
        if ($service->hasUserAcceptedActiveNotice($user)) {
            return;
        }

        $activeNotice = PrivacyNotice::getActive();

        if (!$activeNotice) {
            return;
        }

        // Si el administrador ya decidió "Saltarse el Aviso" durante esta sesión activa para poder editar/corregir
        if (
            $this->userCanSkipNotice($user)
            && session($this->getAdminSkipSessionKey($user->id)) === $activeNotice->id
        ) {
            return;
        }

        $this->loadNoticeForUser($activeNotice, $service, false);
    }

    protected function userCanSkipNotice($user): bool
    {
        if (!$user || !method_exists($user, 'hasAnyRole')) {
            return false;
        }

        return $user->hasAnyRole(
            'Administrador',
            'Super Administrador',
            'Super Admin',
            'RH Corp',
            'RH Coorp'
        );
    }

    protected function getAdminSkipSessionKey(int $userId): string
    {
        return "adc_privacy_admin_skipped_user_{$userId}";
    }

    #[On('open-privacy-notice-preview')]
    public function openPreview(int $noticeId, PrivacyNoticeService $service): void
    {
        $notice = PrivacyNotice::find($noticeId);

        if (!$notice) {
            return;
        }

        $this->loadNoticeForUser($notice, $service, true);
    }

    protected function loadNoticeForUser(PrivacyNotice $notice, PrivacyNoticeService $service, bool $isPreview = false): void
    {
        $user = Auth::user();
        $resolved = $service->resolveDataForUser($notice, $user);

        $this->noticeId = $notice->id;
        $this->isPreview = $isPreview;
        $this->canSkipAsAdmin = $this->userCanSkipNotice($user);
        $this->headerTitle = $notice->title ?: 'Aviso de Privacidad y Protección de Datos Personales';
        $this->version = $notice->version;
        $this->scopeType = $notice->scope_type;
        $this->resolvedData = $resolved;

        $this->initialHtml = $service->renderContent($notice->initial_notice_content, $resolved);
        $this->simplifiedHtml = $service->renderContent($notice->simplified_content, $resolved);
        $this->extendedHtml = $service->renderContent($notice->extended_content, $resolved);
        $this->checkboxLabel = $notice->checkbox_label ?: PrivacyNoticeService::getDefaultCheckboxLabel();

        $this->hasInitialNotice = (bool) $notice->has_initial_notice && !empty(trim(strip_tags($this->initialHtml)));
        $this->hasExtendedNotice = (bool) $notice->has_extended_notice && !empty(trim(strip_tags($this->extendedHtml)));

        // Si tiene aviso inicial habilitado, arranca en 'initial'; de lo contrario, va directo a 'simplified'
        $this->step = $this->hasInitialNotice ? 'initial' : 'simplified';
        $this->acceptedCheckbox = false;
        $this->showModal = true;
    }

    public function goToSimplified(): void
    {
        $this->step = 'simplified';
        $this->dispatch('privacy-notice-scroll-top');
    }

    public function goToExtended(): void
    {
        if (!$this->hasExtendedNotice) {
            return;
        }

        $this->step = 'extended';
        $this->dispatch('privacy-notice-scroll-top');
    }

    public function goToInitial(): void
    {
        if (!$this->hasInitialNotice) {
            return;
        }

        $this->step = 'initial';
        $this->dispatch('privacy-notice-scroll-top');
    }

    public function closePreview(): void
    {
        if ($this->isPreview) {
            $this->showModal = false;
            $this->isPreview = false;
        }
    }

    public function skipAsAdmin(): void
    {
        $user = Auth::user();

        if (!$this->userCanSkipNotice($user)) {
            return;
        }

        if ($this->noticeId && $user) {
            session([$this->getAdminSkipSessionKey($user->id) => $this->noticeId]);
        }

        $this->showModal = false;
        $this->isPreview = false;

        Notification::make()
            ->info()
            ->title('Modo Administrador: Aviso omitido temporalmente')
            ->body('Se cerró la ventana sin registrar aceptación para que puedas revisar, editar o desactivar el aviso.')
            ->send();
    }

    public function acceptNotice(Request $request, PrivacyNoticeService $service): void
    {
        if (!$this->acceptedCheckbox) {
            Notification::make()
                ->warning()
                ->title('Confirmación requerida')
                ->body('Por favor marque la casilla de aceptación para continuar.')
                ->send();
            return;
        }

        if ($this->isPreview) {
            $this->showModal = false;
            $this->isPreview = false;

            Notification::make()
                ->info()
                ->title('Vista previa finalizada')
                ->body('Así es como el colaborador completará la aceptación del Aviso de Privacidad.')
                ->send();
            return;
        }

        $user = Auth::user();
        $notice = $this->noticeId ? PrivacyNotice::find($this->noticeId) : PrivacyNotice::getActive();

        if ($user && $notice) {
            $service->recordAcceptance(
                $notice,
                $user,
                $request->ip(),
                $request->userAgent()
            );
        }

        $this->showModal = false;

        Notification::make()
            ->success()
            ->title('Aviso de Privacidad aceptado')
            ->body('Su consentimiento ha sido registrado correctamente.')
            ->send();
    }

    public function rejectAndLogout(Request $request)
    {
        if ($this->isPreview) {
            $this->showModal = false;
            $this->isPreview = false;

            Notification::make()
                ->info()
                ->title('Simulación de rechazo (Vista Previa)')
                ->body('En modo real, el colaborador sería desconectado y enviado a la pantalla de inicio de sesión.')
                ->send();
            return;
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect(filament()->getLoginUrl());
    }

    public function render()
    {
        return view('livewire.privacy-notice-modal');
    }
}
