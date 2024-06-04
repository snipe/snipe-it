<div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2>
                    OAuth Clients
                </h2>
                @if($authorizationError)
                    <div class="alert alert-danger">
                        <p><strong>Whoops!</strong> Something went wrong!</p>
                        <br>
                        {{ $authorizationError }}
                    </div>
                @endif

                <a class="button button-small"
                   wire:click="$dispatch('openModal')"
                   onclick="$('#modal-create-client').modal('show');"
                >
                    Create New Client
                </a>
            </div>
        </div>

        <div class="panel-body">
            <!-- Current Clients -->
            @if($clients->count() === 0)
                <p class="m-b-none">
                    You have not created any OAuth clients.
                </p>
            @endif

            @if($clients->count() > 0)
                <table class="table table-borderless m-b-none">
                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>Name</th>
                            <th>Secret</th>
                            <th><span class="sr-only">Edit</span></th>
                            <th><span class="sr-only">Delete</span></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <!-- ID -->
                                <td style="vertical-align: middle;">
                                    {{ $client->id }}
                                </td>

                                <!-- Name -->
                                <td style="vertical-align: middle;">
                                    {{ $client->name }}
                                </td>

                                <!-- Secret -->
                                <td style="vertical-align: middle;">
                                    <code>{{ $client->secret }}</code>
                                </td>

                                <!-- Edit Button -->
                                <td style="vertical-align: middle;">
                                    <a class="action-link btn"
                                       wire:click="editClient('{{ $client->id }}')"
                                        onclick="$('#modal-edit-client').modal('show');"
                                    >
                                        Edit
                                    </a>
                                </td>

                                <!-- Delete Button -->
                                <td style="vertical-align: middle;" class="text-right">
                                    <a class="action-link btn btn-danger btn-sm" wire:click="deleteClient('{{ $client->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div>
            @if ($authorized_tokens->count() > 0)
                <div>
                    <div class="panel panel-default">
                        <h2 class="panel-heading">Authorized Applications</h2>

                        <div class="panel-body">
                            <!-- Authorized Tokens -->
                            <table class="table table-borderless m-b-none">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Scopes</th>
                                    <th><span class="sr-only">Delete</span></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($authorized_tokens as $token)
                                    <tr>
                                        <!-- Client Name -->
                                        <td style="vertical-align: middle;">
                                            {{ $token->client->name }}
                                        </td>

                                        <!-- Scopes -->
                                        <td style="vertical-align: middle;">
                                            @if(!$token->scopes)
                                                <span class="label label-default">No Scopes</span>
                                            @endif
                                        </td>

                                        <!-- Revoke Button -->
                                        <td style="vertical-align: middle;">
                                            <a class="btn btn-sm btn-danger"
                                                wire:click="deleteToken('{{ $token->id }}')"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Create Client Modal -->
    <div class="modal fade" id="modal-create-client" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h2 class="modal-title">
                        Create Client
                    </h2>
                </div>

                <div class="modal-body">
                    <!-- Form Errors -->
                    @if($errors->has('name') || $errors->has('redirect'))
                        <div class="alert alert-danger">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                @if($errors->has('name'))
                                    <li>{{ $errors->first('name') }}</li>
                                @endif
                                @if($errors->has('redirect'))
                                    <li>{{ $errors->first('redirect') }}</li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    <!-- Create Client Form -->
                    <form class="form-horizontal" role="form">
                        <!-- Name -->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="create-client-name">Name</label>

                            <div class="col-md-7">
                                <input id="create-client-name"
                                       type="text"
                                       aria-label="create-client-name"
                                       class="form-control"
                                       wire:model.live="name"
                                       wire:keydown.enter="createClient"
                                       autofocus
                                >

                                <span class="help-block">
                                    Something your users will recognize and trust.
                                </span>
                            </div>
                        </div>

                        <!-- Redirect URL -->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="redirect">Redirect URL</label>

                            <div class="col-md-7">
                                <input type="text"
                                       class="form-control"
                                       aria-label="redirect"
                                       name="redirect"
                                       wire:model.live="redirect"
                                       wire:keydown.enter="createClient"
                                >

                                <span class="help-block">
                                    Your application's authorization callback URL.
                                </span>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button"
                            class="btn btn-primary"
                            wire:click="createClient"
                    >
                        Create
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Client Modal -->
    <div class="modal fade" id="modal-edit-client" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">
                        Edit Client
                    </h4>
                </div>


                <div class="modal-body">
                    @if($errors->has('newName') || $errors->has('newRedirect'))
                        <div class="alert alert-danger">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                @if($errors->has('newName'))
                                    <li>{{ $errors->first('newName') }}</li>
                                @endif
                                @if($errors->has('newRedirect'))
                                    <li>{{ $errors->first('newRedirect') }}</li>
                                @endif
                                @if($authorizationError)
                                    <li>{{ $authorizationError }}</li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    <!-- Edit Client Form -->
                    <form class="form-horizontal">
                        <!-- Name -->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="edit-client-name">Name</label>

                            <div class="col-md-7">
                                <input
                                        id="edit-client-name"
                                        type="text"
                                        aria-label="edit-client-name"
                                        class="form-control"
                                        wire:model.live="editName"
                                        wire:keydown.enter="updateClient('{{ $editClientId }}')"
                                >

                                <span class="help-block">
                                    Something your users will recognize and trust.
                                </span>
                            </div>
                        </div>

                        <!-- Redirect URL -->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="redirect">Redirect URL</label>

                            <div class="col-md-7">
                                <input
                                        type="text"
                                        class="form-control"
                                        name="redirect"
                                        aria-label="redirect"
                                        wire:model.live="editRedirect"
                                        wire:keydown.enter="updateClient('{{ $editClientId }}')"
                                >

                                <span class="help-block">
                                    Your application's authorization callback URL.
                                </span>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    <button
                            class="btn btn-primary"
                            wire:click="updateClient('{{ $editClientId }}')"
                    >
                        Update Client
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('openModal', () => {
                $('#modal-create-client').modal('show').on('shown.bs.modal', function() {
                    $(this).find('[autofocus]').focus();
                });
            });
        });
        window.addEventListener('clientCreated', function() {
            $('#modal-create-client').modal('hide');
        });
        window.addEventListener('editClient', function() {
            $('#modal-edit-client').modal('show');
        });
        window.addEventListener('clientUpdated', function() {
            $('#modal-edit-client').modal('hide');
        });



    </script>
</div>
