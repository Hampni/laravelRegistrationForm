<template>
    <div class="v-form-first-step" id="v-form-first-step">
        <div class="agileits-top" id="agileits-top-first">
            <!--first step-->

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
                       for="first_name">Only upper and lower case: Jhon</label>
                <input class="text email" style="margin-top: 5px;" type="text" id="first_name" name="first_name"
                       placeholder="First name"
                       required="">

                <!--Last name-->
                <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="last_name_label"
                       for="last_name">Only upper and lower case: Dorian</label>
                <input class="text email" style="margin-top: 5px;" type="text" id="last_name" name="last_name"
                       placeholder="Last name"
                       required="">

                <!--Birthday-->
                <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="birthday_label"
                       for="birthday">Insert
                    full date: YYYY.MM.DD</label>
                <input class="text email" style="margin-top: 5px;" type="text" id="birthday" name="birthday"
                       placeholder="Birthday"
                       required="">

                <!--Report Subject-->
                <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="report_subject_label"
                       for="report_subject">Upper, lower case, digits allowed</label>
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
                       id="phone_label" for="phone">Insert your phone number. Example: +380 (xxx)
                    xxx-xxx</label><br>
                <input class="text email" style="margin-top: 5px; display: block" id="phone" type="text"
                       name="phone"
                       placeholder="Phone" required="">
                <br>
                <!--Email-->
                <label style="color: floralwhite; font-size: 14px; font-weight: 100 " id="email_label"
                       for="email">Insert
                    your email. Example: YourEmail@mail.com</label> <br>
                <input class="text email" style="margin-top: 5px;" type="email" id="email" name="email"
                       placeholder="Email" required="">
                <div class="wthree-text">
                    <div class="clear"></div>
                </div>
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

export default {
    name: "v-form-first-step",
    components: {},
    data: function () {
        return {
            countries: [],
            errors: []
        }
    },
    mounted() {
        this.phoneNumber();
        this.datepicker();
        this.mask();
        this.getCountries();
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
        datepicker: function () {
            $('#birthday').datepicker(
                {
                    dateFormat: 'yy-mm-dd',
                    changeYear: true,
                    changeMonth: true,
                    yearRange: '1951:2021',
                    currentText: 'Now',
                    maxDate: '-1y'
                }
            );
            const dateMask = IMask(
                document.getElementById('birthday'),
                {
                    mask: Date,
                    pattern: 'Y{-}`m{-}`d ',
                    lazy: true,
                    autofix: true,
                    blocks: {
                        d: {mask: IMask.MaskedRange, placeholderChar: 'd', from: 1, to: 31, maxLength: 3},
                        m: {mask: IMask.MaskedRange, placeholderChar: 'm', from: 1, to: 12, maxLength: 2},
                        Y: {mask: IMask.MaskedRange, placeholderChar: 'y', from: 1950, to: 2021, maxLength: 4}
                    }
                }
            )
        },
        mask: function () {
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

            let form = document.querySelector('.first-form');
            let data = new FormData(form);

            for (let i = 0; i < Object.values(form).length - 1; i++) {
                Object.values(form)[i].style.border = ''
            }

            axios.post('/api/save', data)
                .then((msg) => {
                    console.log(msg)
                    this.showSecondStep();
                })
                .catch((e) => {
                    if (e.response.status === 422) {
                        this.errors = [];
                        let errorsCurrent = []

                        let intersection = Object.values(form).filter(x => Object.keys(e.response.data.errors).includes(x.id));
                        for (let i = 0; i < intersection.length; i++) {
                            for (let key in e.response.data.errors) {
                                errorsCurrent[i] = errorsCurrent[intersection[i].id] = e.response.data.errors[intersection[i].id]
                            }
                        }
                        if (intersection.length == 0) {
                            this.showSecondStep()
                        } else {
                            this.errors = errorsCurrent
                            intersection.forEach((e) => {
                                document.getElementById(e.id).style.border = '1px solid lightcoral'
                            })
                            document.getElementById('agileits-top-first').scrollIntoView();
                        }
                    }
                })

        },
    }
}
</script>

<style scoped>

</style>
