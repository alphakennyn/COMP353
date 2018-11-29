<template>
  <tr class="transaction-row">
    <td>{{billData.id}}</td>
    <td>{{billData.amountToPay}}</td>
    <td>{{billData.totalAmount}}</td>
    <td>{{billData.payee}}</td>
    <td>{{billData.dueDate}}</td>
    <td>{{billData.isPaid}}</td>
    <td>
        <toggle-button
          v-on:change="toggleAutoPay()" 
          color="#82C7EB"
          :value="futurePay"
          :sync="true"
          v-model="futurePay"
          :labels="{checked: 'Yes', unchecked: 'No'}"
        />
    </td>
    <td>
      <input 
        type="checkbox"
        :disabled="billData.isPaid"
        v-model="billData.wantToPay"
        
      />  
    </td>
  </tr>
</template>

<script>
export default {
  name: 'bill',
  data(){
    return{
      futurePay: false,
    }
  },

  props: {
    billData: Object,
    clickHandle: Function,
  },
  computed: {
    billPayStatus() {
      return this.billData.wantToPay
    }
  },
  mounted: function(){
    this.billData.autoPay === "0" ? this.futurePay = false: this.futurePay= true;
  },
  methods: {
    toggleAutoPay: function(){
      const billid = this.billData.id;
      this.$http.post(`${process.env.VUE_APP_API_PATH}/bills/`, billid).then((result) => {        
          //console.log(result);
        }).catch(err => {
          swal('Connection to DB lost');
        })
    }
  },
  watch: {
    billPayStatus() {
      // if(this.billData.wantToPay) {
        this.clickHandle();
      //}
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.transaction-row{
  background-color: #ebebeb;
  td{
    width: 15%;
    text-align: center;
  }
}
</style>
