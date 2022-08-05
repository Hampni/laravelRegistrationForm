<template>

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

                <div class="container text-center" style="max-width: 1800px; height: fit-content"
                     v-for="member in members">
                    <div class="row">

                        <div class="col" style="max-width: 400px">
                            <div class="reportSubj">{{ member.first_name }} &nbsp {{ member.last_name }}</div>
                        </div>
                        <div class="col" style=" word-wrap: break-word; max-width: 600px; line-height: 30px;">
                            <div class="reportSubj"> {{ member.report_subject }}</div>
                        </div>
                        <div class="col">
                            <div class="reportSubj"><a :href="`mailto:${member.email}`">{{ member.email }}</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    data: function () {
        return {
            members: [],
        }
    },

    mounted() {
        this.loadMembers();
    },

    methods: {
        loadMembers: function () {
            axios.get('/api/members')
                .then((response) => {
                    this.members = response.data.data;
                })
                .catch(function (error) {
                    console.log(error)
                })
        }
    }

}
</script>
