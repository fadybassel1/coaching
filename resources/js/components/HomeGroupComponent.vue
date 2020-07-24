<template>
    
  <div class="col-md-3">
   
    <div class="card my-4">
      <h5 class="card-header">Your Groups.</h5>
      <div class="card-body">
            <ul v-for="group in userGroups" :key="group.id" class="list-group">
          <li class="list-group-item"> <a :href="'/user/group/'+group.id">{{group.name}}</a></li>
        </ul>
        </div>
    </div>
    

     <div class="card my-4">
      <h5 class="card-header">Suggested Groups for you.</h5>
      <div class="card-body">
        <ul v-for="suggest in suggestedGroups" :key="suggest.id" class="list-group">
          <li class="list-group-item"> <a :href="'/user/group/'+suggest.id">{{suggest.name}}</a></li>
        </ul>
      </div>
    </div>
    
     <div class="card my-4">
      <h5 class="card-header">Most Popular Groups.</h5>
      <div class="card-body">
        <ul v-for="popularg in popularGroups" :key="popularg.id" class="list-group">
          <li class="list-group-item"> <a :href="'/user/group/'+popularg.id">{{popularg.name}}</a>  <i class="fas fa-users indigo-text"> {{popularg.users_count}}</i></li>
        </ul>
      </div>
    </div>


  </div>

</template>



<script>
import InfiniteLoading from "vue-infinite-loading";
export default {
  mounted() {
    console.log("Component mounted.");
  },
  data() {
    return {
      popularGroups: [],
      userGroups: [],
      suggestedGroups:[]
    };
  },

  created: function () {
    this.$http.get("/user/api/group-stat").then(({ data }) => {
      if (data.data.popularGroups.length) {
        this.popularGroups = data.data.popularGroups;
      }
      if (data.data.userGroups.length) {
        this.userGroups = data.data.userGroups;
      }
    });

       this.$http.get("/user/api/suggested-groups").then(({ data }) => {
           console.log();
      if (data.data.suggestedGroups.length) {
        this.suggestedGroups = data.data.suggestedGroups;
      }
    });    
  },

  methods: {},
};
</script>