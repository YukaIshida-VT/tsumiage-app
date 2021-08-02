<template>
    <div>
        <div class="flex justify-between">
            <a href="#" class="text-blue-400" @click="$router.back()">
                < Back
            </a>
        </div>

        <form @submit.prevent="submitForm" class="pt-6">
            <InputField name="item1" label="項目1" :errors="errors"
            placeholder="" @update:field="form.item1 = $event" :data="form.item1" />
            <InputField name="item2" label="項目2" :errors="errors"
            placeholder="" @update:field="form.item2 = $event" :data="form.item2" />
            <InputField name="item3" label="項目3" :errors="errors"
            placeholder="" @update:field="form.item3 = $event" :data="form.item3" />
            <InputField name="item4" label="項目4" :errors="errors"
            placeholder="" @update:field="form.item4 = $event" :data="form.item4" />
            <InputField name="item5" label="項目5" :errors="errors"
            placeholder="" @update:field="form.item5 = $event" :data="form.item5" />
            <InputField name="item6" label="項目6" :errors="errors"
            placeholder="" @update:field="form.item6 = $event" :data="form.item6" />
            <InputField name="item7" label="項目7" :errors="errors"
            placeholder="" @update:field="form.item7 = $event" :data="form.item7" />
            <InputField name="item8" label="項目8" :errors="errors"
            placeholder="" @update:field="form.item8 = $event" :data="form.item8" />
            <InputField name="item9" label="項目9" :errors="errors"
            placeholder="" @update:field="form.item9 = $event" :data="form.item9" />
            <InputField name="item10" label="項目10" :errors="errors"
            placeholder="" @update:field="form.item10 = $event" :data="form.item10" />
            <InputField name="item11" label="項目11" :errors="errors"
            placeholder="" @update:field="form.item11 = $event" :data="form.item11" />
            <InputField name="item12" label="項目12" :errors="errors"
            placeholder="" @update:field="form.item12 = $event" :data="form.item12" />
            <InputField name="item13" label="項目13" :errors="errors"
            placeholder="" @update:field="form.item13 = $event" :data="form.item13" />
            <InputField name="item14" label="項目14" :errors="errors"
            placeholder="" @update:field="form.item14 = $event" :data="form.item14" />
            <InputField name="item15" label="項目15" :errors="errors"
            placeholder="" @update:field="form.item15 = $event" :data="form.item15" />
            <InputField name="item16" label="項目16" :errors="errors"
            placeholder="" @update:field="form.item16 = $event" :data="form.item16" />
            <InputField name="item17" label="項目17" :errors="errors"
            placeholder="" @update:field="form.item17 = $event" :data="form.item17" />
            <InputField name="item18" label="項目18" :errors="errors"
            placeholder="" @update:field="form.item18 = $event" :data="form.item18" />
            <InputField name="item19" label="項目19" :errors="errors"
            placeholder="" @update:field="form.item19 = $event" :data="form.item19" />
            <InputField name="item20" label="項目20" :errors="errors"
            placeholder="" @update:field="form.item20 = $event" :data="form.item20" />

            <div class="flex justify-end">
                <router-link to="/home" class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">
                    Cancel
                </router-link>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from '../components/InputField';

    export default {
        name: "ItemsEdit",

        components: {
            InputField
        },

        mounted() {
            axios.get('/api/contacts/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    if (error.response.status === 404) {
                        this.$router.push('/contacts');
                    }
                });
        },

        data: function() {
            return {
                form: {
                    'name': '',
                    'email': '',
                    'company': '',
                    'birthday': '',
                    'contact_id': '',
                },

                errors: null,
            }
        },

        methods: {
            submitForm: function() {
                axios.patch('/api/contacts/' + this.$route.params.id, this.form)
                    .then(response => {
                        this.$router.push(response.data.links.self);
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            }
        }
    }
</script>

<style scoped>

</style>