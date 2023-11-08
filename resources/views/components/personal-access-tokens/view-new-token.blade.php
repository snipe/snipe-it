<div class="modal fade" id="modal-access-token" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">
                    Personal Access Token
                </h4>
            </div>

            <div class="modal-body">
                <p>
                    Here is your new personal access token. This is the only time it will be shown so don't lose it!
                    You may now use this token to make API requests.
                </p>

                <pre><code>
{{--                    {{ accessToken }}--}}
                </code></pre>
            </div>

            <!-- Modal Actions -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>