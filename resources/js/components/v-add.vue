<template>
    <div class="v-add">

        <div class="backButton">
            <h1>
                <a href="/adminPanel">
                    <b-button variant="success">Back to Admin Panel</b-button>
                </a>
            </h1>
        </div>

        <h1>Add new member</h1>
        <div class="main-w3layouts wrapper">
            <div class="main-agileinfo">
                <div class="v-form-first-step" id="v-form-first-step">
                    <div class="agileits-top" id="agileits-top-first">

                        <!--errors-->
                        <div id="errors" v-if="errors">
                            <div v-for="(v,k) in errors" :key="k"
                                 class="bg-red-500 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0"
                                 style="border: 1px solid red">
                                <p v-for="error in v" :key="error" class="text-sm">
                                    {{ error }}
                                </p>
                            </div>
                        </div>

                        <form ref="formAddNew" action="" class="form" @submit="addNewMember">

                            <!--First name-->
                            <label style="color: floralwhite; font-size: 14px; font-weight: 100" class="label_input"
                                   id="first_name_label"
                                   for="first_name">Example: Jhon</label>
                            <input style="margin-top: 5px;" type="text" id="first_name"
                                   name="first_name"
                                   placeholder="First name"
                                   required="">

                            <!--Last name-->
                            <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="last_name_label"
                                   for="last_name">Example: Dorian</label>
                            <input style="margin-top: 5px;" type="text" id="last_name"
                                   name="last_name"
                                   placeholder="Last name"
                                   required="">

                            <!--Birthday-->
                            <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="birthday_label"
                                   for="birthday">Insert
                                full date: YYYY.MM.DD</label>
                            <datepicker id="birthday"
                                        :value="date"
                                        format="yyyy-MM-dd"
                                        :disabled-dates="this.disabledDates"
                            ></datepicker>

                            <!--Report Subject-->
                            <label style="color: floralwhite; font-size: 14px; font-weight: 100"
                                   id="report_subject_label"
                                   for="report_subject">Example: Computer Science</label>
                            <input style="margin-top: 5px;" type="text" id="report_subject"
                                   name="report_subject"
                                   placeholder="Report subject" required="">

                            <!--Country-->
                            <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="country_label"
                                   for="country">Choose
                                country:</label>
                            <select class="browser-default custom-select"
                                    id="country"
                                    name="country" required="required">
                                <option value="" selected>Country</option>
                                <option v-for="country in countries"> {{ country.name }}</option>
                            </select>

                            <!--Phone number-->
                            <label style="color: floralwhite; font-size: 14px; font-weight: 100; margin-bottom: 5px"
                                   id="phone_label" for="phone">Example: +380 (xxx)
                                xxx-xxx</label><br>
                            <input style=" display: block; width: 100%" id="phone" type="text"
                                   name="phone"
                                   placeholder="Phone" required="">
                            <br>

                            <!--Email-->
                            <label style="color: floralwhite; font-size: 14px; font-weight: 100 " id="email_label"
                                   for="email">Example: NewEmail@mail.com</label> <br>
                            <input style="margin-top: 5px;" type="email" id="email" name="email"
                                   placeholder="Email" required="">

                            <!--Company-->
                            <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="company_label"
                                   for="company">
                                Company:</label>
                            <input type="text" id="company" name="company" placeholder="Company">

                            <!--Position-->
                            <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="position_label"
                                   for="position">
                                Position:</label>
                            <input style="margin-top: 0" type="text" id="position" name="position"
                                   placeholder="Position">

                            <!--About me-->
                            <label style="color: floralwhite; font-size: 14px; font-weight: 100" id="about_me_label"
                                   for="about_me">Additional information:</label>
                            <textarea class="form-control" name="about_me" placeholder="About me"
                                      id="about_me" rows="4"></textarea>

                            <!--Photo-->
                            <label style="padding-top: 10px; color: white" for="formFileLg"
                                   class="form-label">Photo:</label>
                            <input style="background: white; color: black"
                                   class="form-control form-control-lg"
                                   id="formFileLg"
                                   name="image" type="file" accept=".jpg,.png,.jpeg">

                            <input type="submit" value="Add new member">
                        </form>
                    </div>
                </div>
            </div>
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
    name: 'v-add',
    components: {
        Datepicker
    },
    data: function () {
        return {
            date: new Date(),
            disabledDates: {
                from: new Date()
            },
            countries: [],
            errors: []
        }
    },

    mounted() {
        this.phoneNumber();
        this.mask();
        this.getCountries();

        $('.iti.iti--allow-dropdown')[0].style.width = '94%'
        $('.iti.iti--allow-dropdown')[0].style.marginBottom = '13px'
    },

    methods: {
        addNewMember: function (e) {
            e.preventDefault();

            let form = this.$refs.formAddNew;
            let data = new FormData(form);

            let date = document.querySelector('.vdp-datepicker').children[0].children[0].value;

            data.append('birthday', date)


            for (let i = 0; i < Object.values(form).length - 1; i++) {
                Object.values(form)[i].style.border = ''
            }

            axios.post('/api/members/addMember', data)
                .then((msg) => {
                    console.log(msg)
                    alert('Succesfully added')
                    document.location.reload()
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


        },
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
    }
}
</script>
