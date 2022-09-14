<template>
    <div class="v-form-second-step" id="v-form-second-step">
        <div class="agileits-top-second" id="agileits-top-second">

            <!--Errors displaying-->
            <div id="errors" v-if="errors">
                <div v-for="(v,k) in errors" :key="k"
                     class="bg-red-500 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
                    <p v-for="error in v" :key="error" class="text-sm">
                        {{ error }}
                    </p>
                </div>
            </div>

            <!--second step-->
            <form class="second-form" id="second-form" enctype="multipart/form-data" @submit="toThirdStep">

                <!--Company-->
                <label class="label_input" id="company_label"
                       for="company">Your
                    company:</label>
                <input class="text" type="text" id="company" name="company" placeholder="Company">
                <br>

                <!--Position-->
                <label class="label_input" id="position_label"
                       for="position">Your
                    position:</label>
                <input class="text email" type="text" id="position" name="position"
                       placeholder="Position">

                <!--About me-->
                <label class="label_input" id="about_me_label"
                       for="about_me">Tell
                    us something about yourself:</label>
                <textarea class="form-control" name="about_me" placeholder="About me"
                          id="about_me" rows="4"></textarea>

                <!--Photo-->
                <label class="photoLable" for="formFileLg">Photo:</label>
                <input class="form-control form-control-lg"
                       id="formFileLg"
                       name="photo" type="file" accept=".jpg,.png,.jpeg">
                <input type="submit" value="Next">
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "v-form-second-step",
    components: {},
    data: function () {
        return {
            errors: []
        }
    },
    mounted() {

    },
    methods: {
        showThirdStep: function () {
            $('#first-form').hide('slow')
            $('#agileits-top-first').hide('slow')
            document.querySelector('.agileits-top-second').style.display = ''
            this.$emit('session', {
                data: 'third_form'
            })
        },
        toThirdStep: function (e) {
            e.preventDefault();

            let form = document.querySelector('.second-form')
            let data = new FormData(form)

            for (let i = 0; i < Object.values(form).length - 1; i++) {
                Object.values(form)[i].style.border = ''
            }

            axios.post('/api/saveSecondStep', data)
                .then((msg) => {
                    console.log(msg)
                    this.showThirdStep();
                })
                .catch((e) => {
                    if (e.response.status === 422) {
                        this.errors = [];

                        this.errors = e.response.data.errors
                        Object.keys(e.response.data.errors).forEach((e) => {
                            document.getElementById(e).style.border = '1px solid red'
                        })
                        document.getElementById('agileits-top-first').scrollIntoView();

                    }
                })
        }
    }
}
</script>
