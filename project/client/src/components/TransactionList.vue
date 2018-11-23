<template>
  <table class="transaction-list">
    <h3>Transactions</h3>
    <tbody v-for='transaction in transactions' :key='transaction.tStamp'>
      <Transaction :transaction='transaction'/>    
    </tbody>
  </table>
</template>

<script>
import Transaction from '@/components/Transaction.vue'

export default {
  name: 'TransactionList',
  components: {
    Transaction
  },
  props: {
    data: Object,
  },
  data() {
    return {
      transactions: []
    }
  },
  methods: {
    
  },
  mounted: function() {
    this.$http
      .get(`${process.env.VUE_APP_API_PATH}/transactions?accountNumber=${this.data.accountNumber}`)
      .then(response => {
        this.transactions = response.data.account_transactions;
      })
      .catch(err => {
        alert('uh oh.. no transaction  found');
      });
  },
};
</script>
