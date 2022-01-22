<template>
<div>
  <div v-if="successful" class="alert alert-success alert-highlighted " role="alert">
    You have successfully updated this admin
  </div>
  <div v-if="failed" class="alert alert-danger alert-highlighted" role="alert">
    Server Error!.. Unable to complete your request.
  </div>
  <!-- <form @submit.prevent="handleSubmit" @change="emptyField()"> -->
  <form @submit.prevent="handleSubmit">
    
  <div class="form-group row justify-content-center">
      <div class="channel-avatar">
          <!-- <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSF9WuoaNBpIoPF4qXEBWtNOrns4NMYNT_hPA&usqp=CAU" alt="" class="image"> -->
          <img v-if="imageUrl !== ''" :src="imageUrl" class="image">
          <img v-else-if="admin.profile_picture !== null" :src="'/images/admin_profile_picture/thumbnail/'+admin.profile_picture" alt="" class="image">
          <img v-else :src="'/assets/app/img/user/dummydp.jpg'" alt="" class="image">
          <div onclick="document.getElementById('image').click()" class="channel-avatar-overlay" >
            <span class="icon" title="User Profile">
              <span class="mdi mdi-camera"></span>
            </span>   
          </div>
      </div>
  </div>
   <input @change="onImagePicked" class="d-none" id="image" type="file" name="profile_picture" accept="image/*">
      <label class="text-dark font-weight-medium" for="first_name">First Name</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="mdi mdi-account"></i>
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="first_name" name="first_name" type="text" :class="{'is-invalid' : firstnameErrors.length > 0, 'is-inv' : firstnameErrors.length > 0, 'form-control':true }" placeholder="John" aria-label="first_name" @input="disabling(first_name, firstnameErrors )" v-model="first_name">
      </div>
      <ul v-if="firstnameErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="firstnameError in firstnameErrors" :key="firstnameError" class="form-error" > {{ firstnameError   }}</li>
      </ul>
      
      <label class="text-dark font-weight-medium" for="last_name">Last Name</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-account"></i>
              </span>
          </div>
          <input :disabled="loading !== 'neutral'" id="last_name" name="last_name" type="text" :class="{'is-invalid' : lastnameError, 'is-inv' : lastnameError, 'form-control':true }" placeholder="James" aria-label="last_name" v-model="last_name" @input="disabling(last_name, lastnameError )" >
      </div>
      <ul v-if="lastnameError" class="mb-3 form-error-list"  >
        <li class="form-error"> {{ lastnameError   }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="email">Email</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-email"></i> 
              </span>
          </div>
          <input :disabled="loading !== 'neutral'" id="email" type="text" name="email" :class="{'is-invalid' : emailErrors.length > 0, 'is-inv' : emailErrors.length > 0, 'form-control':true}" placeholder="jahn@example.com " aria-label="email" v-model="email" @input="disabling(email, emailErrors )">
      </div>
      <ul v-if="emailErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="emailError in emailErrors" :key="emailError" class="form-error"> {{ emailError }}</li>
      </ul>

      <button v-if="loading === 'neutral'" type="submit" class="  btn btn-primary mb-4" :disabled="disable">Update </button>
      <button v-else-if="loading === 'loading'" disabled class="buttonload btn btn-primary">Loading.. <i class=" ml-2 fa fa-circle-o-notch fa-spin fa-1x"></i></button>
      <button v-else-if="loading === 'loaded'" disabled class="buttonload btn btn-primary">Done <i class=" ml-2 fa fa-check fa-1x"></i></button>
    </form> 
</div>
</template>

<script>
import axios from 'axios'

export default {
  props:{
    id: {
      required: true,
      default: () => ('')
    }
  },
  data() {
    return {
      admin: {},
      first_name: '',
      last_name:'',
      email: '',
      firstnameErrors: [],
      lastnameError: '',
      emailErrors: [],
      disable: false,
      button_clicked: false,
      loading: 'neutral',
      successful: false,
      failed: false,
      imageUrl: '',
      profile_picture: null
    }
  },
  mounted() {
    this.loadAdmin();
  },
  methods: {
    loadAdmin() {
      axios.get('/admins/'+this.id+'?edit=true')
      .then(res => {
        this.admin = res.data.admin;
        this.first_name = this.admin.first_name
        this.last_name = this.admin.last_name
        this.email = this.admin.email
      })
    },
    handleSubmit() {
      this.firstnameErrors= [];
      this.lastnameError = '';
      this.emailErrors= [];
      this.checkErrors();
      this.button_clicked = true;
      this.loading = 'neutral';
      this.successful= false;
      this.failed= false;

      var data = {};
      if(this.button_clicked && this.firstnameErrors.length < 1 && this.emailErrors.length < 1 && this.lastnameError.length < 1) {
        // data = {
        //   first_name: this.first_name,
        //   last_name: this.last_name ,
        //   email: this.email,
        //   type: 'save'
        // }

        var url = '';
        url = `/admins/${this.admin.id}/edit`
        
        this.loading = 'loading';
        
        const config = {
          headers: {
          'content-type': 'multipart/form-data',
          // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          }
        }
          // form data
        let formData = new FormData();
        if(this.profile_picture){
          formData.append('profile_picture', this.profile_picture);
        }
        formData.append('first_name', this.first_name);
        formData.append('last_name', this.last_name);
        formData.append('email', this.email);
        formData.append('type', 'save');
        // send upload request
        axios.post(url, formData, config)
        .then(response => {
          console.log(response.status)
          if(response.status === 200) {
            this.loading = 'loaded';
            setTimeout(() => this.successful= true, 500);
            setTimeout(() => window.location.replace("/admins"), 2000);
          }
          })
        .catch(error => {
            console.log(error.response)
            this.failed = true;
            setTimeout(() => {
              this.loading = 'neutral';
              this.disable = false;
            }, 1000);
        })
      } 
     
    },
    onImagePicked (event) {
      const files = event.target.files
      let filename = files[0].name
      const fileReader = new FileReader()
      fileReader.onload = e => {
        this.imageUrl = e.target.result;
      console.log(e.target);
      };
      fileReader.readAsDataURL(files[0])
      this.profile_picture = files[0]
    },
    disabling(field, fieldError) {
      this.disable;
      if( fieldError.length > 0) {
        if(field.length > 0) {
          if(field === this.last_name) {
            this.lastnameError = '';
          } else if(field === this.email && this.validEmail(this.email)){
            this.emailErrors = [];
          } else if(field === this.first_name) {
            this.firstnameErrors= [];
          }

          if(this.firstnameErrors.length < 1 && this.emailErrors.length < 1 && this.lastnameError.length < 1) {
            this.disable = false;
          }
          
        } else if(field === ''){
          this.disable = true;
        }
      }
    },
    emptyField() {
      
      if (this.button_clicked) {
        this.checkErrors();
        if(this.firstnameErrors.length < 1 && this.emailErrors.length < 1 && this.lastnameError.length < 1) {
            this.disable = false;
        }
      }
      
    },
    validEmail: function (email) {
      var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    checkErrors() {
      if(this.first_name.length < 1) {
        if(this.firstnameErrors.length > 0){
           this.firstnameErrors[this.firstnameErrors.length - 1] = 'First Name is required';
        } else {
          this.firstnameErrors.push('First Name is required ');
        }
        
      } else{
        this.firstnameErrors = [];
      }

      this.lastnameError = this.last_name.length > 0 ? '' : 'Last Name is required';

      if(this.email.length < 1) {
        if(this.emailErrors.length > 0){
           this.emailErrors[this.emailErrors.length - 1] = 'Email is required ';
        } else {
          this.emailErrors.push('Email is required');
        }
      } else if (!this.validEmail(this.email)) {
        if(this.emailErrors.length > 0){
          this.emailErrors[this.emailErrors.length - 1] = 'Invalid Email.';
        } else {
          this.emailErrors.push('Invalid Email.');
        }
      } else {
        this.emailErrors = [];
      }

      this.disable = true;
    }
  }
}
</script>

<style scoped>
.channel-avatar {
  position: relative;
  width: 100px;
  height: 100px;
  cursor: pointer;
  /* border: 1px solid rgba(0, 0, 0, 0.125); */
}

.image {
  display: block;
  width: 100%;
  height: 100%;
}

.channel-avatar-overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
  transition: .3s ease;
  background-color: rgba(0, 0, 0, 0.4);
}

.channel-avatar:hover .channel-avatar-overlay {
  opacity: 1;
}

.icon {
  color: white;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.mdi-camera:hover {
  color: #eee;
} 

.mdi-camera:before {
    font-size: xx-large;
}
</style>

