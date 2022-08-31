<template>


<!-- ---------------------------------------------------------------------------- -->

<div>

<div class="inline">

            
                <div class="export" >
        <b-button :href="link" variant="warning">Exporté <i class="fa-solid fa-download"></i></b-button>
    </div>



    <b-form class="form" @submit.prevent="onSubmits" inline >
    <div>
    <label class="sr-only" for="inline-form-input-name">De:</label>
    <input :class="validdatedebut" v-model="form.debut" id="inline-form-input-name"  type="date"  >
    </div>

<div>

<label class="sr-only" for="inline-form-input-username">A</label>
<input id="inline-form-input-username" v-model="form.fin" :class="validdatefin" type="date"  >
</div>


<div>
    <select v-model="form.selected"  :class="validselect">
        <option value="null">----</option>
        <option :value="list.codeCompte" v-for="list in listcompte" :key="list.codeCompte">{{list.CodeCompteBancaire}}</option>
    </select>
</div>
<input type="hidden" :value="getcodecompteb" name="" id="">
<b-button type="submit" variant="primary"><i class="fa-solid fa-magnifying-glass"></i></b-button>
</b-form>
</div>

<div>
<tables :compteA="compteA" :compteB="compteB" :listcompte="listcompte" :form="form" :loadA="loadA" :loadB="loadB"/>
</div>

</div>


</template>

<script>
import Axios from "axios"
import displayTables from '@/components/elitinfo/displayTables.vue'

export default{
   // props:['listcompte','form','compteA','compteB','loadA','loadB'],
    props:{
        listcompte:Array,
        form:Object,
        compteA:Array,
        compteB:Array,
        loadA:Boolean,
        loadB:Boolean
    },
   components:{
    'tables':displayTables
   },
 data(){

    return{
        dates:[],
       
    }
 },
 methods:{
    onSubmits(){
       if(!this.form.debut || !this.form.fin || this.form.selected==null){
            return false;
        }
        if(Date.parse(this.form.debut) > Date.parse(this.form.fin)){
            return false;
        }
        if(this.form.selected=="null"){
            return false;
        }

            this.loadA=true;
            this.loadB=true;
           Axios.post('http://127.0.0.1:8000/api/search',this.form).then(response=>{
                this.loadA=false;
                this.compteA=response.data;
        })
        Axios.post('http://127.0.0.1:8000/api/searchB',this.form).then(response=>{
                this.loadB=false;
                this.compteB=response.data;
        })
       this.dates.push({'debut':this.form.debut,'fin':this.form.fin});
    },

    getListCompte(){
Axios.get("http://127.0.0.1:8000/api/listeCompte").then(response=>{
    this.listcompte=response.data;
})
    },

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
          console.log(this.form.codeb)  
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
        console.log(this.form.selected)
        return "form-control"
    },
    link(){
        let linked="http://127.0.0.1:8000/api/export/"+this.form.debut+"/"+this.form.fin+"/"+this.form.selected+"/"+this.form.codeb;
        console.log(linked);
        return linked;
    
    }
 },
 mounted(){
    this.getListCompte()
 }
}
</script>

<style>
.card-edit{
    max-width:500px;
    margin:5%;
    padding:15px;
}
.inline{
    background-color:rgba(240, 231, 231, 0.205);
      padding:20px;
       color: white;
}
.inline .export{
    float: right;
}
.form{ 
    display: flex;
    align-items: center;

   
}
.form div{
    margin-right:10px;
}
.btn-submit{
    
    margin-top:20px;
}
</style>