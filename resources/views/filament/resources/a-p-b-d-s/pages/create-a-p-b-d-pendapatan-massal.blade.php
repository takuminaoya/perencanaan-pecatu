<x-filament-panels::page>
    {{-- Page content --}}
    <form wire:submit="create">
        {{ $this->form }}

        <x-filament::button
            type="submit"
        >
            Kirim
        </x-filament::button>
    </form>
</x-filament-panels::page>
