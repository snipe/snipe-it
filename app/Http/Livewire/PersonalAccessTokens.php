<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class PersonalAccessTokens extends Component
{
    public function render()
    {
        return view('livewire.personal-access-tokens', [
            'tokens' => Auth::user()->tokens,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'scopes' => 'nullable|array',
        ];
    }

    public function createToken(): void
    {
       Auth::user()->createToken($this->name, $this->scopes);
    }

    public function deleteToken($tokenId): void
    {
        Auth::user()->tokens()->where('id', $tokenId)->delete();
    }

    public function getTokensProperty(): array
    {
        return Auth::user()->tokens;
    }
}
