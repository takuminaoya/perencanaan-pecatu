<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    public $user;
    public $usulans;

    public function mount()
    {
        $this->user = whois('pengguna');
        $this->usulans = $this->user->usulans;
    }

    public function logout()
    {
        Auth::guard('pengguna')->logout();

        return $this->redirect('/');
    }
};
