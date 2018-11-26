<template>
  <div class="account-info">
    {{isEditing}}
    <div class="item" v-for="(item, keyValue) in data" :key="keyValue">
      <strong>{{keyValue}}</strong>: {{data[keyValue]}}
    </div>
  </div>
</template>

<script>
export default {
  name: "account-info",
  props: {
    data: Object,
    isEditing: Boolean
  }
};
</script>

<style scoped lang="scss">
.account-info {
    .view {
      border-color: transparent;
      background-color: initial;
      color: initial;
    }
    .item {
      padding: 5px 10px 5px 0px;
    }
}
</style>
