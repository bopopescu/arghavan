<template>
    <div class="col-md-4">
        <!-- <div class="option-card"> -->
            <div class="card card-profile" @click.prevent= "onSelectionCardViewAction">
                <div class="card-avatar">
                        <img class="img" :src="userPicture" />
                </div>

                <div class="card-body">
                     <!-- User Code -->
                    <div class="row text-center">
                        <h4>
                            <strong>
                                {{ userName }}
                                {{ userLastname }}
                            </strong>
                        </h4>
                    </div>
                     <div class= "row text-center">
                        <a href="#">
                            <h4 @click.prevent="onCountClick"
                                class="car-count">
                                {{ carsCount }}
                                 <i class="fas fa-car"></i>
                            </h4>
                        </a>
                        </div>
                    <!-- /User Code -->
                </div>
            </div>
        <!-- </div> -->
    </div>
</template>


<script>
export default {
    name: 'CarSearch',

    props: [
        'userData'
    ],

    computed: {
        userName: state => state.userData.people.people_name,
        userLastname: state => state.userData.people.people_lastname,
        carsCount: state => state.userData.cars.length,
        userPicture: state => state.userData.people.pictureThumbUrl,
        userId: state => state.userData.id,
    },

    methods: {
        /**
         * Count label click
         */
        onCountClick(){
            this.$emit ('edit-data', this.userData);
        },

        onSelectionCardViewAction(){
            if ($('.card.card-profile.choice').length > 0) {
                $('.choice').removeClass('choice');
                $('.card.card-profile').addClass('choice');
            }
            else {
                $('.card.card-profile').addClass('choice');
            }
            this.$emit ('selection-changed', this.userData);
        },
    }
}
</script>

<style scoped>
.car-count{
    flex-grow: 1;
    width: 100%;
    text-align: center;
    font-size: 6em;
    color: gray;
}
.card .card-profile:first-of-type {
    margin-left: 0;
}
.card .card-profile:last-of-type {
    margin-right: 0;
}
.card .card-profile:hover,
.card .card-profile.choice {
    border: 2px #0079c1 solid;
    text-decoration: none;
}
a.card .card-profile p:hover {
    text-decoration: none;
}


    /*cursor: pointer;*/
</style>
