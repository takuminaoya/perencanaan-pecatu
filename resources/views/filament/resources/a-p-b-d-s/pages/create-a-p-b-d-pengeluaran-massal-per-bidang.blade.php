<x-filament-panels::page>
        {{-- Page content --}}
    <form wire:submit="create">
        {{ $this->form }}

        <x-filament::button
            type="submit"
            class="mt-5"
        >
            Kirim
        </x-filament::button>

        <span class="not-data-loading:hidden">
            Mohon untuk tidak merefresh halaman ini. Dalam proses penyimpanan data..
        </span>
    </form>
</x-filament-panels::page>
