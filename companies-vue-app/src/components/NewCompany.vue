<template>
  <div>
      <Button label="New" @click="openNewCompanyDialog">test</Button>

      <CompanyForm  v-model:displayForm="displayForm" />

  </div>
</template>

<script>

import Button from "primevue/button";
import CompanyForm from "./CompanyForm";

export default {
    name: 'NewCompany',
    data() {
        return {
            displayForm: false,
        }
    },
    components: {
        Button,
        CompanyForm
    },
    methods: {
        openNewCompanyDialog() {
            this.displayForm = true;
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

    div {
        border: 1px solid;
        text-align: left;
    }

    .p-button {
        margin: 0.3rem .5rem;
        min-width: 10rem;
    }

</style>
