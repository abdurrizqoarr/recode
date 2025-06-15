<x-filament-panels::page>
    <form wire:submit="create" class="mb-6">
        {{ $this->form }}

        <div class="flex justify-end items-center gap-2 mt-2">
            <x-filament::button type="submit" wire:loading.attr="disabled" class="flex justify-end items-center gap-2">
                <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="submit" />
                Tambah Tugas
            </x-filament::button>
        </div>
    </form>

    <hr class="mb-6 border-gray-300 dark:border-gray-600" />

    <div>
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
            Daftar Tugas Tambahan
        </h2>
        {{ $this->table }}
    </div>
</x-filament-panels::page>
