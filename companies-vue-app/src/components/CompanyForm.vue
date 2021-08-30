<template>

    <!-- that way visibility is controller from other component  -->
    <Dialog  header="Company" :visible="displayForm" @update:visible="$emit('update:display-form', $event)">
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
// import FileUpload from 'primevue/fileupload';
import Button from 'primevue/button';

export default {
    data() {
        return {
            display: this.displayForm,  // getting from prop

            name: '',
            email: '',
            phone: ''
        }
    },
    methods: {
        async addCompany() {
            console.log('test' + this.name);
            // todo use base url
            await fetch('http://localhost:8000/index.php/api/companies', {
                method: 'POST',
                body: JSON.stringify({name: this.name, email: this.email, phone: this.phone})
            })

            this.name = '';
            this.email = '';
            this.phone = '';
            this.$emit('update:display-form', false);

            // const company = await res.json();
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
        // FileUpload,
        Button
    },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>


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
