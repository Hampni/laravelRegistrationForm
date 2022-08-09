<template>
    <div class="v-form">
        <!-- main -->
        <div class="main-w3layouts wrapper">

            <div class="chart-align">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3303.7615498731893!2d-118.34587228458561!3d34.1012485
22592996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2bf20e4c82873%3A0x14015754d926dadb!2zNzA2MCBIb2xseXdvb2Q
gQmx2ZCwgTG9zIEFuZ2VsZXMsIENBIDkwMDI4LCDQodCo0JA!5e0!3m2!1sru!2slt!4v1658219330371!5m2!1sru!2slt"
                        style="border:0; width: 100%; height: 450px" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <h1 class="titlePart">To participate in the conference, please fill out the form</h1>

            <div class="main-agileinfo">
                <v-form-first-step @session="sessionSet"/>
                <v-form-second-step @session="sessionSet"/>
                <v-form-third-step/>
            </div>
        </div>
    </div>
</template>

<script>
import VFormFirstStep from "./formComponents/v-form-first-step";
import VFormSecondStep from "./formComponents/v-form-second-step";
import VFormThirdStep from "./formComponents/v-form-third-step";

export default {
    name: 'FormComponent',
    components: {
        VFormFirstStep,
        VFormSecondStep,
        VFormThirdStep
    },
    comments: {},
    props: {},
    data: function () {
        return {
            membersAmount: null,
        }
    },
    computed: {},
    watch: {},

    mounted() {
        this.session();
        console.log(this.$session.get('data'))
        //       this.$session.destroy()
    },

    methods: {
        session: function () {
            this.$session.start()
            if (this.$session.get('data') == 'second_part') {
                $('#agileits-top-first').hide();
                document.querySelector('.agileits-top-second').style.display = 'block';
            } else {
                document.querySelector('.agileits-top-second').style.display = 'none';
            }
        },
        sessionSet: function (data) {
            if (Object.values(data).includes('second_form')) {
                this.$session.set('data', 'second_part');
            } else if (Object.values(data).includes('third_form')) {
                $('#agileits-top-second').hide('slow');
                document.querySelector('.agileits-top-third').style.display = 'block';
                this.$session.destroy();
            }
        }
    }

}
</script>
