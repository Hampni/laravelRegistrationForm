<template>
    <div class="v-admin-panel-entry-data">
        <tr class="listAdmin" style="border-bottom: black 1px solid; height: fit-content">
            <td class="listItemAdmin align-middle">
                <div class="row" style="line-height: initial; padding: 5px">
                    <div class="col-sm" style="max-width: 100px; top: 23px">
                        <span class="dataBlock">{{ member_entry_data.id }}</span>
                    </div>
                    <div class="col-sm" style="max-width: 170px; top: 23px">
                        <span class="dataBlock">{{ member_entry_data.first_name }}</span>
                    </div>
                    <div class="col-sm" style="max-width: 270px; top: 23px">
                        <span class="dataBlock">{{ member_entry_data.last_name }}</span>
                    </div>
                    <div class="col-sm" style="max-width: 270px; top: 23px">
                        <span class="dataBlock">{{ member_entry_data.report_subject }}</span>
                    </div>
                    <div class="col-sm" style="max-width: 270px; top: 23px">
                        <span class="dataBlock">{{ member_entry_data.email }}</span>
                    </div>
                    <div class="col-sm" style="max-width: 270px; top: 23px">
                        <span class="dataBlock">{{ member_entry_data.phone }}</span>
                    </div>

                    <div class="col-sm">
                        <span class="dataBlock">
                                        <div>
                                            <b-button-group>
                                                <b-button-group vertical style="padding: 5px;">
                                                    <b-button style="border-radius: 5px; margin: 5px" variant="info"
                                                          @click="showAllData(member_entry_data.id)">Show all data</b-button>
                                                    <b-button style="border-radius: 5px; margin: 5px" :variant="isShown ? '' : 'light'"
                                                          @click="changeDisplay">{{
                                                        isShown ? 'hide' : 'show'
                                                    }}</b-button>
                                                </b-button-group>

                                                <b-button-group vertical style="padding: 5px;">
                                                <b-button style="border-radius: 5px ;margin: 5px" variant="info" @click="deleteMember(member_entry_data.id)">Delete</b-button>
                                                    <a style="text-decoration: none; margin: 5px"
                                                   :href="'/update/'+ member_entry_data.id">
                                                  <b-button
                                                      variant="info">Update</b-button>
                                                </a>
                                                </b-button-group>
                                            </b-button-group>

                                        </div>




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
