<template>
    <div class="v-admin">
        <div class="container-admin-panel text-center"
             style="">

            <tr class="listAdmin" style="border-bottom: black 1px solid">
                <td class="listItemAdmin">
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

            <div v-for="member in members">
                <tr class="listAdmin" style="border-bottom: black 1px solid">
                    <td class="listItemAdmin">
                        <div class="row" style="text-align: left">
                            <div class="col-sm">
                                <span class="dataBlock">{{ member.first_name }}</span>
                            </div>
                            <div class="col-sm">
                                <span class="dataBlock">{{ member.last_name }}</span>
                            </div>
                            <div class="col-sm">
                                <span class="dataBlock">{{ member.birthday }}</span>
                            </div>
                            <div class="col-sm">
                                <span class="dataBlock">{{ member.report_subject }}</span>
                            </div>
                            <div class="col-sm">
                                <span class="dataBlock">{{ member.country }}</span>
                            </div>
                            <div class="col-sm">
                                <span class="dataBlock">{{ member.phone }}</span>
                            </div>
                            <div class="col-sm">
                                <span class="dataBlock">{{ member.email }}</span>
                            </div>
                            <div class="col-sm">
                                <span class="dataBlock">{{ member.company }}</span>
                            </div>
                            <div class="col-sm">
                                <span class="dataBlock">{{ member.position }}</span>
                            </div>
                            <div class="col-sm">
                                <span class="dataBlock">{{ member.about_me }}</span>
                            </div>
                            <div class="col-sm">
                                <span class="dataBlock"><a href="">{{ member.photo }}</a></span>
                            </div>
                            <div class="col-sm">
                                <span>
                                    <button id="hideShow" class="btn btn-info"
                                            @click="changeDisplay(member.id, toDo(member))">
                                    {{ toDo(member) }}
                                    </button>
                                </span>
                            </div>
                            <div class="col-sm">
                                <span><button class="btn btn-dark">Delete</button></span>
                            </div>
                            <div class="col-sm">
                                <span><button class="btn btn-light">Update</button></span>
                            </div>
                        </div>
                    </td>
                </tr>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'v-admin',
    components: {},
    comments: {},
    props: {},
    data: function () {
        return {
            members: [],
        }
    },
    computed: {},
    watch: {},

    mounted() {
        this.loadMembers();
    },

    methods: {
        changeDisplay: (memberId, toDo) => {

            let change = toDo == 'hide' ? 0 : 1
            axios.post('/api/members/changeDisplay/' + memberId + '/' + change)
                .then((response) => {
                    console.log(response)
                    document.location.reload()
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        toDo(member) {
            if (member.is_shown == 1) {
                return 'hide'
            } else {
                return 'show'
            }
        },

        loadMembers: function () {
            axios.get('/api/members/all')
                .then((response) => {

                    this.members = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
        }
    }

}
</script>
