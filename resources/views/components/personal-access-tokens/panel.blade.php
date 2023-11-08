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
    </div>

</div>