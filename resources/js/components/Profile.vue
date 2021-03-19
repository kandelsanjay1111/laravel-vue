<style>
.widget-user .widget-user-header{
    height:250px;
}
</style>
<template>
</style>
    <div class="container">
        <div class="row justify-content-center">

        <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="background: url('./img/photo1.png') center center;">
                <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
                <h5 class="widget-user-desc text-right">Web Designer</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" :src="getProfileImage()" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
            <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                  
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="activity">
                  No activity to show
                  </div>
                  
                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal" @submit.prevent="updateInfo()">
                      <div class="form-group row">
                        <label for="inputName"  class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="name" placeholder="Name" v-model="form.name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="email" placeholder="Email" v-model="form.email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="password" placeholder="" v-model="form.password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="bio"  class="col-sm-2 col-form-label">bio</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="bio" placeholder="bio" v-model="form.bio">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="photo" class="col-sm-2 col-form-label">Profile Photo</label>
                        <div class="col-sm-10">
                          <input name="photo" type="file" id="photo" @change="uploadImage">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
        </div>
    </div>
</template>

<script>
    export default {
      data(){
        return{
          
          users:{},

          form: new Form({
            id:'',
            name: '',
            email:'',
            password:'',
            type:'',
            bio:'',
            photo:''
          })
        }

      },

      methods:{

      getProfileImage(){
      return "img/profile/"+this.form.photo;
      },

      updateInfo(){
      this.$Progress.start();
      this.form.put('api/profile')
      .then(()=>{
      this.$Progress.finish();
      })
      .catch(()=>{
      this.$Progress.fail();
      });
      },

        uploadImage(e){

        let file = e.target.files[0];

            if(file['size']<2111775){

            let reader= new FileReader();
            reader.readAsDataURL(file);

              reader.onloadend = (file)=>{
              
              this.form.photo=reader.result;
              }

            }

            else{
          Swal.fire({
          icon:'error',
          title: 'Oops..',
          text: 'Choose file less than 2 mb',
          })
        }
        
        }

      },

      

        mounted() {
            console.log('Component mounted.')
        },

        created(){
          axios.get('api/profile').then(({data})=>(this.form.fill(data)));
        }
    }
</script>
