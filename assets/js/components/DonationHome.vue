<template>
    <div>

        <div class="step-content" id="step-c1">
            <h1 class="red">Joins us in finding actionable solutions to America’s toughest challenges.</h1>
            <p>The Bipartisan Policy Center is a recognized leader in bringing together all sides, regardless of party affiliation or political viewpoint—to tackle the critical challenges facing our nation. Support BPC by making a donation that ensures our work can continue. Share your impact using #Give2BPC on social media to spread the word that bipartisanship is necessary, and worth it.</p>
        
            <div id="price-buttons">
                <div class="price-button" v-bind:key="price" v-bind:class="{'price-selected':donationAmount == price && !customAmount}" v-on:click="setDonation(price)" v-for="price in donations.levels">{{price | currency}}</div>
                <input type="number" v-model="customAmount" class="price-button price-custom" placeholder="Custom">
            </div>

            <form>
                <input type="checkbox" v-model="recurring" id="recurring"> <p>Make this a <span class="bold">monthly</span> contribution. This can  be cancelled at any time.</p>
            </form>

            <p class="legal">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras venenatis congue erat. Proin ut metus eu nunc convallis consectetur nec sit amet libero. Nullam nulla leo, rutrum vitae orci eu, faucibus euismod justo. Pellentesque fermentum luctus felis tincidunt sollicitudin. Nam a velit elementum, egestas nisl vitae, tincidunt enim. Quisque laoreet ligula mauris, ut tincidunt eros tincidunt nec. Donec porta sodales enim, eget mattis lectus faucibus sed. Curabitur suscipit lorem metus, id consectetur nulla volutpat tincidunt. Nam consequat metus enim, nec gravida lacus facilisis sed. Proin interdum porttitor malesuada.</p>
        </div>

        <div v-bind:click="runTest()" class="step-action" id="step-a1">
            <a href="https://bipartisanpolic.org" id="step-a1-back">{{'Back to Bipartisan Policy Center'}}</a>
            <router-link to="/details" class="button btn-red" id="step-a1-next">Continue</router-link>
        </div>
    </div><!-- /.main -->
</template>

<script>
    export default {
        name: 'DonationHome',
        data () {
            axios.get('checkout').then(res => {console.log(res.data)})
            .catch(error => {
                // console.log('ERROR: ',err);
                // log out the error
                let message = `ERROR: `;
                // loader
                this.tableLoading = false;
                // Error
                if (error.response) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    message += error.response.status + `; ` + error.response.data.message;
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                } else if (error.request) {
                    // The request was made but no response was received
                    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                    // http.ClientRequest in node.js
                    message += error.request;
                    console.log(error.request);
                } else {
                    // Something happened in setting up the request that triggered an Error
                    message += error.message;
                    console.log('ERROR:', error.message);
                }
                console.log('ERROR CONFIG:',error.config,message);
            });
            return {
                assetURL: window.location.origin + '/wp-content/themes/fens-theme/assets/',
                donationAmount: null,
                recurring: false,
                customAmount: null,
                donations: {
                    levels:[    
                        10,
                        25,
                        50,
                        100,
                        250,
                        500,
                        750,
                        1000
                    ],
                    custom: {
                        label: '',
                        cost: null
                    }
                },
            }
        },
        methods: {
            runTest: function(){
                console.log('test');
                const url = 'https://wp-sandbox.localhost/wp-json/wc/v3/products';
                //=ck_8f3cc129a259045c7b1fadbf16a9fd8dabd9a2bd&consumer_secret=cs_3b8a5fe55c60233f247031442d2c9589543d721a';
                
                axios.get(url,{
                        auth: {
                            username: 'ck_8f3cc129a259045c7b1fadbf16a9fd8dabd9a2bd',
                            password: 'cs_3b8a5fe55c60233f247031442d2c9589543d721a'
                        },
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(res => {
                        console.log('RES: ',res.data);
                    })   
                    .catch(error => {
                        // console.log('ERROR: ',err);
                        // log out the error
                        let message = `ERROR: `;
                        // loader
                        this.tableLoading = false;
                        // Error
                        if (error.response) {
                            // The request was made and the server responded with a status code
                            // that falls out of the range of 2xx
                            message += error.response.status + `; ` + error.response.data.message;
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {
                            // The request was made but no response was received
                            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                            // http.ClientRequest in node.js
                            message += error.request;
                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            message += error.message;
                            console.log('ERROR:', error.message);
                        }
                        console.log('ERROR CONFIG:',error.config,message);
                    });
            },
            setDonation: function () {
                this.$store.commit('increment');
            },
            setCustomPrice: function() {
                //
            },
            setDonation: function(amount) {
                this.customAmount = null;
                this.donationAmount = amount;
            },
            updateState: function() {
                const donation = {
                    amount: this.donationAmount,
                    recurring: this.recurring
                }
                this.$store.commit('setAmount', donation);
            },
            noDonation: function() {
                this.$toast.open({
                    duration: 5000,
                    message: `Please specify a donation amount to proceed`,
                    position: 'is-bottom',
                    type: 'is-danger'
                })
            }
        },   
        computed: {
            isCustom: function() {
                if(this.customAmount){
                    this.donationAmount = this.customAmount;
                    return true;
                }
                return false;
            }
        },
        beforeRouteLeave (to, from, next) {
            console.log('BEFORE:',from);
            if(this.donationAmount == null){
                this.noDonation();
                return;
            }
            this.updateState();
            console.log(this.$store.getters.donation);
            next();
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
