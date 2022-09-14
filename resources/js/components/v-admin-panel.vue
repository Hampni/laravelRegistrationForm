<template>
    <div class="v-admin-panel">
        <div class="main-w3layouts wrapper">
            <div class="main-agileinfo main-agileinfo-width">
                <div class="container text-center">
                    <div class="container-admin-panel text-center">
                        <!--table sheets-->
                        <pagination align="center" size="large" :data="members"
                                    @pagination-change-page="getResults"></pagination>
                        <tr class="listAdmin">
                            <td class="listItemAdminBase">
                                <div class="row" style="padding: 20px">
                                    <div class="col-sm" style="max-width: 100px">
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
                                    <div class="col-sm" style="max-width: 270px">
                                        <span class="dataBlock">Phone</span>
                                    </div>
                                    <div class="col-sm" style="width: 1000px">
                                    <span class="dataBlock">
                                        <div>
                                            <a href="/addMember">
                                                <b-button block variant="info">Add new member</b-button>
                                            </a>
                                        </div>
                                    </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <!--all info about member-->
                        <div class="allDataConvert">
                            <div ref="allData" class="allData">
                                <div class="divDataContent">
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
                                <div class="divImageAP">
                                    <img class="imageAllData"
                                         v-bind:src="'/images/memberImages/'  + memberAllData.photo"
                                         alt=""/>
                                </div>
                                <div>
                                    <b-button class="b-buttonClose"
                                              variant="dark"
                                              @click="closeAllInfo">X
                                    </b-button>
                                </div>
                            </div>
                        </div>

                        <b-row class="b-row">
                            <v-admin-panel-entry-data
                                v-for="(member, index) in members.data"
                                :key="member.id"
                                :member_entry_data="member"
                                :memberId="member.id"
                                @delete="deleteMember"
                                @showAllData="showAllData"
                            />
                        </b-row>
                    </div>
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
            memberAllData: [],
            members: {},
            items: [],
            paginatedItems: [],
            currentPage: 1,

            //Amount of members on page
            perPage: 10,
            totalRows: ''
        }
    },
    mounted() {
        this.$refs.allData.style.display = 'none'
        this.getResults();
    },
    methods: {
        paginate(page_size, page_number) {
            let itemsToParse = this.items;
            this.paginatedItems = itemsToParse.slice(
                page_number * page_size,
                (page_number + 1) * page_size
            );
        },
        onPageChanged(page) {
            this.paginate(this.perPage, page - 1);
        },
        showAllData: function (memberId) {
            this.members.data.forEach(e => {
                if (e.id == memberId.id) {
                    this.memberAllData = e
                    this.$refs.allData.style.display = ''
                }
            })
        },
        closeAllInfo: function () {
            this.$refs.allData.style.display = 'none'
        },
        deleteMember: function (memberId) {
            let data = {};
            data['id'] = memberId['id'];
            axios.post('/api/members/deleteMember', data)
                .then((response) => {
                    this.members.data.forEach((e, index) => {
                        if (e.id == memberId['id']) {
                            this.members.data.splice(index, 1)
                        }
                    })
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        getResults(page = 1) {
            axios.get('/api/members/all?page=' + page)
                .then(response => {
                    this.members = response.data;
                });
        },
    }

}
</script>
