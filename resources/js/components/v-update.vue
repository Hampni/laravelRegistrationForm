<template>
    <div class="v-update">
        <div class="convert">
            <b-container class="bv-example-row-update">
                <b-row>
                    <b-col>
                        Current Information:
                        <div class="currentData">
                            <div><b>Id:</b> {{ member.id }}</div>
                            <div><b>First name:</b> {{ member.first_name }}</div>
                            <div><b> Last name:</b> {{ member.last_name }}</div>
                            <div><b>Birthday:</b> {{ member.birthday }}</div>
                            <div><b> Report subject:</b> {{ member.report_subject }}</div>
                            <div><b> Country:</b> {{ member.country }}</div>
                            <div><b> Phone:</b> {{ member.phone }}</div>
                            <div><b> Email:</b> {{ member.email }}</div>
                            <div><b> Company:</b> {{ member.company }}</div>
                            <div><b> Position:</b> {{ member.position }}</div>
                            <div><b> About me:</b> {{ member.about_me }}</div>
                            <div style="padding-top: 30px">
                                <img style="width: 300px" v-bind:src="'/images/memberImages/' + member.photo"
                                     alt=""/>
                            </div>
                        </div>
                    </b-col>
                    <b-col>
                        <div class="newData">
                            New Information:
                            <div><b>Id:</b> {{ member.id }}</div>
                            <form ref="updateForm" class="updateForm" action="" @submit="updateData">
                                <input type="hidden" name="id" :value="member.id">
                                <label for="first_name"><b>First name:</b></label>
                                <input type="text" id="first_name" name="first_name"
                                       style="padding: 3px; line-height: 15px; border-radius: 20px; padding-left: 10px"
                                       :value="member.first_name">

                                <label for="last_name"><b>Last name:</b></label>
                                <input type="text" id="last_name" name="last_name"
                                       style="padding: 3px; line-height: 15px; border-radius: 20px; padding-left: 10px"
                                       :value="member.last_name">

                                <label for="birthday"><b>Birthday:</b></label>
                                <input type="text" id="birthday" name="birthday"
                                       style="padding: 3px; line-height: 15px; border-radius: 20px; padding-left: 10px"
                                       :value="member.birthday">

                                <label for="report_subject"><b>Report subject:</b></label>
                                <input type="text" id="report_subject" name="report_subject"
                                       style="padding: 3px; line-height: 15px; border-radius: 20px; padding-left: 10px"
                                       :value="member.report_subject">

                                <label for="country"><b>Country:</b></label>
                                <input type="text" id="country" name="country"
                                       style="padding: 3px; line-height: 15px; border-radius: 20px; padding-left: 10px"
                                       :value="member.country">

                                <label for="phone"><b>Phone:</b></label>
                                <input type="text" id="phone" name="phone"
                                       style="padding: 3px; line-height: 15px; border-radius: 20px; padding-left: 10px"
                                       :value="member.phone">

                                <label for="email"><b>Email:</b></label>
                                <input type="text" id="email" name="email"
                                       style="padding: 3px; line-height: 15px; border-radius: 20px; padding-left: 10px"
                                       :value="member.email">

                                <label for="company"><b>Company:</b></label>
                                <input type="text" id="company" name="company"
                                       style="padding: 3px; line-height: 15px; border-radius: 20px; padding-left: 10px"
                                       :value="member.company">

                                <label for="position"><b>Position:</b></label>
                                <input type="text" id="position" name="position"
                                       style="padding: 3px; line-height: 15px; padding-left: 10px; border-radius: 20px;"
                                       :value="member.position">

                                <label for="about_me"><b>About me:</b></label>
                                <input type="text" id="about_me" name="about_me"
                                       style="padding: 3px; line-height: 15px; border-radius: 20px; padding-left: 10px"
                                       :value="member.about_me">

                                <label style="padding-top: 10px; color: white" for="formFileLg"
                                       class="form-label">Photo:</label>
                                <input style="background: white; color: black" class="form-control form-control-lg"
                                       id="formFileLg"
                                       name="image" type="file" accept=".jpg,.png,.jpeg">

                                <input type="submit" value="Update">
                            </form>
                        </div>
                    </b-col>
                </b-row>
            </b-container>

        </div>
    </div>
</template>

<script>

import axios from "axios";

export default {
    name: 'v-update',
    props: ['id'],
    data: function () {
        return {
            member: {},
        }
    },

    mounted() {
        this.getMember();
    },

    methods: {
        updateData: function (e) {
            e.preventDefault();

            let form = document.querySelector('.updateForm')
            let data = new FormData(form);

            axios.post('/api/members/updateMember', data)
                .then((msg) => {
                    alert('Successfully updated')
                    this.getMember();
                })
                .catch((e) => {
                    if (e.response.status === 422) {
                        this.errors = [];
                    }
                })

        },
        getMember: function () {
            axios.get('/api/members/one/' + this.id)
                .then((response) => {
                    this.member = response.data.data[0]
                })
                .catch((error) => {
                    console.log(error)
                });
        }
    }
}
</script>
