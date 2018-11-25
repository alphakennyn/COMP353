<template>
<div class="payroll">
  <h1>Payroll</h1>
  <strong> Enter clock in time (YYYY-MM-DD HH:MM:SS): </strong> <br>
  <input v-model.trim="newClockIn"/> <br>
  <strong> Enter clock out time (YYYY-MM-DD HH:MM:SS): </strong> <br>
  <input v-model.trim="newClockOut"/> <br>
  <button v-if="showBtn" @click='submitClock'>Submit</button>
  <br><br>
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
    data: Array,
    eid: Number
  },
  data() {
    return {
      newClockIn: '',
      newClockOut: ''
    };
  },
  methods: {
    submitClock: function() {
      const data = {
        "eid": this.eid,
        "clockIn": this.newClockIn,
        "clockOut": this.newClockOut
      };
      
      if (data.clockIn == '' || data.clockOut == '') {
        alert('Please input correct fields');
        return;
      }
      this.$http
        .post(`${process.env.VUE_APP_API_PATH}/timeclock/`, data)
        .then(response => {
          if ("error" in response.data) {
            alert("Error post!");
          } else {
            this.newClockIn = '';
            this.newClockOut = '';
            this.data = response.data.map(x => x);
          }
        });
    }
  },
  computed: {
    showBtn: function() {
      return this.newClockIn !== "" && this.newClockOut !== "";
    }
  }
};
</script>

<style scoped lang="scss">
.payroll {
  margin: 50px;
  input {
    width: 200px;
    height: 25px;
  }
  table {
    tr {
      text-align: left;
    }
    td {
      width: 200px;
    }
  }
  button {
    margin-top: 10px;
    padding: 10px 15px;
  }
}
</style>
