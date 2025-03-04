<x-filament-panels::page>
    <x-filament::section>
        {{$this->bulkImportForm}}
    </x-filament::section>
</x-filament-panels::page>
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('reset-file', () => {
            document.querySelector('[type="file"]').value = '';
        });
    });
</script>

