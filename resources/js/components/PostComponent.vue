<template >
  <div class="container-fluid shadow-none">
    <div
      style="  width: auto; 
                height:auto;
                max-height: 700px; 
                overflow-y: auto;
                overflow-x:hidden; 
                text-align:justify;"
      class="container-fluid scrollbar scrollbar-near-moon"
    >
      <div class="row justify-content-center">
        <div class="container-fluid">
          <div class="card border-info mb-3">
            <h5 class="card-header">
              <img :src="'../avatar.jpg'" class="rounded-circle" width="50px" alt />
              Mark "STATIC" "GROUP ID STATIC 1"
              <!-- <cite class="blockquote-footer float-right" title="Group Admin">Member</cite> -->
            </h5>
            <div class="card-body">
              <div class="d-flex">
                <input
                  type="text"
                  name="newPost"
                  id="newPost"
                  v-model="newPost"
                  class="form-control"
                  placeholder="Aktb aly nfsk fih"
                />
              </div>
              <hr />
              <div id="card-footer">
                <input
                  @click="addNewPost"
                  type="button"
                  value="Post"
                  class="btn btn-primary btn-sm float-right"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-for="post in posts" :key="post.id" class="row justify-content-center">
        <div class="container-fluid">
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
                  data-target="#likeModal"
                  v-on:click="component = 'likes'; post_id = post.id;"
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
                  style="color:#3687CF; cursor: pointer;"
                  class="far fa-thumbs-up float-left ml-md-5"
                >
                  <span style="padding-left:3px;">Like</span>
                </i>
                <i
                  v-else
                  @click="dislikeButton(post)"
                  style="color:#3687CF; cursor: pointer;"
                  class="fas fa-thumbs-up float-left ml-md-5"
                >
                  <span style="padding-left:3px;">Like</span>
                </i>
                <i style="color:#3687CF;" class="far fa-comment float-right mr-md-5">
                  <a
                    v-on:click="component = 'comments'; post_id = post.id;"
                    data-toggle="modal"
                    data-target="#exampleModalCenter"
                  >
                    <span style="padding-left:3px;">Comments</span>
                  </a>
                </i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <infinite-loading @distance="1" @infinite="infiniteHandler"></infinite-loading>
    </div>
    <!-- COMMENT AND LIKE MODEL -->
    <component
      :is="component"
      v-bind="currentProperties"
      :key="post_id"
      @commentAdded="increment_comments_count"
    ></component>
    <!-- END COMMENT AND LIKE MODEL -->
  </div>
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
      if (this.component == "comments") {
        return {
          commenturl: this.commenturl,
          post_id: this.post_id,
        };
      } else if (this.component == "likes") {
        return {
          likeurl: this.likeurl,
          post_id: this.post_id,
        };
      }
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
      newPost: "",
    };
  },
  methods: {
    hash() {
      window.location.hash = "";
    },
    addNewPost() {
      if (this.newPost != "") {
        axios
          .post("addNewPost", {
            text: this.newPost,
          })
          .then(({ data }) => {
            console.log(data);
            if (data.success) {
              data.post.liked = false;
              data.post.likes_count = 0;
              data.post.comments_count = 0;
              this.posts.unshift(data.post);
              this.newPost = "";
            }
          });
      }
    },
    increment_comments_count(post_id) {
      let post = this.posts.find((o) => o.id === post_id);
      post.comments_count++;
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
