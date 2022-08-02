<div class="modal-dialog modal-dialog-centered modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
               
                </h2>

            </div>
            <div class="modal-body">
              <form action="{{ route('tasks/store') }}" method="post">
                {{ csrf_field() }}
                Task name:
                <br />
                <input type="text" name="name" />
                <br /><br />
                Task description:
                <br />
                <textarea name="description"></textarea>
                <br /><br />
                Start time:
                <br />
                <input type="text" name="task_date" class="date" />
                <br /><br />
                End time:
                <br />
                <input type="text" name="task_end_date" class="date" />
                <br /><br />
                <input type="submit" value="Save" />
              </form>
            </div>
        </div>
</div>

<script src="{{ url('js/jquery-1.11.3.min.js')}}"></script>
<script src="{{ url('js/jquery-ui.min.js')}}"></script>
<script>
    $('.date').datepicker({
        autoclose: true,
        dateFormat: "yy-mm-dd"
    });
</script>