<template>
  <div class="menu">
    <a class="menu__item" :class="{ active: isActive('info') }" @click="toggleMenu('info')">
      Account Information
    </a>
    <span>|</span>
    <a class="menu__item" :class="{ active: isActive('transactions') }" @click="toggleMenu('transactions')">
      Transaction History
    </a>
    <span>|</span>
    <a class="menu__item" :class="{ active: isActive('transfer') }" @click="toggleMenu('transfer')">
      Transfer Money 
    </a>
    <span>|</span>
    <a class="menu__item" :class="{ active: isActive('pay') }" @click="toggleMenu('pay')">
      Pay Bills
    </a>
    <span>|</span>
    <a class="menu__item"  :class="{ active: isActive('etransfer') }" @click="toggleMenu('etransfer')">
      e-Transfer 
    </a>
  </div>
</template>

<script>
export default {
  name: "account",
  props: {},
  data() {
    return {
      activeItem: 'info'
    }
  },
  methods: {
    isActive: function (menuItem) {
      return this.activeItem === menuItem
    },
    toggleMenu: function(menu) {
      this.activeItem = menu;
      this.$emit('clickedMenu', menu);
    }
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
  .active {
    font-weight: bold;
  }
}
</style>
