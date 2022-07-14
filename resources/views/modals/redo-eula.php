<!-- Modal -->
<div class="modal fade" id="redoEula" tabindex="-1" role="dialog" aria-labelledby="redoEulaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">Send...</div>
                <div class="modal-body">
                    <h5>Remind User to Sign</h5>
                    <p>Sends an email reminding user Eula remains unsigned. <button type="button" class="btn btn-secondary pull-right "><a href="{{route('account.accept.resend', $asset_id }}"  title="reminder" >Send Reminder</a></button></p>
                    <hr>
                    <h5 class>Reset and Resign EULA agreement</h5>
                    <p>Bad Signature was captured. Resets and Resends Original EULA <button type="button" class="btn btn-secondary pull-right"><a href="{{route('account.accept.resign', $asset_id)}}" title="resign">Resign</a></button></p>
                    <hr>
        </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>

</div>
