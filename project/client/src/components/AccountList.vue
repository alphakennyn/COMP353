<template>
  <div class="account-list">
    <h3>Your account</h3>
    <button @click="addAccount()">Add</button>
    <AddAccountForm v-if="toggleAddAccount" :clientId='clientId'/>
    <div v-for='account in accounts' :key='account.accountNumber'>
      <Account :account='account'/>
    </div>
  </div>
</template>

<script>
import Account from '@/components/Account.vue'
import AddAccountForm from '@/components/AddAccountForm.vue'

export default {
  name: 'AccountList',
  components: {
    Account,
    AddAccountForm
  },
  props: {
    clientId: Number,
  },
  data() {
    return {
      toggleAddAccount: false,
      accounts: []
    }
  },
  methods: {
    addAccount: function() {
      this.toggleAddAccount = !this.toggleAddAccount;
    }
  },
  mounted: function() {
    this.$http
      .get(`${process.env.VUE_APP_API_PATH}/accounts?user_id=${this.clientId}`)
      .then(response => {
        this.accounts = response.data.user_accounts;
      })
      .catch(err => {
        alert('uh oh.. no account found');
      });
  },
};
</script>
