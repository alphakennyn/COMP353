<template>
<div class="payroll">
  <h1>Payroll</h1>
  <table>
    <tr>
      <th>Clock in</th>
      <th>Clock out</th> 
    </tr>
    <tr v-for="(item, keyValue) in data" :key="keyValue">
      <td>
        {{item.clockIn}}
      </td>
      <td>
        {{item.clockOut}}
      </td> 
    </tr>
  </table>
</div>
</template>

<script>
export default {
  name: "payroll",
  props: {
    data: Array
  },
  data() {
    return {};
  },
  methods: {}
};
</script>

<style scoped lang="scss">
.payroll {
  table {
    tr {
      text-align: left;
    }
    td {
      width: 200px;
    }
  }
}
</style>
