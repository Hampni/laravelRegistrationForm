<template>
    <div class="v-admin-panel">

        <div class="container-admin-panel text-center">
            <!--table sheets-->
            <tr class="listAdmin" style="border-bottom: black 1px solid">
                <td class="listItemAdminBase">
                    <div class="row" style="text-align: left;">
                        <div class="col-sm" style="max-width: 50px">
                            <span class="dataBlock">id</span>
                        </div>
                        <div class="col-sm" style="max-width: 170px">
                            <span class="dataBlock">First name</span>
                        </div>
                        <div class="col-sm" style="max-width: 270px">
                            <span class="dataBlock">Last name</span>
                        </div>
                        <div class="col-sm" style="max-width: 270px">
                            <span class="dataBlock">Report subject</span>
                        </div>
                        <div class="col-sm" style="max-width: 270px">
                            <span class="dataBlock">Email</span>
                        </div>
                        <div class="col-sm">
                            <span class="dataBlock">About me</span>
                        </div>
                        <div class="col-sm" style="width: 1000px">
                            <span class="dataBlock">
                                <a href="/addMember">
                                    <b-button variant="info">Add new member</b-button>
                                </a>
                            </span>
                        </div>
                    </div>
                </td>
            </tr>

            <!--all info about member-->
            <div class="allDataConvert">
                <div ref="allData" class="allData">
                    <div style="padding: 20px; text-align: left">
                        <div><b>Id:</b> {{ memberAllData.id }}</div>
                        <div><b>First name:</b> {{ memberAllData.first_name }}</div>
                        <div><b> Last name:</b> {{ memberAllData.last_name }}</div>
                        <div><b>Birthday:</b> {{ memberAllData.birthday }}</div>
                        <div><b> Report subject:</b> {{ memberAllData.report_subject }}</div>
                        <div><b> Country:</b> {{ memberAllData.country }}</div>
                        <div><b> Phone:</b> {{ memberAllData.phone }}</div>
                        <div><b> Email:</b> {{ memberAllData.email }}</div>
                        <div><b> Company:</b> {{ memberAllData.company }}</div>
                        <div><b> Position:</b> {{ memberAllData.position }}</div>
                        <div><b> About me:</b> {{ memberAllData.about_me }}</div>
                    </div>
                    <div style="padding-top: 30px; text-align: center">
                        <img style="width: 200px;"
                             v-bind:src="'/images/memberImages/'  + memberAllData.photo"
                             alt=""/>
                    </div>
                    <div>
                        <b-button style="position: absolute; top: 10px; right: 10px" variant="dark"
                                  @click="closeAllInfo">X
                        </b-button>
                    </div>
                </div>
            </div>

            <!--members data-->
            <v-admin-panel-entry-data
                v-for="member in members"
                :key="member.id"
                :member_entry_data="member"
                :memberId="member.id"
                @delete="deleteMember"
                @showAllData="showAllData"
            />
        </div>

        <!--pagination-->
        <b-container class="bv-example-row" style="padding: 20px">
            <b-row style="text-align: center">
                <b-col>
                    <a href="" class="pageLink" @click.prevent="firstPage(first_page)"><< First</a>
                    <a href="" class="pageLink" @click.prevent="prevPage">< Prev</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page - 2)">{{
                            current_page - 2 < first_page ? null : current_page - 2
                        }}</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page - 1)">{{
                            current_page - 1 < first_page ? null : current_page - 1
                        }}</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page)" style="font-size: 35px">
                        {{ current_page }}</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page + 1)">{{
                            current_page + 1 > last_page ? null : current_page + 1
                        }}</a>
                    <a href="" class="pageLink" @click.prevent="toPage(current_page + 2)">{{
                            current_page + 2 > last_page ? null : current_page + 2
                        }}</a>
                    <a href="" class="pageLink" @click.prevent="nextPage">Next ></a>
                    <a href="" class="pageLink" @click.prevent="lastPage(last_page)">Last >></a>
                </b-col>

            </b-row>
        </b-container>
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
            memberAllData: [],
            members: [],
            current_page: Number,
            last_page: Number,
            first_page: Number
        }
    },
    mounted() {
        this.$refs.allData.style.display = 'none'
        this.loadMembers();
    },

    methods: {
        showAllData: function (memberId) {
            this.members.forEach(e => {
                if (e.id == memberId.id) {
                    this.memberAllData = e
                    this.$refs.allData.style.display = ''
                }
            })
        },
        closeAllInfo: function () {
            this.$refs.allData.style.display = 'none'
        },
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
