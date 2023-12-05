<?php

namespace App\Http\Livewire;

use Laravel\Passport\Client;
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

        //$this->dispatchBrowserEvent('clientCreated', $newClient->accessToken);
    }

    public function deleteClient(Client $clientId): void
    {
        //->delete must be of type Client - thus the model binding
        app(ClientRepository::class)->delete($clientId);
    }
}
