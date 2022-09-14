<template>
    <div class="v-members">
        <div class="main-w3layouts wrapper">
            <div class="backButton">
                <h1>
                    <a href="/">
                        <b-button variant="success">Back to Form</b-button>
                    </a>
                </h1>
            </div>
            <h1>All members</h1>
            <div class="main-agileinfo main-agileinfo-width">
                <div class="members-convert">
                    <div class="backButton">
                        <pagination align="center" size="large" :data="members"
                                    @pagination-change-page="getResults"></pagination>
                    </div>
                    <b-row>
                        <v-member-data cols="12" sm="4" class="my-1"
                                       v-for="(member, index) in members.data"
                                       :key="member.id"
                                       :member_data="member">
                        </v-member-data>
                    </b-row>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VMemberData from "./v-member-data";

export default {
    name: 'v-members',
    components: {
        VMemberData,
    },
    data: function () {
        return {
            members: {}
        }
    },

    mounted() {
        this.getResults();
    },

    methods: {
        getResults(page = 1) {
            axios.get('/api/members?page=' + page)
                .then(response => {
                    this.members = response.data;
                });
        }
    }
}
</script>
