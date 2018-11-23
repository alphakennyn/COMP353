<template>
  <div>
  <h3>Transactions</h3>
  <div>
    You are allowed {{transactions_left}} transactions per month and
    currently have {{transactions_pm}} transactions left this month.
  </div>
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
    <tbody v-for='transaction in transactions' :key='transaction.tStamp'>
      <Transaction :transaction='transaction'/>    
    </tbody>
  </table>
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
    data: Object,
  },
  data() {
    return {
      transactions: [],
      transactions_left: Object,
      transactions_pm: Object
    }
  },
  methods: {

  },
  mounted: function() {
    this.$http
      .get(`${process.env.VUE_APP_API_PATH}/transactions?accountNumber=${this.data.accountNumber}`)
      .then(response => {
        this.transactions = response.data.account_transactions;
        this.transactions_left = response.data.transactions_left;
        this.transactions_pm = response.data.transactions_pm;
      })
      .catch(err => {
        alert('uh oh.. no transaction  found');
      });
  },
};
</script>
