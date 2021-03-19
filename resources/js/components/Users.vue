<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Responsive Hover Table</h3>
                <div class="card-tools">
                <button class="btn btn-success" type="button" @click="openModal" data-target="#addNew"> <i class="fas fa-user-plus"></i> Add User</button>
                </div>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Registered At</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user,index) in users" :key="user.id">
                      <td>{{index+1}}</td>
                      <td>{{user.name | textup}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.type |textup}}</td>
                      <td>{{user.created_at | mydate}}</td>
                      <td>
                      <a @click.prevent="editModal(user)"><i class="fas fa-edit text-blue"></i></a>/
                      <a @click.prevent="deleteUser(user.id)"><i class="fas fa-trash text-red"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form @submit.prevent="editmode? updateUser() :createUser()" @keydown="form.onKeydown($event)">
      <div class="modal-header">
        <h5 v-show="!editmode" class="modal-title" id="exampleModalLongTitle">Create New User</h5>
        <h5 v-show="editmode" class="modal-title" id="exampleModalLongTitle">Update User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
          <div class="form-group">
            <input id="name" v-model="form.name" type="text" name="name"
              class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off" placeholder="name">
            <has-error :form="form" field="name"></has-error>
          </div>
          <div class="form-group">
            <input id="email" v-model="form.email" type="email" name="email"
              class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" autocomplete="off" placeholder="admin@gmail.com">
            <has-error :form="form" field="email"></has-error>
          </div>
          <div class="form-group">
            <input id="password" v-model="form.password" type="password" name="password"
              class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" autocomplete="off" placeholder="password">
            <has-error :form="form" field="password"></has-error>
          </div>
          <div class="form-group">
            <select id="type" v-model="form.type" type="text" name="type"
              class="form-control" :class="{ 'is-invalid': form.errors.has('type') }" autocomplete="off">
              <option class="form-control" value="">Select User Role</option>
              <option class="form-control" value="admin" >Admin</option>
              <option class="form-control" value="user">Standard User</option>
              <option class="form-control" value="author">Author</option>
            </select>
            <has-error :form="form" field="type"></has-error>
          </div>
          <div class="form-group">
            <textarea id="bio" v-model="form.bio" type="text" name="bio"
              class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }" autocomplete="off" placeholder="Short bio for user(optional)">

            </textarea>
            <has-error :form="form" field="bio"></has-error>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
    </div>
</template>

<script>
    export default{
      
      data(){
        return{
          editmode:false,

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
        openModal(){
        $('#addNew').modal('show')
        this.editmode=false;
        this.form.reset();
        },

        editModal(user){
        this.editmode=true;
        $('#addNew').modal('show')
        this.form.fill(user);
        },
        
        updateUser(){
        this.$Progress.start();
        this.form.put('api/user/'+this.form.id).then(()=>{
            $('#addNew').modal('hide');
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'User has been updated successfully',
            showConfirmButton: false,
            timer: 2500
            })
            this.$Progress.finish();
            }).catch(()=>{
            this.$Progress.fail();
            });
        this.loadUser();
        },

        loadUser(){

        axios.get('api/user').then(({data})=>(this.users=data.data));

        },

        deleteUser(id){
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
          this.form.delete('api/user/'+id).then(()=>{

            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
            this.loadUser();
          })
          }
        })
          
        },

        createUser(){
        
        this.$Progress.start();

        this.form.post('api/user').then(()=>{
        Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'User has been created successfully',
        showConfirmButton: false,
        timer: 2500
        })
        $('#addNew').modal('hide');
        this.loadUser();
        }).catch(()=>{
            this.$Progress.fail();
            });

        this.$Progress.finish();
        }

      },

      created() {
      this.loadUser();
      }

    }
</script>
