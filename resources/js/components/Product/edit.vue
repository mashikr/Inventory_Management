<template>
    <div class="row px-lg-5 mx-lg-4">
        <div class="card mt-3 shadow">
            <div class="card-header text-center">
                <h3>Edit Product</h3>
            </div>
            <div class="card-body">
                <form enctype='multipart/form-data' @submit.prevent="editProduct">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="productname">Product Name</label>
                                <input type="text" name="productname" class="form-control" v-model="form.product_name" required>
                                <div class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_code">Product Code</label>
                                <input type="text" name="product_code" class="form-control" v-model="form.product_code" required>
                                <div class="text-danger" v-if="errors.product_code">{{ errors.product_code[0] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select v-model="form.category_id" class="form-select">
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.category }}</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <select v-model="form.supplier_id" class="form-select">
                                    <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>
                                </select>                           
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="buying_price">Buying Price</label>
                                <input type="number" class="form-control" name="buying_price" min="1" v-model="form.buying_price" id="buying_price" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="selling_price">Selling Price</label>
                                <input type="number" class="form-control" name="selling_price" v-model="form.selling_price" min="1" id="selling_price" required>                            
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="buying_date">Buying Date</label>
                                <input type="date" class="form-control" name="buying_date"  v-model="form.buying_date" id="buying_date" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_quantity">Quantity</label>
                                <input type="number" class="form-control" name="product_quantity" v-model="form.product_quantity" id="nid" min="1" required>                            
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="image">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" @change="addImage" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">{{ fileName }}</label>
                                </div>  
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img :src="form.image" alt="Selected Photo"  height="80px">
                        </div>
                    </div>
                    
                    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                </form>

            </div>
        </div>
    </div>
</template>


<script>
    export default {
         created() {
            if(!User.loggedIn()) {
                this.$router.push({name: '/'});
            }
            axios.get("/api/product/"+this.$route.params.id)
                .then(res => {
                    this.form = res.data;
                })
                .catch(error => this.errorMessage = error.response.data.message)

            axios.get("/api/category")
                .then(res => {
                    this.categories = res.data;
                })
                .catch(error => this.errorMessage = error.response.data.message)
            
            axios.get("/api/supplier")
                .then(res => {
                    this.suppliers = res.data;
                })
                .catch(error => this.errorMessage = error.response.data.message)
        },
        data() {
            return {
                form: {},
                fileName: 'Chose Photo',
                errors: {},
                categories: {},
                suppliers: {},
                errorMessage: ''
            }
        },
        methods: {
            editProduct() {
               axios.patch('/api/product/'+this.$route.params.id, this.form)
               .then((response) => {
                   this.$router.push({ name: 'allProduct'});
                   Notification.success();
               })
               .catch(error => {
                   Notification.error(error.response.data.message);
                   this.errors = error.response.data.errors;
               })
            },
            addImage(event) {
                let file = event.target.files[0];
                this.fileName = file.name;
                const fileExt = ["jpg", "jpeg", "JPG", "png", "PNG", "jfif"];
                 let ext = this.fileName.split(".");
                ext = ext[ext.length-1];
                if (file.size>1048770) {
                    Notification.image_validation('Upload image less than 1MB');
                } else if(!fileExt.includes(ext)) {
                     Notification.image_validation('Please insert an image file');
                } else {
                    let reader = new FileReader();
                    reader.onload = event => {
                        this.form.image = event.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            }
        }
    }
</script>