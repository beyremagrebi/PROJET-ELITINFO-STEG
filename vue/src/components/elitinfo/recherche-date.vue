<template>

<b-card
class="card-edit"
title="Veuillez Choisir une date"
v-if="block"
>

<!-- ---------------------------------------------------------------------------- -->
    <b-alert
      :show="dismissCountDown"
      variant="warning"
      @dismissed="dismissCountDown=0"
      @dismiss-count-down="countDownChanged"
    >
      {{Message}} {{ dismissCountDown }} seconds...
    </b-alert>

    <b-form @submit.prevent="onSubmit">
     <b-form-group
        id="input-group-1"
        label="De:"
        label-for="input-1"
      >
            <input type="date" v-model="form.debut" :class="validdatedebut">
      </b-form-group>

           <b-form-group
        id="input-group-2"
        label="A:"
        label-for="input-2"
      >
<input type="date" :class="validdatefin" v-model="form.fin" >
      </b-form-group>
<b-form-group
label="CCB(code compte bancaire) :"
>
<select  size="sm" v-model="form.selected" :class="validselect">
    <option value="null">----</option>
    <option :value="list.codeCompte" v-for="list in listcompte" :key="list.codeCompte">{{list.CodeCompteBancaire}}</option>
</select>
<input type="hidden" :value="getcodecompteb" name="" id="">
</b-form-group>

<div class="btn-submit">
    <b-button type="submit"  class="btn btn-success">Rechcerche</b-button>
</div>
</b-form>
</b-card>

<div v-else>
    <display :listcompte="listcompte" :form="form" :compteA="compteA" :compteB="compteB" :loadA="loadA " :loadB="loadB"/>
</div>
</template>

<script>
import Axios from "axios";
import displayData from '@/components/elitinfo/displayData.vue'

export default{
    components:{
        'display':displayData
    },
 data(){
    return{
           form:{
        debut:null,
        fin:null,
        selected:null,
        codeb:null
    },
    listcompte:[],
    compteA:[],
    compteB:[],
    block:true,
    loadA:true,
    loadB:true,
    dismissSecs: 5,
    dismissCountDown: 0,
    Message:null
    }
 },
 methods:{
    onSubmit(){
      
        if(!this.form.debut || !this.form.fin || this.form.selected==null){
            this.Message="tous les champs sont obligatoires"
            this.showAlert();
            return false;
        }
        if(Date.parse(this.form.debut) > Date.parse(this.form.fin)){
            this.Message="Date de fin postérieure à la date de début"
            this.showAlert();
            return false;
        }
        if(this.form.selected=="null"){
            this.Message="Code Compte Bancaire invalid"
            this.showAlert();
            return false;
        }

        Axios.post('http://127.0.0.1:8000/api/search',this.form).then(response=>{
                
                this.loadA=false;
                this.compteA=response.data;
                this.analyse(this.compteA);
        })
        Axios.post('http://127.0.0.1:8000/api/searchB',this.form).then(response=>{
            this.loadB=false;
                this.compteB=response.data;
                this.analyse(this.compteB)
                
        })
         this.block=false
          
    },
    getListCompte(){
Axios.get("http://127.0.0.1:8000/api/listeCompte").then(response=>{
    this.listcompte=response.data;
})
    },
          countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown
      },
      showAlert() {
        this.dismissCountDown = this.dismissSecs
      },
      analyse(table){
        let count;
        let code='';
        for(let i=0;i<table.length;i++){
            code=table[i].code;
            count =0;
            table[i].id=i;
            for(let j=0;j<table.length;j++){
                if(code==table[j].code){
                    
                    count++;
                   table[i].analyse=count;
                   
                }
            }
        }
      }
 },
 computed:{
    getcodecompteb(){
        let i=0;
            while( i<this.listcompte.length){
                
                if(this.listcompte[i].codeCompte==this.form.selected){
                    this.form.codeb=this.listcompte[i].CodeCompteBancaire
                    return this.form.codeb
                }
                i++;
            }
            
    },
    validdatefin(){
        if(!this.form.fin){
            return "form-control is-invalid"
        }
        else{
        if(Date.parse(this.form.debut) > Date.parse(this.form.fin)){
             return "form-control is-invalid"
        }
        }

        return "form-control"
    },
        validdatedebut(){
        if(!this.form.debut){
            return "form-control is-invalid"
        }
        return "form-control"
    },
    validselect(){
        if(this.form.selected=='null'){
            return "form-control is-invalid"
        }
        return "form-control"
    }
 },
 mounted(){
    this.getListCompte();
        let currentDate = new Date();
        let cDay = currentDate.getDate();
        let cMonth = currentDate.getMonth() + 1;
        let cYear = currentDate.getFullYear();
        let day=cDay;
        let month=cMonth;
        if(cDay<10){
          day="0"+cDay;
        }
        if(cMonth<10){
          month="0"+cMonth;
        }
        let datesys=cYear + "-" + month+ "-" + day;
        this.form.debut=datesys;
        this.form.fin=datesys;
 }
}
</script>

<style>
.card-edit{
    max-width:500px;
    margin:5%;
    padding:15px;
}
.btn-submit{
    float: right;
    margin-top:20px;
}
</style>