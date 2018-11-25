<template>
  <tr class="transaction-row">
    <td>{{transaction.id}}</td>
    <td>{{transaction.tStamp}}</td>
    <td>{{transaction.transType}}</td>
    <td>{{formatedMoney}}</td>
    <td>{{transaction.bid}}</td>
  </tr>
</template>

<script>
export default {
  name: 'transaction',
  props: {
    transaction: Object,
  },
  computed: {
    formatedMoney: function(){
      return '$' + this.transaction.amount + '.00';
    }
  },
  mounted: function() {
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
