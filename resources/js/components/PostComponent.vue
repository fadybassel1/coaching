<template>
    <div class="container">
        <div>
        <div v-for="post in posts" :key="post.id" class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                         <h5 class="card-header"> <img :src="'../avatar.jpg'" class="rounded-circle" width="50px" alt=""> Mark Refaat
                        <cite class="blockquote-footer float-right" title="Group Admin">Member</cite> </h5>
                        <div class="card-body">
                             <p class="card-title">15 min ago.</p>
    
                           <h5>{{post.text}}</h5>
                    <i class="far fa-thumbs-up float-left ml-md-5"> Like</i> 
                    <i  style="color:#3687CF;" class="far fa-comment float-right mr-md-5"> <a :href="'/admin/post-comment-view/' + post.id"> Comments </a> </i>

                            <hr>
                       </div>
                </div>
            </div>
        </div>
            <infinite-loading @distance="1" @infinite="infiniteHandler"></infinite-loading>
</div>

    </div>


    
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
   export default {  
         components: {
     InfiniteLoading,
     },
       
       mounted() {
            console.log('Component mounted.')
        }
      , data() {
            return {
                posts:[],
                page:1,
            }
        }, methods:{

            commentsModal(){
                    $('#exampleModalCenter').modal('show');
            },


            infiniteHandler($state){
               var lock = true;
                   let vm =this;
                               
                   this.$http.get('/admin/posts?page='+this.page)
                   .then(response=>{
                        return response.json();
                   }).then(newResponse=>{
                       if(newResponse.data.length){
                       $.each(newResponse.data,function(key,value){
                           vm.posts.push(value)
                           console.log(newResponse.total); 
                       });
                       this.page=this.page+1;
                       if(newResponse.total==this.posts.length)
                       $state.complete();
                       $state.loaded();
                       }
                       else $state.complete();
                       });
                }
        }
    }
</script>




















// <div class="modal fade show" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-modal="true" style="display: block;">
//     <div class="modal-dialog modal-dialog-centered" role="document">
//         <div class="modal-content">
//             <div class="modal-header">
//                 <h5 class="modal-title" id="exampleModalCenterTitle">Comments</h5>
//                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
//                     <span aria-hidden="true">×</span>
//                 </button>
//             </div>
//             <div class="modal-body">

               
//                     <h5 class="card-header"> <img src="http://192.168.0.9:8000/avatar.jpg" class="rounded-circle" width="50px" alt=""> Mark Refaat
//                         <cite class="blockquote-footer float-right" title="Group Admin">Member</cite> </h5>
//                     <div class="card-body">
//                         <p class="card-title">30 min ago.</p>
//                         <h5>Hi</h5>
//                         <hr>
//                     </div>
               

            
                    
//                         <h5 class="card-header"> <img src="http://192.168.0.9:8000/avatar.jpg" class="rounded-circle" width="50px" alt=""> Mark Refaat
//                             <cite class="blockquote-footer float-right" title="Group Admin">Member</cite> </h5>
//                         <div class="card-body">
//                             <p class="card-title">15 min ago.</p>
//                             <h5>welcomee very nice to meet you.</h5>
//                             <hr>
//                         </div>
                    
            
            
//                         <h5 class="card-header"> <img src="http://192.168.0.9:8000/avatar.jpg" class="rounded-circle" width="50px" alt=""> Mark Refaat
//                         <cite class="blockquote-footer float-right" title="Group Admin">Member</cite> </h5>
//                     <div class="card-body">
//                         <p class="card-title">10 min ago.</p>
//                         <h5>Helloooooo</h5>
//                         <hr>
//                     </div>
            
            
//                 </div>
               

//             <div class="modal-footer">

//                 <input class="form-control" style="width: 90%" placeholder="send a comment" type="text">
//                 <i class="far fa-paper-plane active"></i>
//             </div>
//         </div>
//     </div>
// </div>








<div class="card-body">
        <p class="card-title">1 hour ago.</p>
        <h5>Hello everybody</h5>
        <hr>
        

     
       
    
    </div>