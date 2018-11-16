<template>
  <div class="account-card">
    <div class="account-title">
      <h3>{{account.accountType}}</h3>
    </div>
    {{account.balance}}
  </div>
</template>

<script>
export default {
  name: 'account',
  props: {
    account: Object,
  },
  mounted: function() {
    // conosle.log(this.account);
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.account-card {
  border-radius: 7px;
  box-shadow: -2px 2px 11px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
  padding: 10px 20px;
  height: inherit;

  .account-title {
    text-align: center
  }
}

</style>
