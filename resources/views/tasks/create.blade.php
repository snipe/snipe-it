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

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script>
    $('.date').datepicker({
        autoclose: true,
        dateFormat: "yy-mm-dd"
    });
</script>