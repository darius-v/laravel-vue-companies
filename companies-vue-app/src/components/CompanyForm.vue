<template>

    <Dialog  header="Header" :visible="displayForm" @update:visible="$emit('update:display-form', $event)">
        Content

    </Dialog>
<!--    <button @click="openModal"></button>-->
</template>

<script>

import Dialog from 'primevue/dialog';

export default {
    data() {
        return {
            display: this.displayForm,  // getting from prop
            modal: true
        }
    },
    props: {
        displayForm: Boolean,
    },
    // methods: {
    //     openModal() {
    //         // this.displayModal = true;
    //         this.display = true;
    //     },
    // },
    // methods: {
        // started() {
        //     console.log('started in company form');
        // }
    // },
    name: 'CompanyForm',
    components: {
        Dialog,
    },

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
