<template>
    <div class="v-update">
        <div class="convert">

            <div class="backButton">
                <h1>
                    <a href="/adminPanel">
                        <b-button variant="success">Back to Admin Panel</b-button>
                    </a>
                </h1>
            </div>

            <b-container class="bv-example-row-update">
                <b-row>
                    <b-col>
                        <h1>Update Information:</h1>
                        <div class="main-w3layouts wrapper">
                            <div class="main-agileinfo" style="width: 50%">
                                <div class="agileits-top agileits-top-line" id="agileits-top-first">

                                    <!--Errors displaying-->
                                    <div id="errors" v-if="errors">
                                        <div v-for="(v,k) in errors" :key="k"
                                             class="bg-red-500 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
                                            <p v-for="error in v" :key="error" class="text-sm">
                                                {{ error }}
                                            </p>
                                        </div>
                                    </div>

                                    <form ref="updateForm" class="updateForm" @submit="updateData">

                                        <input type="hidden" name="id" :value="member.id">

                                        <!--First name-->
                                        <label class="label_input"
                                               for="first_name">First name:</label>
                                        <input type="text" id="first_name" name="first_name"
                                               class="label_input"
                                               :value="member.first_name" @change="change">

                                        <!--Last name-->
                                        <label class="label_input"
                                               for="last_name">Last name:</label>
                                        <input type="text" id="last_name" name="last_name"
                                               class="label_input"
                                               :value="member.last_name" @change="change">

                                        <!--Birthday-->
                                        <label class="label_input"
                                               for="birthday">Birthday:</label>
                                        <datepicker id="birthday"
                                                    :value="date"
                                                    format="yyyy-MM-dd"
                                                    :disabled-dates="this.disabledDates"
                                                    @change="change"
                                        ></datepicker>

                                        <!--Report subject-->
                                        <label class="label_input"
                                               for="report_subject">Report subject:</label>
                                        <input type="text" id="report_subject" name="report_subject"
                                               class="label_input"
                                               :value="member.report_subject" @change="change">

                                        <!--Country-->
                                        <label class="label_input"
                                               for="country">Country:</label>
                                        <input type="text" id="country" name="country"
                                               class="label_input"
                                               :value="member.country" @change="change">

                                        <!--Phone-->
                                        <label class="label_input"
                                               for="phone">Phone:</label>
                                        <input type="text" id="phone" name="phone"
                                               class="label_input"
                                               :value="member.phone" @change="change">

                                        <!--Email-->
                                        <label class="label_input"
                                               for="email">Email:</label>
                                        <input type="text" id="email" name="email"
                                               class="label_input"
                                               :value="member.email" @change="change">

                                        <!--Company-->
                                        <label class="label_input"
                                               for="company">Company:</label>
                                        <input type="text" id="company" name="company"
                                               class="label_input"
                                               :value="member.company" @change="change">

                                        <!--Position-->
                                        <label class="label_input"
                                               for="position">Position:</label>
                                        <input type="text" id="position" name="position"
                                               class="label_input"
                                               :value="member.position" @change="change">

                                        <!--About-->
                                        <label class="label_input"
                                               for="about_me">About me:</label>
                                        <textarea class="form-control"
                                                  name="about_me"
                                                  id="about_me"
                                                  rows="4"
                                                  :value="member.about_me" @change="change"></textarea>

                                        <!--Photo-->
                                        <label class="label_input"
                                               for="formFileLg">Photo:</label>
                                        <input style="background: white; color: black"
                                               class="form-control form-control-lg"
                                               id="formFileLg"
                                               name="image" type="file" accept=".jpg,.png,.jpeg">

                                        <div style="padding-top: 30px">
                                            <img style="border-radius: 60px; width: 90%; padding: 20px"
                                                 v-bind:src="'/images/memberImages/' + member.photo"
                                                 alt=""/>
                                            <b-button variant="info" style="position: absolute" @click="deletePhoto">
                                                Delete
                                            </b-button>
                                        </div>

                                        <input type="submit" value="Update">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Datepicker from 'vuejs-datepicker';

export default {
    name: 'v-update',
    components: {
        Datepicker
    },
    props: ['id'],
    data: function () {
        return {
            date: new Date(),
            disabledDates: {
                from: new Date()
            },
            member: {},
            errors: [],
        }
    },
    mounted() {
        this.getMember();
    },
    methods: {
        change: function (e) {
            Object.keys(this.member).forEach((key) => {
                if (key == e.target.id) {
                    this.member[key] = e.target.value
                }
            })
        },
        updateData: function (e) {
            e.preventDefault();
            //collecting data from form
            let form = document.querySelector('.updateForm')
            let data = new FormData(form);

            console.log(data)

            for (let i = 0; i < Object.values(form).length - 1; i++) {
                Object.values(form)[i].style.border = ''
                // console.log(Object.values(form)[i].name)
                // console.log(Object.values(form)[i].value)
            }

            let date = document.querySelector('.vdp-datepicker').children[0].children[0].value;
            data.append('birthday', date)

            this.updateFunction(data)
        },
        getMember: function () {
            axios.get('/api/members/one/' + this.id)
                .then((response) => {
                    this.member = response.data.data[0]
                })
                .catch((error) => {
                    console.log(error)
                });
        },
        deletePhoto: function (e) {
            e.preventDefault()

            let data = new FormData();
            data.append('id', this.member.id)
            data.append('photo', 'default.png')

            axios.post('/api/members/deletePhoto', data)
                .then((msg) => {
                    this.getMember();
                    alert('Successfully updated')
                })
                .catch((e) => {
                    console.log(e)
                })
        },
        updateFunction: function (data) {
            axios.post('/api/members/updateMember', data)
                .then((msg) => {
                    this.getMember();
                    this.errors = [];
                    alert('Successfully updated')
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
        }

    }
}
</script>
