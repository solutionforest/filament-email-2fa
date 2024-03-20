<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="save">
        <span class="text-gray-500 text-sm">
            @lang('filament-email-2fa::email_sent', ['email' => $this->getUser()->email])
        </span>
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getFormActions()" :full-width="$this->hasFullWidthFormActions()" />

    </x-filament-panels::form>
</x-filament-panels::page.simple>
