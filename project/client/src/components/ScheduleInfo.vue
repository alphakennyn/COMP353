<template>
  <div class="schedule-info">
    <h1>Schedule</h1>
    <table>
      <tr>
        <th>Start time</th>
        <th>End time</th> 
        <th>Holiday?</th>
        <th>Sick days?</th>
      </tr>
      <tr v-for="(item, keyValue) in data" :key="keyValue">
        <td>
          {{item.startTime}}
        </td>
        <td>
          {{item.startTime}}
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
