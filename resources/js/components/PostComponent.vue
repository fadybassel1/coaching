<template >
  <div class="card shadow-none">
    <div class="card">
      <div v-for="post in posts" :key="post.id" class="row justify-content-center">
        <div class="col-md-8">
          <div class="card border-info mb-3">
            <h5 class="card-header">
              <img :src="'../avatar.jpg'" class="rounded-circle" width="50px" alt />
              {{ post.user.name }}
              <!-- <cite class="blockquote-footer float-right" title="Group Admin">Member</cite> -->
            </h5>
            <div class="card-body">
              <p class="card-title text-muted">{{ post.created_at }}</p>
              <h5>{{ post.text }}</h5>
              <div class="d-flex">
                <a
                  v-if="post.likes_count > 0"
                  data-toggle="modal"
                  @click="viewLikes(post.id)"
                  data-target="#likeModal"
                >{{ post.likes_count }} Likes</a>
                <a
                  v-if="post.comments_count > 0"
                  data-toggle="modal"
                  data-target="#exampleModalCenter"
                  class="ml-auto"
                  v-on:click="component = 'comments'; post_id = post.id;"
                >{{ post.comments_count }} Comments</a>
              </div>
              <hr />
              <div id="card-footer">
                <i
                  v-if="post.liked==false"
                  @click="likeButton(post)"
                  style="color:#3687CF; cursor: pointer"
                  class="far fa-thumbs-up float-left ml-md-5"
                >Like</i>
                <i
                  v-else
                  @click="dislikeButton(post)"
                  style="color:#3687CF; cursor: pointer;"
                  class="fas fa-thumbs-up float-left ml-md-5"
                >Like</i>
                <i style="color:#3687CF;" class="far fa-comment float-right mr-md-5">
                  <a
                    v-on:click="component = 'comments'; post_id = post.id;"
                    data-toggle="modal"
                    data-target="#exampleModalCenter"
                  >Comments</a>
                </i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <infinite-loading @distance="1" @infinite="infiniteHandler"></infinite-loading>
    </div>
    <!-- COMMENT MODEL -->
    <component :is="component" v-bind="currentProperties" :key="post_id"></component>
    <!-- END COMMENT MODEL -->
    <!-- LIKE MODEL -->
    <div
      class="modal fade"
      id="likeModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Likes</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              @click="hash"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div v-for="like in likes" :key="like.id">
            <h5 class="card-header">
              <img :src="'../avatar.jpg'" class="rounded-circle" width="50px" alt />
              {{ like.name }}
              <cite
                class="blockquote-footer float-right"
                title="Group Admin"
              >Member</cite>
            </h5>
            <p>{{ like.created_at }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END LIKE MODEL -->
</template>

<script>
window.onload = function () {
  $("#exampleModalCenter").on("show.bs.modal", function (e) {
    window.location.hash = "modal";
  });

  $(window).on("hashchange", function (event) {
    if (window.location.hash != "#modal") {
      $("#exampleModalCenter").modal("hide");
    }
  });
};

import InfiniteLoading from "vue-infinite-loading";
export default {
  props: {
    posturl: String,
    commenturl: String,
    likeurl: String,
  },
  components: {
    InfiniteLoading,
  },
  computed: {
    currentProperties: function () {
      return {
        commenturl: this.commenturl,
        post_id: this.post_id,
      };
    },
  },

  mounted() {
    console.log("Component mounted.");
    // $("#exampleModalCenter").on("hidden.bs.modal", function () {
    //   this.comments = [];
    //   console.log(this.comments);
    // });
    // $("#likeModal").on("hidden.bs.modal", function () {
    //   this.likes = [];
    //   console.log(this.likes);
    // });
  },
  data() {
    return {
      posts: [],
      page: 1,
      commentpage: 1,
      likepage: 1,
      comments: [],
      likes: [],
      component: "",
      post_id: -1,
    };
  },
  methods: {
    hash() {
      window.location.hash = "";
    },
    likeButton(post) {
      Vue.axios.post("api/posts/" + post.id + "/like").then((response) => {
        post.liked = true;
        post.likes_count += 1;
      });
    },
    dislikeButton(post) {
      Vue.axios.delete("api/posts/" + post.id + "/like").then((response) => {
        post.liked = false;
        post.likes_count -= 1;
      });
    },
    viewComments(id) {
      console.log(id);
      this.$http
        .get(this.commenturl + id + "?page=" + this.commentpage)
        .then(({ data }) => {
          if (data.data.length) {
            console.log(this.comments);
            this.comments = [];
            this.comments.unshift(...data.data);
            console.log(this.comments);
          } else {
            this.comments = [];
          }
        });
    },

    viewLikes(id) {
      console.log(id);
      console.log(this.likeurl + id + "?page=" + this.likepage);
      this.$http
        .get(this.likeurl + id + "?page=" + this.likes)
        .then(({ data }) => {
          console.log(data);
          if (data.data.length) {
            console.log("likes");
            console.log(this.likes);
            this.likes = [];
            this.likes.unshift(...data.data);
            console.log(this.likes);
          } else {
            this.likes = [];
          }
        });
    },

    infiniteHandler($state) {
      var lock = true;
      let vm = this;
      console.log(this.posturl);
      this.$http.get(this.posturl + "?page=" + this.page).then(({ data }) => {
        if (data.data.data.length) {
          this.page += 1;
          $.each(data.data.data, function (key, value) {
            console.log(value);
            vm.posts.push(value);
          });
          $state.loaded();
        } else {
          $state.complete();
        }
      });
    },

    // infiniteHandlercomment($state, id) {
    //   var lock = true;
    //   let vm = this;

    //   this.$http
    //     .get("/admin/post-comment/" + this.postid + "?page=" + this.page)
    //     .then(({ data }) => {
    //       if (data.data.length) {
    //         this.page += 1;
    //         this.comments.unshift(...data.data.reverse());
    //         $state.loaded();
    //       } else {
    //         $state.complete();
    //       }
    //     });
    // }
  },
};
</script>

//
<div class="card-body">
//         <p class="card-title">1 hour ago.</p>
//         <h5>Hello everybody</h5>
//         <hr>
        

     
       
    
//     </div>
