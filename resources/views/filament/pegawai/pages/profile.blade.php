<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="flex justify-end items-center gap-2 mt-2">
            <x-filament::button type="submit" wire:loading.attr="disabled" class="flex justify-end items-center gap-2">
                <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="submit" />
                Perbarui Profile
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
