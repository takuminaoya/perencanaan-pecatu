<?php

use App\Models\KontakForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component {
    public $nama = '';
    public $email = '';
    public $subjek = '';
    public $pesan = '';

    public function save() {
        try {
            DB::beginTransaction();

            $validated = $this->validate([  
                'nama' => 'required',
                'email' => 'required|email',
                'subjek' => 'required',
                'pesan' => 'required',
            ]);

            $validated['uuid'] = Str::uuid();

            KontakForm::create($validated);
            
            DB::commit();

            session()->flash('status', 'Kontak telah berhasil dibuat. Terima Kasih atas masukan anda.');
        } catch (Exception $e) {
            DB::rollBack();
            abort(500);
        }
    }
};
