<style scoped>
    .action-link {
        cursor: pointer;
    }

    .m-b-none {
        margin-bottom: 0;
    }
</style>

<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2>
                        (Livewire) OAuth Clients
                    </h2>

                    <a class="action-link"
{{--                       @click="showCreateClientForm"--}}
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
                    <table class="table table-borderless m-b-none"
    {{--                       v-if="clients.length > 0"--}}
                    >
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
                            <tr
                            >
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
                                    <a class="action-link"
                                       @click="edit(client)"
                                    >
                                        Edit
                                    </a>
                                </td>

                                <!-- Delete Button -->
                                <td style="vertical-align: middle;">
                                    <a class="action-link btn btn-danger btn-sm"
                                       wire:click="deleteClient('{{ $client->id }}')"
                                    >
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Create Client Modal -->
        <div class="modal fade" id="modal-create-client" tabindex="-1" role="dialog">
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
                        <div class="alert alert-danger"
{{--                             v-if="createForm.errors.length > 0"--}}
                        >
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li
{{--                                        v-for="error in createForm.errors"--}}
                                >
{{--                                    {{ error }}--}}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Client Form -->
                        <form class="form-horizontal" role="form">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="create-client-name">Name</label>

                                <div class="col-md-7">
                                    <input id="create-client-name" type="text" aria-label="create-client-name" class="form-control"
{{--                                           @keyup.enter="store" --}}
{{--                                           v-model="createForm.name"--}}
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
                                    <input type="text" class="form-control" aria-label="redirect" name="redirect"
{{--                                           @keyup.enter="store" --}}
{{--                                           v-model="createForm.redirect"--}}
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

                        <button type="button" class="btn btn-primary"
{{--                                @click="store"--}}
                        >
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Client Modal -->
        <div class="modal fade" id="modal-edit-client" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Edit Client
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger"
{{--                             v-if="editForm.errors.length > 0"--}}
                        >
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li
{{--                                        v-for="error in editForm.errors"--}}
                                >
{{--                                    {{ error }}--}}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Client Form -->
                        <form class="form-horizontal" role="form">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="edit-client-name">Name</label>

                                <div class="col-md-7">
                                    <input id="edit-client-name" type="text" aria-label="edit-client-name" class="form-control"
{{--                                           @keyup.enter="update" --}}
{{--                                           v-model="editForm.name"--}}
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
                                    <input type="text" class="form-control" name="redirect" aria-label="redirect"
{{--                                           @keyup.enter="update" --}}
{{--                                           v-model="editForm.redirect"--}}
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

                        <button type="button" class="btn btn-primary"
{{--                                @click="update"--}}
                        >
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>