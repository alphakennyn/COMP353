<template>
  <div class="menu">
    <a class="menu__item" @click="toggleMenu('transactions')">
      Transaction History
    </a>
    <span>|</span>
    <a class="menu__item" @click="toggleMenu('transfer')">
      Transfer Money 
    </a>
    <span>|</span>
    <a class="menu__item" @click="toggleMenu('pay')">
      Pay Bills
    </a>
    <span>|</span>
    <a class="menu__item" @click="toggleMenu('etransfer')">
      e-transfer 
    </a>
  </div>
</template>

<script>
export default {
  name: "account",
  props: {
    toggleMenu: Function
  }
};
</script>

<style scoped lang="scss">
.menu {
  display: flex;
  margin: 15px 0px;
  span {
    padding: 0px 15px;
  }
  a {
    text-decoration: underline;
  }
}
</style>
