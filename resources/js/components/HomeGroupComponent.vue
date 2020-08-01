<template>
  <div class="col-md-3">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="card-body text-center">Popular Groups</div>
        </div>
        <div v-for="popularg in popularGroups" :key="popularg.id" class="carousel-item">
          <div class="card mb-3" style="max-width: 540px;">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img
                  v-if="popularg.photo"
                  :src="'../groups_images/'+popularg.photo"
                  width="100"
                  height="100"
                  class="card-img"
                />
                <img v-else :src="'../groups_images/404.png'" class="card-img" alt="..." />
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">{{popularg.name}}</h5>
                  <p class="card-text">Has {{popularg.users_count}} Members.</p>
                  <div class="card-text">
                    <a
                      :id="'joinButton'+popularg.id"
                      class="btn btn-outline-primary btn-sm btn-block"
                      @click="joinGroup(popularg.id)"
                    >Join</a>
                    <div
                      :id="'requestedButton'+popularg.id"
                      style="display: none;"
                      class="btn btn-outline-secondary btn-sm btn-block"
                    >Requested</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <a
        class="carousel-control-prev"
        href="#carouselExampleControls"
        role="button"
        data-slide="prev"
      >
        <span class="carousel-control-prev-icon blue" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a
        class="carousel-control-next"
        href="#carouselExampleControls"
        role="button"
        data-slide="next"
      >
        <span class="carousel-control-next-icon blue" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <div class="card my-4 border-primary mb-3">
      <h5 class="card-header">Your Groups.</h5>
      <div class="card-body">
        <ul v-for="group in userGroups" :key="group.id" class="list-group">
          <li class="list-group-item">
            <a :href="'/user/group/'+group.id">{{group.name}}</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="card my-4 border-primary mb-3">
      <h5 class="card-header">Suggested Groups for you.</h5>
      <div class="card-body">
        <ul v-for="suggest in suggestedGroups" :key="suggest.id" class="list-group">
          <li class="list-group-item">
            <a :href="'/user/group/'+suggest.id">{{suggest.name}}</a>
          </li>
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
      suggestedGroups: [],
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

  methods: {
    joinGroup(group_id) {
      console.log(group_id);
      axios.get("requestGroupJoin/" + group_id).then(({ data }) => {
        if (data.success) {
          document.getElementById("joinButton" + group_id).style.display =
            "none";
          document.getElementById("requestedButton" + group_id).style.display =
            "block";
        }
      });
    },
  },
};
</script>