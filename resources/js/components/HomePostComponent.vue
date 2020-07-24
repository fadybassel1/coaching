<template>
     <!-- Post Content Column -->
      <div class="col-lg-7">

        <!-- Title -->
        <h1 class="mt-4">Most Recent Posts</h1>

        <!-- Posts -->
            <div class="card my-4"> 
      <div v-for="post in posts" :key="post.id" class="row justify-content-center">
        <div class="col-md-8">
          <div class="card border-info mb-3">
            <h5 class="card-header">
              <img :src="'../avatar.jpg'" class="rounded-circle" width="50px" alt /> {{post.user.name}}
              <!-- <cite class="blockquote-footer float-right" title="Group Admin">Member</cite> -->
            </h5>
            <div class="card-body">
              <p class="card-title text-muted">{{post.created_at}}</p>
              <h5>{{post.text}}</h5>
              <hr>
              <div id="card-footer">
                  <i style="color:#3687CF;" class="far fa-thumbs-up float-left ml-md-5"> Like</i>
              <i style="color:#3687CF;" class="far fa-comment float-right mr-md-5">
                <a
                  
                > Comments</a>
              </i>

              </div>
              
            </div>
          </div>
        </div>
      </div>
      <infinite-loading @distance="1" @infinite="infiniteHandler"></infinite-loading>
    </div>



      </div>
</template>



<script>
import InfiniteLoading from 'vue-infinite-loading';
   export default { 
   
       mounted() {
            console.log('Component mounted.')
        }
      , data() {
            return {
                posts:[],
                page:1,
            };
        }, methods:{

     infiniteHandler($state) {
      var lock = true;
      let vm = this;

      this.$http.get("/user/api/recent-posts?page=" + this.page).then(({ data }) => {
        console.log();
        if (data.data.data.length) {
          this.page += 1;
          $.each(data.data.data, function(key, value) {
            vm.posts.push(value);
          });
          $state.loaded();
        } else {
          $state.complete();
        }
      });
    }
        }
    }
</script>