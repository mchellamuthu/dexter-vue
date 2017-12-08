<template>
<div class="container">
  <div class="row">
    <div class="col-md">
      <p>
          {{ user.name }}
      </p>
      <p>
          {{ user.email }}
      </p>
      <p>
          {{ user.api_token }}
      </p>

    </div>
  </div>
</div>
</template>

<script>
    export default {
      props: ['userId'],
      data(){
          return {
            user:""
          }
      },
      mounted() {
        this.getUsers();

      },
      methods: {
        getUsers() {
          axios.post('/api/user/',{userid:this.userId})
                .then((response) => {
                    console.log(response.data);
                    this.user = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        }
      }
    }
</script>
