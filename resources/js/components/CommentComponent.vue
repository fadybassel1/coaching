<template>
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
          <button type="button" class="close" data-dismiss="modal" @click="hash" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div v-for="comment in comments" :key="comment.id" class="modal-body">
          <h5 class="card-header">
            <img :src="'../avatar.jpg'" class="rounded-circle" width="50px" alt />
            {{ comment.user.name }}
            <cite
              class="blockquote-footer float-right"
              title="Group Admin"
            >Member</cite>
          </h5>
          <div class="card-body">
            <p class="card-title">{{ comment.created_at }}.</p>
            <h5>{{ comment.text }}</h5>
            <hr />
          </div>
        </div>
        <div class="container text-center">
          <div v-if="loadMore == true" @click="infiniteHandler" class="btn btn-primary">LoadMore</div>
        </div>
        <div class="modal-footer">
          <input class="form-control" style="width: 90%" placeholder="send a comment" type="text" />
          <i class="far fa-paper-plane active"></i>
        </div>
      </div>
    </div>
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
    };
  },
  methods: {
    hash() {
      window.location.hash = "";
    },
    close: function () {
      this.$emit("close");
    },

    infiniteHandler() {
      this.loadMore = true;
      axios
        .get(this.commenturl + this.post_id + "?page=" + this.commentpage)
        .then(({ data }) => {
          if (data.data.length) {
            this.commentpage += 1;
            this.comments.push(...data.data);
          } else {
            this.loadMore = false;
          }
        });
    },
  },
};
</script>
