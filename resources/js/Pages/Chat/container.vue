<script >
import AppLayout from '@/Layouts/AppLayout.vue';
import MessageContainer from './messageContainer.vue';
import InputMessage from './inputMessage.vue';
import axios from 'axios';
import ChatRoomSelection from './chatRoomSelection.vue';

export default{

components:{
    AppLayout,
    MessageContainer,
    InputMessage,
    ChatRoomSelection
},
data: function(){
  return{
    ChatRooms : [],
    currentRoom : [],
    messages : []
  }
},
methods:{
  getRooms(){
    axios.get('/chat/rooms')
    .then( response => {
      this.ChatRooms = response.data;
      this.setRoom(response.data[0]) ;
    })
    .catch( error => {
      console.log(error);
    })
  },
  setRoom(room){
      this.currentRoom = room;
      this.getMessages(); 
    },
    getMessages(){
      axios.get('/chat/room/' + this.currentRoom.id + '/messages')
      .then(response => {
        this.messages = response.data;
      })
      .catch( error => {
      console.log(error);
    })
    }
},
created(){
  this.getRooms();
}
}
</script>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <ChatRoomSelection></ChatRoomSelection>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                   <MessageContainer :messages="messages" 
                   />
                   <InputMessage 
                   :room ="currentRoom" 
                   v-on:messagesent="getMessages()"
                   /> 
                </div>
            </div>
        </div>
    </AppLayout>
</template>
