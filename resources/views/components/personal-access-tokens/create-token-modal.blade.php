@props([
    'title' => 'Create Token',
    'errors' => false,
])

<!-- Create Token Modal -->
<div class="modal fade" id="modal-create-token" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">
                    Create Token
                </h4>
            </div>

            <div class="modal-body">
                <!-- Form Errors -->
                @if($errors === true)
                    <div class="alert alert-danger"
    {{--                     v-if="form.errors.length > 0"--}}
                    >
                        <p><strong>Whoops!</strong> Something went wrong!</p>
                        <br>
                        <ul>
                            <li
    {{--                                v-for="error in form.errors"--}}
                            >
    {{--                            {{ error }}--}}
                            </li>
                        </ul>
                    </div>
                @endif

                <!-- Create Token Form -->
                <form class="form-horizontal" role="form"
{{--                      @submit.prevent="store"--}}
                >
                    <!-- Name -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="name">Name</label>

                        <div class="col-md-6">
                            <input id="create-token-name" type="text" aria-label="name" class="form-control" name="name"
{{--                                   v-model="form.name"--}}
                            >
                        </div>
                    </div>

                    <!-- Scopes -->
{{--                    <div class="form-group"--}}
{{--                         v-if="scopes.length > 0"--}}
{{--                    >--}}
{{--                        <label class="col-md-4 control-label">Scopes</label>--}}

{{--                        <div class="col-md-6">--}}
{{--                            <div--}}
{{--                                    v-for="scope in scopes"--}}
{{--                            >--}}
{{--                                <div class="checkbox">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox"--}}
{{--                                               @click="toggleScope(scope.id)"--}}
{{--                                               :checked="scopeIsAssigned(scope.id)"--}}
{{--                                        >--}}

{{--                                        {{ scope.id }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </form>
            </div>

            <!-- Modal Actions -->
            <div class="modal-footer">
                <button type="button" class="btn primary" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary"
{{--                        @click="store"--}}
                >
                    Create
                </button>
            </div>
        </div>
    </div>
</div>