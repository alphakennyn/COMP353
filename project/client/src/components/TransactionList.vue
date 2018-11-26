<template>
  <div>
  <h3>Transactions</h3>
  <div>
    You are allowed {{acc.transactionsPerMonth}} transactions per month and
    currently have {{acc.transactionsLeft}} transactions left this month.
  </div>
  <div v-if="transactions.hasOwnProperty(acc.accountNumber) && transactions[acc.accountNumber].length!=0">
  <table class="transaction-list">
    <thead>
      <tr>
        <th>Transaction ID</th>
        <th>Date and Time</th>
        <th>Type</th>
        <th>Amount</th>
        <th>Branch ID</th>
      </tr>
    </thead>
    <tbody v-for='transaction in transactions[acc.accountNumber]' :key='transaction.tStamp'>
      <Transaction :transaction='transaction'/>    
    </tbody>
  </table>
  </div>
  <div v-else>
    <strong>No transactions to display here :-()</strong>
  </div>
  </div>
</template>

<script>
import Transaction from '@/components/Transaction.vue'

export default {
  name: 'TransactionList',
  components: {
    Transaction
  },
  props: {
    client: String,
    acc: Object,
  },
  data() {
    return {
      transactions: {},
    }
  },
  methods: {

  },
  mounted: function() {
    this.$http
      .get(`${process.env.VUE_APP_API_PATH}/transactions?clientID=${this.client}`)
      .then(response => {
        this.transactions = response.data;
        console.log(response.data);
      })
      .catch(err => {
        alert('uh oh.. no transaction  found');
      });
  },
};
</script>
