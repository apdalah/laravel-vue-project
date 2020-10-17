<template>


    <v-app-bar app :dark="true">
        <slot name="toggleButton"></slot>
        <v-toolbar-title>Title</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
        </v-btn>
        <v-btn icon>
        <v-icon>mdi-heart</v-icon>
        </v-btn>
        <v-btn icon>
        <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
    </v-app-bar>

</template>


<script>
export default {
  props: ["user"],
  data: () => ({
       
    drawer: null,
    // allNotifications: [],
    // unreadNotifications: [],
  }),
  props: ["user"],
  // watch:{
  //     allNotifications(val){
  //         this.unreadNotifications =  this.allNotifications.filter(notification => {
  //           return notification.read_at == null;
  //       });
  //     }
  // },
  methods: {
    // logout() {
    //   axios.post("/logout").then(response => window.location.reload());
    // },
    // markAsRead() {
    //   axios.get("/mark-all-read/" + this.user.id).then(response=>{
    //       this.unreadNotifications = [];
    //   });
    // }
  },
 
  created() {
    // this.allNotifications = this.user.notifications;
    // this.unreadNotifications =  this.allNotifications.filter(notification => {
    //     return notification.read_at == null;
    //   });
    // Echo.private("App.User." + this.user.id).notification(notification => {
    //   this.allNotifications.unshift(notification.notification);
    // });
  }
};
</script>