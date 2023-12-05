<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ClientRepository;
use Livewire\Component;

class OauthClients extends Component
{
    public function render()
    {
        return view('livewire.oauth-clients', [
            'clients' => app(ClientRepository::class)->activeForUser(auth()->user()->id),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'redirect' => 'required|url|max:255',
        ];
    }

    public function createClient(): void
    {
        $this->validate();

        //$newClient = ;

        $this->dispatchBrowserEvent('clientCreated', $newClient->accessToken);
    }

    public function deleteClient($clientId): void
    {
        Auth::user()->clients()->find($clientId)->delete();
    }
}
