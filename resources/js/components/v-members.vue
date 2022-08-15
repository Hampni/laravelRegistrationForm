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
            <div class="main-agileinfo" style="width: 100%;">
                <div class="members-convert">
                    <b-row>
                        <v-member-data cols="12" sm="4" class="my-1"
                                       v-for="(member, index) in paginatedItems"
                                       :key="member.id"
                                       :member_data="member">
                        </v-member-data>
                    </b-row>
                    <b-row>
                        <b-pagination
                            @change="onPageChanged"
                            :total-rows="totalRows"
                            :per-page="perPage"
                            v-model="currentPage"
                            class="my-2"
                            align="center"
                            size="lg"
                        />
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
        VMemberData
    },
    data: function () {
        return {
            members: [],
            items: [],
            paginatedItems: [],
            currentPage: 1,

            //Amount of members on page
            perPage: 10,
            totalRows: ''
        }
    },

    mounted() {
        this.loadMembers();
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
        loadMembers: function () {
            axios.get('/api/members')
                .then((response) => {
                    this.members = response.data.data;
                    this.totalRows = this.members.length;
                    this.items = this.members;
                    this.paginatedItems = this.members;
                    this.paginate(this.perPage, 0);
                })
                .catch(function (error) {
                    console.log(error)
                })
        }
    }

}
</script>
