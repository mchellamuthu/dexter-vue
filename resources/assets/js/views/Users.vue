<template>
<div class="container">
  <div class="row">
    <div class="col-md">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">API Token</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.key">
            <th scope="row">1</th>
            <td>{{user.name}}</td>
            <td>{{user.email}}</td>
            <td>{{user.api_token}}</td>
            <td><router-link  v-bind:to="'/user/'+user.id" class="btn btn-primary">EDIT</router-link></td>
          </tr>
          
        </tbody>
      </table>
    </div>
  </div>
</div>
</template>

<script>
    export default {
      data(){
          return {
            users:"",
            sno:0
          }
      },
      mounted() {
        this.getUsers();

      },
      methods: {
        getUsers() {
          axios.get('/api/users')
                .then((response) => {
                    console.log(response.data);
                    this.users = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        }
      }
    }
</script>
