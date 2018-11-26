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
    data: Object,
    isEditing: Boolean
  },
  mounted: () => {
    console.log('User type of: ', typeof this.data)
    console.log('User mounted: ', this.data)
  },
  computed: function() {
    const d = this.data;

    return d.reduce((acc, red) => {
      if (red === '')
      acc[red] = d[red];
      return acc;
    }, {})
    // data: function() {
    //   return Object.keys(this.data);
    // }
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
