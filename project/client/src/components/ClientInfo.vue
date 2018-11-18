<template>
  <div class="client__info">
    <div class="item" v-for="(item, keyValue) in data" :key="keyValue">
      <strong>{{keyValue}}</strong>: {{data[keyValue]}}
    </div>
  </div>
</template>

<script>
export default {
  name: "client-info",
  props: {
    data: Object
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
