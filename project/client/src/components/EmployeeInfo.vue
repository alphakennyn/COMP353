<template>
  <div class="employee-info">
    <div class="item" v-for="(item, keyValue) in employee" :key="keyValue">
      <strong>{{labels[keyValue]}}</strong>:
      <input type="text" v-model="employee[keyValue]" :disabled="!isEditing || !allowToEdit.includes(keyValue)"
             :class="{view: !isEditing || !allowToEdit.includes(keyValue)}" />
    </div>
    <button @click="isEditing = !isEditing" v-if="!isEditing">Edit</button>
    <button @click="save" v-else-if="isEditing">Save</button>
    <button v-if="isEditing" @click="cancel">Cancel</button>
  </div>
</template>

<script>
export default {
  name: "employee-info",
  props: {
    data: Object,
    eid: Number,
  },
  data() {
    return {
      originalData: this.data,
      employee: this.data,
      isEditing: false,
      allowToEdit: ["phone", "address"],
      labels: {
        bid: 'Branch ID',
        phone: "Employee Phone",
        managerId: "Manager ID",
        fax: "Branch Fax",
        location: "Branch location",
        city: "Branch City",
        openingDate: "Opening Date",
        revenue: "Branch Revenue ($)",
        category: "Category",
        bphone: "Branch Phone",
        title: "Title",
        address: "Address",
        hourlyWage: "Hourly Wage ($)",
        startDate: "Start Date",
        availableSick: "Available Sick days",
        availableHoliday: "Available Holiday"
      }
    };
  },
  methods: {
    save: function() {

      const data = {
        eid: this.eid,
        phone: this.employee.phone,
        address: this.employee.address
      }

      this.$http
        .post(`${process.env.VUE_APP_API_PATH}/employees/`, data)
        .then(response => {
          if ("error" in response.data) {
            alert(response.data.error);
            this.cancel();
          } else {
            this.originalData = JSON.parse(JSON.stringify(this.employee));
            this.isEditing = false;
          }
        });
    },
    cancel: function() {
      this.employee = JSON.parse(JSON.stringify(this.originalData));
      this.isEditing = false;
    }
  },
  watch: {
    data: function(newVal, oldVal) {
      this.employee = newVal;
      this.originalData = JSON.parse(JSON.stringify(this.employee));
    }
  },
  mounted() {
  }
};
</script>

<style scoped lang="scss">
.employee-info {
  .view {
    border-color: transparent;
    background-color: initial;
    color: initial;
  }

  input {
    width: 300px;
    height: 30px;
    font-size: 16px;
  }
}
</style>
