<template>


   <div class="container">
           <infinite-loading direction="top" @infinite="infiniteHandler"></infinite-loading>
        <div>
        <div v-for="comment in comments" :key="comment.id" class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                         <h5 class="card-header"> <img :src="'../../avatar.jpg'" class="rounded-circle" width="50px" alt=""> Mark Refaat
                        <cite class="blockquote-footer float-right" title="Group Admin">Member</cite> </h5>
                        <div class="card-body">
                             <p class="card-title">15 min ago.</p>
    
                           <h5>{{comment.text}}</h5>
                    <i class="far fa-thumbs-up float-left ml-md-5"> Like</i> 

                            <hr>
                       </div>
                </div>
            </div>
        </div>
        <div class="footer">

                <input class="form-control" style="width: 90%" placeholder="send a comment" type="text">
                <i class="far fa-paper-plane active"></i>
            </div>
</div>
          
    </div>
   














               
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
   export default { 
       props: ['id'], 
         components: {
     InfiniteLoading,
     },
       mounted() {
            console.log('Component mounted.')
        }
      , data() {
            return {
                comments:[],
                page:1,
            };
        }, methods:{

            infiniteHandler($state){
               var lock = true;
                   let vm =this;
                               
                   this.$http.get('/admin/post-comment/'+this.id+'?page='+this.page)
                   .then(({ data }) => {
                if (data.data.length) {
                 this.page += 1;
                this.comments.unshift(...data.data.reverse());
                $state.loaded();
                 } else {
                $state.complete();
                  }
                });
                }
        }
    }










</script>