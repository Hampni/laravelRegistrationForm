<template>
    <div class="v-form-first-step" id="v-form-first-step">
        <div class="agileits-top" id="agileits-top-first">

            <!--Errors displaying-->
            <div id="errors" v-if="errors">
                <div v-for="(v,k) in errors" :key="k"
                     class="bg-red-500 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0"
                     style="border: 1px solid red">
                    <p v-for="error in v" :key="error" class="text-sm">
                        {{ error }}
                    </p>
                </div>
            </div>

            <form id="first-form" class="first-form" @submit="toSecondStep">

                <!--First name-->
                <label style="color: floralwhite; font-size: 14px; font-weight: 100" class="label_input"
                       id="first_name_label"
                       for="first_name">Example: Jhon</label>
                <input class="text email" style="margin-top: 5px;" type="text" id="first_name" name="first_name"
                       placeholder="First name"
                       required="">

                <!--Last name-->
                <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="last_name_label"
                       for="last_name">Example: Dorian</label>
                <input class="text email" style="margin-top: 5px;" type="text" id="last_name" name="last_name"
                       placeholder="Last name"
                       required="">

                <!--Birthday-->
                <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="birthday_label"
                       for="birthday">Select date:</label>
                <datepicker id="birthday"
                            :value="date"
                            format="yyyy-MM-dd"
                            style="padding-bottom: 20px"
                            :disabled-dates="this.disabledDates"
                            ></datepicker>

                <!--Report Subject-->
                <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="report_subject_label"
                       for="report_subject">Example: Computer Science</label>
                <input class="text email" style="margin-top: 5px;" type="text" id="report_subject"
                       name="report_subject"
                       placeholder="Report subject" required="">

                <!--Country-->
                <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="country_label"
                       for="country">Choose
                    your country:</label>
                <select class="browser-default custom-select" style="margin-top: 5px; margin-bottom: 25px;"
                        id="country"
                        name="country" required="required">
                    <option value="" selected>Country</option>
                    <option v-for="country in countries"> {{ country.name }}</option>
                </select>

                <!--Phone number-->
                <label style="color: floralwhite; font-size: 14px; font-weight: 100; margin-bottom: 5px"
                       id="phone_label" for="phone">Example: +380 (xxx)
                    xxx-xxx</label><br>
                <input class="text email" style="margin-top: 5px; display: block; width: 100%" id="phone" type="text"
                       name="phone"
                       placeholder="Phone" required="">
                <br>
                <!--Email-->
                <label style="color: floralwhite; font-size: 14px; font-weight: 100 " id="email_label"
                       for="email">Example: YourEmail@mail.com</label> <br>
                <input class="text email" style="margin-top: 5px;" type="email" id="email" name="email"
                       placeholder="Email" required="">

                <input id="submit" type="submit" value="Next">
            </form>

        </div>
    </div>
</template>

<script>
import axios from 'axios';
import IMask from 'imask';
import intlTelInput from "intl-tel-input";
import 'intl-tel-input/build/css/intlTelInput.css';
import Datepicker from 'vuejs-datepicker';

export default {
    name: "v-form-first-step",
    components: {
        Datepicker
    },
    data: function () {
        return {
            date: new Date(),
            disabledDates:  {
                from: new Date()
            },
            countries: [],
            errors: []
        }
    },
    mounted() {
        this.getCountries();
        this.phoneNumber();
        this.masked();
    },
    methods: {
        phoneNumber: function () {
            $('#phone').mask(
                ' (999) 999-999?9', {
                    placeholder: ''
                }
            )
            const input = document.querySelector("#phone");
            const iti = intlTelInput(input)
            $('#phone').on(
                'change', function () {
                    $('#phone')[0].value = '+' + iti.getSelectedCountryData().dialCode + $('#phone')[0].value
                }
            )
        },
        masked: function () {
            const first_name = IMask(
                document.getElementById('first_name'), {
                    mask: '********************'
                }
            )

            const last_name = IMask(
                document.getElementById('last_name'), {
                    mask: '********************'
                }
            )
        },
        getCountries: function () {
            axios.get('/api/countries')
                .then((response) => {
                    this.countries = response.data.data;
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        showSecondStep: function () {
            $('#first-form').hide('slow')
            $('#agileits-top-first').hide('slow')
            document.querySelector('.agileits-top-second').style.display = ''
            this.$emit('session', {
                data: 'second_form'
            })
        },
        toSecondStep: function (e) {
            e.preventDefault();

            //collecting data from form
            let form = document.querySelector('.first-form');
            let data = new FormData(form);

            let date = document.querySelector('.vdp-datepicker').children[0].children[0].value;

            data.append('birthday', date)

            for (let i = 0; i < Object.values(form).length - 1; i++) {
                Object.values(form)[i].style.border = ''
            }
            //sending data
            axios.post('/api/saveFirstStep', data)
                .then((msg) => {
                    console.log(msg)
                    this.showSecondStep();
                })
                //catching errors and displaying them
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
        },

    }
}
</script>

