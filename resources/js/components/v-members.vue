<template>
    <div class="v-members">
        <div class="main-w3layouts wrapper">

            <div class="backButton">
                <h1>
                    <a href="/">
                        <button class="btn btn-success">Back to Form</button>
                    </a>
                </h1>
            </div>
            <h1>All members</h1>

            <div class="main-agileinfo" style="width: 100%;">
                <div class="members-convert">
                    <v-member-data
                        v-for="member in members"
                        :key="member.id"
                        :member_data="member"
                    />
                </div>
            </div>
        </div>

        <!--pagination-->
        <b-container class="bv-example-row" style="padding: 20px">
            <b-row style="text-align: center">
                <b-col>
                    <a href="" class="pageLink" @click.prevent="firstPage(first_page)"><< First</a>
                    <a href="" class="pageLink" @click.prevent="prevPage">< Prev</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page - 1)">{{
                            current_page - 1 < first_page ? null : current_page - 1
                        }}</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page)" style="font-size: 35px">
                        {{ current_page }}</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page + 1)">{{
                            current_page + 1 > last_page ? null : current_page + 1
                        }}</a>
                    <a href="" class="pageLink" @click.prevent="nextPage">Next ></a>
                    <a href="" class="pageLink" @click.prevent="lastPage(last_page)">Last >></a>
                </b-col>

            </b-row>
        </b-container>

    </div>
</template>

<script>
import VMemberData from "./v-member-data";

export default {
    name: 'v-members',
    components: {
        VMemberData
    },
    data: function () {
        return {
            members: [],
            current_page: Number,
            last_page: Number,
            first_page: Number
        }
    },

    mounted() {
        this.loadMembers();
    },

    methods: {
        firstPage(first_page) {
            axios.get('/api/members/all?page=' + first_page)
                .then((response) => {
                    this.members = response.data.data
                    this.current_page = first_page
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        lastPage(last_page) {
            axios.get('/api/members/all?page=' + last_page)
                .then((response) => {
                    this.members = response.data.data
                    this.current_page = last_page
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        toPage(page) {
            axios.get('/api/members/all?page=' + page)
                .then((response) => {
                    this.members = response.data.data
                    this.current_page = page
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        nextPage: function () {
            let nextPage;
            if (this.current_page + 1 <= this.last_page) {
                nextPage = this.current_page + 1
                axios.get('/api/members/all?page=' + nextPage)
                    .then((response) => {
                        this.members = response.data.data
                        this.current_page++
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }


        },
        prevPage: function () {
            let prevPage;
            if (this.current_page - 1 >= this.first_page) {
                prevPage = this.current_page - 1
                axios.get('/api/members/all?page=' + prevPage)
                    .then((response) => {
                        this.members = response.data.data
                        this.current_page--
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }
        },
        loadMembers: function () {
            axios.get('/api/members?page=1')
                .then((response) => {
                    this.members = response.data.data;

                    this.current_page = response.data.meta.current_page
                    this.last_page = response.data.meta.last_page
                    this.first_page = response.data.meta.from

                })
                .catch(function (error) {
                    console.log(error)
                })
        }
    }

}
</script>
