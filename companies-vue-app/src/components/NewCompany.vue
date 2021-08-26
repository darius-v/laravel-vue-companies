<template>
  <div>
      <Button label="New"></Button>
  </div>
</template>

<script>

import Button from "primevue/button";

export default {
  name: 'NewCompany',
  components: {
      Button
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
/* todo use bootstrap */
    div {
        border: 1px solid;
        text-align: left;
    }
</style>
