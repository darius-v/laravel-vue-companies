<template>
  <div>
      <Button label="New" @click="sendData">test</Button>

      <CompanyForm  v-model:displayForm="displayForm" />

  </div>
</template>

<script>

import Button from "primevue/button";
import CompanyForm from "./CompanyForm";

export default {
    name: 'NewCompany',
    // methods: {
    //     openModal() {
    //         this.$emit('open_new_company_modal');
    //     },
    // },
    data() {
        return {
            displayForm: false,
        }
    },
    components: {
        Button,
        CompanyForm
    },
    // setup(props, context) {
    //     console.log(context);
    //     console.log('darius');
    //     function openModal() {
    //         context.emit('open_new_company_modal');
    //         console.log('emitted');
    //     }
    //     return {
    //         openModal
    //     }
    // },
    methods: {
        sendData() {
            // console.log('sendData in new company');
            // this.$emit('sending-start');
            //
            // this.$emit('sending-complete');
            this.displayForm = true;
        }
    }
    // emits: ['open_new_company_modal'],
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
