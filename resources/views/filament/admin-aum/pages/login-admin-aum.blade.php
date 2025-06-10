<x-filament-panels::page.simple>
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

    <x-filament-panels::form id="form" wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />

        <div class="mt-4 text-center space-y-2">
            <a href="{{ route('filament.pegawai.auth.login') }}"
                class="text-sm text-green-600 hover:underline font-medium">
                Login sebagai Pegawai
            </a>
            <br>
            <a href="{{ route('filament.admin.auth.login') }}"
                class="text-sm text-purple-600 hover:underline font-medium">
                Login sebagai Admin Master
            </a>
        </div>
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
</x-filament-panels::page.simple>
