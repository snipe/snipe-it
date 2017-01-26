
<style scoped>
</style>

<template>
    <div class="box" v-if="errors">
  <div class="box-body">
    <div class="alert alert-warning">
      <strong>Warning</strong> Some Errors occured while importing
    </div>

    <div class="errors-table">
      <table class="table table-striped table-bordered" id="errors-table">
        <thead>
          <th>Item</th>
          <th>Errors</th>
        </thead>
        <tbody>
          <tr v-for="(error, item) in errors">
            <td>{{ item }}</td>
            <td v-for="(value, field) in error">
                <b>{{ field }}:</b>
                <span v-for="errorString in value">{{errorString[0]}}</span>
              <br />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
         props: ['errors'],
    }

</script>
