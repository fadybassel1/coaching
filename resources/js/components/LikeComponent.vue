<template>
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
        <div style="margin-top:1%;" class="container text-center">
          <span
            v-if="loadMore == true"
            @click="infiniteHandler"
            class="badge badge-pill badge-primary"
          >LoadMore</span>
        </div>
      </div>
    </div>
  </div>
</template> 

<script>
import InfiniteLoading from "vue-infinite-loading";
export default {
  props: {
    likeurl: String,
    post_id: Number,
  },
  components: {
    InfiniteLoading,
  },

  mounted() {
    axios
      .get(this.likeurl + this.post_id + "?page=" + this.likepage)
      .then(({ data }) => {
        if (data.data.length) {
          this.likepage += 1;
          this.likes.push(...data.data);
          if (this.likes.length == data.total) this.loadMore = false;
        } else {
          this.loadMore = false;
        }
      });
  },
  data() {
    return {
      likepage: 1,
      likes: [],
      loadMore: true,
    };
  },
  methods: {
    hash() {
      window.location.hash = "";
    },
    infiniteHandler() {
      this.loadMore = true;
      axios
        .get(this.likeurl + this.post_id + "?page=" + this.likepage)
        .then(({ data }) => {
          if (data.data.length) {
            this.likepage += 1;
            this.likes.push(...data.data);
            if (this.likes.length == data.total) this.loadMore = false;
          } else {
            this.loadMore = false;
          }
        });
    },
  },
};
</script>
