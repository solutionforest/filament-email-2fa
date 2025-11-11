<x-filament-panels::page.simple>
    @php
        $alignment = $this->getFormActionsAlignment();
        $fullWidth = $this->hasFullWidthFormActions();
    @endphp

    <form wire:submit="save" class="space-y-6">
        <div class="space-y-2">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                @lang('filament-email-2fa::filament-email-2fa.email_sent', ['email' => $this->getUser()->email])
            </p>
            @if (session()->has('resent-success'))
                <p class="text-sm text-success-600 dark:text-success-400">
                    {{ session('resent-success') }}
                </p>
            @endif
        </div>

        {{ $this->form }}

        <x-filament::actions
            :actions="$this->getFormActions()"
            :alignment="$alignment"
            :full-width="$fullWidth"
        />
    </form>
</x-filament-panels::page.simple>
