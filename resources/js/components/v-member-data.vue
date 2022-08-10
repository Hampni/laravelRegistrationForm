<template>
    <div class="v-member-data">
        <div class="container text-center" style="max-width: 1800px; height: fit-content">
            <div class="row">
                <div class="col" style="max-width: 150px">
                    <div style="padding-top: 30px">
                        <img class="member-image" v-bind:src="'/images/memberImages/' + member_data.photo"
                             alt=""/>
                    </div>
                </div>
                <div class="col" style="max-width: 400px; word-wrap: break-word; line-height: 30px;">
                    <div class="reportSubj">{{ member_data.first_name }} &nbsp {{ member_data.last_name }}</div>
                </div>
                <div class="col" style=" word-wrap: break-word; max-width: 600px; line-height: 30px;">
                    <div class="reportSubj"> {{ member_data.report_subject }}</div>
                </div>
                <div class="col">
                    <div class="reportSubj"><a :href="`mailto:${member_data.email}`">{{ member_data.email }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "v-member-data",
    props: {
        member_data: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    methods: {
        isShown(member) {
            if (member.is_shown == 1) {
                return 'hide'
            } else {
                return 'show'
            }
        },
    }


}

</script>

<style scoped>

</style>
