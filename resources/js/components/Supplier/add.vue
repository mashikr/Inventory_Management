<template>
    <div class="row px-lg-5 mx-lg-4">
        <div class="card mt-3 shadow">
            <div class="card-header text-center">
                <h3>Add Supplier</h3>
            </div>
            <div class="card-body">
                <form enctype='multipart/form-data' @submit.prevent="addSupplier">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Name</label>
                                <input type="text" name="name" class="form-control" v-model="form.name" required>
                                <div class="text-danger" v-if="errors.name">{{ errors.name[0] }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" v-model="form.email" required>
                                <div class="text-danger" v-if="errors.email">{{ errors.email[0] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" v-model="form.address" id="address" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shopname">Shop Name</label>
                                <input type="text" class="form-control" name="shopname" v-model="form.shopname" id="shopname">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_no">Phone No</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text py-0 text-dark" id="basic-addon1">+880</span>
                                    </div>
                                    <input type="number" class="form-control" name="phone_no"  v-model="form.phone" id="phone_no" min="1000000000" required>
                                </div>
                                <div class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</div>
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
                            <img :src="form.photo" alt="Selected Photo"  height="80px">
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
        },
        data() {
            return {
                form: {
                    name: null,
                    email: null,
                    address: null,
                    shopname: null,
                    phone: null,
                    photo: null,
                },
                fileName: 'Chose Photo',
                errors: {}
            }
        },
        methods: {
            addSupplier() {
               axios.post('/api/supplier', this.form)
               .then((response) => {
                   this.$router.push({ name: 'allSupplier'});
                   Notification.success();
               })
               .catch(error => {
                   Notification.image_validation(error.response.data.message);
                   this.errors = error.response.data.errors;
               })
            },
            addImage(event) {
                let file = event.target.files[0];
                this.fileName = file.name;
                const fileExt = ["jpg", "jpeg", "JPG", "png", "PNG"];
                let ext = this.fileName.split(".");
                ext = ext[ext.length-1];
                if (file.size>1048770) {
                    Notification.image_validation('Upload image less than 1MB');
                } else if(!fileExt.includes(ext)) {
                    console.log(ext);
                     Notification.image_validation('Please insert an image file');
                } else {
                    let reader = new FileReader();
                    reader.onload = event => {
                        this.form.photo = event.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            }
        }
    }
</script>