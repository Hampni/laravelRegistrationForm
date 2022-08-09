<template>
    <div class="v-form-third-step" id="v-form-third-step">
        <div class="agileits-top-third" id="agileits-top-third">
            <!--Share buttons-->
            <!--Facebook-->
            <div style="padding:25px">
                <div>
                    <a target="_blank"
                       href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fprodanets.trainee.albedo.dev%2F&amp;src=sdkpreparse"
                       class="fb-xfbml-parse-ignore">
                        <button style="width: 100%; margin-bottom: 10px; " class="btn btn-primary">Facebook
                        </button>
                    </a>
                </div>
                <!--Twitter-->
                <div>
                    <a href="https://twitter.com/share?ref_src=twsrc%5Etfw"
                       target="_blank"
                       data-size="large"
                       data-text="Check out this Meetup with SoCal AngularJS! "
                       data-url="http://localhost:8002/"
                       data-show-count="false">
                        <button style="width: 100%; margin-bottom: 10px" class="btn btn-info">Twitter</button>
                    </a>
                </div>
            </div>


            <!--All members page-->
            <button onclick="location.href='/members';" type="button" class="btn btn-primary btn-lg btn-block">
                All Members ({{ membersAmount }})
            </button>
        </div>
    </div>
</template>

<script>

export default {
    name: "v-form-third-step",
    components: {

    },
    data: function () {
        return {
            membersAmount: null,
        }
    },
    mounted() {
        this.loadMembersAmount()
    },
    methods: {
        loadMembersAmount: function () {
            axios.get('/api/members/countMembers', { withCredentials: true })
                .then((response) => {
                    this.membersAmount = response.data;
                })
                .catch(function (error) {
                    console.log(error)

                })
        }
    }
}
</script>

<style scoped>

</style>
