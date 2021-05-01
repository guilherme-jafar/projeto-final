<template>


    <p>{{students}}</p>
</template>

<script>
import Echo from "laravel-echo";

export default {
name: "WaitRoomStudent",

    data() {
        return {
            students:0
        }
    },
    watch:{
        currentRoom(){
            this.connect();
        }
    },

    methods:{
        connect()
        {
            let l = window.location.href.split('/');
            window.Echo.private('room'.l[l.length - 1])
                .listen('.NewStudent', e => {
                    console.log(e)
                    this.students=e.num;

                })

        }
    },
    mounted() {
        // window.Echo = new Echo({
        //     broadcaster: 'pusher',
        //     key: 'd6cfe66609c4185a1732',
        //     cluster:'eu',
        //     encrypted: true,
        //     forceTLS:true
        // });




    },
}
</script>

<style scoped>

</style>
