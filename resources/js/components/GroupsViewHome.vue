<template>

 <div id="carouselExampleControls1" class="carousel slide" data-ride="carousel">
      For Testinggg
      <div  class="carousel-inner">
         <div class="carousel-item active">
           <div class="card-body text-center">
             Popular Groups
           </div>
         </div>
         <div class="container-fluid">
        <div v-for="popularg in popularGroups" :key="popularg.id" class="carousel-item">
          <div class="card mb-3" style="max-width: 540px;">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img :src="'../avatar.jpg'" class="card-img" alt="..." />
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">{{popularg.name}}</h5>
                  <p
                    class="card-text"
                  >Has {{popularg.users_count}} Members.</p>
                  <p class="card-text">
                   <a class="btn btn-outline-primary btn-sm btn-block" href="">Join</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
      <a
        class="carousel-control-prev"
        href="#carouselExampleControls1"
        role="button"
        data-slide="prev"
      >
        <span class="carousel-control-prev-icon blue" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a
        class="carousel-control-next"
        href="#carouselExampleControls1"
        role="button"
        data-slide="next"
      >
        <span class="carousel-control-next-icon blue" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

               
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
   export default { 
       props: ['id'], 
         components: {
     InfiniteLoading,
     },
       mounted() {
            console.log('Component mounted.')
        }
    ,data() {
    return {
      popularGroups: [],
      userGroups: [],
      suggestedGroups: [],
    };
  },

  created: function () {
    this.$http.get("/user/api/group-stat").then(({ data }) => {
      if (data.data.popularGroups.length) {
        this.popularGroups = data.data.popularGroups;
      }
    });
  },
    }










</script>