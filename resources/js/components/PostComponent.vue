

<template>
  <div class="card shadow-none">
    <div class="card">
      <div v-for="post in posts" :key="post.id" class="row justify-content-center">
        <div class="col-md-8">
          <div class="card border-info mb-3">
            <h5 class="card-header">
              <img :src="'../avatar.jpg'" class="rounded-circle" width="50px" alt />
              {{post.user.name}}
              <!-- <cite class="blockquote-footer float-right" title="Group Admin">Member</cite> -->
            </h5>
            <div class="card-body">
              <p class="card-title text-muted">{{post.created_at}}</p>
              <h5>{{post.text}}</h5>
              <hr />
              <div id="card-footer">
                <i style="color:#3687CF;" class="far fa-thumbs-up float-left ml-md-5">
                  Like
                  <a
                    data-toggle="modal"
                    @click="viewLikes(post.id)"
                    data-target="#likeModal"
                  >{{ post.likes_count }}</a>
                </i>
                <i style="color:#3687CF;" class="far fa-comment float-right mr-md-5">
                  <a
                    data-toggle="modal"
                    @click="viewComments(post.id)"
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
    <div
      class="modal fade"
      id="exampleModalCenter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Comments</h5>
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
          <div v-for="comment in comments" :key="comment.id" class="modal-body">
            <h5 class="card-header">
              <img :src="'../avatar.jpg'" class="rounded-circle" width="50px" alt />
              {{comment.user.name}}
              <cite
                class="blockquote-footer float-right"
                title="Group Admin"
              >Member</cite>
            </h5>
            <div class="card-body">
              <p class="card-title">{{comment.created_at}}.</p>
              <h5>{{comment.text}}</h5>
              <hr />
            </div>
          </div>

          <div class="modal-footer">
            <input class="form-control" style="width: 90%" placeholder="send a comment" type="text" />
            <i class="far fa-paper-plane active"></i>
          </div>
        </div>
      </div>
    </div>
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
              {{like.name}}
              <cite
                class="blockquote-footer float-right"
                title="Group Admin"
              >Member</cite>
            </h5>
            <p>{{like.created_at}}</p>
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

  mounted() {
    console.log("Component mounted.");
    $("#exampleModalCenter").on("hidden.bs.modal", function () {
      this.comments = [];
      console.log(this.comments);
    });
    $("#likeModal").on("hidden.bs.modal", function () {
      this.likes = [];
      console.log(this.likes);
    });
  },
  data() {
    return {
      posts: [],
      page: 1,
      commentpage: 1,
      comments: [],
      likes: [],
    };
  },
  methods: {
    hash() {
      window.location.hash = "";
    },
    viewComments(id) {
      console.log(id);
      this.$http
        .get(this.commenturl + id + "?page=" + this.commentpage)
        .then(({ data }) => {
          if (data.data.length) {
            console.log(this.comments);
            this.comments=[];
            this.comments.unshift(...data.data);
            console.log(this.comments);
          } else {
            this.comments = [];
          }
        });
    },

    viewLikes(id) {
      console.log(id);
      this.$http
        .get(this.likeurl + id + "?page=" + this.likes)
        .then(({ data }) => {
          console.log(data.length);
          if (data.length) {
            console.log("likes");
            console.log(this.likes);
            this.likes=[];
            this.likes.unshift(...data);
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























// <div class="card-body">
//         <p class="card-title">1 hour ago.</p>
//         <h5>Hello everybody</h5>
//         <hr>
        

     
       
    
//     </div>