<template>
  <div class="container-fluid my-5" align="center">
    <div class="row">
      <input
        v-model="search"
        @keyup="searchGroups"
        class="form-control form-control-sm mr-3 w-75"
        type="text"
        placeholder="Search"
        aria-label="Search"
      />
      <i class="fas fa-search" aria-hidden="true"></i>
    </div>

    <div class="row">
      <div
        class="card"
        style="width: 16rem; margin:1%"
        v-for="result in searchResults"
        :key="result.id"
      >
        <div class="text-center">
          <img
            v-if="result.photo"
            :src="'../groups_images/'+result.photo"
            style="max-width:150px; margin:0 auto; object-fit: cover;"
            width="150px"
            height="100px"
            class="card-img-top"
            alt="..."
          />
          <img
            v-else
            :src="'../groups_images/404.png'"
            style="max-width:150px; margin:0 auto; object-fit: cover;"
            width="150px"
            height="100px"
            class="card-img-top"
            alt="..."
          />

          <div class="card-body">
            <p class="card-text">{{result.name}}</p>
          </div>
          <div class="card-footer">
            <a :href="'/user/group/'+result.id" class="btn btn-primary btn-sm">View</a>
          </div>
        </div>
      </div>
    </div>

    <h3 class="font-weight-bold pb-4 mb-0 text-center">Your Groups</h3>
    <div class="row">
      <div class="card" style="width: 16rem; margin:1%" v-for="group in userGroups" :key="group.id">
        <div class="text-center">
          <img
            v-if="group.photo"
            :src="'../groups_images/'+group.photo"
            style="max-width:150px; margin:0 auto; object-fit: cover;"
            width="150px"
            height="100px"
            class="card-img-top"
            alt="..."
          />
          <img
            v-else
            :src="'../groups_images/404.png'"
            style="max-width:150px; margin:0 auto; object-fit: cover;"
            width="150px"
            height="100px"
            class="card-img-top"
            alt="..."
          />

          <div class="card-body">
            <p class="card-text">{{group.name}}</p>
          </div>
          <div class="card-footer">
            <a :href="'/user/group/'+group.id" class="btn btn-primary btn-sm">View</a>
          </div>
        </div>
      </div>
    </div>
    <input
      v-if="loadMore == true"
      @click="infiniteHandler"
      type="button"
      class="btn btn-primary btn-sm"
      value="load more"
    />
  </div>
</template>

<script>
import InfiniteLoading from "vue-infinite-loading";
export default {
  props: ["id"],

  mounted() {
    console.log("Component mounted.");
  },
  data() {
    return {
      userGroups: [],
      searchResults: [],
      loadMore: true,
      page: 1,
      search: "",
    };
  },

  methods: {
    searchGroups() {
      if (this.search.length == 0) this.searchResults = [];
      if (this.search.length >= 3) {
        axios.get("/user/api/search-groups/" + this.search).then(({ data }) => {
          if (data.data.results.length) {
            this.searchResults = [];
            this.searchResults = data.data.results;
          }
        });
      }
    },
    infiniteHandler() {
      this.loadMore = true;
      axios
        .get("/user/api/view-user-groups?page=" + this.page)
        .then(({ data }) => {
          if (data.data.userGroups.data.length) {
            this.userGroups.push(...data.data.userGroups.data);
            if (data.data.userGroups.last_page == this.page)
              this.loadMore = false;
            this.page += 1;
          } else {
            this.loadMore = false;
          }
        });
    },
  },

  created: function () {
    this.$http
      .get("/user/api/view-user-groups?page=" + this.page)
      .then(({ data }) => {
        if (data.data.userGroups.data.length) {
          this.userGroups = data.data.userGroups.data;
          this.page += 1;
        }
      });
  },
};
</script>