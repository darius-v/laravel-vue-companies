<template>

    <!-- that way visibility is controlled from other component  -->
    <Dialog  header="Company" :visible="displayForm" @update:visible="$emit('update:display-form', $event)">
        <Message v-for="msg of messages" severity="error" :key="msg">{{msg}}</Message>
        <h5>Name</h5>
        <InputText type="text" v-model="name" />
        <h5>Email</h5>
        <InputText type="email" v-model="email" />

        <h5>Phone</h5>
        <InputText type="text" v-model="phone" />

<!--        todo - after company is created so could assign-->
<!--        <h5>Logo</h5>-->
<!--        <FileUpload name="demo[]" url="./upload" />-->

        <div>
            <Button @click="addCompany" label="Submit" />
        </div>

    </Dialog>
</template>

<script>

import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import CompanyService from "./service/CompanyService";
import Message from 'primevue/message';

export default {
    data() {
        return {
            name: '',
            email: '',
            phone: '',
            messages: []
        }
    },
    companyService: null,
    created() {
        this.companyService = new CompanyService();
    },
    methods: {
        async addCompany() {
            this.companyService.create(this.name, this.email, this.phone)
                .then(() => {
                    this.name = '';
                    this.email = '';
                    this.phone = '';
                    this.$emit('update:display-form', false);
                    this.messages = [];
                })
                .catch((error) => {
                    if (error.response) {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx

                        let object = error.response.data.errors;
                        for (const property in object) {
                            console.log(`${property}: ${object[property]}`);
                            this.messages.push(`${object[property]}`);
                        }
                    }
                });
            // todo add to array of companies, array can be in different component
        }
    },
    props: {
        displayForm: Boolean,
    },

    name: 'CompanyForm',
    components: {
        Dialog,
        InputText,
        Button,
        Message
    },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

.p-button {
    margin: 0.3rem .5rem;
    min-width: 10rem;
}

</style>
