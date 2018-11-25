<template>
  <div class="employee-info">
    <div class="item" v-for="(item, keyValue) in data" :key="keyValue">
      <strong>{{labels[keyValue]}}</strong>: {{data[keyValue]}}
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
.employee-info {

}
</style>
