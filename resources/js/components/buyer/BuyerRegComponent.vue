<template>
<div>
     <div v-if="successful" class="alert alert-success alert-highlighted " role="alert">
       You have successfully created a new buyer
     </div>
     <div v-if="failed" class="alert alert-danger alert-highlighted" role="alert">
        Server Error!.. Unable to complete your request.
     </div>
    <form @submit.prevent="handleSubmit" @change="emptyField()">
      <label class="text-dark font-weight-medium" for="first_name">First Name</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="mdi mdi-account"></i>
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="first_name" name="first_name" type="text" :class="{'is-invalid' : firstnameErrors.length > 0, 'is-inv' : firstnameErrors.length > 0, 'form-control':true }" placeholder="John" aria-label="first_name" v-model="first_name" @input="disabling(first_name, firstnameErrors )">
      </div>
      <ul v-if="firstnameErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="firstnameError in firstnameErrors" :key="firstnameError" class="form-error" > {{ firstnameError   }}</li>
      </ul>
      <label class="text-dark font-weight-medium" for="middle_name">Middle Name</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="mdi mdi-account"></i>
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="middle_name" name="middle_name" type="text" placeholder="Adeola" aria-label="last_name" v-model="middle_name" class="form-control">
      </div>
      
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

      <label class="text-dark font-weight-medium" for="phone_number">Phone number</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-phone-classic"></i> 
              </span>
          </div>
          <input :disabled="loading !== 'neutral'" id="phone_number" type="text" name="phone_number" :class="{'is-invalid' : phoneNumberErrors.length > 0, 'is-inv' : phoneNumberErrors.length > 0, 'form-control':true}" placeholder="2348023456789 " aria-label="phone_number" v-model="phone_number" @input="disabling(phone_number, phoneNumberErrors )">
      </div>
      <ul v-if="phoneNumberErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="phoneNumberError in phoneNumberErrors" :key="phoneNumberError" class="form-error"> {{ phoneNumberError }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="role">Role</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-human-child"></i> 
              </span>
          </div>
          <select :disabled="loading !== 'neutral'" class="form-control" id="role" v-model="role" :class="{'is-invalid' : roleErrors.length > 0, 'is-inv' : roleErrors.length > 0}"  @change="disabling(role, roleErrors )">
            <option value="" disabled selected>Select Role</option>
            <option value="customer" selected>Customer</option>
            <option value="guest">Guest Customer</option>
          </select>
      </div>
      <ul v-if="roleErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="roleError in roleErrors" :key="roleError" class="form-error"> {{ roleError }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="gender">Gender</label>
      <div class="input-group">
          <ul class="list-unstyled list-inline" id="gender">
            <li class="d-inline-block mr-3">
              <label class="control control-radio outlined radio-primary">Male
                <input type="radio" name="gender" value="male" v-model="gender" checked="checked">
                <div class="control-indicator"></div>
              </label>
            </li>
            <li class="d-inline-block mr-3">
              <label class="control control-radio outlined radio-primary">Female
                <input type="radio" name="gender" value="female" v-model="gender">
                <div class="control-indicator"></div>
              </label>
            </li>
            <li class="d-inline-block mr-3">
              <label class="control control-radio outlined radio-primary">Other
                <input type="radio" name="gender" value="other" v-model="gender">
                <div class="control-indicator"></div>
              </label>
            </li>
          </ul>
      </div>

      <label class="text-dark font-weight-medium" for="dob">Date of Birth</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-calendar"></i> 
              </span>
          </div>
          <input :disabled="loading !== 'neutral'" id="dob" type="date" name="dob" :max="new Date().toISOString().slice(0, 10)" aria-label="dob" v-model="dob" class="form-control">
      </div>
      
    <label class="text-dark font-weight-medium" for="address">Address</label>
    <div class="form-group" id="address">
      
      <FormulateInput
        type="group"
        v-model="addresses"
        name="addresses"
        label="Maximum of 5 addresses"
        help="The first address will be your primary address"
        add-label="+ Add Address"
        :repeatable="true"
        :limit="limit"
        validation = 'required'
        
      >
      <div class="order">
        <FormulateInput
          type="text"
          name="address"
          label="Address"
          placeholder="Address"
          validation="required"
          :validation-messages="{
            required: 'Address is required.'
          }"
         @change = "updateAddress"
        />
      </div>
      <div class="order">
        <FormulateInput
          type="text"
          name="city"
          label="City"
          placeholder="City"
          validation="required"
          :validation-messages="{
            required: 'City is required.'
          }"
          @change = "updateAddress"
        />
      </div>
      <div class="order">
        <FormulateInput
          name="state"
          type="select" 
          label="State" 
          placeholder="Select a state"
          validation="required" 
          :validation-messages="{
            required: 'State is required.'
          }"
      @change = "updateAddress"
          :options="{
            vanilla: 'Vanilla', 
            chocolate: 'Chocolate', 
            strawberry: 'Strawberry', 
            pineapple: 'Pineapple',
            vanila: 'Vanilla', 
            chcolae: 'Chocolate', 
            strawbrry: 'Strawberry', 
            pieappe: 'Pineapple',
            vanill: 'Vanilla', 
            choclate: 'Chocolate', 
            strawbery: 'Strawberry', 
            pineappe: 'Pineapple',
            vana: 'Vanilla', 
            choat: 'Chocolate', 
            strawerry: 'Strawberry', 
            pineaple: 'Pineapple',
            vnilla: 'Vanilla', 
            chcolate: 'Chocolate', 
            srwberry: 'Strawberry', 
            pieaple: 'Pineapple',
            vanla: 'Vanilla', 
            chclate: 'Chocolate', 
            stwberry: 'Strawberry', 
            pinaple: 'Pineapple',
            anila: 'Vanilla', 
            ocolate: 'Chocolate', 
            awberry: 'Strawberry', 
            peapple: 'Pineapple',
            vaia: 'Vanilla', 
            clate: 'Chocolate', 
            berry: 'Strawberry', 
            ppple: 'Pineapple',
            }" 
        />      
      </div>
    </FormulateInput>
      <ul v-if="addressesErrors.length > 0" class="mb-3 form-error-list"  >
        <li class="form-error"> {{ addressesErrors }}</li>
      </ul>
      <!-- <ul v-if="addressesErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="addressesError in addressesErrors" :key="addressesError" class="form-error"> {{ addressesError }}</li>
      </ul> -->
    </div>

      <!-- <label class="text-dark font-weight-medium" for="address">Address</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-map-marker-multiple"></i> 
              </span>
          </div>
          <input :disabled="loading !== 'neutral'" id="address" type="text" name="address" :class="{'is-invalid' : addressErrors.length > 0, 'is-inv' : addressErrors.length > 0, 'form-control':true}" placeholder="2, Akoigba street, Ebute meta " aria-label="address" v-model="address" @input="disabling(address, addressErrors )">
      </div>
      <ul v-if="emailErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="addressError in addressErrors" :key="addressError" class="form-error"> {{ addressError }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="state">State</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-source-commit-start"></i> 
              </span>
          </div>
          <select :disabled="loading !== 'neutral'" class="form-control" id="state" v-model="state"  :class="{'is-invalid' : stateErrors.length > 0, 'is-inv' : stateErrors.length > 0}"  @change="disabling(state, stateErrors )">
            <option disabled value="">Select state</option>
            <option value="Abuja">FCT Abuja</option>
            <option value="Abia">Abia</option>
            <option value="Adamawa">Adamawa</option>
            <option value="Akwa Ibom">Akwa Ibom </option>
            <option value="Anambra">Anambra</option>
            <option value="Bauchi">Bauchi</option>
            <option value="Bayelsa">Bayelsa</option>
            <option value="Benue">Benue</option>
            <option value="Borno">Borno</option>
            <option value="Cross River">Cross River</option>
            <option value="Delta">Delta</option>
            <option value="Ebonyi">Ebonyi</option>
            <option value="Edo">Edo</option>
            <option value="Ekiti">Ekiti</option>
            <option value="Enugu">Enugu</option>
            <option value="Gombe">Gombe</option>
            <option value="Imo">Imo</option>
            <option value="Jigawa">Jigawa</option>
            <option value="Kaduna">Kaduna</option>
            <option value="Kano">Kano</option>
            <option value="Katsina">Katsina</option>
            <option value="Kebbi">Kebbi</option>
            <option value="Kogi">Kogi</option>
            <option value="Kwara">Kwara</option>
            <option value="Lagos">Lagos</option>
            <option value="Nasarawa">Nasarawa</option>
            <option value="Niger">Niger</option>
            <option value="">Ogun</option>
            <option value="Ogun">Ondo</option>
            <option value="Osun">Osun</option>
            <option value="Oyo">Oyo</option>
            <option value="Plateau">Plateau</option>
            <option value="Rivers">Rivers</option>
            <option value="Sokoto">Sokoto</option>
            <option value="Taraba">Taraba</option>
            <option value="Yobe">Yobe</option>
            <option value="Zamfara">Zamfara</option>
          </select>
      </div>
      <ul v-if="stateErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="stateError in stateErrors" :key="stateError" class="form-error"> {{ stateError }}</li>
      </ul> --> 

      <button v-if="loading === 'neutral'" type="submit" class="  btn btn-primary mb-4" :disabled="disable"> Create</button>
      <button v-else-if="loading === 'loading'" disabled class="buttonload btn btn-primary">Loading.. <i class=" ml-2 fa fa-circle-o-notch fa-spin fa-1x"></i></button>
      <button v-else-if="loading === 'loaded'" disabled class="buttonload btn btn-primary">Done <i class=" ml-2 fa fa-check fa-1x"></i></button>
    </form>
</div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      first_name:'',
      middle_name:'',
      last_name:'',
      email: '',
      phone_number: '',
      role: '',
      gender: 'male',
      dob: '',
      firstnameErrors: [],
      lastnameError: '',
      emailErrors: [],
      phoneNumberErrors: [],
      roleErrors: [],
      addressesErrors: '',
      disable: false,
      button_clicked: false,
      loading: 'neutral',
      successful: false,
      failed: false,
      limit: 2,
      addresses : [],
    }
  },
  methods: {
    updateAddress() {
      // console.log(this.formData.addresses?.[0]);
      var al = this.addresses?.length;
      if(this.addresses?.length > 0 && this.addresses?.length < 5 && this.addresses[al-1]?.address?.length > 0 && this.addresses[al-1]?.city?.length > 0 && this.addresses[al-1]?.state?.length > 0)
      {
        this.limit = this.addresses.length + 1
        console.log(this.addresses.length);
        console.log(this.limit);
      }

      // if(this.addressData.addresses?.length > 1){
      //   const map2 = this.addressData.addresses.map(x => {
      //     JSON.stringify(x).toLowerCase() == JSON.stringify(this.addressData.addresses[1]).toLowerCase();
      //   jay.push(x);})
      // }
      // console.log(jay);
    },
    handleSubmit() {
      this.firstnameErrors= [];
      this.lastnameError = '';
      this.emailErrors= [];
      this.phoneNumberErrors = [];
      this.roleErrors = [];
      this.addressesErrors = '';
      this.checkErrors();
      this.button_clicked = true;
      this.loading = 'neutral';
      this.successful= false;
      this.failed= false;
      console.log('here dey');
      console.log(this.addressesErrors);

      var data = {};
      if(this.button_clicked && this.firstnameErrors.length < 1 && this.emailErrors.length < 1  && this.roleErrors.length < 1 && this.phoneNumberErrors.length < 1 && this.lastnameError.length < 1 && this.addressesErrors?.length < 1) {
      console.log('here nkor 1');
      
        data = {
          first_name: this.first_name,
          middle_name: this.middle_name ,
          last_name: this.last_name ,
          email: this.email,
          phone_number: this.phone_number,
          role: this.role,
          gender: this.gender,
          dob: this.dob,
          addresses: this.addresses,
          type: 'save'
        }
        console.log(this.addressesErrors);

        var url = '';
        url = '/buyers'
        
        this.loading = 'loading';
        axios.post(url, data)
        .then(response => {
          console.log(response.status)
          if(response.status === 201) {
            this.loading = 'loaded';
            setTimeout(() => this.successful= true, 500);
            setTimeout(() => window.location.replace("/buyers"), 2000);
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
          } else if(field === this.phone_number) {
            this.phoneNumberErrors= [];
          } else if(field === this.role) {
            this.roleErrors= [];
          } else if(field === this.addresses) {
            this.addressesErrors= '';
          }

          if(this.firstnameErrors.length < 1 && this.emailErrors.length < 1 && this.lastnameError.length < 1 && this.phoneNumberErrors.length < 1 && this.roleErrors.length < 1 && this.addressesErrors?.length < 1) {
            
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
        var strangeError;
        if(this.firstnameErrors.length < 1 && this.emailErrors.length < 1 && this.lastnameError.length < 1 && this.phoneNumberErrors.length < 1 && this.roleErrors.length < 1 && this.addressesErrors?.length < 1) {
          this.disable = false;
        }
      }
      
    },
    validEmail: function (email) {
      var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    validPhoneNumber: function (phone_number) {
      var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
      return re.test(phone_number);
    },
    checkErrors() {
      console.log(this.addresses?.length);
      console.log(this.addresses);
        // check address error
      // if(this.addresses?.length > 0) {
      //   console.log('here gangan');
      //   for(let i=0; i<this.addresses.length; i++) {
      //       console.log(this.addresses[i]);
      //       console.log(this.addresses[i].address);
      //       console.log(this.addresses[i].city);
      //       console.log(this.addresses[i].state);
      //       console.log(this.addressesErrors);
      //     if(!this.addresses[i].address || this.addresses[i].address.length < 1 || !this.addresses[i].city || this.addresses[i].city.length < 1 || !this.addresses[i].state || this.addresses[i].state.length < 1) {
      //       console.log('address them zero');
      //       if(this.addressesErrors?.length > 0 && i > 0){
      //         this.addressesErrors[ i-1] = 'Address field is required';
      //         // this.addressesErrors[i - 1] = 'Address field is required';
      //       console.log('address them first');
      //       console.log(this.addressesErrors);
      //       } else {
      //         this.addressesErrors[i] = 'Address field is required';
      //       console.log('address them second');
      //       console.log(this.addressesErrors);
      //       }
      //       console.log('address them');
      //     } else {
      //         var commonError;
      //       if(this.addressesErrors?.length > 0 && i > 0){
      //         // var commonError = this.addressesErrors.find(err => err == "nothing");
      //         for(let j=0; j<this.addressesErrors.length; j++) {
      //           commonError = this.addressesErrors[j] == "nothing" ? 1 : ''
      //         console.log(commonError);
      //         }
      //         this.addressesErrors[ i-1] = "nothing";m  
      //         // this.addressesErrors[i - 1] = 'Address field is required';
      //       console.log('address them third');
      //       console.log(this.addressesErrors);
      //       } else {
      //       this.addressesErrors[i] = "nothing";
      //       console.log('address them fourth');
      //       console.log(this.addressesErrors);
      //       }
      //     }
      //   };
      // }

      if(this.addresses?.length > 0) {
        console.log('here gangan');
        var updatedAddressList = this.addresses.map(element => JSON.stringify(element).toLowerCase());
        var addressExists = updatedAddressList.some((val, i) => updatedAddressList.indexOf(val) !== i);
        console.log(addressExists);
        for(let i=0; i<this.addresses.length; i++) {
          if(!this.addresses[i].address || this.addresses[i].address.length < 1 || !this.addresses[i].city || this.addresses[i].city.length < 1 || !this.addresses[i].state || this.addresses[i].state.length < 1) {
            console.log('address them zero');
            this.addressesErrors = 'Address field is required';
              console.log(this.addressesErrors);
          } else {
            if(this.addressesErrors?.length > 0) {
              if(this.addressesErrors == 'Address field is required'  && i == 1 ){
                if(!this.addresses[i-1]?.address || this.addresses[i-1]?.address.length < 1 || !this.addresses[i-1]?.city || this.addresses[i-1]?.city.length < 1 || !this.addresses[i-1]?.state || this.addresses[i-1]?.state.length < 1) {
                  this.addressesErrors == 'Address field is required'
                }else if(this.addresses[i].address && this.addresses[i].address.length > 0 && this.addresses[i].city && this.addresses[i].city.length > 0 && this.addresses[i].state && this.addresses[i].state.length > 0) {
                  if(addressExists) {
                    this.addressesErrors = 'There is a duplicate of an address'
                  } else {
                    this.addressesErrors = ''; 
                  }
                } else {
                  this.addressesErrors;
                }
              }
              else if(this.addressesErrors == 'Address field is required' && i == 2){
                if(!this.addresses[i-1]?.address || this.addresses[i-1]?.address.length < 1 || !this.addresses[i-1]?.city || this.addresses[i-1]?.city.length < 1 || !this.addresses[i-1]?.state || this.addresses[i-1]?.state.length < 1 || !this.addresses[i-2]?.address || this.addresses[i-2]?.address.length < 1 || !this.addresses[i-2]?.city || this.addresses[i-2]?.city.length < 1 || !this.addresses[i-2]?.state || this.addresses[i-2]?.state.length < 1) {
                  this.addressesErrors == 'Address field is required'
                } else if(this.addresses[i].address && this.addresses[i].address.length > 0 && this.addresses[i].city && this.addresses[i].city.length > 0 && this.addresses[i].state && this.addresses[i].state.length > 0) {
                  if(addressExists) {
                    this.addressesErrors = 'There is a duplicate of an address'
                  } else {
                    this.addressesErrors = ''; 
                  }
                } else {
                  this.addressesErrors;
                }
              }
              else if(this.addressesErrors == 'Address field is required' && i == 3){
                if(!this.addresses[i-1]?.address || this.addresses[i-1]?.address.length < 1 || !this.addresses[i-1]?.city || this.addresses[i-1]?.city.length < 1 || !this.addresses[i-1]?.state || this.addresses[i-1]?.state.length < 1 || !this.addresses[i-2]?.address || this.addresses[i-2]?.address.length < 1 || !this.addresses[i-2]?.city || this.addresses[i-2]?.city.length < 1 || !this.addresses[i-2]?.state || this.addresses[i-2]?.state.length < 1 || !this.addresses[i-3]?.address || this.addresses[i-3]?.address.length < 1 || !this.addresses[i-3]?.city || this.addresses[i-3]?.city.length < 1 || !this.addresses[i-3]?.state || this.addresses[i-3]?.state.length < 1) {
                  this.addressesErrors == 'Address field is required'
                }else if(this.addresses[i].address && this.addresses[i].address.length > 0 && this.addresses[i].city && this.addresses[i].city.length > 0 && this.addresses[i].state && this.addresses[i].state.length > 0) {
                  if(addressExists) {
                    this.addressesErrors = 'There is a duplicate of an address'
                  } else {
                    this.addressesErrors = ''; 
                  }
                } else {
                  this.addressesErrors;
                }
              }
              else if(this.addressesErrors == 'Address field is required' && i == 4){
                if(!this.addresses[i-1]?.address || this.addresses[i-1]?.address.length < 1 || !this.addresses[i-1]?.city || this.addresses[i-1]?.city.length < 1 || !this.addresses[i-1]?.state || this.addresses[i-1]?.state.length < 1 || !this.addresses[i-2]?.address || this.addresses[i-2]?.address.length < 1 || !this.addresses[i-2]?.city || this.addresses[i-2]?.city.length < 1 || !this.addresses[i-2]?.state || this.addresses[i-2]?.state.length < 1 || !this.addresses[i-3]?.address || this.addresses[i-3]?.address.length < 1 || !this.addresses[i-3]?.city || this.addresses[i-3]?.city.length < 1 || !this.addresses[i-3]?.state || this.addresses[i-3]?.state.length < 1 || !this.addresses[i-4]?.address || this.addresses[i-4]?.address.length < 1 || !this.addresses[i-4]?.city || this.addresses[i-4]?.city.length < 1 || !this.addresses[i-4]?.state || this.addresses[i-4]?.state.length < 1) {
                  this.addressesErrors == 'Address field is required'
                }else if(this.addresses[i].address && this.addresses[i].address.length > 0 && this.addresses[i].city && this.addresses[i].city.length > 0 && this.addresses[i].state && this.addresses[i].state.length > 0) {
                  if(addressExists) {
                    this.addressesErrors = 'There is a duplicate of an address'
                  } else {
                    this.addressesErrors = ''; 
                  }
                } else {
                  this.addressesErrors;
                }
              }
              else if(addressExists) {
                this.addressesErrors = 'There is a duplicate of an address'
              } else {
                this.addressesErrors = ''; 
              }
            } else {
              if(addressExists) {
                this.addressesErrors = 'There is a duplicate of an address'
              } else {
                this.addressesErrors = ''; 
              }
              console.log(this.addressesErrors);
            } console.log(this.addresses.state);
          }
        };
      } else {
        this.addressesErrors = 'At least one address is required';
      } 



        // check address error
      // if(this.addresses?.length > 0) {
      //   console.log('here gangan');
      //   this.addresses.map(address => {
      //     if(!address.address || address.address.length < 1 || !address.city || address.city.length < 1 || !address.state || address.state.length < 1) {
      //       if(this.addressesErrors.length > 0){
      //         this.addressesErrors[0] = 'Address field is required';
      //         // this.addressesErrors[this.addressesErrors.length - 1] = 'Address field is required';
      //       console.log('address them first');
      //       console.log(this.addressesErrors);
      //       } else {
      //         this.addressesErrors[0] = 'Address field is required';
      //       console.log('address them second');
      //       console.log(this.addressesErrors);
      //       }
      //       console.log('address them');
      //     } else {
      //       this.addressesErrors = [];
      //     }
      //   });
      //   console.log(this.addressesErrors);
      // } else if(this.addresses?.length < 1) {
      //   this.addressesErrors = ['At least one address is required'];
      // } else{
      //   this.addressesErrors = [];
      // }
      
        //check address error
      // if(this.addresses?.length > 0) {
      //   console.log('here gangan');
      //   this.addresses.map(address => {
      //     if(address.address == undefined || address.address.length < 1 || address.city == undefined || address.city.length < 1 || address.state == undefined || address.state.length < 1) {
      //         this.addressesErrors = 'Address field is required';
      //         console.log(this.addressesErrors);
      //     } else {
      //       if(this.addressesErrors?.length > 0) {
      //         if(this.addressesErrors == 'Address field is required' && address.address && address.address.length > 0 && address.city && address.city.length > 0 && address.state && address.state.length > 0) {
      //           this.addressesErrors = '';
      //         } else {
      //           this.addressesErrors;
      //         } console.log(this.addressesErrors);
      //       } else {
      //         this.addressesErrors = '';
      //         console.log(this.addressesErrors);
      //       } console.log(this.addresses.state);
      //     }
      //   });
      //   console.log(this.addressesErrors);
      //   console.log(this.addressesErrors);
      // } else {
      //   this.addressesErrors = 'At least one address is required';
      // } 
      //   console.log(this.addressesErrors);
        // check first name error
      if(this.first_name.length < 1) {
        if(this.firstnameErrors.length > 0){
           this.firstnameErrors[this.firstnameErrors.length - 1] = 'First Name is required';
        } else {
          this.firstnameErrors.push('First Name is required ');
        }
        
      } else{
        this.firstnameErrors = [];
      }

      // check last name error
      this.lastnameError = this.last_name.length > 0 ? '' : 'Last Name is required';

      // check email error
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

      // Check phone number error
      if(this.phone_number.length < 1) {
        if(this.phoneNumberErrors.length > 0){
           this.phoneNumberErrors[this.phoneNumberErrors.length - 1] = 'Phone number is required';
        } else {
          this.phoneNumberErrors.push('Phone number is required ');
        }
      }else if (!this.validPhoneNumber(this.phone_number)) {
        if(this.phoneNumberErrors.length > 0){
          this.phoneNumberErrors[this.phoneNumberErrors.length - 1] = 'Invalid Phone number.';
        } else {
          this.phoneNumberErrors.push('Invalid Phone number.');
        }
      } else{
        this.phoneNumberErrors = [];
      }
      
      // Check role error
      if(this.role.length < 1) {
        if(this.roleErrors.length > 0){
           this.roleErrors[this.roleErrors.length - 1] = 'Role is required';
        } else {
          this.roleErrors.push('Role is required ');
        }
      } else{
        this.roleErrors = [];
      }

      this.disable = true;
    }
  }
}
</script>

<style>
  .form-error-list {
    margin-top: -10px
  }
  .form-error {
    color:red;
    font-weight:400
  }
  .is-inv {
    border-color: #fe5461;
  }
  .buttonload {
    border: none; /* Remove borders */
    color: white; /* White text */
    padding: 12px 24px; /* Some padding */
    font-size: 16px; /* Set a font-size */
  }
  .formulate-input .formulate-input-element {
    max-width: none;  
  }
</style>

