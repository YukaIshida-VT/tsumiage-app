<template>
    <div>
        <div id="DateTimeDisp" class="mb-4"></div>
        <form @submit.prevent="submitForm">
            <InputField name="tsumiage1" label="積み上げその1" :errors="errors"
            placeholder="" @update:field="form.tsumiage1 = $event" />
            <InputField name="tsumiage2" label="積み上げその2" :errors="errors"
            placeholder="" @update:field="form.tsumiage2 = $event" />
            <InputField name="tsumiage3" label="積み上げその3" :errors="errors"
            placeholder="" @update:field="form.tsumiage3 = $event" />
            <InputField name="tsumiage4" label="積み上げその4" :errors="errors"
            placeholder="" @update:field="form.tsumiage4 = $event" />

            <div class="flex justify-end">
                <router-link to="/contacts" class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">
                    Cancel
                </router-link>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">今日の積み上げ作成</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from '../components/InputField';

    export default {
        name: "TsumiageCreate",

        components: {
            InputField
        },

        data: function () {
            return {
                form: {
                    'tsumiage1': '',
                    'tsumiage2': '',
                    'tsumiage3': '',
                    'tsumiage4': '',
                },

                errors: null,
            }
        },

        mounted() {
            this.displayToday();
        },

        methods: {
            submitForm: function () {
                axios.post('/api/contacts', this.form)
                    .then(response => {
                        this.$router.push(response.data.links.self);
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },

            displayToday: function () {
                var now = new Date();
                var Year = now.getFullYear();
                var Month = now.getMonth()+1;
                var Day = now.getDate();

                document.getElementById("DateTimeDisp").innerHTML = Year + "年" + Month + "月" + Day + "日";
            },
        }
    }
</script>

<style scoped>

</style>