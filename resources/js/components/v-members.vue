<template>
    <div class="v-members">
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
                    <v-member-data
                        v-for="member in members"
                        :key="member.id"
                        :member_data="member"
                    />
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
        VMemberData
    },
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
