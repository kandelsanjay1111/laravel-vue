<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{getPath()}} Component</div>

                    <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th>Description</th>
                      <th>Stock</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(message,index) in messages">
                      <td>{{index+1}}</td>
                      <td>{{message.name}}</td>
                      <td>{{message.price}}</td>
                      <td>{{message.description}}</td>
                      <td>{{message.stock}}</td>
                    </tr>
                  </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
        return {
        messages:[],
        }
    },
    methods:{
    getPath(){
    return this.$route.path;
    }
    },
    mounted() {
        axios.get('api/product').then(product=>{
        this.messages=product.data;
        });
    }
    }
</script>
