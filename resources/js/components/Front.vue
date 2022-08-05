<template>

    <body>
    <h1>Hello</h1>
    <div :class="{'loading': loading}">
        <a class="list-group-item" v-for="country in countries">
            {{ country.name }}
        </a>
        <a class="list-group-item" >

        </a>
    </div>
    </body>

</template>

<script>

export default {
    data: function () {
        return {
            members: [],
            countries: [],
            loading: true
        }
    },

    mounted() {
        this.loadCountries();
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
                });
        },

        loadCountries: function () {
            axios.get('/api/countries')
                .then((response) => {
                    this.countries = response.data.data;
                })
                .catch(function (error) {
                    console.log(error)
                });
        }
    }
}

</script>
