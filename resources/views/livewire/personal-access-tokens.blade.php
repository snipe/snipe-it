@props([
    'token_url' => url('oauth/personal-access-tokens'),
    'scopes_url' => url('oauth/scopes'),
])

<div>
    <p>New Personal Access Token Component</p>
    <div>
        <p>{{ $token_url }}</p>
        <p>{{ $scopes_url }}</p>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="text-right" style="display: flex; justify-content: space-between; align-items: center;">

                <a class="btn btn-info btn-sm action-link pull-right"
                   onclick="$('#modal-create-token').modal('show');"
                >
                    Create New Token
                </a>
            </div>
        </div>
        <div class="panel-body">
            <!-- No Tokens Notice -->
            @if($tokens->count() === 0)
                <p class="m-b-none"
                >
                    You have not created any personal access tokens.
                </p>
            @endif

            <!-- Personal Access Tokens -->
            <table class="table table-borderless m-b-none">
                @if($tokens->count() > 0)
                    <thead>
                    <tr>
                        <th class="col-md-3">Name</th>
                        <th class="col-md-2">Created</th>
                        <th class="col-md-2">Expires</th>
                        <th class="col-md-2"><span class="sr-only">Delete</span></th>
                    </tr>
                    </thead>
                @endif
                @foreach($tokens as $token)
                    <tbody>
                    <tr>
                        <!-- Client Name -->

                        <td style="vertical-align: middle;">
                            {{ $token->name }}
                        </td>

                        <td style="vertical-align: middle;">
                            {{ $token->created_at }}
                        </td>

                        <td style="vertical-align: middle;">
                            {{ $token->expires_at }}
                        </td>


                        <!-- Delete Button -->
                        <td style="vertical-align: middle;" class="text-right">
                            <a class="action-link btn btn-danger btn-sm" wire:click="deleteToken({{ $token->id }})">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>



    </div>

    <!-- Create Token Modal -->
    <x-personal-access-tokens.create-token-modal />

    <!-- View New Token Modal -->
    <x-personal-access-tokens.view-new-token />

</div>