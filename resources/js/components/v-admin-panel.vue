<template>
    <div class="v-admin-panel">

        <div class="container-admin-panel text-center" style="">
            <tr class="listAdmin" style="border-bottom: black 1px solid">
                <td class="listItemAdminBase">
                    <div class="row" style="text-align: left">
                        <div class="col-sm">
                            <span class="dataBlock">First name</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock">Last name</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock">Birthday</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock">Report subject</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock">Country</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock">Phone</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock">Email</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock">Company</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock">Position</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock">About me</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock">Photo</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock"></span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock"></span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock"></span>
                        </div>
                    </div>
                </td>
            </tr>

            <v-admin-panel-entry-data
                v-for="member in members"
                :key="member.id"
                :member_entry_data="member"
                :memberId="member.id"
                @session="deleteMember"
            />
        </div>
        <br>
        <br>
        <br>
        <br>



        <div class="container" style="padding: 0; border: none; line-height: 40px">
            <div class="row" style="text-align: center">
                <div class="col">

                    <a href="" class="pageLink" @click.prevent="prevPage">< Prev</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page - 2)">{{ current_page - 2 < first_page ? null : current_page - 2 }}</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page - 1)">{{ current_page - 1 < first_page ? null : current_page - 1 }}</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page)" style="font-size: 35px"> {{ current_page }}</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page + 1)">{{ current_page + 1 > last_page ? null : current_page + 1 }}</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page + 2)">{{ current_page + 2 > last_page ? null : current_page + 2 }}</a>
                    <a href="" class="pageLink" @click.prevent="nextPage">Next ></a>

                </div>
            </div>
        </div>

    </div>

</template>

<script>
import VAdminPanelEntryData from "./v-admin-panel-entry-data";

export default {
    name: 'v-admin-panel',
    components: {
        VAdminPanelEntryData
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
        deleteMember: function (memberId) {
            let data = {};
            data['id'] = memberId['id'];

            axios.post('/api/members/deleteMember', data)
                .then((response) => {
                    this.members.forEach((e, index) => {
                        if (e.id == memberId['id']) {
                            this.members.splice(index, 1)
                        }
                    })
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        loadMembers: function () {
            axios.get('/api/members/all?page=1')
                .then((response) => {
                    this.members = response.data.data
                    this.current_page = response.data.meta.current_page
                    this.last_page = response.data.meta.last_page
                    this.first_page = response.data.meta.from
                })
                .catch((error) => {
                    console.log(error)
                })
        }
    }

}
</script>
