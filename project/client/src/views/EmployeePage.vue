<template>
<div class="employee-page">
  <div class="container">
    <h1>{{employeeName}}</h1>
    <EmployeeInfo :data='employeeData' :eid='parseInt(id)'/>
    <button class="payroll-btn" @click="getPayroll()">Payroll</button>
    <button @click='deleteAccount()' v-if='!cantDelete.includes(employeeData.title)' class="delete-btn">DELETE ACCOUNT</button>
    <br>
    <button v-if='cantDelete.includes(employeeData.title)' class="bank-btn" @click="getBank()">Toggle Bank Info</button>
    <div v-if="showBankInfo">
      <div v-for="(bank, index) in bankInfo" :key='index'>
        <h3>Branch id {{bank.bid}}: ${{bank.Profit}} ({{bank.city}})</h3>
      </div>
      <h2>Bank total = ${{sumBank}}</h2>
      <div v-for="(value, key) in sumCitys" :key='key'>
        <h3>{{key}}: ${{value}}</h3>
      </div>
    </div>
    <modal name="showPayroll" height='auto'>
      <PayrollInfo :data="payroll" :eid='parseInt(id)'/>
    </modal>
    <ScheduleInfo :data='schedule' />
  </div>

</div>
</template>
<script>
import EmployeeInfo from "@/components/EmployeeInfo.vue";
import ScheduleInfo from "@/components/ScheduleInfo.vue";
import PayrollInfo from "@/components/PayrollInfo.vue";
import swal from "sweetalert2";

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
      showBankInfo: false,
      cantDelete: ["Manager", "President", "Investment Manager", "Insurance Manager", "Banking Manager"],
      employeeName: "",
      employeeData: {},
      schedule: [],
      payroll: [],
      bankInfo: [],
      sumBank: '',
      sumCitys: {}
    };
  },
  methods: {
    getPayroll: function() {
      this.$http
        .get(`${process.env.VUE_APP_API_PATH}/timeclock?id=${this.id}`)
        .then(response => {
          this.payroll = response.data;
          this.$modal.show("showPayroll");
        })
        .catch(error => {
          alert(error);
        });
    },
    getBank: function() {
      this.$http
        .get(`${process.env.VUE_APP_API_PATH}/revenue/`)
        .then(response => {
          console.log(response.data);
          this.bankInfo = response.data;
          this.showBankInfo = !this.showBankInfo;
          let bankTotal = this.bankInfo.reduce((prev, cur) => {
            return parseFloat(prev) + parseFloat(cur.Profit);
          }, 0);
          this.sumBank = bankTotal;

          let test = {}
          this.bankInfo.forEach(x => {
            let city = x.city;

            if (test.hasOwnProperty(city)) {
              test[x['city']] = test[x['city']] + x['Profit'];
            } else {
              test[x['city']] = x['Profit']
            }
            // if (x.city in test) {
            //   test[x.city] = test[x.city] + x.Profit;
            // } else {
            //   test[x.city] = x.Profit;
            // }
          })
          this.sumCitys = test;
          console.log(test);
        })
        .catch(error => {
          alert(error);
        });
    },
    deleteAccount: function() {
      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          const data = {id: this.id};
          this.$http
            .post(`${process.env.VUE_APP_API_PATH}/delemployee/`, data)
            .then(response => {
              if (response.data.hasOwnProperty("error") ) {
                alert("Oops couldn't delete account!")
              } else {
                this.$router.replace({ path: `/` });
              }
            })
            .catch(error => {
              alert(error);
            });
        }
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
        delete this.employeeData["fullName"];
      })
      .catch(error => {
        alert(error);
      });

    this.$http
      .get(`${process.env.VUE_APP_API_PATH}/schedule?eid=${this.id}`)
      .then(response => {
        console.log(response.data);
        this.schedule = response.data;
      })
      .catch(error => {
        alert(error);
      });
  },
  beforeCreate() {
    if (!this.$session.get('id')) {
      this.$router.push('/')
    } else {
      this.$emit("authenticated", true);
    }
  },
};
</script>

<style lang="scss" scoped>
.employee-page {
  padding: 50px 0px;
  .payroll-btn {
    background-color: #50b83c;
    border: 1px solid #50b83c;
    margin-top: 15px;
    padding: 10px 15px;
    color: white;
  }
  .delete-btn {
    margin-left: 25px;
    background-color: #DE3618;
    border: 1px solid #DE3618;
    margin-top: 15px;
    padding: 10px 15px; 
    color: white;
  }
  .bank-btn {
    margin-top: 15px;
    padding: 10px 15px; 
  }
}
</style>
