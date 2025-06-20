<x-filament-panels::page>
        {{ $this->form }}

        @if ($file)
                <div class="mt-4 bg-white p-3 rounded-lg shadow border flex items-center space-x-4 gap-6">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <div>
                                <div class="font-semibold text-blue-700">Bukti SK Tersedia</div>
                                <a href="{{ route('download.document', ['filename' => $file]) }}" target="_blank" class="hover:text-gray-700 decoration-0">
                                        Klik di sini untuk melihat atau mengunduh dokumen SK
                                </a>
                        </div>
                </div>
        @endif
</x-filament-panels::page>
