<template>
  <div class="employee-info">
    <div class="item" v-for="(item, keyValue) in employee" :key="keyValue">
      <strong>{{labels[keyValue]}}</strong>: {{employee[keyValue]}}
    </div>
  </div>
</template>

<script>
export default {
  name: "employee-info",
  props: {
    data: Object
  },
  data() {
    return {
      employee: {},
      labels: {
        "phone": "Branch phone",
        "fax": "Branch Fax",
        "location": "Branch location",
        "city": "Branch City",
        "openingDate": "Opening Date",
        "revenue": "Branch Revenue ($)",
        "category": "Category",
        "ephone": "Employee Phone",
        "title": "Title",
        "address": "Address",
        "hourlyWage": "Hourly Wage ($)",
        "startDate": "Start Date",
        "availableSick": "Available Sick days",
        "availableHoliday": "Available Holiday"
      }
    }
  },
  watch: {
    data: function(newVal, oldVal) {
      this.employee = newVal;
      delete this.employee['managerId'];
      delete this.employee['eid'];
      delete this.employee['bid'];
    }
  },
  mounted() {
  }
};
</script>

<style scoped lang="scss">
.employee-info {

}
</style>
