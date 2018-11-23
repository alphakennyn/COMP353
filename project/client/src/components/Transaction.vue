<template>
  <tr class="transaction-row">
    <td>{{transaction.transNumber}}</td>
    <td>{{transaction.tStamp}}</td>
    <td>{{transaction.transType}}</td>
    <td>{{formatMoney(transaction.amount)}}</td>
    <td>{{transaction.bid}}</td>
  </tr>
</template>

<script>
export default {
  name: 'transaction',
  props: {
    transaction: Object,
  },
  methods: {
    formatMoney: function(amount){
      return '$' + amount + '.00';
    }
  },
  mounted: function() {
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.transaction-row{
  background-color: #f3f3f3;
  td{
    width: 15%;
    text-align: center;
  }
}
</style>
