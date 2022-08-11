<template>
    <div class="v-admin-panel-entry-data">
        <tr class="listAdmin" style="border-bottom: black 1px solid">
            <td class="listItemAdmin">
                <div class="row" style="text-align: left">
                    <div class="col-sm">
                        <span class="dataBlock">{{ member_entry_data.first_name }}</span>
                    </div>
                    <div class="col-sm">
                        <span class="dataBlock">{{ member_entry_data.last_name }}</span>
                    </div>
                    <div class="col-sm">
                        <span class="dataBlock">{{ member_entry_data.birthday }}</span>
                    </div>
                    <div class="col-sm">
                        <span class="dataBlock">{{ member_entry_data.report_subject }}</span>
                    </div>
                    <div class="col-sm">
                        <span class="dataBlock">{{ member_entry_data.country }}</span>
                    </div>
                    <div class="col-sm">
                        <span class="dataBlock">{{ member_entry_data.phone }}</span>
                    </div>
                    <div class="col-sm">
                        <span class="dataBlock">{{ member_entry_data.email }}</span>
                    </div>
                    <div class="col-sm">
                        <span class="dataBlock">{{ member_entry_data.company }}</span>
                    </div>
                    <div class="col-sm">
                        <span class="dataBlock">{{ member_entry_data.position }}</span>
                    </div>
                    <div class="col-sm">
                        <span class="dataBlock">{{ member_entry_data.about_me }}</span>
                    </div>
                    <div class="col-sm">
                        <span class="dataBlock"><a href="">{{ member_entry_data.photo }}</a></span>
                    </div>
                    <div class="col-sm">
                                <span>
                                    <button :class="'btn btn-'+ (isShown ? 'warning' : 'info')"
                                            @click="changeDisplay">
                                    {{ isShown ? 'hide' : 'show'}}
                                    </button>
                                </span>
                    </div>
                    <div class="col-sm">
                                <span>
                                    <button class="btn btn-dark" @click="deleteMember(member_entry_data.id)">Delete</button>
                                </span>
                    </div>
                    <div class="col-sm">
                        <span><button class="btn btn-light">Update</button></span>
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
                return{}
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
            this.$emit('session', {
                id: memberId
            })
        },
    }
}
</script>
