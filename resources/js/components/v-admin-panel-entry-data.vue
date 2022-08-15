<template>
    <div class="v-admin-panel-entry-data">
        <tr class="listAdmin" style="border-bottom: black 1px solid">
            <td class="listItemAdmin">
                <div class="row" style="padding: 20px">
                    <div class="col-sm" style="max-width: 100px">
                        <span class="dataBlock">{{ member_entry_data.id }}</span>
                    </div>
                    <div class="col-sm" style="max-width: 170px">
                        <span class="dataBlock">{{ member_entry_data.first_name }}</span>
                    </div>
                    <div class="col-sm" style="max-width: 270px">
                        <span class="dataBlock">{{ member_entry_data.last_name }}</span>
                    </div>
                    <div class="col-sm" style="max-width: 270px">
                        <span class="dataBlock">{{ member_entry_data.report_subject }}</span>
                    </div>
                    <div class="col-sm" style="max-width: 270px">
                        <span class="dataBlock">{{ member_entry_data.email }}</span>
                    </div>
                    <div class="col-sm" style="max-width: 270px">
                        <span class="dataBlock">{{ member_entry_data.phone }}</span>
                    </div>

                    <div class="col-sm">
                        <span class="dataBlock">
                                    <b-button variant="info"
                                              @click="showAllData(member_entry_data.id)">Show all data</b-button>
                                    <b-button :variant="isShown ? 'warning' : 'info'"
                                              @click="changeDisplay">{{ isShown ? 'hide' : 'show' }}</b-button>
                                    <b-button @click="deleteMember(member_entry_data.id)">Delete</b-button>
                                    <a style="text-decoration: none;"
                                       :href="'/update/'+ member_entry_data.id">
                                        <b-button variant="light">Update</b-button>
                                </a>
                        </span>
                    </div>
                </div>
            </td>
        </tr>
    </div>
</template>

<script>
export default {
    name: 'v-admin-panel-entry-data',
    props: {
        member_entry_data: {
            type: Object,
            default() {
                return {}
            }
        },
        memberId: Number,
    },
    mounted() {
    },
    data: function () {
        return {
            isShown: this.member_entry_data.is_shown
        }
    },
    methods: {
        showAllData: function (memberId) {
            this.$emit('showAllData', {
                id: memberId
            })
        },
        changeDisplay: function (e) {
            let data = {};
            let change = this.isShown == '1' ? 0 : 1;
            data['id'] = this.memberId;
            data['change'] = change;
            axios.post('/api/members/changeDisplay', data)
                .then((response) => {
                    console.log(response.data)
                    this.isShown = response.data
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        toDo(is_shown) {
            if (is_shown == 1) {
                return 'hide'
            } else {
                return 'show'
            }
        },
        deleteMember(memberId) {
            this.$emit('delete', {
                id: memberId
            })
        },
    }
}
</script>
