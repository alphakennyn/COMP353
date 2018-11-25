<template>
  <div class="container">
    <h1>{{employeeName}}</h1>
    <EmployeeInfo :data='employeeData' />
    <button @click="getPayroll()">Payroll</button>
    <modal name="showPayroll" height='auto'>
      <PayrollInfo :data="payroll" />
    </modal>
    <ScheduleInfo :data='schedule' />
  </div>
  
</template>

<script>
import EmployeeInfo from "@/components/EmployeeInfo.vue";
import ScheduleInfo from "@/components/ScheduleInfo.vue";
import PayrollInfo from "@/components/PayrollInfo.vue";

export default {
  name: "EmployeePage",
  components: {
    EmployeeInfo,
    ScheduleInfo,
    PayrollInfo
  },
  props: {
    id: String
  },
  data() {
    return {
      employeeName: '',
      employeeData: {},
      schedule: [],
      payroll: []
    }
  },
  methods: {
    getPayroll: function() {
      this.$http
      .get(`${process.env.VUE_APP_API_PATH}/timeclock?id=${this.id}`)
      .then(response => {
        this.payroll = response.data;
        this.$modal.show("showPayroll");
      }).catch(error => {
          alert(error);
      });
    }
  },
  mounted: function() {
    this.labels = {
      category: "Category",
      phone: "Phone Number",
      title: "Title",
      email: "Email",
      address: "Address",
      joinDate: "Join date",
      DOB: "Date of Birth",
      cardNumber: "Card Number"
    };
    this.$http
      .get(`${process.env.VUE_APP_API_PATH}/employees?id=${this.id}`)
      .then(response => {
        this.employeeName = response.data.fullName;
        this.employeeData = response.data;
        delete this.employeeData['fullName']
      }).catch(error => {
          alert(error);
      });

    this.$http
      .get(`${process.env.VUE_APP_API_PATH}/schedule?eid=${this.id}`)
      .then(response => {
        console.log(response.data);
        this.schedule = response.data;
      }).catch(error => {
          alert(error);
      });
  }

};
</script>

<style lang="scss" scoped>

</style>
