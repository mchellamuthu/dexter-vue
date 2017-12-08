<template>
<div class="home-content">
  <button type="button" class="btn btn-primary">Hi</button>
</div>
</template>

<script>
export default {
  data() {
    return {
      institutes: ''
    }
  },
  mounted() {
    this.getInstitutes()
  },
  methods: {
    getInstitutes() {
      axios.get('/api/institutes')
        .then((response) => {
          console.log(response.data);
          this.institutes = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    }
  }
}
</script>
<style lang="css">
.dropdown-toggle::after {
    display:none !important;
}
  .block-container{
    text-align: center;
  }
  .block-container > .card{
    cursor: pointer;
    width: 15rem;
    float: left;
    margin: 5px;
  }
  .block-container > .card img{

    margin-bottom: 10px;
  }
</style>
