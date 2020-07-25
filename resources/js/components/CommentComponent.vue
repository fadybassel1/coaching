<template>
  <div
    ref="myModal"
    class="modal fade"
    id="exampleModalCenter"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Comments</h5>
          <button type="button" class="close" data-dismiss="modal" @click="hash" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div v-for="comment in comments" :key="comment.id" class="card border-primary">
            <h5 class="card-header">
              <img :src="'../avatar.jpg'" class="rounded-circle" width="50px" alt />
              <!-- {{ comment.user.name }} -->
              <cite class="blockquote-footer float-right" title="Group Admin">Member</cite>
            </h5>
            <div class="card-body">
              <p class="card-title">{{ comment.created_at }}.</p>
              <h5>{{ comment.text }}</h5>
              <hr />
            </div>
          </div>
          <div style="margin-top:1%;" class="container text-center">
            <span
              v-if="loadMore == true"
              @click="infiniteHandler"
              class="badge badge-pill badge-primary"
            >LoadMore</span>
          </div>
        </div>
        <div class="modal-footer">
          <input
            v-model="commentText"
            class="form-control"
            style="width: 90%"
            placeholder="send a comment"
            type="text"
          />
          <i @click="addComment" class="far fa-paper-plane active"></i>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
window.onload = function () {
  $("#exampleModalCenter").on("show.bs.modal", function (e) {
    window.location.hash = "modal";
    $("#exampleModalCenter").modal("handleUpdate");
    $("#exampleModalCenter").animate(
      { scrollTop: $("#exampleModalCenter .modal-content").height() },
      "slow"
    );
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
    commenturl: String,
    post_id: Number,
  },
  components: {
    InfiniteLoading,
  },

  mounted() {
    axios
      .get(this.commenturl + this.post_id + "?page=" + this.commentpage)
      .then(({ data }) => {
        if (data.data.length) {
          this.commentpage += 1;
          this.comments.push(...data.data);
          this.handleOpen();
          if (this.comments.length == data.total) this.loadMore = false;
        } else {
          this.loadMore = false;
        }
      });
  },
  data() {
    return {
      commentpage: 1,
      comments: [],
      loadMore: true,
      commentText: "",
    };
  },
  methods: {
    handleOpen() {
      this.$refs.myModal.scrollTop = this.$refs.myModal.scrollHeight;
    },
    hash() {
      window.location.hash = "";
    },
    close: function () {
      this.$emit("close");
    },
    addComment() {
      if (this.commentText != "") {
        axios
          .post("addComment", {
            post_id: this.post_id,
            text: this.commentText,
          })
          .then(({ data }) => {
            console.log(data);
            if (data.success) {
              this.comments.unshift(data.comment);
              this.commentText = "";
            }
          });
      }
    },
    infiniteHandler() {
      this.loadMore = true;
      axios
        .get(this.commenturl + this.post_id + "?page=" + this.commentpage)
        .then(({ data }) => {
          if (data.data.length) {
            this.commentpage += 1;
            this.comments.push(...data.data);
            if (this.comments.length == data.total) this.loadMore = false;
          } else {
            this.loadMore = false;
          }
        });
    },
  },
};
</script>
