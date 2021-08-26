<template>
  <div>
      <Button label="New" @click="openModal"></Button>
      <Dialog header="Header" v-model:visible="display" >
          Content
<!--          <template #footer>-->
<!--              <Button label="Cancel" icon="pi pi-times" class="p-button-text"/>-->
<!--              <Button label="Create" icon="pi pi-check" autofocus />-->
<!--          </template>-->
      </Dialog>
  </div>
</template>

<script>

// import PrimeVue from 'primevue';
import Button from "primevue/button";
import Dialog from 'primevue/dialog';

export default {
    data() {
        return {
            display: false,
            modal: true
        }
    },
    methods: {
        openModal() {
            this.displayModal = true;
            // this.displayModal = true;
            this.display = true;
        },
    },
    name: 'NewCompany',
    components: {
        Button,
        Dialog,
        // PrimeVue
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

.p-button {
    margin: 0.3rem .5rem;
    min-width: 10rem;
}

p {
    margin: 0;
}

.confirmation-content {
    display: flex;
    align-items: center;
    justify-content: center;
}

.p-dialog .p-button {
    min-width: 6rem;
}
</style>
