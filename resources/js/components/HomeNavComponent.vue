<template>
     <!-- Post Content Column -->
      <div class="container-fluid">


        <div style="" class="card shadow-none sticky-top">
      <nav style="margin-bottom:3%"  class="nav nav-pills flex-column flex-sm-row" id="pills-tab" role="tablist">
         <ul class="nav nav-pills" style="margin:0 auto" role="tablist">
          <li class="nav-item">
          <a v-on:click="component='post-component'" class="nav-link active"  data-toggle="pill" role="tab" aria-controls="pills-home" aria-selected="true" href="#">Home</a>
            </li>
          <li class="nav-item">
          <a v-on:click="component='groups-view-home'" class="nav-link" id="pills-profile-tab" data-toggle="pill"  role="tab" aria-controls="pills-profile" aria-selected="false" href="#">Groups</a>
           </li>
          <li class="nav-item">
          <a class="nav-link" id="pills-contact-tab" data-toggle="pill" role="tab" aria-controls="pills-contact" aria-selected="false"  href="#">Notifications</a>  
            </li>
         </ul>
        </nav>
</div>
          <!-- <post-component posturl='/user/api/recent-posts' commenturl="/admin/post-comment/"> </post-component> -->
         <keep-alive>
          <component :is="component" v-bind="currentProperties"></component>
         </keep-alive>

      </div>
</template>



<script>
   export default { 
   
       mounted() {
            console.log('Component mounted.')
        }
      , data() {
            return {
                component:'post-component',

            };
        }, methods:{}
        
        ,computed:{
            currentProperties: function() {
    if (this.component === 'post-component') {
      return { 
        posturl: '/user/api/recent-posts' , commenturl:'/admin/post-comment/' }
    }
    else return {}
  }
        }
    }
</script>