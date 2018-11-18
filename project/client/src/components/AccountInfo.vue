<template>
  <div class="account-info">
    <div class="item" v-for="(item, keyValue) in data" :key="keyValue">
      <strong>{{keyValue}}</strong>: {{data[keyValue]}}
    </div>
  </div>
</template>

<script>
export default {
  name: "account-info",
  props: {
    data: Object
  }
};
</script>

<style scoped lang="scss">
.account-info {

}
</style>
