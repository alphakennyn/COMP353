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
    cached: Object,
    eid: Number,
  },
  data() {
    return {
      isEditing: false,
      employee: {},
      allowToEdit: ["ephone", "address"],
      labels: {
        phone: "Branch phone",
        fax: "Branch Fax",
        location: "Branch location",
        city: "Branch City",
        openingDate: "Opening Date",
        revenue: "Branch Revenue ($)",
        category: "Category",
        ephone: "Employee Phone",
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
        ephone: this.employee.ephone,
        address: this.employee.address
      }

      this.$http
        .post(`${process.env.VUE_APP_API_PATH}/employees/`, data)
        .then(response => {
          // delete this.user.id;
          if ("error" in response.data) {
            alert(response.data.error);
            this.cancel();
          } else {
            this.cached = Object.assign({}, this.employee);
            this.isEditing = false;
          }
        });
      console.log(data)

    },
    cancel: function() {
      console.log(this.cached);
      this.employee = Object.assign({}, this.cached);
      this.isEditing = false;
    }
  },
  watch: {
    data: function(newVal, oldVal) {
      this.employee = newVal;
      delete this.employee["managerId"];
      delete this.employee["eid"];
      delete this.employee["bid"];
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
