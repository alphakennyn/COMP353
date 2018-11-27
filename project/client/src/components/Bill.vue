<template>
  <tr class="transaction-row">
    <td>{{billData.id}}</td>
    <td>{{billData.amountToPay}}</td>
    <td>{{billData.totalAmount}}</td>
    <td>{{billData.payee}}</td>
    <td>{{billData.dueDate}}</td>
    <td>{{billData.isPaid}}</td>
    <td>
      <input 
        type="checkbox"
        v-model="billData.wantToPay"
        
      />
    </td>
  </tr>
</template>

<script>
export default {
  name: 'bill',
  props: {
    billData: Object,
    clickHandle: Function,
  },
  computed: {
    billPayStatus() {
      return this.billData.wantToPay
    }
  },
  watch: {
    billPayStatus() {
      // if(this.billData.wantToPay) {
        this.clickHandle();
      //}
    }
  }
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
