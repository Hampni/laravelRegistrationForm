<template>
    <div class="v-form">
        <!-- main -->
        <div class="main-w3layouts wrapper">

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
    name: 'v-form',
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
