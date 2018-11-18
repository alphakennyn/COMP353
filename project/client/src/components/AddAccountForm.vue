
<template>
  <div class="account-form">
    <select v-model="newAccount.accountType">
      <option v-for='(account, keyValue) in accounts' :value='keyValue' :key='keyValue' >{{keyValue}}</option>
    </select>
    <input v-if='accounts[newAccount.accountType] && accounts[newAccount.accountType].minBalance' placeholder="min balance" v-model.trim="newAccount.minBalance"/>
    <input v-if='accounts[newAccount.accountType] && accounts[newAccount.accountType].businessNumber' placeholder="Business Number" v-model.trim="newAccount.businessNumber"/>
    <input v-if='accounts[newAccount.accountType] && accounts[newAccount.accountType].taxId' placeholder="Tax Id ?" v-model.trim="newAccount.taxId"/>
    <input v-if='accounts[newAccount.accountType] && accounts[newAccount.accountType].creditLimit' placeholder="Credit Limit" v-model.trim="newAccount.creditLimit"/>
    <button  v-if='accounts[newAccount.accountType]' @click='submit()'>Create Account</button>
  </div>
</template>

<script>
export default {
  name: 'AccAccountForm',
  data() {
    return {
      chargeplanList: [], //http get
      investmentRateList: [], //http get
      accountType: '',
      newAccount: {
        cid: this.clientId,
        accountType: '',
        cpid: 1,
        irid: 1,
        balance: 0,
        transactionPerMonth: 0,
        maxPerDay: 0,
        minBalance: null,
        businessNumber: null,
        taxId: null,
        creditLimit: null
      },
      accounts: {
        Business: {
          minBalance: true,
          businessNumber: true,
          taxId: true,
          creditLimit: false,
        },
        Checking: {
          minBalance: false,
          businessNumber: false,
          taxId: false,
          creditLimit: false,
        },
        "Credit Card": {
          minBalance: false,
          businessNumber: false,
          taxId: false,
          creditLimit: true,
        },
        "Foreign Corrency": {
          minBalance: true,
          businessNumber: false,
          taxId: false,
          creditLimit: false,
        },
        Insurance: {
          minBalance: false,
          businessNumber: false,
          taxId: false,
          creditLimit: false,

        },
        Investment: {
          minBalance: true,
          businessNumber: false,
          taxId: false,
          creditLimit: false,

        },
        'Line of Credit': {
          minBalance: false,
          businessNumber: false,
          taxId: false,
          creditLimit: true,

        },
        'Savings': {
          minBalance: true,
          businessNumber: false,
          taxId: false,
          creditLimit: false,

        }
      }
    }
  },
  props: {
    toggleAccountForm: Boolean,
    clientId: Number
  },
  methods: {
    submit: function() {
      this.$http.post(`${process.env.VUE_APP_API_PATH}/accounts/`, this.newAccount).then(result => {
        this.$emit('clicked', result.data)
      })
    },
  },
  mounted: function() {}
};
</script>
