<template>
  <div class="container">
    <div class="row">
      <div class="col col-md-12 block-container">
        <router-link class="card text-center" v-for="classroom in classrooms" :key="classroom.id" :to="'/classroom/' + classroom.id">
          <div class="card-body">
            <img style="border-radius:100%;" :src="classroom.avatar" alt="Card image cap">
            <h6 class="card-title">{{classroom.class_name}}</h6>
          </div>
          <div class="card-footer">
            <div class="dropdown dropup  float-left">
              <a class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">settings</i>
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <button class="dropdown-item" type="button">Action</button>
                <button class="dropdown-item" type="button">Another action</button>
                <button class="dropdown-item" type="button">Something else here</button>
              </div>
            </div>
            <!-- <span class="float-left text-muted"></span> -->
            <span class="float-right text-muted"><i class="material-icons">arrow forward</i></span>
          </div>
        </router-link>



      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['instituteId'],
  data () {
    return {
      institute: '',
      classrooms: ''
    }
  },
  mounted() {
    this.getInstitutes();
    this.getClassRooms();
  },
  methods: {
    getInstitutes() {
      axios.post('/api/institute/',{instituteId: this.instituteId})
      .then((response) => {
        this.institute = response.data;
      })
      .catch((err) => {
        console.log(err);
      })
    },
    getClassRooms() {
      axios.post('/api/classrooms', {instituteId: this.instituteId})
      .then((response) => {
        console.log(response.data);
        this.classrooms = response.data;
      })
      .catch((err)  => {
        console.log(err);
      })
    }
  }
}
</script>
