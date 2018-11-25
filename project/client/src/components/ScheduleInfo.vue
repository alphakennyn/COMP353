<template>
  <div class="schedule-info">
    <h1>Schedule</h1>
    <table>
      <tr>
        <th>Start time</th>
        <th>End time</th> 
        <th>Holiday?</th>
        <th>Sick day?</th>
      </tr>
      <tr v-for="(item, keyValue) in data" :key="keyValue">
        <td>
          {{item.startTime}}
        </td>
        <td>
          {{item.endTime}}
        </td>
        <td>
          <span v-if="!item.isHoliday">Yes</span>
          <span v-else>No</span>
        </td>
        <td>
          <span v-if="!item.isSickDay">Yes</span>
          <span v-else>No</span>
        </td> 
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  name: "schedule-info",
  props: {
    data: Array
  },
  data() {
    return {
      labels: {
        "category": "Category",
        "phone": "phone",
        "title": "Title",
        "address": "Address",
        "hourlyWage": "Hourly Wage",
        "startDate": "Start Date",
        "availableSick": "Available Sick",
        "availableHoliday": "Available Holiday"
      }
    }
  }
};
</script>

<style scoped lang="scss">
.schedule-info {
  padding: 25px 0px;
  table {
    tr {
      text-align: left;
      &:nth-child(even) {
        background-color: #f2f2f2
      }
    }
    td {
      width: 200px;
    }
  }
}
</style>
